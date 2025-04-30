@extends('dashboard.layouts.app')
@section('title', 'Add Supplier')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="mb-4">Add New Supplier</h2>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('dashboard.suppliers.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label" for="name">Supplier Name</label>
            <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}"
              required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="company_name">Company Name</label>
            <input class="form-control" id="company_name" name="company_name" type="text"
              value="{{ old('company_name') }}">
          </div>

          <div class="mb-3">
            <label class="form-label" for="email">Email (optional)</label>
            <input class="form-control" id="email" name="email" type="email"
              value="{{ old('email') }}">
          </div>

          <div class="mb-3">
            <label class="form-label" for="phone">Phone</label>
            <input class="form-control" id="phone" name="phone" type="text" value="{{ old('phone') }}"
              required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="address">Address</label>
            <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
          </div>

          <button class="btn btn-primary" type="submit">Save Supplier</button>
          <a class="btn btn-secondary" href="{{ route('dashboard.suppliers.index') }}">Cancel</a>
        </form>
      </div>
    </div>
  </div>
@endsection
