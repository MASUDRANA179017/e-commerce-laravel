<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->order_number ?? 'N/A' }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; padding: 24px; color: #111; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { height: 50px; }
        .section { margin-bottom: 16px; }
        .title { font-weight: 700; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; }
        th { background: #f6f7fb; text-align: left; }
        .text-end { text-align: right; }
        .total-row { font-weight: 700; background: #f6f7fb; }
        .muted { color: #6b7280; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media print { body { padding: 0; } }
    </style>
    <meta charset="utf-8">
</head>
<body>
    <div class="header">
        <div class="brand">
            @if(isset($business_setup) && $business_setup->logo)
                <img src="{{ asset('storage/' . $business_setup->logo) }}" alt="{{ $business_setup->company_name }}">
                <div>
                    <div class="title">{{ $business_setup->company_name ?? 'GrowUp' }}</div>
                    <div class="muted">{{ $business_setup->street_address ?? 'Dhaka, Bangladesh' }}</div>
                </div>
            @else
                <div>
                    <div class="title">{{ $business_setup->company_name ?? 'GrowUp' }}</div>
                    <div class="muted">{{ $business_setup->street_address ?? 'Dhaka, Bangladesh' }}</div>
                </div>
            @endif
        </div>
        <div style="text-align:right">
            <div class="title">INVOICE</div>
            <div><strong>Invoice #:</strong> {{ $order->order_number ?? 'N/A' }}</div>
            <div><strong>Date:</strong> {{ $order->created_at ? $order->created_at->format('M d, Y H:i A') : now()->format('M d, Y H:i A') }}</div>
            <div><strong>Status:</strong> {{ ucfirst($order->status ?? 'pending') }}</div>
        </div>
    </div>

    <div class="grid section">
        <div>
            <div class="title muted">BILL TO</div>
            <div><strong>{{ $order->full_name ?? 'Guest' }}</strong></div>
            <div>{{ $order->email ?? 'N/A' }}</div>
            <div>{{ $order->phone ?? 'N/A' }}</div>
            <div>{{ $order->full_address ?? 'N/A' }}</div>
        </div>
        <div>
            <div class="title muted">SHIP TO</div>
            <div><strong>{{ $order->full_name ?? 'Guest' }}</strong></div>
            <div>{{ $order->full_address ?? 'Delivery Address' }}</div>
        </div>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th class="text-end">Qty</th>
                    <th class="text-end">Unit Price</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_name ?? 'Product' }}</td>
                    <td class="text-end">{{ $item->quantity ?? 0 }}</td>
                    <td class="text-end">৳{{ number_format($item->price ?? 0, 2) }}</td>
                    <td class="text-end">৳{{ number_format(($item->price ?? 0) * ($item->quantity ?? 0), 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-end muted">No items found</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                    <td class="text-end">৳{{ number_format($order->subtotal ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                    <td class="text-end">৳{{ number_format($order->shipping ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                    <td class="text-end">৳{{ number_format($order->tax ?? 0, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                    <td class="text-end"><strong>৳{{ number_format($order->total ?? 0, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="grid section">
        <div>
            <div class="title">Notes</div>
            <div class="muted">{{ $order->notes ?? 'Thank you for your purchase.' }}</div>
        </div>
        <div style="text-align:right">
            <div><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'cash') }}</div>
            <div><strong>Payment Status:</strong> {{ ucfirst($order->payment_status ?? 'pending') }}</div>
        </div>
    </div>

    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html>

