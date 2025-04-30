@extends('dashboard.layouts.app')
@section('title', 'Purchases List')

@section('content')
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">All Purchases</h2>
      <a class="btn btn-primary" href="{{ route('dashboard.purchases.create') }}">+ Add New Purchase</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table-bordered table-hover table align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Invoice No</th>
            <th>Supplier</th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Payment Method</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($purchases as $purchase)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $purchase->invoice_no }}</td>
              <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
              <td>{{ $purchase->purchase_date->format('d M, Y') }}</td>
              <td>{{ number_format($purchase->total_amount, 2) }} ৳</td>
              <td>{{ number_format($purchase->paid_amount, 2) }} ৳</td>
              <td class="text-danger fw-bold">
                {{ number_format($purchase->due_amount, 2) }} ৳
              </td>
              <td>{{ ucfirst($purchase->payment_method) ?? 'N/A' }}</td>
              <td>
                <a class="btn btn-sm btn-info"
                  href="{{ route('dashboard.purchases.show', $purchase->id) }}">View</a>

                <form class="d-inline" action="{{ route('dashboard.purchases.destroy', $purchase->id) }}"
                  method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                </form>

                @if ($purchase->due_amount > 0)
                  <button class="btn btn-sm btn-success pay-due-btn" data-id="{{ $purchase->id }}"
                    data-due="{{ $purchase->due_amount }}">
                    <i class="fas fa-money-bill-wave"></i> Pay Due
                  </button>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-muted text-center" colspan="9">No purchases found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    $(document).on('click', '.pay-due-btn', function() {
      const purchaseId = $(this).data('id');
      const dueAmount = $(this).data('due');
      const amount = prompt(`Enter amount to pay (due: ${dueAmount} ৳):`, dueAmount);

      if (amount && !isNaN(amount) && parseFloat(amount) > 0) {
        $.ajax({
          url: `/dashboard/purchases/${purchaseId}/pay-due`,
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            amount: amount
          },
          success: function(res) {
            alert(res.message);
            location.reload(); // Refresh to show updated due
          },
          error: function(err) {
            alert('Something went wrong.');
            console.error(err);
          }
        });
      }
    });
  </script>
@endpush
