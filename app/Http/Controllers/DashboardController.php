<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    // Total Sales this month
    $totalSales = Sale::whereMonth('created_at', now()->month)->sum('total_amount');

    // Total Products
    $totalProducts = Product::count();

    // Total Stock Available
    $totalStock = Product::sum('stock');

    // Sales Data for Chart
    $salesData = $this->getSalesData();

    // Product Category Breakdown
    $productCategories = $this->getProductCategories();

    return view('dashboard.index', compact('totalSales', 'totalProducts', 'totalStock', 'salesData', 'productCategories'));
  }

  private function getSalesData()
  {
    $sales = Sale::whereMonth('created_at', now()->month)
      ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total_sales')
      ->groupBy('date')
      ->orderBy('date')
      ->get();

    return [
      'dates' => $sales->pluck('date'),
      'values' => $sales->pluck('total_sales')
    ];
  }

  private function getProductCategories()
  {
    $categories = Category::withCount('products')->get();

    return [
      'names' => $categories->pluck('name'),
      'counts' => $categories->pluck('products_count')
    ];
  }
}
