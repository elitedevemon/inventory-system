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
