@extends('dashboard.layouts.app')
@section('title', 'Sale Invoice')

@section('content')
  <div class="container my-4">
    <div class="card rounded-3 shadow">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="mb-0">Sale Invoice</h3>
          <a class="btn btn-secondary" href="{{ route('dashboard.sales.index') }}">← Back to Sales</a>
        </div>

        {{-- Customer Details --}}
        <div class="row mb-4">
          <div class="col-md-6">
            <h5>Customer Information</h5>
            <p class="mb-1"><strong>Name:</strong> {{ $sale->customer->name }}</p>
            <p class="mb-1"><strong>Phone:</strong> {{ $sale->customer->phone }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $sale->customer->email ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $sale->customer->address ?? 'N/A' }}</p>
          </div>
          <div class="col-md-6 text-end">
            <p class="mb-1"><strong>Invoice No:</strong> {{ $sale->invoice_no }}</p>
            <p class="mb-1"><strong>Sale Date:</strong> {{ $sale->sale_date->format('d M Y') }}</p>
            <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($sale->payment_method) }}</p>
          </div>
        </div>

        {{-- Product Table --}}
        <div class="table-responsive">
          <table class="table-bordered table-hover table align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sale->saleItems as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->product->name }}</td>
                  <td>{{ number_format($item->unit_price, 2) }} ৳</td>
                  <td>{{ $item->quantity }}</td>
                  <td>{{ number_format($item->unit_price * $item->quantity, 2) }} ৳</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot class="fw-bold">
              <tr>
                <td class="text-end" colspan="4">Total Amount:</td>
                <td>{{ number_format($sale->total_amount, 2) }} ৳</td>
              </tr>
              <tr>
                <td class="text-end" colspan="4">Paid:</td>
                <td>{{ number_format($sale->paid_amount, 2) }} ৳</td>
              </tr>
              <tr class="{{ $sale->due_amount > 0 ? '' : 'd-none' }}">
                <td class="text-end text-danger" colspan="4">Due:</td>
                <td class="text-danger">{{ number_format($sale->due_amount, 2) }} ৳</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
