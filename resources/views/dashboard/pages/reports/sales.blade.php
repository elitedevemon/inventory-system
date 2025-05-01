@extends('dashboard.layouts.app')
@section('title', 'Sales Report')

@section('content')
  <div class="container py-4">
    <h2 class="mb-4">Sales Report</h2>

    <div class="row">
      <!-- Pie Chart for Product Sales -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Sales by Product</div>
          <div class="card-body">
            <canvas id="salesPieChart" height="200"></canvas>
          </div>
        </div>
      </div>

      <!-- Line Chart for Daily Sales -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Sales Over Time</div>
          <div class="card-body">
            <canvas id="salesLineChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      // Data from backend
      const productNames = @json($salesPerProduct->pluck('name'));
      const productTotals = @json($salesPerProduct->pluck('total'));

      const salesDates = @json($salesPerDay->pluck('date'));
      const salesTotals = @json($salesPerDay->pluck('total'));

      // Pie Chart
      new Chart(document.getElementById('salesPieChart'), {
        type: 'pie',
        data: {
          labels: productNames,
          datasets: [{
            label: 'Total Sales',
            data: productTotals,
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
          }]
        }
      });

      // Line Chart
      new Chart(document.getElementById('salesLineChart'), {
        type: 'line',
        data: {
          labels: salesDates,
          datasets: [{
            label: 'Sales Amount',
            data: salesTotals,
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            fill: true,
            tension: 0.4,
          }]
        }
      });
    </script>
  @endpush
@endsection
