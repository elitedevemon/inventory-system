<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {
    $purchases = Purchase::latest()->get();
    return view('dashboard.pages.purchases.index', compact('purchases'));
  }

  /**
   * Show the form for creating a new resource.
   *
   */
  public function create()
  {
    $suppliers = Supplier::latest()->get();
    $products = Product::latest()->get();
    return view('dashboard.pages.purchases.create', compact('suppliers', 'products'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    $request->validate([
      'supplier_id' => 'required|exists:suppliers,id',
      'purchase_date' => 'required|date',
      'products' => 'required|array',
      'products.*' => 'required|exists:products,id',
      'quantities' => 'required|array',
      'unit_prices' => 'required|array',
      'payment_method' => 'required|string',
      'paid_amount' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {
      $total = 0;
      $items = [];

      foreach ($request->products as $index => $productId) {
        $quantity = $request->quantities[$index];
        $unitPrice = $request->unit_prices[$index];
        $total += $quantity * $unitPrice;

        $items[] = [
          'product_id' => $productId,
          'quantity' => $quantity,
          'unit_price' => $unitPrice,
        ];
      }

      $purchase = Purchase::create([
        'invoice_no' => 'INV-' . strtoupper(Str::random(6)),
        'supplier_id' => $request->supplier_id,
        'purchase_date' => $request->purchase_date,
        'total_amount' => $total,
        'paid_amount' => $request->paid_amount,
        'due_amount' => $total - $request->paid_amount,
        'payment_method' => $request->payment_method,
      ]);

      foreach ($items as $item) {
        $purchase_item = PurchaseItem::create([
          'purchase_id' => $purchase->id,
          'product_id' => $item['product_id'],
          'quantity' => $item['quantity'],
          'unit_price' => $item['unit_price'],
          'total_price' => $item['quantity'] * $item['unit_price'],
        ]);

        $purchase_item->product()->increment('stock', $item['quantity']);
      }
    });

    return redirect()->route('dashboard.purchases.index')->with('success', 'Purchase saved successfully!');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Purchase  $purchase
   */
  public function show(Purchase $purchase)
  {
    return view('dashboard.pages.purchases.show', compact('purchase'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Purchase  $purchase
   */
  public function destroy(Purchase $purchase)
  {
    $purchase->delete();
    return back()->with('success', 'Purchase record deleted successfully');
  }

  /**
   * Update the specified payment due.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Purchase  $purchase
   */
  public function payDue(Request $request, Purchase $purchase)
  {
    $request->validate([
      'amount' => 'required|numeric|min:1'
    ]);

    $amount = $request->amount;

    if ($amount > $purchase->due_amount) {
      return response()->json(['message' => 'Amount exceeds due.'], 422);
    }

    $purchase->paid_amount += $amount;
    $purchase->due_amount -= $amount;
    $purchase->save();

    return response()->json(['message' => 'Due payment recorded successfully.']);
  }
}
