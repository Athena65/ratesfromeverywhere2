<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Ana sayfada ürünleri listelemek için
    public function index()
    {
        $products = Product::all(); // Tüm ürünleri al
        return view('welcome', compact('products')); // home view dosyasına yönlendir
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
            'site_rating' => 'nullable|numeric|min:0|max:5',
            'global_rating' => 'nullable|numeric|min:0|max:5',
        ]);

        // resmi buraya kaydeder :  storage/app/public/products
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // urunu olstur ve kaydet
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'site_rating' => $request->site_rating ?? 0,
            'global_rating' => $request->global_rating ?? 0,
        ]);

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
            'site_rating' => 'nullable|numeric|min:0|max:5',
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

        // Ürün bilgilerini güncelle
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'site_rating' => $request->site_rating,
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

}
