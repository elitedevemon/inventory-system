@extends('dashboard.layouts.app')
@section('title', 'Sales List')

@section('content')
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">All Sales</h2>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Sale Form -->
    <div class="card mb-4">
      <div class="card-header">
        <h4>Sell Product to Customer</h4>
      </div>
      <div class="card-body">
        <form id="addSaleForm">
          @csrf
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="customer_id">Customer</label>
              <select class="form-select" id="customer_id" name="customer_id">
                <option selected disabled>Select Customer</option>
                @foreach ($customers as $customer)
                  <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label for="payment_method">Payment Method</label>
              <select class="form-select" id="payment_method" name="payment_method">
                <option value="cash">Cash</option>
                <option value="bkash">Bkash</option>
                <option value="bank">Bank</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="paid_amount">Paid Amount</label>
              <input class="form-control" id="paid_amount" name="paid_amount" type="number" step="0.01">
            </div>
          </div>

          <div id="productWrapper">
            <div class="row product-row align-items-end mb-2">
              <div class="col-md-4">
                <label>Product</label>
                <select class="form-select product-select">
                  <option disabled selected>Select Product</option>
                  @foreach ($products as $product)
                    <option data-price="{{ $product->price }}" value="{{ $product->id }}">
                      {{ $product->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-2">
                <label>Quantity</label>
                <input class="form-control product-quantity" type="number" value="1" min="1">
              </div>

              <div class="col-md-3">
                <label>Payable</label>
                <input class="form-control payable-amount" type="text" value="0.00" readonly>
              </div>

              <div class="col-md-2">
                <label>&nbsp;</label>
                <button class="btn btn-danger remove-product w-100" type="button">Remove</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6 offset-md-6 text-end">
              <h5>Total Payable: <span id="totalPayableAmount">0.00</span> ৳</h5>
            </div>
          </div>

          <button class="btn btn-secondary mt-3" id="addMoreProduct" type="button">+ Add More Product</button>
          <button class="btn btn-primary mt-3" type="submit">Sell Products</button>
        </form>
      </div>
    </div>

    <!-- Sales Table -->
    <div class="table-responsive mt-4" id="salesTable">
      <table class="table-bordered table-hover table align-middle" id="salesDataTable">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Invoice No</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Product(s)</th>
            <th>Due</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="salesDataBody">
          @foreach ($sales as $sale)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $sale->invoice_no }}</td>
              <td>{{ $sale->customer->name }}</td>
              <td>{{ $sale->sale_date->format('d M, Y') }}</td>
              <td>
                @foreach ($sale->saleItems as $item)
                  {{ $item->product->name }} (x{{ $item->quantity }})<br>
                @endforeach
              </td>
              <td class="text-danger">{{ number_format($sale->due_amount ?? 0, 2) }} ৳</td>
              <td class="text-end">
                @if ($sale->due_amount > 0)
                  <button class="btn btn-sm btn-danger payDueBtn" data-id="{{ $sale->id }}">Pay
                    Due</button>
                @endif
                <a class="btn btn-sm btn-info" href="{{ route('dashboard.sales.show', $sale->id) }}">View</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        // Add product row
        $('#addMoreProduct').click(function() {
          $('#productWrapper').append(`
            <div class="row product-row align-items-end mt-2">
              <div class="col-md-4">
                <label>Product</label>
                <select class="form-select product-select">
                  <option disabled selected>Select Product</option>
                  @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                      {{ $product->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-2">
                <label>Quantity</label>
                <input type="number" class="form-control product-quantity" placeholder="Quantity" min="1" value="1">
              </div>

              <div class="col-md-3">
                <label>Payable</label>
                <input type="text" class="form-control payable-amount" readonly value="0.00">
              </div>

              <div class="col-md-2">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-danger remove-product w-100">Remove</button>
              </div>
            </div>
          `);
        });


        $(document).on('click', '.remove-product', function() {
          $(this).closest('.product-row').remove();
          updateTotalPayable();
        });

        function updatePayableAmount(row) {
          const price = parseFloat(row.find('.product-select option:selected').data('price')) || 0;
          const quantity = parseInt(row.find('.product-quantity').val()) || 0;
          const total = price * quantity;
          row.find('.payable-amount').val(total.toFixed(2));

          updateTotalPayable();
        }

        function updateTotalPayable() {
          let total = 0;
          $('.payable-amount').each(function() {
            total += parseFloat($(this).val()) || 0;
          });
          $('#totalPayableAmount').text(total.toFixed(2));
        }

        // Trigger on change of product or quantity
        $(document).on('change', '.product-select, .product-quantity', function() {
          const row = $(this).closest('.product-row');
          updatePayableAmount(row);
        });



        // Handle Sale Form Submission
        $('#addSaleForm').submit(function(e) {
          e.preventDefault();
          const products = [];
          $('.product-row').each(function() {
            const product_id = $(this).find('.product-select').val();
            const quantity = $(this).find('.product-quantity').val();

            if (product_id && quantity) {
              products.push({
                product_id: product_id,
                quantity: quantity
              });
            }
          });

          const customerId = $('#customer_id').val();
          const paidAmount = $('#paid_amount').val();
          const paymentMethod = $('#payment_method').val();

          // Simple validation
          if (!customerId || !paidAmount || products.length === 0) {
            alert('Please fill all required fields and add at least one product.');
            return;
          }

          const formData = {
            _token: '{{ csrf_token() }}',
            customer_id: customerId,
            paid_amount: paidAmount,
            payment_method: paymentMethod,
            products: products
          };

          $.ajax({
            url: "{{ route('dashboard.sales.store') }}",
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
              if (response.success) {
                loadSalesTable();
                alert('Sale added successfully');
                $('#addSaleForm')[0].reset();
              }
            },
            error: function(xhr) {
              if (xhr.status === 422 || xhr.status === 400) {
                alert(xhr.responseJSON.message);
              } else {
                alert('Something went wrong!');
              }
            }
          });
        });

        // Load Sales Table
        function loadSalesTable() {
          $.ajax({
            url: "{{ route('dashboard.sales.index') }}",
            method: 'GET',
            success: function(response) {
              $('#salesDataBody').html(response);
            }
          });
        }

        // Handle Due Payment
        $(document).on('click', '.payDueBtn', function() {
          const saleId = $(this).data('id');
          const amount = prompt("Enter amount to pay:");

          if (amount && !isNaN(amount)) {
            $.ajax({
              url: `/dashboard/sales/pay-due/${saleId}`,
              method: 'POST',
              data: {
                _token: "{{ csrf_token() }}",
                amount: amount
              },
              success: function(response) {
                alert(response.message);
                loadSalesTable();
              },
              error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Payment failed.');
              }
            });
          }
        });
      });
    </script>
  @endpush
@endsection
