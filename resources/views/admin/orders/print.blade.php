<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->order_number ?? 'N/A' }}</title>
    <meta charset="utf-8">
    <style>
        @media print {
            @page { margin: 0; size: 80mm auto; }
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 76mm; /* Slightly less than 80mm to avoid overflow */
            margin: 0 auto;
            background: #fff;
            color: #000;
            padding: 2mm;
        }
        .header { text-align: center; margin-bottom: 10px; }
        .header img { max-width: 60px; max-height: 60px; margin-bottom: 5px; }
        .header h2 { font-size: 16px; margin: 0; font-weight: bold; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10px; }

        .divider { border-top: 1px dashed #000; margin: 5px 0; }

        .info-group { margin-bottom: 5px; font-size: 11px; }
        .info-group div { display: flex; justify-content: space-between; }

        .items-table { width: 100%; border-collapse: collapse; margin-top: 5px; font-size: 11px; }
        .items-table th { text-align: left; border-bottom: 1px dashed #000; padding: 2px 0; font-size: 10px; text-transform: uppercase; }
        .items-table td { padding: 4px 0; vertical-align: top; }
        .items-table .item-name { width: 45%; }
        .items-table .qty { text-align: center; width: 15%; }
        .items-table .price { text-align: right; width: 20%; }
        .items-table .total { text-align: right; width: 20%; }

        .totals-table { width: 100%; margin-top: 5px; border-top: 1px dashed #000; padding-top: 5px; font-size: 11px; }
        .totals-table td { padding: 2px 0; }
        .text-right { text-align: right; }
        .grand-total { font-weight: bold; font-size: 14px; border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 5px 0; margin: 5px 0; }

        .footer { text-align: center; margin-top: 15px; font-size: 10px; }
        .barcode { text-align: center; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="invoice-container">
    <div class="header">
        @if(isset($business_setup) && $business_setup->logo)
            <img src="{{ asset('storage/' . $business_setup->logo) }}" alt="Logo">
        @endif
        <h2>{{ $business_setup->company_name ?? 'GrowUp' }}</h2>
        <p>{{ $business_setup->street_address ?? 'Dhaka, Bangladesh' }}</p>
        <p>Phone: {{ $business_setup->phone ?? 'N/A' }}</p>
    </div>

    <div class="divider"></div>

    <div class="info-group">
        <div><span>Invoice:</span> <span>#{{ $order->order_number }}</span></div>
        <div><span>Date:</span> <span>{{ $order->created_at ? $order->created_at->format('d-M-Y h:i A') : now()->format('d-M-Y h:i A') }}</span></div>
        @if($order->full_name && $order->full_name != 'Guest')
        <div><span>Customer:</span> <span>{{ $order->full_name }}</span></div>
        @endif
        @if($order->phone)
        <div><span>Phone:</span> <span>{{ $order->phone }}</span></div>
        @endif
    </div>

    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th class="item-name">ITEM</th>
                <th class="qty">QTY</th>
                <th class="price">PRICE</th>
                <th class="total">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order->items as $item)
            <tr>
                <td class="item-name">
                    {{ $item->product_name }}
                    @if($item->variant_name)
                    <br><small>({{ $item->variant_name }})</small>
                    @endif
                </td>
                <td class="qty">{{ $item->quantity }}</td>
                <td class="price">{{ number_format($item->price, 0) }}</td>
                <td class="total">{{ number_format($item->price * $item->quantity, 0) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">No items found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">৳{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->discount > 0)
        <tr>
            <td>Discount</td>
            <td class="text-right">-৳{{ number_format($order->discount, 2) }}</td>
        </tr>
        @endif
        @if($order->tax > 0)
        <tr>
            <td>Tax</td>
            <td class="text-right">+৳{{ number_format($order->tax, 2) }}</td>
        </tr>
        @endif
        @if($order->shipping > 0)
        <tr>
            <td>Shipping</td>
            <td class="text-right">+৳{{ number_format($order->shipping, 2) }}</td>
        </tr>
        @endif
    </table>

    <div class="grand-total">
        <div style="display: flex; justify-content: space-between;">
            <span>TOTAL</span>
            <span>৳{{ number_format($order->total_amount ?? ($order->subtotal + $order->tax + $order->shipping - $order->discount), 2) }}</span>
        </div>
    </div>

    @if($order->paid_amount)
    <div style="display: flex; justify-content: space-between; font-size: 11px;">
        <span>PAID</span>
        <span>৳{{ number_format($order->paid_amount, 2) }}</span>
    </div>
    @endif

    @if($order->change_amount)
    <div style="display: flex; justify-content: space-between; font-size: 11px;">
        <span>CHANGE</span>
        <span>৳{{ number_format($order->change_amount, 2) }}</span>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for shopping with us!</p>
        <p>Please come again.</p>
        <small>Software by Qbit-Tech</small>
    </div>
    </div>

    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html>
