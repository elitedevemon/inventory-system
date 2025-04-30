@extends('dashboard.layouts.app')
@section('title', 'Edit Product')
@section('content')
  <div class="container">
    <h2 class="mb-4">Edit Product</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST"
      enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label" for="name">Product Name</label>
        <input class="form-control" name="name" type="text" value="{{ old('name', $product->name) }}"
          required>
      </div>

      <div class="mb-3">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select" name="category_id" required>
          <option value="">Select a category</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label" for="supplier_id">Supplier</label>
        <select class="form-select" name="supplier_id" required>
          <option value="">Select a supplier</option>
          @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
              {{ $supplier->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label" for="price">Price</label>
        <input class="form-control" name="price" type="number" value="{{ old('price', $product->price) }}"
          required>
      </div>

      <div class="mb-3">
        <label class="form-label" for="stock">Stock Quantity</label>
        <input class="form-control" name="stock" type="number" value="{{ old('stock', $product->stock) }}"
          required>
      </div>

      <div class="mb-3">
        <label class="form-label" for="image">Product Image</label><br>
        @if ($product->image)
          <img class="img-thumbnail mb-2" src="{{ asset("storage/{$product->image}") }}" width="150">
        @endif
        <input class="form-control" name="image" type="file">
      </div>

      <button class="btn btn-primary" type="submit">Update Product</button>
      <a class="btn btn-secondary" href="{{ route('dashboard.products.index') }}">Cancel</a>
    </form>
  </div>
@endsection
