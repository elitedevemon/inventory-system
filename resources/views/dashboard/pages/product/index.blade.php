@extends('vendor.layouts.app')
@section('title', 'Product List')
@section('content')

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Products</h2>
    <a class="btn btn-primary" href="{{ route('vendor.dashboard.products.create') }}">
      + Add Product
    </a>
  </div>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table-bordered table-hover table align-middle">
      <thead class="table-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Price</th>
          <th scope="col">Stock</th>
          <th scope="col">Image</th>
          <th scope="col">Colors</th>
          <th scope="col">Created At</th>
          <th class="text-center" scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($products as $product)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->title }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock }}</td>
            <td>
              @if ($product->image)
                <img src="{{ asset((string) $product->image) }}" alt="Product Image" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover;">
              @else
                <span class="text-muted">No image</span>
              @endif
            <td>
              @if (!empty($product->colors))
                @foreach ($product->colors as $color)
                  <span class="badge rounded-pill" style="background-color: {{ $color }};">&nbsp;</span>
                @endforeach
              @else
                <span class="text-muted">No colors</span>
              @endif
            </td>
            <td>{{ $product->created_at->diffForHumans() }}</td>
            <td class="text-center">
              <a class="btn btn-sm btn-warning" href="{{ route('vendor.dashboard.products.edit', $product->id) }}">Edit</a>
              <form class="d-inline" action="{{ route('vendor.dashboard.products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-muted text-center" colspan="6">No products available.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
