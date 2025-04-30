@extends('dashboard.layouts.app')
@section('title', 'Suppliers List')
@section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>All Suppliers</h1>
      <a class="btn btn-primary" href="{{ route('dashboard.suppliers.create') }}">Add New Supplier</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-body table-responsive">
        <table class="table-striped table-hover table">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Company</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($suppliers as $supplier)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->company_name }}</td>
                <td>{{ $supplier->email ?? 'N/A' }}</td>
                <td>{{ $supplier->phone ?? 'N/A' }}</td>
                <td>{{ $supplier->address }}</td>
                <td>
                  <a class="btn btn-sm btn-warning"
                    href="{{ route('dashboard.suppliers.edit', $supplier->id) }}">Edit</a>
                  <form class="d-inline" action="{{ route('dashboard.suppliers.destroy', $supplier->id) }}"
                    method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td class="text-center" colspan="8">No suppliers found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
