<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fa;
        padding: 20px;
    }

    .container-invoice {
        max-width: 900px;

        background: white;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    /* Top Header Bar */
    .top-bar {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 6px 30px;
        color: white;
        font-size: 12px;
    }

    /* Main Header */
    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        border-bottom: 2px solid #1e3c72;
    }

    .company-info h1 {
        font-size: 2rem;
        color: #1e3c72;
        margin-bottom: 5px;
        font-weight: 800;
    }

    .company-info p {
        color: #666;
        font-size: 12px;
        margin: 2px 0;
    }

    .invoice-badge {
        text-align: right;
    }

    .invoice-badge .badge-title {
        font-size: 10px;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .invoice-badge .invoice-number {
        background: #1e3c72;
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 8px;
        box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
    }

    .invoice-badge .invoice-type {
        background: #f0f4f8;
        color: #1e3c72;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    /* Info Section */
    .info-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        padding: 15px 30px;
        background: #f8f9fa;
    }

    .info-box h3 {
        color: #1e3c72;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 2px solid #1e3c72;
    }

    .info-item {
        display: flex;
        margin: 6px 0;
        font-size: 13px;
    }

    .info-item strong {
        min-width: 100px;
        color: #333;
    }

    .info-item span {
        color: #666;
        flex: 1;
    }

    /* Table Section */
    .table-section {
        padding: 15px 30px;
    }

    .section-title {
        color: #1e3c72;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
        padding-bottom: 6px;
        border-bottom: 2px solid #e0e0e0;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
    }

    .details-table thead {
        background: #1e3c72;
        color: white;
    }

    .details-table th {
        padding: 10px 8px;
        text-align: left;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .details-table tbody tr {
        border-bottom: 1px solid #e8e8e8;
    }

    .details-table tbody tr:hover {
        background: #f8f9fa;
    }

    .details-table td {
        padding: 8px;
        color: #555;
        font-size: 12px;
    }

    .details-table tfoot {
        border-top: 2px solid #1e3c72;
    }

    .details-table tfoot tr {
        background: white;
    }

    .details-table tfoot td {
        padding: 8px;
        font-weight: 600;
        color: #333;
        font-size: 12px;
    }

    .details-table tfoot tr:last-child {
        background: #1e3c72;
        color: white;
    }

    .details-table tfoot tr:last-child td {
        color: white;
        font-size: 13px;
        font-weight: 700;
        padding: 10px 8px;
    }

    /* Footer Signature */
    .signature-section {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        padding: 20px 30px 15px 30px;
        margin-top: 20px;
        border-top: 2px solid #e0e0e0;
    }

    .signature-box {
        text-align: center;
    }

    .signature-line {
        border-top: 2px solid #333;
        padding-top: 8px;
        margin-top: 40px;
        font-size: 10px;
        color: #666;
        font-weight: 600;
    }

    /* Bottom Bar */
    .bottom-bar {
        background: #1e3c72;
        padding: 10px 30px;
        color: white;
        text-align: center;
        font-size: 11px;
    }

    /* Print Styles */
    @media print {
        body {
            background: white;
            padding: 0;
        }

        .container-invoice {
            box-shadow: none;
        }

        .top-bar,
        .details-table thead,
        .details-table tfoot tr:last-child,
        .bottom-bar {
            background: #1e3c72 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .info-section {
            background: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
    }

    @media (max-width: 768px) {
        .main-header {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .invoice-badge {
            text-align: center;
        }

        .info-section {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .signature-section {
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
    }
</style>

<div class="container-invoice">
    <!-- Top Bar -->
    <div class="top-bar">
        {{ __('messages.sale_invoice') }} | {{ __('messages.email') }}: {{ $company_info->email }} |
        {{ __('messages.phone') }}: {{ $company_info->phone }}
    </div>

    <!-- Main Header -->
    <div class="main-header">
        <div class="company-info">
            <h1>{{ $company_info->name }}</h1>
            <p>{{ $company_info->address }}</p>
        </div>
        <div class="invoice-badge">
            <div class="badge-title">{{ __('messages.invoice_no') }}</div>
            <div class="invoice-number">{{ $sale->invoice_no }}</div>
            <div class="invoice-type">{{ __('messages.sale_invoice') }}</div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-box">
            <h3>{{ __('messages.invoice_information') }}</h3>
            <div class="info-item">
                <strong>{{ __('messages.date') }}:</strong>
                <span>{{ date('d/m/Y', strtotime($sale->date)) }}</span>
            </div>
            <div class="info-item">
                <strong>{{ __('messages.invoice_no') }}:</strong>
                <span>{{ $sale->invoice_no }}</span>
            </div>
        </div>
    </div>

    <!-- Product Table -->
    <div class="table-section">
        <div class="section-title">{{ __('messages.sale') }} {{ __('messages.information') }}</div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>{{ __('messages.serial_no') }}</th>
                    <th>{{ __('messages.product') }}</th>
                    <th>{{ __('messages.size') }}</th>
                    <th>{{ __('messages.color') }}</th>
                    <th>{{ __('messages.quantity') }}</th>
                    <th>{{ __('messages.rate') }}</th>
                    <th>{{ __('messages.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->details as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->variant->product->name ?? '' }}</td>
                        <td>{{ $item->variant->size->name ?? '' }}</td>
                        <td>{{ $item->variant->color->color_name ?? '' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->rate, 2) }}</td>
                        <td>{{ number_format($item->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6"><strong>{{ __('messages.total_amount') }}</strong></td>
                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6"><strong>{{ __('messages.discount') }}</strong></td>
                    <td>{{ number_format($sale->discount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6"><strong>{{ __('messages.final_amount') }}</strong></td>
                    <td>{{ number_format($sale->total_amount - $sale->discount, 2) }}</td>
                </tr>

                <tr>
                    <td colspan="6"><strong>{{ __('messages.paid_amount') }}</strong></td>
                    <td>{{ number_format($sale->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6"><strong>{{ __('messages.due_amount') }}</strong></td>
                    <td>{{ number_format($sale->due_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Payment Table -->
    @if ($sale->payments->count() > 0)
        <div class="table-section" style="padding-top: 0;">
            <div class="section-title">{{ __('messages.payments') }}</div>

            <table class="details-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.serial_no') }}</th>
                        <th>{{ __('messages.fund') }}</th>
                        <th>{{ __('messages.bank') }}</th>
                        <th>{{ __('messages.bank_account') }}</th>
                        <th>{{ __('messages.amount') }}</th>
                    </tr>
                </thead>
                @php
                    $paymentTotal = 0;
                @endphp
                <tbody>
                    @foreach ($sale->payments as $index => $payment)
                        @php
                            $paymentTotal += $payment->amount;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->fund->name ?? '' }}</td>
                            <td>{{ $payment->bank->name ?? '-' }}</td>
                            <td>{{ $payment->account->account_number ?? '-' }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><strong>{{ __('messages.total_payment') }}</strong></td>
                        <td>{{ number_format($paymentTotal, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">{{ __('messages.prepared_by') }}</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">{{ __('messages.checked_by') }}</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">{{ __('messages.approved_by') }}</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">{{ __('messages.accountant') }}</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">{{ __('messages.managing_director') }}</div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar">
        Thank you for your business!
    </div>
</div>
