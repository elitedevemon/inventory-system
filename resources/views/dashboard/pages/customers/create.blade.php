@extends('dashboard.layouts.app')
@section('title', 'Add New Customer')

@section('content')
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Add New Customer</h2>
      <a href="{{ route('dashboard.customers.index') }}" class="btn btn-secondary">← Back to List</a>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('dashboard.customers.store') }}" method="POST">
      @csrf
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
          <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="address" class="form-label">Address</label>
          <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control">
        </div>
      </div>

      <button type="submit" class="btn btn-success">Create Customer</button>
    </form>
  </div>
@endsection
