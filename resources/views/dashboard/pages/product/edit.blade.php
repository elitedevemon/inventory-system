@extends('vendor.layouts.app')
@section('title', 'Edit Product')
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="form-section">
        <h4 class="mb-4">Edit Product</h4>

        {{-- Flash Messages --}}
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('vendor.dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
          <input type="hidden" name="slug" value="{{ $product->slug }}">

          {{-- Category --}}

          {{-- Title --}}
          <div class="mb-3">
            <label class="form-label" for="title">Product Title</label>
            <input class="form-control" id="title" name="title" type="text" value="{{ old('title', $product->title) }}" required>
          </div>

          {{-- Price --}}
          <div class="mb-3">
            <label class="form-label" for="price">Price (USD)</label>
            <input class="form-control" id="price" name="price" type="number" value="{{ old('price', $product->price) }}" step="0.01" required>
          </div>

          {{-- Stock --}}
          <div class="mb-3">
            <label class="form-label" for="stock">Stock</label>
            <input class="form-control" id="stock" name="stock" type="number" value="{{ old('stock', $product->stock) }}" required>
          </div>

          {{-- Image --}}
          <div class="mb-3">
            <label class="form-label" for="image">Product Image</label>
            <input class="form-control" id="image" name="image" type="file" accept="image/*"
              onchange="previewImage(event)" value="{{ old('image', $product->image) }}">
            @if ($product->image)
              <img src="{{ asset("storage/{$product->image}") }}" alt="Current Image" class="preview-img d-block mb-2" id="preview">
            @endif
          </div>

          {{-- Description --}}
          <div class="mb-3">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
          </div>

          {{-- Dynamic Color Picker --}}
          <div class="mb-3">
            <label class="form-label">Colors</label>
            <div id="color-container">
              @foreach ($product->colors as $color)
                <div class="d-flex color-input-group mb-2">
                  <input class="form-control form-control-color me-2" name="color[]" type="color" value="{{ $color }}">
                  <button type="button" class="btn btn-danger remove-color">Remove</button>
                </div>                
              @endforeach
            </div>
            <button class="btn btn-secondary" id="add-color" type="button">+ Add More Color</button>
          </div>

          <button class="btn btn-primary" type="submit">Update Product</button>
        </form>

      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    body {
      background-color: #f5f7fa;
    }

    .form-section {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .preview-img {
      max-height: 120px;
      margin-top: 10px;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function previewImage(event) {
      const [file] = event.target.files;
      if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
      }
    }
  </script>
  <script>
    $(document).ready(function() {
      $('#add-color').click(function() {
        const colorInput = `
            <div class="d-flex mb-2 color-input-group">
                <input type="color" name="color[]" class="form-control form-control-color me-2" value="#000000">
                <button type="button" class="btn btn-danger remove-color">Remove</button>
            </div>`;
        $('#color-container').append(colorInput);
      });

      $(document).on('click', '.remove-color', function() {
        $(this).closest('.color-input-group').remove();
      });
    });
  </script>
@endpush
