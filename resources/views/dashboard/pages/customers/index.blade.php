@extends('dashboard.layouts.app')
@section('title', 'Customers List')

@section('content')
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">All Customers</h2>
      <a class="btn btn-primary" href="{{ route('dashboard.customers.create') }}">+ Add Customer</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table-bordered table-hover table align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Total Purchases</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($customers as $customer)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $customer->name }}</td>
              <td>{{ $customer->phone }}</td>
              <td>{{ $customer->email ?? '—' }}</td>
              <td>{{ $customer->address }}</td>
              <td>{{ $customer->sales->count() }}</td>
              <td>
                <a class="btn btn-sm btn-info"
                  href="{{ route('dashboard.customers.show', $customer->id) }}">View</a>
                <a class="btn btn-sm btn-warning"
                  href="{{ route('dashboard.customers.edit', $customer->id) }}">Edit</a>
                <form class="d-inline" action="{{ route('dashboard.customers.destroy', $customer->id) }}"
                  method="POST" onsubmit="return confirm('Delete this customer?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-muted text-center" colspan="7">No customers found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
