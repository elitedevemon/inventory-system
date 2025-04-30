<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {
    $categories = Category::latest()->get();
    return view("dashboard.pages.category.index", compact("categories"));
  }

  /**
   * Show the form for creating a new resource.
   *
   */
  public function create()
  {
    return view("dashboard.pages.category.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:categories,name',
      'description' => 'nullable|string|max:1000',
    ]);

    Category::create([
      'name' => $request->name,
      'description' => $request->description,
    ]);

    return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Category  $category
   */
  public function edit(Category $category)
  {
    return view('dashboard.pages.category.edit', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Category  $category
   */
  public function update(Request $request, Category $category)
  {
    $request->validate([
      'name' => "required|string|max:255|unique:categories,name,{$category->id}",
      'description' => 'nullable|string|max:1000',
    ]);

    $category->update([
      'name' => $request->name,
      'description' => $request->description,
    ]);

    return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Category  $category
   */
  public function destroy(Category $category)
  {
    $category->delete();
    return redirect()->route('dashboard.categories.index')->with('success','Category deleted successfully');
  }
}
