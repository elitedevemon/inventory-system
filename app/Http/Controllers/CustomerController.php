<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $customers = Customer::latest()->get();
    return view("dashboard.pages.customers.index", compact("customers"));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view("dashboard.pages.customers.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    $request->validate([
      'name'    => 'required|string|max:255',
      'phone'   => 'required|string|max:20|unique:customers,phone',
      'email'   => 'nullable|email|max:255|unique:customers,email',
      'address' => 'nullable|string|max:500',
    ]);

    Customer::create($request->all());

    return redirect()->route('dashboard.customers.index')
      ->with('success', 'Customer created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   */
  public function show(Customer $customer)
  {
    return view('dashboard.pages.customers.show', compact('customer'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   */
  public function edit(Customer $customer)
  {
    return view('dashboard.pages.customers.edit', compact('customer'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Customer  $customer
   */
  public function update(Request $request, Customer $customer)
  {
    $validated = $request->validate([
      'name'    => 'required|string|max:255',
      'phone'   => "required|string|max:20|unique:customers,phone,{$customer->id}",
      'email'   => "nullable|email|max:255|unique:customers,email,{$customer->id}",
      'address' => 'nullable|string|max:500',
    ]);

    // Update customer
    $customer->update($validated);

    // Redirect with success message
    return redirect()->route('dashboard.customers.index')
      ->with('success', 'Customer updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Customer  $customer
   */
  public function destroy(Customer $customer)
  {
    $customer->delete();
    return back()->with('success', 'Customer deleted successfully');
  }

  public function payDue(Request $request)
  {
    $request->validate([
      'sale_id'     => 'required|exists:sales,id',
      'paid_amount' => 'required|numeric|min:1',
    ]);

    $sale = Sale::findOrFail($request->sale_id);

    $sale->paid_amount += $request->paid_amount;
    $sale->due_amount -= $request->paid_amount;
    $sale->save();

    return response()->json(['message' => 'Due payment updated successfully.']);
  }
}
