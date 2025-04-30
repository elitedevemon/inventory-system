@extends('dashboard.layouts.app')
@section('title', (string) $product->name)
@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header">
            <h4>Product Details</h4>
          </div>
          <div class="card-body">
            <div class="mb-4 text-center">
              <img class="img-fluid rounded" src="{{ asset("storage/{$product->image}") }}"
                alt="{{ $product->name }}" style="max-height: 250px;">
            </div>

            <table class="table-bordered table">
              <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
              </tr>
              <tr>
                <th>Category</th>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
              </tr>
              <tr>
                <th>Supplier</th>
                <td>{{ $product->supplier->name ?? 'N/A' }}</td>
              </tr>
              <tr>
                <th>Stock</th>
                <td>{{ $product->stock }}</td>
              </tr>
              <tr>
                <th>Cost Price</th>
                <td>৳ {{ number_format($product->latest_purchase_item->unit_price ?? 0, 2) }}</td>
              </tr>
              <tr>
                <th>Selling Price</th>
                <td>৳ {{ number_format($product->price, 2) }}</td>
              </tr>
              <tr>
                <th>Created At</th>
                <td>{{ $product->created_at->format('d M, Y h:i A') }}</td>
              </tr>
            </table>

            <a class="btn btn-secondary" href="{{ route('dashboard.products.index') }}">Back to List</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
