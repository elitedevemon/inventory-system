@extends('dashboard.layouts.app')
@section('title', 'Product List')
@section('content')
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>All Products</h2>
      <a class="btn btn-primary" href="{{ route('dashboard.products.create') }}">Add New Product</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table-bordered table-hover table">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Stock</th>
            <th>Unit Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($products as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <img class="img-fluid w-25 rounded" src="{{ asset("storage/{$product->image}") }}"
                  alt="{{ $product->name }}" style="max-height: 80px;">
              </td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->category->name ?? 'N/A' }}</td>
              <td>{{ $product->supplier->name ?? 'N/A' }}</td>
              <td>{{ $product->stock }}</td>
              <td>৳ {{ number_format($product->price, 2) }}</td>
              <td>
                <a class="btn btn-sm btn-warning"
                  href="{{ route('dashboard.products.show', $product->id) }}">View</a>
                <a class="btn btn-sm btn-warning"
                  href="{{ route('dashboard.products.edit', $product->id) }}">Edit</a>
                <form class="d-inline" action="{{ route('dashboard.products.destroy', $product->id) }}"
                  method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-center" colspan="7">No products found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
