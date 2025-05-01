<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $customers = Customer::latest()->get();
    $products = Product::latest()->get();
    $sales = Sale::with('customer', 'product')->latest()->get();
    if (request()->ajax()) {
      return view('dashboard.pages.sales.sales_table', compact('sales'))->render();
    }
    return view("dashboard.pages.sales.index", compact(["products","customers", "sales"]));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'customer_id' => 'required|exists:customers,id',
      'products' => 'required|array|min:1',
      'products.*.product_id' => 'required|exists:products,id',
      'products.*.quantity' => 'required|integer|min:1',
      'paid_amount' => 'required|numeric|min:0',
      'payment_method' => 'required|in:cash,bkash,bank',
    ]);

    $totalAmount = 0;
    $saleItems = [];

    foreach ($validated['products'] as $item) {
      $product = Product::findOrFail($item['product_id']);

      if ($product->stock < $item['quantity']) {
        return response()->json([
          'message' => "Out of stock for {$product->name}. Only {$product->stock} left."
        ], 400);
      }

      $subtotal = $product->price * $item['quantity'];
      $totalAmount += $subtotal;

      // Prepare items
      $saleItems[] = [
        'product_id' => $product->id,
        'quantity' => $item['quantity'],
        'unit_price' => $product->price,
        'subtotal' => $subtotal,
      ];

      // Update stock
      $product->decrement('stock', $item['quantity']);
    }

    $dueAmount = $totalAmount - $validated['paid_amount'];
    $invoice_no = 'INV-' . strtoupper(Str::random(10));
    
    try {
      $sale = Sale::create([
        'invoice_no' => $invoice_no,
        'customer_id' => $validated['customer_id'],
        'sale_date' => now(),
        'total_amount' => $totalAmount,
        'paid_amount' => $validated['paid_amount'],
        'due_amount' => $dueAmount,
        'payment_method' => $validated['payment_method'],
      ]);
    } catch (\Throwable $th) {
      throw $th;
      // return response()->json([
      //   'message' => "Something went wrong {$th->getMessage}"
      // ], 400);
    }

    try {
      // Save all products sold
      foreach ($saleItems as $item) {
        $sale->saleItems()->create([
          'product_id' => $item['product_id'],
          'quantity' => $item['quantity'],
          'unit_price' => $item['unit_price'],
          'subtotal' => $item['subtotal'],
        ]);
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    return response()->json(['success' => true, 'message' => 'Sale added successfully.']);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Sale  $sale
   */
  public function show(Sale $sale)
  {
    return view('dashboard.pages.sales.show', compact('sale'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function edit(Sale $sale)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Sale $sale)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function destroy(Sale $sale)
  {
    //
  }

  /**
   * Pay due
   */
  public function payDue(Request $request, Sale $sale)
  {
    $validated = $request->validate([
      'amount' => 'required|numeric|min:1',
    ]);

    if ($validated['amount'] > $sale->due_amount) {
      return response()->json([
        'message' => 'Payment exceeds due amount.'
      ], 400);
    }

    $sale->paid_amount += $validated['amount'];
    $sale->due_amount -= $validated['amount'];
    $sale->save();

    return response()->json([
      'success' => true,
      'message' => 'Due amount updated successfully.',
      'updated_due' => $sale->due_amount,
      'updated_paid' => $sale->paid_amount,
    ]);
  }
}
