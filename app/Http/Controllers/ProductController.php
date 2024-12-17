<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Request as ProductRequest;
use App\Models\UserRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Ana sayfada ürünleri listelemek için
    public function index()
    {
        $userId = Auth::id(); // Mevcut kullanıcı ID'si

        // Ürünleri alt kategoriye göre sıralayarak al
        $products = Product::with('subcategories') // Subcategory ilişkisini al
        ->get()
            ->sortBy(function ($product) {
                // Alt kategoriyi alfabetik olarak sıralama için kullan
                return optional($product->subcategories->first())->name;
            });

        // Her ürün için kullanıcının verdiği puanı ilişkilendirin
        foreach ($products as $product) {
            $product->user_rating = UserRating::where('product_id', $product->id)
                ->where('user_id', $userId)
                ->value('user_rate');
        }

        return view('welcome', compact('products'));
    }

    // Ürün oluşturma formunu gösterir
    public function create()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('admin.products.create', compact('categories')); // Pass categories to the view
    }


    // Admin panelinde ürünleri listelemek için
    public function adminIndex()
    {
        // Ürünleri alt kategoriye göre sıralayarak al
        $products = Product::with('subcategories') // Subcategory ilişkisini al
        ->get()
            ->sortBy(function ($product) {
                // Alt kategoriyi alfabetik olarak sıralama için kullan
                return optional($product->subcategories->first())->name;
            });
        // Okunmamış talepleri al
        // Talepleri yükleme
        $requests = ProductRequest::all();
        $unreadRequests = ProductRequest::where('status', 'pending')->count();

        return view('admin.products.index', compact('products', 'unreadRequests', 'requests')); // Admin ürün sayfasına yönlendir
    }


    // Ürünü kaydeder
    public function store(Request $request)
    {
        // Validate the data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8112', // Image validation
            'global_rating' => 'nullable|numeric|min:0|max:5',
            'categories' => 'array|exists:categories,id', // Validate categories array
            'subcategories' => 'nullable|array|exists:subcategories,id', // Validate subcategories array
        ]);

        // Save the image if it exists
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;

        // Calculate the initial site rating based on user ratings
        $initialSiteRating = UserRating::where('product_id', $request->id)->avg('user_rate') ?? 0;

        // Create the product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'global_rating' => $request->global_rating ?? 0,
            'site_rating' => $initialSiteRating,
        ]);

        // Sync categories with the product
        $product->categories()->sync($request->input('categories', []));


        // Sync subcategories with the product (if provided)
        $product->subcategories()->sync($request->input('subcategories', []));

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla eklendi.');
    }

    // urun duzenleme fonksiyonu
    public function edit(Product $product)
    {
        $categories = Category::all(); // Get all categories
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Veriyi doğrula
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'global_rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8112', // Image validation,
            'categories' => 'array|exists:categories,id', // Kategori doğrulama
            'subcategories' => 'nullable|array|exists:subcategories,id' // Alt kategori doğrulama
        ]);

        // Görsel işleme: Eğer yeni bir resim yüklendiyse eskiyi silip yenisini kaydediyoruz
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        } else {
            $validatedData['image'] = $product->image; // Mevcut resmi koru
        }

        // Kullanıcı puanlarının ortalamasını hesaplayarak `site_rating` alanını güncelle
        $averageRating = UserRating::where('product_id', $product->id)->avg('user_rate');
        $validatedData['site_rating'] = round($averageRating, 1);

        // Ürün bilgilerini güncelle
        $product->update($validatedData);

        // Kategorileri senkronize et
        $product->categories()->sync($request->input('categories', []));

        // Alt kategorileri senkronize et
        $product->subcategories()->sync($request->input('subcategories', []));

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla güncellendi.');
    }


    // urun silme fonksiyonu
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla silindi.');
    }

    //urunleri tek tek gosterme fonksiyonu
    public function show($id)
    {
        $product = Product::findOrFail($id);
        // Her ürün için kullanıcının verdiği puanı ilişkilendirin
        $userId = Auth::id(); // Mevcut kullanıcı ID'si
        $product->user_rating = UserRating::where('product_id', $product->id)
            ->where('user_id', $userId)
            ->value('user_rate');

        return view('product.show', compact('product'));
    }

    //benzerini bul icin
    public function findSimilar(Request $request)
    {
        // Eğer product_id sağlanmışsa ürün kontrolü yap
        if ($request->product_id) {
            $product = Product::findOrFail($request->product_id);

            if (!$product->image) {
                return back()->with('error', __('messages.product_image_not_found'));
            }

            // Ürün resim yolunu hazırla
            $imagePath = storage_path('app/public/' . $product->image);

            if (!file_exists($imagePath)) {
                return back()->with('error', __('messages.product_image_not_found_on_server'));
            }
        } elseif ($request->image_path) {
            // Eğer image_path sağlanmışsa bu yolu kullan
            $imagePath = $request->image_path;

            if (!file_exists($imagePath)) {
                return back()->with('error', __('messages.image_not_found_on_server'));
            }
        } else {
            // Ne product_id ne de image_path sağlanmışsa hata döndür
            return back()->with('error', __('messages.no_image_or_product_provided'));
        }

        // Send the image and subcategories to the Python API
        $response = Http::asMultipart()
            ->attach('image', file_get_contents($imagePath), 'image.jpg')
            ->post('http://127.0.0.1:5000/process-image', [
            ]);

        // Handle API failure
        if ($response->failed()) {
            logger()->error('Python API request failed', [
                'response' => $response->body(),
                'status' => $response->status(),
            ]);
            return back()->with('error', __('messages.error_processing_image'));
        }


        // Extract categories from the API response
        $categories = $response->json()['categories'] ?? [];

        // Handle the case where no categories are found
        if (empty($categories)) {
            return view('product.similar_products', [
                'similarProducts' => collect(),
                'message' => __('messages.no_similar_products'),
            ]);
        }

        // Map returned YOLO category IDs to site categories yolo_ids => 'site_categories'
        $yoloToSiteCategoryMap = [
            339 => 'Telefon',
            304 => 'Dizüstü Bilgisayar',
            516 => 'Tablet',
            203 => 'Ayakkabı', # tum ayakkabılar (main category)
            127 => 'Klavye',
            129 => 'Mouse',
            244 => 'Kulaklık',
            82 => 'Kamera',
            577 => 'Saat', # tum saatler (main category)
        ];

        $mappedCategories = [];
        foreach ($categories as $categoryId) {
            if (isset($yoloToSiteCategoryMap[$categoryId])) {
                $mappedCategories[] = $yoloToSiteCategoryMap[$categoryId];
            }
        }

        // Handle the case where no mapped categories are found
        if (empty($mappedCategories)) {
            return view('product.similar_products', [
                'similarProducts' => collect(),
                'message' => __('messages.no_similar_products'),
            ]);
        }

        // Use the mapped categories for further processing
        $similarProducts = Product::whereHas('subcategories', function ($query) use ($mappedCategories) {
            $query->whereIn('name', $mappedCategories);
        })->get();

        // if mapped categories does not contain subcategories then show main category
        if ($similarProducts->isEmpty()) {
            $similarProducts = Product::whereHas('categories', function ($query) use ($mappedCategories) {
                $query->whereIn('name', $mappedCategories);
            })->get();
        }


        return view('product.similar_products', compact('similarProducts'));
    }

    // Find similar products by upload
    public function findSimilarByUpload(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8112',
            'url' => 'nullable|url',
        ]);

        if (!$request->hasFile('image') && !$request->url) {
            return back()->with('error', __('messages.no_image_or_url'));
        }

        if ($request->hasFile('image')) {
            // Benzersiz isim oluştur
            $imageName = 'temp/' . time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

            // Önceki resmi sil
            $oldImagePath = session('uploaded_image_path');
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            // Yeni resmi kaydet
            $imagePath = $request->file('image')->storeAs('', $imageName, 'public');
            $absolutePath = storage_path('app/public/' . $imagePath);

            // Session'a yeni resmin yolunu kaydet
            session(['uploaded_image_path' => $imagePath]);

            // findSimilar fonksiyonunu çağırırken dosya yolunu gönder
            return $this->findSimilar(new Request(['product_id' => null, 'image_path' => $absolutePath]));
        }


        if ($request->url) {
            // URL'den resim indirme ve geçici olarak kaydetme
            try {
                $imageContent = Http::get($request->url)->body();
                $tempImageName = 'temp/' . uniqid() . '.jpg';
                Storage::disk('public')->put($tempImageName, $imageContent);
                $absolutePath = storage_path('app/public/' . $tempImageName);
                // findSimilar fonksiyonunu çağırırken dosya yolunu gönder
                return $this->findSimilar(new Request(['product_id' => null, 'image_path' => $absolutePath]));
            } catch (\Exception $e) {
                return back()->with('error', __('messages.invalid_image_url'));
            }
        }
    }

    //show image upload form to find similar products
    public function showUploadForm()
    {
        return view('product.upload_image');
    }

    // Get Product
    public function storeRequest(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8112', // Resim yükleme desteği
            'image_url' => 'nullable|url', // URL desteği
            'description' => 'nullable|string|max:1000',
        ]);

        $imagePath = null;

        // Resim yükleme işlemi
        if ($request->hasFile('image')) {
            // Benzersiz isim oluştur
            $imageName = 'product_requests/' . time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

            // Önceki resmi sil
            $oldImagePath = session('uploaded_image_path');
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

        } elseif ($request->image_url) {
            $imagePath = $request->image_url; // URL kullanımı
        }

        // Talebi veritabanına kaydet
        ProductRequest::create([
            'product_name' => $request->input('product_name', 'Belirtilmeyen Ürün'),
            'image_url' => $imagePath,
            'description' => $request->input('description'),
            'user_id' => auth()->id(), // Kullanıcı ID'sini kaydet (opsiyonel)
        ]);
        // Başarı mesajıyla birlikte doğru bir route'a yönlendir
        return redirect()->route('home')->with('success', __('messages.request_created'));
    }
}
