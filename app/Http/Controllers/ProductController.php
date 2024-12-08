<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\UserRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        return view('admin.products.index', compact('products')); // Admin ürün sayfasına yönlendir
    }

    // Ürünü kaydeder
    public function store(Request $request)
    {
        // Validate the data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif,webp|max:8112', // Image validation
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        $product = Product::findOrFail($request->product_id);

        if (!$product->image) {
            return back()->with('error', __('messages.product_image_not_found'));
        }

        // Prepare the image file path
        $imagePath = storage_path('app/public/' . $product->image);

        if (!file_exists($imagePath)) {
            return back()->with('error', __('messages.product_image_not_found_on_server'));
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
            203 => 'Ayakkabı',
            127 => 'Klavye', // yeterli sayida urun var
            129 => 'Mouse', // yeterli sayida urun var
            244 => 'Kulaklık', // yeterli sayida urun var
            82 => 'Kamera', // yeterli sayida urun var

            // Urun yok henuz - urun eklenecek - Kategoriler var
            113 => 'Saat',
            157 => 'Dijital Saat',
            573 => 'Duvar Saati',
            4 => 'Alarm Saati',
            // Add more mappings as needed
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
}
