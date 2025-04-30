@extends('dashboard.layouts.app')
@section('title', 'Purchase Invoice')

@section('content')
<div class="container">
  <div class="card shadow p-4">
    <div class="d-flex justify-content-between mb-3">
      <h3>Purchase Invoice</h3>
      <a href="{{ route('dashboard.purchases.index') }}" class="btn btn-secondary btn-sm">← Back to List</a>
    </div>

    <!-- Invoice Header -->
    <div class="row mb-4">
      <div class="col-md-6">
        <h5>Supplier Info:</h5>
        <p>
          <strong>{{ $purchase->supplier->name ?? 'N/A' }}</strong><br>
          Phone: {{ $purchase->supplier->phone ?? 'N/A' }}<br>
          Address: {{ $purchase->supplier->address ?? 'N/A' }}
        </p>
      </div>
      <div class="col-md-6 text-md-end">
        <h5>Invoice Details:</h5>
        <p>
          <strong>Invoice #:</strong> {{ $purchase->invoice_no }}<br>
          <strong>Date:</strong> {{ $purchase->purchase_date->format('d M Y') }}<br>
        </p>
      </div>
    </div>

    <!-- Products Table -->
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Category</th>
            <th>Unit Price (৳)</th>
            <th>Quantity</th>
            <th>Subtotal (৳)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($purchase->purchaseItems as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->product->name }}</td>
              <td>{{ $item->product->category->name ?? 'N/A' }}</td>
              <td>{{ number_format($item->unit_price, 2) }}</td>
              <td>{{ $item->quantity }}</td>
              <td>{{ number_format($item->unit_price * $item->quantity, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot class="table-light fw-bold">
          <tr>
            <td colspan="5" class="text-end">Total:</td>
            <td>{{ number_format($purchase->total_amount, 2) }} ৳</td>
          </tr>
          <tr>
            <td colspan="5" class="text-end">Paid:</td>
            <td>{{ number_format($purchase->paid_amount, 2) }} ৳</td>
          </tr>
          <tr class="text-danger">
            <td colspan="5" class="text-end">Due:</td>
            <td>{{ number_format($purchase->due_amount, 2) }} ৳</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endsection
