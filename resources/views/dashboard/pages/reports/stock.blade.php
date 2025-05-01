@extends('dashboard.layouts.app')
@section('title', 'Stock Report')

@section('content')
  <div class="container">
    <h4 class="mb-4">Stock Report</h4>
    <table class="table-bordered table-striped table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Purchased Quantity</th>
          <th>Sold Quantity</th>
          <th>Current Stock</th>
          <th>Stock Usage</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
          <tr class="{{ $product['stock'] <= 5 ? 'table-warning' : '' }}">
            <td>{{ $product['name'] }}</td>
            <td>{{ $product['purchased'] }}</td>
            <td>{{ $product['sold'] }}</td>
            <td>
              {{ $product['stock'] }}
              @if ($product['stock'] <= 5)
                <span class="badge bg-danger">Low Stock</span>
              @endif
            </td>
            <td>
              <div class="progress" style="height: 20px;">
                <div class="progress-bar bg-info" role="progressbar"
                  style="width: {{ $product['used_percent'] }}%;">
                  {{ $product['used_percent'] }}%
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <canvas id="stockChart" height="100"></canvas>
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('stockChart').getContext('2d');
    const stockChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($products->pluck('name')),
        datasets: [{
            label: 'Purchased',
            data: @json($products->pluck('purchased')),
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
          },
          {
            label: 'Sold',
            data: @json($products->pluck('sold')),
            backgroundColor: 'rgba(255, 99, 132, 0.6)'
          },
          {
            label: 'In Stock',
            data: @json($products->pluck('stock')),
            backgroundColor: 'rgba(75, 192, 192, 0.6)'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top'
          },
          title: {
            display: true,
            text: 'Product Stock Summary'
          }
        }
      }
    });
  </script>
@endpush
