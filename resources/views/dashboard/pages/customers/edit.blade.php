@extends('dashboard.layouts.app')

@section('title', 'Edit Customer')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow rounded-4 border-0">
          <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0">✏️ Edit Customer</h4>
            <a href="{{ route('dashboard.customers.index') }}" class="btn btn-sm btn-light">
              ← Back to List
            </a>
          </div>

          <div class="card-body p-4">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('dashboard.customers.update', $customer->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $customer->email) }}">
              </div>

              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
              </div>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4">
                  💾 Update Customer
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
