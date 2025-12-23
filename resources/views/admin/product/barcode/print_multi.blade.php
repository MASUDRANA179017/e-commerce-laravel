<!DOCTYPE html>
<html>
<head>
    <title>Print All Barcodes</title>
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; background: #fff !important; }
            .label-item { border: none !important; }
        }
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
        }
        .print-area {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 20px;
            justify-content: center;
        }
        .label-item {
            width: 2in; /* Standard Label Width */
            height: auto;
            border: 1px dashed #ccc;
            padding: 10px;
            text-align: center;
            background: #fff;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .label-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .label-barcode {
            margin: 2px 0;
            width: 100%;
        }
        .label-barcode img {
            max-width: 100%;
            height: 35px;
            display: block;
            margin: 0 auto;
        }
        .label-sku {
            font-size: 10px;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        .label-price {
            font-size: 12px;
            font-weight: bold;
            margin-top: 2px;
        }
        .controls {
            padding: 15px;
            text-align: center;
            background: #343a40;
            color: #fff;
            margin-bottom: 20px;
        }
        .btn {
            padding: 8px 20px;
            background: #0d6efd;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
        }
        .btn:hover { background: #0b5ed7; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5c636a; }
    </style>
</head>
<body>

    <div class="controls no-print">
        <div style="margin-bottom: 10px;">
            <strong>Print Preview</strong> - {{ count($items) }} products x {{ $quantity }} labels each
        </div>
        <button onclick="window.print()" class="btn">Print Labels</button>
        <button onclick="window.close()" class="btn btn-secondary" style="margin-left: 10px;">Close</button>
    </div>

    <div class="print-area">
        @foreach($items as $item)
            @for($i = 0; $i < $item['quantity']; $i++)
                <div class="label-item">
                    <div class="label-title">{{ $item['product']->title }}</div>
                    <div class="label-barcode">
                        <img src="data:image/png;base64,{{ $item['barcode'] }}">
                    </div>
                    <div class="label-sku">{{ $item['product']->sku }}</div>
                    <div class="label-price">৳{{ number_format($item['product']->price, 0) }}</div>
                </div>
            @endfor
        @endforeach
    </div>

</body>
</html>