<style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: middle;
        border: 1px solid #ddd;
        text-align: left !important;
    }

    table {
        page-break-inside: auto
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

    thead {
        display: table-header-group
    }

    tfoot {
        display: table-footer-group
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .container-invoice {
        width: 900px;
        padding: 40px;
        background: white;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .header-section {
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom: 3px solid #4CAF50;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .company-info {
        text-align: center;
    }

    .company-info h1 {
        font-size: 2.5rem !important;
        margin: 0 0 10px 0;
        color: #2c3e50;
        font-weight: bold;
    }

    .company-info h6 {
        font-size: 13px;
        margin: 5px 0;
        color: #555;
        font-weight: normal;
    }

    .invoice-info {
        text-align: center;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 25px;
    }

    .invoice-info h3 {
        font-size: 18px;
        margin: 0;
        color: #4CAF50;
        font-weight: bold;
        text-transform: uppercase;
    }

    .details-section {
        margin-top: 25px;
    }

    .info-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #4CAF50;
        margin-bottom: 10px;
    }

    .info-box h4 {
        margin: 0 0 15px 0;
        font-weight: bold;
        font-size: 15px;
        color: #2c3e50;
        border-bottom: 2px dotted #ddd;
        padding-bottom: 8px;
    }

    .info-row {
        display: flex;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .info-row strong {
        min-width: 120px;
        color: #555;
    }

    .info-row span {
        flex: 1;
        color: #2c3e50;
        font-weight: 500;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .details-table thead {
        background: linear-gradient(to right, #4CAF50, #45a049);
        color: white;
    }

    .details-table thead th {
        border: 1px solid #45a049 !important;
        padding: 12px 8px;
        text-align: center !important;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
    }

    .details-table tbody td {
        border: 1px solid #ddd;
        padding: 10px 8px;
        font-size: 13px;
        color: #2c3e50;
    }

    .details-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .details-table tbody tr:hover {
        background-color: #f0f8f0;
        transition: background-color 0.2s;
    }

    .details-table tfoot {
        background: #f8f9fa;
        font-weight: bold;
    }

    .details-table tfoot td {
        border: 1px solid #ddd;
        padding: 12px 8px;
        font-size: 14px;
        color: #2c3e50;
    }

    .section-title {
        font-size: 16px;
        font-weight: bold;
        color: #2c3e50;
        margin: 30px 0 15px 0;
        padding-bottom: 8px;
        border-bottom: 2px solid #4CAF50;
    }

    .amount-words {
        margin-top: 15px;
        padding: 15px;
        background: #e8f5e9;
        border-left: 4px solid #4CAF50;
        font-size: 13px;
        font-weight: 600;
        color: #2c3e50;
        border-radius: 4px;
    }

    .footer-section {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
        padding-top: 30px;
        border-top: 2px solid #eee;
    }

    .footer-box {
        text-align: center;
        font-size: 13px;
        width: 30%;
    }

    .footer-box strong {
        display: block;
        margin-top: 40px;
        padding-top: 10px;
        border-top: 2px solid #333;
        color: #2c3e50;
    }

    .footer-box p {
        margin: 5px 0;
        color: #555;
    }

    @media print {
        body {
            background: white;
        }

        .container-invoice {
            box-shadow: none;
            margin: 0;
            padding: 20px;
        }
    }
</style>

<div class="container-invoice">
    <!-- Header Section -->
    <div class="header-section">
        <div class="company-info">
            <h1>{{ $company_info->name }}</h1>
            <h6>{{ $company_info->address }}</h6>
            <h6>{{ __('messages.email') }}: {{ $company_info->email }} |
                {{ __('messages.phone') }}: {{ $company_info->phone }}</h6>
        </div>
    </div>

    <!-- Invoice Type -->
    <div class="invoice-info">
        <h3>{{ __('messages.product_transfer_invoice') }}</h3>
    </div>

    <!-- Transfer Information Section -->
    <div class="details-section"
        style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 30px;">

        <!-- Transfer Date -->
        <div class="info-box">
            <h4>{{ __('messages.transfer_information') }}</h4>
            <div class="info-row">
                <strong>{{ __('messages.date') }}:</strong>
                <span>{{ date('d/m/Y', strtotime($transfer->date)) }}</span>
            </div>

        </div>

        <!-- From Branch -->
        <div class="info-box">
            <h4>{{ __('messages.from_branch') }}</h4>
            <div class="info-row">
                <strong>{{ __('messages.name') }}:</strong>
                <span>{{ $transfer->formBranch->name ?? '' }}</span>
            </div>
            <div class="info-row">
                <strong>{{ __('messages.email') }}:</strong>
                <span>{{ $transfer->formBranch->email ?? '' }}</span>
            </div>
            <div class="info-row">
                <strong>{{ __('messages.address') }}:</strong>
                <span>{{ $transfer->formBranch->address ?? '' }}</span>
            </div>
        </div>

        <!-- To Branch -->
        <div class="info-box">
            <h4>{{ __('messages.to_branch') }}</h4>
            <div class="info-row">
                <strong>{{ __('messages.name') }}:</strong>
                <span>{{ $transfer->toBranch->name ?? '' }}</span>
            </div>
            <div class="info-row">
                <strong>{{ __('messages.email') }}:</strong>
                <span>{{ $transfer->toBranch->email ?? '' }}</span>
            </div>
            <div class="info-row">
                <strong>{{ __('messages.address') }}:</strong>
                <span>{{ $transfer->toBranch->address ?? '' }}</span>
            </div>
        </div>

    </div>

    <!-- Product Details Title -->
    <h5 class="section-title">{{ __('messages.transfer_information') }}</h5>

    <!-- Product List Table -->
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 5%;">{{ __('messages.serial_no') }}</th>
                <th style="width: 25%;">{{ __('messages.product') }}</th>
                <th style="width: 12%;">{{ __('messages.size') }}</th>
                <th style="width: 12%;">{{ __('messages.color') }}</th>
                <th style="width: 12%; text-align: center;">{{ __('messages.quantity') }}</th>
                <th style="width: 15%; text-align: right;">{{ __('messages.rate') }}</th>
                <th style="width: 19%; text-align: right;">{{ __('messages.total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transfer->details as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->variant->product->name ?? '' }}</td>
                    <td>{{ $item->variant->size->name ?? '' }}</td>
                    <td>{{ $item->variant->color->color_name ?? '' }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->rate, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right;"><strong>{{ __('messages.total_amount') }}:</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($transfer->total_amount, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Amount in Words -->
    @if (isset($amountInWords))
        <div class="amount-words">
            {{ __('messages.amount_in_words') }}: {{ $amountInWords }}
        </div>
    @endif



</div>
