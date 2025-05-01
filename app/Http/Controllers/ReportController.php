<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
  public function sales()
  {
    // Sales per product using Eloquent
    $salesPerProduct = Product::withSum('sales', 'subtotal')->get()->map(function ($product) {
      return [
        'name' => $product->name,
        'total' => $product->sales_sum_subtotal
      ];
    });

    // Sales per day using Eloquent
    $salesPerDay = Sale::selectRaw('DATE(sale_date) as date, SUM(total_amount) as total')
      ->groupBy(DB::raw('DATE(sale_date)'))
      ->orderBy('date')
      ->get();

    return view('dashboard.pages.reports.sales', compact('salesPerProduct', 'salesPerDay'));
  }

  public function purchases()
  {
    // Total purchase per product
    $purchasesPerProduct = Product::withSum('purchases', 'total_price')->get()->map(function ($product) {
      return [
        'name' => $product->name,
        'total' => $product->purchases_sum_total_price
      ];
    });

    // Total purchase per day
    $purchasesPerDay = Purchase::selectRaw('DATE(purchase_date) as date, SUM(total_amount) as total')
      ->groupBy(DB::raw('DATE(purchase_date)'))
      ->orderBy('date')
      ->get();

    return view('dashboard.pages.reports.purchases', compact('purchasesPerProduct', 'purchasesPerDay'));
  }

  public function stock()
  {
    $products = Product::with(['purchases', 'sales'])->get()->map(function ($product) {
      $purchased = $product->purchases->sum('quantity');
      $sold = $product->sales->sum('quantity');
      $stock = $purchased - $sold;
      $usedPercent = $purchased > 0 ? round(($sold / $purchased) * 100) : 0;

      return [
        'name' => $product->name,
        'purchased' => $purchased,
        'sold' => $sold,
        'stock' => $stock,
        'used_percent' => $usedPercent
      ];
    });

    return view('dashboard.pages.reports.stock', compact('products'));
  }
}
