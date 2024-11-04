<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Ana sayfada ürünleri listelemek için
    public function index()
    {
        $userId = Auth::id(); // Mevcut kullanıcı ID'si
        $products = Product::all();

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
        return view('admin.products.create'); // Görünümü döndürüyor
    }

    // Admin panelinde ürünleri listelemek için
    public function adminIndex()
    {
        $products = Product::all(); // Tüm ürünleri al
        return view('admin.products.index', compact('products')); // Admin ürün sayfasına yönlendir
    }

    // Ürünü kaydeder
    public function store(Request $request)
    {
        // Validate the data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'global_rating' => 'nullable|numeric|min:0|max:5',
        ]);

        // resmi buraya kaydeder :  storage/app/public/products
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Ürün kaydedildikten sonra site_rating'i hesapla
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'global_rating' => $request->global_rating ?? 0,
            'site_rating' => 0, // İlk başta 0
        ]);

        // `user_ratings` tablosundan ortalama hesapla
        $averageRating = UserRating::where('product_id', $product->id)->avg('user_rate');
        $product->update(['site_rating' => $averageRating ?? 0]);

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla eklendi.');
    }

    // urun duzenleme fonksiyonu
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        // Veriyi doğrula
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'global_rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Yeni resim yüklendiyse mevcut resmi sil ve yenisini kaydet
        if ($request->hasFile('image')) {
            // Eski resmi sil
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            // Yeni resmi kaydet
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Kullanıcı puanlarının ortalamasını hesaplayarak `site_rating` alanını güncelle
        $averageRating = UserRating::where('product_id', $product->id)->avg('user_rate');

        // Ürün bilgilerini güncelle
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'site_rating' => round($averageRating, 1), // Ortalama kullanıcı puanı
            'global_rating' => $request->global_rating,
            'image' => $product->image,
        ]);

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
        return view('product.show', compact('product'));
    }

}
