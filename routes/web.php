<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

// auth routes
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// dashboard routes
Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {
  Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('index');

    // category
    Route::resource('categories', CategoryController::class)->except('show');

    //supplier
    Route::resource('suppliers', SupplierController::class)->except('show');

    //purchases
    Route::resource('purchases', PurchaseController::class)->except('edit', 'update');
    Route::post('purchases/{purchase}/pay-due', [PurchaseController::class, 'payDue'])
      ->name('purchases.pay-due');

    //products
    Route::resource('products', ProductController::class);

    //customer
    Route::resource('customers', CustomerController::class);
    Route::post('customers/pay-due', [CustomerController::class, 'payDue'])->name('customers.pay-due');


    //sales
    Route::resource('sales', SaleController::class)->except('create', 'edit', 'update', 'destroy');
    Route::post('sales/pay-due/{sale}', [SaleController::class, 'payDue'])->name('sales.pay-due');

    //reports
    Route::controller(ReportController::class)->prefix('reports')->name('reports.')->group(function () {
      Route::get('sales', 'sales')->name('sales');
      Route::get('purchases', 'purchases')->name('purchases');
      Route::get('stock', 'stock')->name('stock');
    });
  });
});
