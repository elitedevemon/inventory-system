@extends('dashboard.layouts.app')
@section('title', 'Add New Purchase')

@section('content')
  <div class="container">
    <h2 class="mb-4">Add New Purchase</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Whoops!</strong> Please fix the following issues:
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('dashboard.purchases.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label" for="supplier_id">Select Supplier</label>
        <select class="form-select" id="supplier_id" name="supplier_id" required>
          <option selected disabled>-- Select Supplier --</option>
          @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label" for="purchase_date">Purchase Date</label>
        <input class="form-control" name="purchase_date" type="date" required>
      </div>

      <hr>
      <h5>Purchase Items</h5>

      <div id="items-wrapper">
        <div class="row item-row mb-3">
          <div class="col-md-5">
            <label class="form-label">Product</label>
            <select class="form-select" name="products[]" required>
              <option selected disabled>-- Select Product --</option>
              @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Quantity</label>
            <input class="form-control" name="quantities[]" type="number" min="1" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Unit Price</label>
            <input class="form-control" name="unit_prices[]" type="number" step="0.01" required>
          </div>
          <div class="col-md-1 d-flex align-items-end">
            <button class="btn btn-danger btn-sm remove-row" type="button">X</button>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <button class="btn btn-secondary" id="add-item" type="button">+ Add Item</button>
      </div>

      <div class="mb-3">
        <label class="form-label" for="payment_method">Payment Method</label>
        <select class="form-select" name="payment_method" required>
          <option value="cash">Cash</option>
          <option value="bkash">Bkash</option>
          <option value="bank">Bank</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label" for="paid_amount">Paid Amount (৳)</label>
        <input class="form-control" name="paid_amount" type="number" step="0.01" required>
      </div>

      <button class="btn btn-primary" type="submit">Save Purchase</button>
    </form>
  </div>

  @push('scripts')
    <script>
      document.getElementById('add-item').addEventListener('click', () => {
        const wrapper = document.getElementById('items-wrapper');
        const newRow = wrapper.querySelector('.item-row').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        wrapper.appendChild(newRow);
      });

      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
          const row = e.target.closest('.item-row');
          if (document.querySelectorAll('.item-row').length > 1) row.remove();
        }
      });
    </script>
  @endpush
@endsection
