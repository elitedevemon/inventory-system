@extends('dashboard.layouts.app')
@section('title', 'Edit Category')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="mb-4">Edit Category</h2>

        @if ($errors->any())
          <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul class="mb-0 mt-2">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label" for="name">Category Name</label>
            <input class="form-control" id="name" name="name" type="text"
              value="{{ old('name', $category->name) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="description">Description (optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
          </div>

          <button class="btn btn-success" type="submit">Update Category</button>
          <a class="btn btn-secondary" href="{{ route('dashboard.categories.index') }}">Back to List</a>
        </form>
      </div>
    </div>
  </div>
@endsection
