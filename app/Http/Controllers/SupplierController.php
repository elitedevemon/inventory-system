<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $suppliers = Supplier::latest()->get();
    return view('dashboard.pages.supplier.index', compact('suppliers'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('dashboard.pages.supplier.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'company_name' => 'nullable|string|max:255',
      'email' => 'nullable|email|max:255',
      'phone' => 'required|string|max:20',
      'address' => 'nullable|string',
    ]);

    Supplier::create($request->all());

    return redirect()->route('dashboard.suppliers.index')->with('success', 'Supplier added successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Supplier  $supplier
   */
  public function edit(Supplier $supplier)
  {
    return view('dashboard.pages.supplier.edit', compact('supplier'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Supplier  $supplier
   */
  public function update(Request $request, Supplier $supplier)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'company_name' => 'nullable|string|max:255',
      'email' => 'nullable|email|max:255',
      'phone' => 'required|string|max:20',
      'address' => 'nullable|string',
    ]);

    $supplier = Supplier::findOrFail($supplier->id);

    $supplier->update($request->all());

    return redirect()->route('dashboard.suppliers.index')->with('success', 'Supplier updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Supplier  $supplier
   */
  public function destroy(Supplier $supplier)
  {
    $supplier->delete();
    return back()->with('success', 'Supplier deleted successfully');
  }
}
