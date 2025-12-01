<!DOCTYPE html>
<html>
<head>
    <title>Order #{{ $order ?? 'N/A' }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #0496ff; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f5f5f5; }
        .text-end { text-align: right; }
        .total-row { font-weight: bold; background: #f5f5f5; }
        .info-section { margin-bottom: 20px; }
        .info-section h3 { margin-bottom: 10px; color: #333; }
    </style>
</head>
<body>
    <div class="header">
        <h1>GrowUp E-Commerce</h1>
        <p>Order Receipt</p>
    </div>

    <div class="info-section">
        <h3>Order Information</h3>
        <p><strong>Order #:</strong> {{ $order ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ now()->format('M d, Y H:i A') }}</p>
        <p><strong>Status:</strong> Pending</p>
    </div>

    <div class="info-section">
        <h3>Customer Information</h3>
        <p><strong>Name:</strong> Customer Name</p>
        <p><strong>Email:</strong> customer@email.com</p>
        <p><strong>Phone:</strong> +880 1XXX-XXXXXX</p>
        <p><strong>Address:</strong> Dhaka, Bangladesh</p>
    </div>

    <h3>Order Items</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Qty</th>
                <th class="text-end">Price</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Sample Product</td>
                <td>1</td>
                <td class="text-end">৳0.00</td>
                <td class="text-end">৳0.00</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end">Subtotal:</td>
                <td class="text-end">৳0.00</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end">Shipping:</td>
                <td class="text-end">৳0.00</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-end">Total:</td>
                <td class="text-end">৳0.00</td>
            </tr>
        </tfoot>
    </table>

    <p style="text-align: center; margin-top: 40px; color: #666;">
        Thank you for your purchase!<br>
        GrowUp E-Commerce | info@growup.com
    </p>

    <script>window.onload = function() { window.print(); }</script>
</body>
</html>

