@extends('dashboard.layouts.app')
@section('title', 'Dashboard')
@section('content')
  <div class="container py-4">
    <div class="row">
      {{-- Sales Overview --}}
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">Sales Overview</div>
          <div class="card-body">
            <h5 class="card-title">{{ $totalSales }} USD</h5>
            <p class="card-text">Total Sales This Month</p>
          </div>
        </div>
      </div>

      {{-- Products Overview --}}
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">Products Overview</div>
          <div class="card-body">
            <h5 class="card-title">{{ $totalProducts }} Products</h5>
            <p class="card-text">Total Products in Inventory</p>
          </div>
        </div>
      </div>

      {{-- Total Stock --}}
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header bg-warning text-white">Total Stock</div>
          <div class="card-body">
            <h5 class="card-title">{{ $totalStock }} Items</h5>
            <p class="card-text">Total Stock Available</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      {{-- Sales Chart --}}
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">Sales Chart</div>
          <div class="card-body">
            <canvas id="salesChart"></canvas>
          </div>
        </div>
      </div>

      {{-- Product Breakdown Chart --}}
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">Product Breakdown</div>
          <div class="card-body">
            <canvas id="productChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Sales Chart Data
    const salesChart = new Chart(document.getElementById('salesChart'), {
      type: 'line',
      data: {
        labels: @json($salesData['dates']),
        datasets: [{
          label: 'Sales',
          data: @json($salesData['values']),
          borderColor: 'rgb(75, 192, 192)',
          fill: false,
        }]
      },
      options: {
        responsive: true,
        scales: {
          x: { beginAtZero: true },
          y: { beginAtZero: true }
        }
      }
    });

    // Product Breakdown Chart
    const productChart = new Chart(document.getElementById('productChart'), {
      type: 'pie',
      data: {
        labels: @json($productCategories['names']),
        datasets: [{
          label: 'Product Categories',
          data: @json($productCategories['counts']),
          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
          borderColor: 'rgba(255, 255, 255, 0.5)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
      }
    });
  </script>
@endpush
