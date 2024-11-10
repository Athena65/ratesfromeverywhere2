<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Show the form for creating a new subcategory.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function create(Category $category)
    {
        return view('admin.subcategories.create', compact('category'));
    }

    /**
     * Store a newly created subcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->subcategories()->create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Subcategory created successfully.');
    }

    /**
     * Show the form for editing the specified subcategory.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\View\View
     */
    public function edit(Category $category, Subcategory $subcategory)
    {
        return view('admin.subcategories.edit', compact('category', 'subcategory'));
    }

    /**
     * Update the specified subcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $subcategory->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified subcategory from storage.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category, Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Subcategory deleted successfully.');
    }
}
