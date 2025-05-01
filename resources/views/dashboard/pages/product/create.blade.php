@extends('dashboard.layouts.app')
@section('title', 'Create Product')
@section('content')
  <div class="container">
    <h2 class="mb-4">Add New Product</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Product Name -->
      <div class="mb-3">
        <label class="form-label" for="name">Product Name</label>
        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Product name"
          required>
      </div>

      <!-- Category -->
      <div class="mb-3">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select" id="category_id" name="category_id" required>
          <option value="">Select Category</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Supplier -->
      <div class="mb-3">
        <label class="form-label" for="supplier_id">Supplier</label>
        <select class="form-select" id="supplier_id" name="supplier_id">
          <option value="">Select Supplier</option>
          @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
              {{ $supplier->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Stock -->
      <div class="mb-3">
        <label class="form-label" for="stock">Stock Quantity</label>
        <input class="form-control" id="stock" name="stock" type="number" value="{{ old('stock', 0) }}">
      </div>

      <!-- Unit Price -->
      <div class="mb-3">
        <label class="form-label" for="price">Unit Price</label>
        <input class="form-control" id="price" name="price" type="number"
          value="{{ old('price', 0.0) }}" step="0.01" required>
      </div>

      <!-- Product Image (optional) -->
      <div class="mb-3">
        <label class="form-label" for="image">Product Image (optional)</label>
        <input class="form-control" id="image" name="image" type="file">
      </div>

      <!-- Submit Button -->
      <button class="btn btn-success" type="submit">Create Product</button>
      <a class="btn btn-secondary" href="{{ route('dashboard.products.index') }}">Cancel</a>
    </form>
  </div>
@endsection
