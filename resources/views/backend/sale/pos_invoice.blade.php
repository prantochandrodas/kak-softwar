<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background-color: #f0f0f0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .invoice-container {
            width: 400px;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #333;
            padding-bottom: 15px;
        }

        .shop-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .location {
            font-size: 12px;
            margin-bottom: 3px;
        }

        .contact {
            font-size: 11px;
            margin: 2px 0;
        }

        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 15px 0;
            padding: 10px;
            background: #f9f9f9;
            border: 1px dashed #999;
            font-size: 11px;
        }

        .info-section h5 {
            font-size: 12px;
            margin-bottom: 5px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }

        .info-section div {
            margin: 3px 0;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }

        .table-header {
            display: grid;
            grid-template-columns: 0.5fr 1.8fr 0.7fr 0.7fr 0.6fr 0.8fr 1fr;
            gap: 5px;
            font-weight: bold;
            font-size: 10px;
            border-bottom: 1px solid #333;
            padding: 5px 0;
            margin: 10px 0;
        }

        .table-header div:nth-child(5),
        .table-header div:nth-child(6),
        .table-header div:nth-child(7) {
            text-align: right;
        }

        .item {
            margin-bottom: 8px;
            font-size: 10px;
            border-bottom: 1px dotted #ddd;
            padding-bottom: 6px;
        }

        .item-details {
            display: grid;
            grid-template-columns: 0.5fr 1.8fr 0.7fr 0.7fr 0.6fr 0.8fr 1fr;
            gap: 5px;
            align-items: center;
        }

        .item-details div:nth-child(1) {
            text-align: center;
        }

        .item-details div:nth-child(5),
        .item-details div:nth-child(6),
        .item-details div:nth-child(7) {
            text-align: right;
        }

        .totals {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 11px;
        }

        .total-row.highlight {
            font-weight: bold;
            font-size: 13px;
            background: #f0f0f0;
            padding: 5px;
            margin: 8px 0;
        }

        .invoice-footer-info {
            font-size: 10px;
            margin: 10px 0;
            text-align: center;
        }

        .signature-section {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            font-size: 9px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 25px;
            padding-top: 3px;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px dashed #333;
            font-size: 11px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
                display: block;
            }

            .invoice-container {
                box-shadow: none;
                width: 80mm;
                margin: 0 auto;
            }

            .print-button {
                display: none;
            }
        }

        .print-button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
            margin: 20px auto;
            display: block;
        }

        .print-button:hover {
            background: #45a049;
        }
    </style>
</head>


<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="header">
            <div class="shop-name">{{ $company_info->name }}</div>
            <div class="location">{{ $company_info->address }}</div>
            <div class="contact">{{ __('messages.email') }}: {{ $company_info->email }} | {{ __('messages.phone') }}:
                {{ $company_info->phone }}</div>
        </div>

        <!-- Invoice & Customer Info -->
        <div class="invoice-info">
            <div class="info-section">
                <h5>{{ __('messages.invoice_information') }}</h5>
                <div><strong>{{ __('messages.invoice_no') }}:</strong> {{ $sale->invoice_no }}</div>
                <div><strong>{{ __('messages.date') }}:</strong> {{ date('d/m/Y', strtotime($sale->date)) }}</div>
            </div>
            <div class="info-section">
                <h5>{{ __('messages.customer_information') }}</h5>
                <div><strong>{{ __('messages.name') }}:</strong> {{ $sale->customer->name ?? '' }}</div>
                <div><strong>{{ __('messages.phone') }}:</strong> {{ $sale->customer->phone ?? '' }}</div>
                <div><strong>{{ __('messages.address') }}:</strong> {{ $sale->customer->address ?? '' }}</div>
            </div>
        </div>

        <!-- Sale Information Title -->
        <div class="section-title">{{ __('messages.sale') }} {{ __('messages.information') }}</div>

        <!-- Table Header -->
        <div class="table-header">
            <div>{{ __('messages.serial_no') }}</div>

            <div>{{ __('messages.quantity') }}</div>
            <div>{{ __('messages.rate') }}</div>
            <div>{{ __('messages.total') }}</div>
        </div>

        <!-- Items Container -->
        <div>
            @foreach ($sale->details as $index => $item)
                <div class="item">
                    <!-- First line: Product, Size, Color -->
                    <div style="font-size: 10px; font-weight: bold; margin-bottom: 3px;">
                        {{ $index + 1 }}. {{ $item->variant->product->name ?? '' }}
                        ({{ $item->variant->size->name ?? '' }}, {{ $item->variant->color->color_name ?? '' }})
                    </div>

                    <!-- Second line: Quantity, Rate, Total -->
                    <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 6px;">
                        <span>Qty: {{ $item->quantity }}</span>
                        <span>Rate: {{ number_format($item->rate, 2) }}</span>
                        <span>Total: {{ number_format($item->amount, 2) }}</span>
                    </div>

                    <hr style="border: 0.5px dotted #ddd; margin: 4px 0;">
                </div>
            @endforeach

        </div>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>{{ __('messages.total_amount') }}:</span>
                <span>{{ number_format($sale->total_amount - $sale->vat, 2) }}</span>
            </div>
            <div class="total-row">
                <span>{{ __('messages.vat') }} {{ __('messages.amount') }}:</span>
                <span>{{ number_format($sale->vat, 2) }}</span>
            </div>
            <div class="total-row">
                <span>{{ __('messages.discount') }}:</span>
                <span>{{ number_format($sale->discount, 2) }}</span>
            </div>
            <div class="total-row highlight">
                <span>{{ __('messages.final_amount') }}:</span>
                <span>{{ number_format($sale->total_amount - $sale->discount, 2) }}</span>
            </div>
            <div class="total-row">
                <span>{{ __('messages.paid_amount') }}:</span>
                <span>{{ number_format($sale->paid_amount, 2) }}</span>
            </div>
            <div class="total-row">
                <span>{{ __('messages.due_amount') }}:</span>
                <span>{{ number_format($sale->due_amount, 2) }}</span>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="invoice-footer-info">
            <div>Total Items: {{ count($sale->details) }}</div>
        </div>



        <!-- Footer -->
        <div class="footer">
            <div style="font-weight: bold;">{{ __('messages.thank_you_shopping') }}</div>
        </div>
    </div>



    <script>
        window.print();
        window.onafterprint = function() {
            window.close();
            window.location.href = document.referrer;
        };
    </script>
</body>

</html>
