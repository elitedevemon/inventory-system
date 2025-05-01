@extends('dashboard.layouts.app')
@section('title', 'Purchase Report')

@section('content')
<div class="container">
  <h4 class="mb-4">Purchase Reports</h4>

  <div class="row">
    <div class="col-md-6">
      <canvas id="purchasePieChart"></canvas>
    </div>
    <div class="col-md-6">
      <canvas id="purchaseLineChart"></canvas>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const purchasePieCtx = document.getElementById('purchasePieChart').getContext('2d');
  const purchaseLineCtx = document.getElementById('purchaseLineChart').getContext('2d');

  const purchasesPerProduct = @json($purchasesPerProduct);
  const purchasesPerDay = @json($purchasesPerDay);

  new Chart(purchasePieCtx, {
    type: 'pie',
    data: {
      labels: purchasesPerProduct.map(p => p.name),
      datasets: [{
        label: 'Total Purchase',
        data: purchasesPerProduct.map(p => p.total),
        backgroundColor: ['#f39c12', '#00c0ef', '#dd4b39', '#00a65a']
      }]
    }
  });

  new Chart(purchaseLineCtx, {
    type: 'line',
    data: {
      labels: purchasesPerDay.map(p => p.date),
      datasets: [{
        label: 'Daily Purchase Total',
        data: purchasesPerDay.map(p => p.total),
        borderColor: '#3c8dbc',
        fill: false
      }]
    }
  });
</script>
@endpush
