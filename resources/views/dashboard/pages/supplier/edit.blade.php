@extends('dashboard.layouts.app')
@section('title', 'Edit Supplier')
@section('content')
  <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h2 class="mb-4">Edit Supplier</h2>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('dashboard.suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="name" class="form-label">Supplier Name</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
        </div>

        <div class="mb-3">
          <label for="company_name" class="form-label">Company Name</label>
          <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $supplier->company_name) }}">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $supplier->email) }}">
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" required>
        </div>

        <div class="mb-3">
          <label for="address" class="form-label">Address</label>
          <textarea class="form-control" id="address" name="address">{{ old('address', $supplier->address) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Supplier</button>
        <a href="{{ route('dashboard.suppliers.index') }}" class="btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection