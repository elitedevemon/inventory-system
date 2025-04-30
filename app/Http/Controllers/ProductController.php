<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products = Product::latest()->get();
    return view("dashboard.pages.product.index", compact("products"));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $categories = Category::latest()->get();
    $suppliers = Supplier::latest()->get();

    return view("dashboard.pages.product.create", compact("categories", "suppliers"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'supplier_id' => 'nullable|exists:suppliers,id',
      'stock' => 'required|integer|min:0',
      'price' => 'required|numeric|min:0',
      'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
      $validated['image'] = $request->file('image')->store('products', 'public');
    }

    Product::create($validated);

    return redirect()->route('dashboard.products.index')
      ->with('success', 'Product created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Product  $product
   */
  public function show(Product $product)
  {
    return view('dashboard.pages.product.show', compact('product'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Product  $product
   */
  public function edit(Product $product)
  {
    $categories = Category::latest()->get();
    $suppliers = Supplier::latest()->get();

    return view("dashboard.pages.product.edit", compact(["categories", "suppliers", "product"]));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Product  $product
   */
  public function update(Request $request, Product $product)
  {
    // Validate the incoming data
    $request->validate([
      'name' => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'supplier_id' => 'required|exists:suppliers,id',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image validation
    ]);

    // Update product fields
    $product->name = $request->name;
    $product->category_id = $request->category_id;
    $product->supplier_id = $request->supplier_id;
    $product->price = $request->price;
    $product->stock = $request->stock;

    // Handle image upload (if new image is uploaded)
    if ($request->hasFile('image')) {
      // Delete the old image if it exists
      if ($product->image && Storage::exists("public/{$product->image}")) {
        Storage::delete("public/{$product->image}");
      }else{
        return back()->with('error', 'file not found')->withInput();
      }
      // Store the new image
      $imagePath = $request->file('image')->store('products', 'public');
      $product->image = $imagePath;
    }

    // Save the updated product
    $product->save();

    // Redirect to the product index page with success message
    return redirect()->route('dashboard.products.index')->with('success', 'Product updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Product  $product
   */
  public function destroy(Product $product)
  {
    $product->delete();
    return back()->with('success', 'Product deleted successfully');
  }
}
