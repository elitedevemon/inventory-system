@extends('dashboard.layouts.app')
@section('title', 'Customer Profile')

@section('content')
  <div class="container">
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card rounded-4 border-0 shadow-sm">
          <div
            class="card-header d-flex justify-content-between align-items-center bg-primary rounded-top-4 text-white">
            <h4 class="mb-0">👤 Customer Profile</h4>
            <a class="btn btn-light btn-sm" href="{{ route('dashboard.customers.index') }}">
              ← Back to List
            </a>
          </div>
          <div class="card-body p-4">
            <div class="table-responsive">
              <table class="table-borderless table-striped mb-0 table">
                <tbody>
                  <tr>
                    <th style="width: 180px;">Name:</th>
                    <td>{{ $customer->name }}</td>
                  </tr>
                  <tr>
                    <th>Phone:</th>
                    <td>{{ $customer->phone }}</td>
                  </tr>
                  <tr>
                    <th>Email:</th>
                    <td>{{ $customer->email ?? 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Address:</th>
                    <td>{{ $customer->address ?? 'N/A' }}</td>
                  </tr>
                  {{-- Optional: Add more fields like created_at, status, etc. --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h3 class="mt-5">Sale History</h3>

    <div class="table-responsive mt-3">
      <table class="table-bordered table-hover table align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Invoice No</th>
            <th>Sale Date</th>
            <th>Total Products</th>
            <th>Total Amount</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Payment Method</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($customer->sales as $sale)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $sale->invoice_no }}</td>
              <td>{{ $sale->sale_date->format('d M, Y') }}</td>
              <td>{{ $sale->total_product }}</td>
              <td>{{ number_format($sale->total_amount, 2) }} ৳</td>
              <td>{{ number_format($sale->paid_amount, 2) }} ৳</td>
              <td class="{{ $sale->due_amount > 0 ? 'text-danger fw-bold' : '' }}">
                {{ number_format($sale->due_amount ?? 0, 2) }} ৳
              </td>
              <td>{{ ucfirst($sale->payment_method) }}</td>
              <td>
                @if ($sale->due_amount > 0)
                  <button class="btn btn-sm btn-warning pay-due-btn" data-sale-id="{{ $sale->id }}"
                    data-due="{{ $sale->due_amount }}">
                    Pay Due
                  </button>
                @else
                  <span class="text-success">Paid</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-muted text-center" colspan="9">No sales found for this customer.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Due Payment Modal -->
  <div class="modal fade" id="duePaymentModal" aria-labelledby="duePaymentModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog">
      <form id="duePaymentForm" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Pay Due Amount</h5>
            <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input id="sale_id" name="sale_id" type="hidden">
            <div class="mb-3">
              <label class="form-label" for="paid_amount">Amount to Pay</label>
              <input class="form-control" id="paid_amount" name="paid_amount" type="number" min="1"
                step="0.01" required>
              <small class="text-muted">Max due: <span id="max_due"></span> ৳</small>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Confirm Payment</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).on('click', '.pay-due-btn', function() {
      let saleId = $(this).data('sale-id');
      let due = $(this).data('due');

      $('#sale_id').val(saleId);
      $('#paid_amount').attr('max', due).val('');
      $('#max_due').text(due.toFixed(2));
      $('#duePaymentModal').modal('show');
    });

    $('#duePaymentForm').submit(function(e) {
      e.preventDefault();
      const saleId = $('#sale_id').val();
      const paidAmount = $('#paid_amount').val();

      $.ajax({
        url: "{{ route('dashboard.customers.pay-due') }}", // You must create this route & controller
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          sale_id: saleId,
          paid_amount: paidAmount
        },
        success: function(response) {
          location.reload(); // Reload to reflect updated payment
        },
        error: function(xhr) {
          alert('Something went wrong. Please try again.');
        }
      });
    });
  </script>
@endsection
