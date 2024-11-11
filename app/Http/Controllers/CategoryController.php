<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
// CategoryController.php içindeki getSubcategories metodu
    public function getSubcategories($categoryId, $productId = null)
    {
        try {
            // Kategori adını ve alt kategorileri al
            $categoryName = Category::where('id', $categoryId)->value('name');
            $subcategories = Subcategory::where('category_id', $categoryId)->get();

            // Seçili alt kategorileri belirle
            $selectedSubcategories = [];
            if ($productId) {
                // `product_subcategory` tablosundan daha önce seçili olan alt kategorileri al
                $selectedSubcategories = \DB::table('product_subcategory')
                    ->where('product_id', $productId)
                    ->pluck('subcategory_id')
                    ->toArray();
            }

            // JSON yanıtını döndür
            return response()->json([
                'category_name' => $categoryName,
                'subcategories' => $subcategories,
                'selected_subcategories' => $selectedSubcategories
            ]);
        } catch (\Exception $e) {
            // Hata durumunda log kaydı
            \Log::error("getSubcategories hatası: " . $e->getMessage());
            return response()->json(['error' => 'Bir hata oluştu.'], 500);
        }
    }

}
