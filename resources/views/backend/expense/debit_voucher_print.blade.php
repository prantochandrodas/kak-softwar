<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Voucher</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .voucher-wrapper {
            max-width: 850px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            background: #2c3e50;
            color: white;
            padding: 25px 30px;
            border-bottom: 4px solid #34495e;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .company-info {
            font-size: 13px;
            line-height: 1.5;
            opacity: 0.95;
        }

        /* Top Info Bar */
        .info-bar {
            display: flex;
            justify-content: space-between;
            padding: 20px 30px;
            background: #ecf0f1;
            border-bottom: 1px solid #bdc3c7;
        }

        .voucher-badge {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .badge {
            background: #e74c3c;
            color: white;
            padding: 8px 18px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 13px;
        }

        .badge.type {
            background: #27ae60;
        }

        .date-info {
            background: white;
            padding: 8px 18px;
            border: 1px solid #95a5a6;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            color: #2c3e50;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        .detail-row {
            display: flex;
            padding: 12px 15px;
            border-bottom: 1px solid #ecf0f1;
            background: #fafafa;
            margin-bottom: 2px;
        }

        .detail-row:last-child {
            margin-bottom: 20px;
        }

        .detail-label {
            font-weight: 600;
            color: #2c3e50;
            min-width: 150px;
            font-size: 14px;
        }

        .detail-value {
            color: #34495e;
            font-size: 14px;
            flex: 1;
        }

        /* Table */
        .expense-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #bdc3c7;
        }

        .expense-table thead {
            background: #34495e;
            color: white;
        }

        .expense-table th {
            padding: 12px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            border-right: 1px solid #2c3e50;
        }

        .expense-table th:last-child {
            border-right: none;
        }

        .expense-table tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid #ecf0f1;
            border-right: 1px solid #ecf0f1;
            color: #2c3e50;
            font-size: 14px;
        }

        .expense-table tbody td:last-child {
            border-right: none;
        }

        .expense-table tfoot {
            background: #ecf0f1;
        }

        .expense-table tfoot td {
            padding: 15px 12px;
            font-weight: bold;
            color: #2c3e50;
            font-size: 15px;
            border-right: 1px solid #bdc3c7;
        }

        .expense-table tfoot td:last-child {
            border-right: none;
        }

        .amount-text {
            text-align: right;
            font-weight: 600;
        }

        /* Signatures */
        .signatures {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
            padding: 25px 0;
        }

        .sign-box {
            text-align: center;
        }

        .sign-line {
            border-top: 1.5px solid #7f8c8d;

            margin-bottom: 8px;
        }

        .sign-label {
            font-size: 12px;
            color: #7f8c8d;
            font-weight: 600;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .voucher-wrapper {
                box-shadow: none;
            }
        }

        @media (max-width: 768px) {
            .signatures {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<script>
    window.print();
    window.onafterprint = function() {
        window.close();
        window.location.href = document.referrer;
    };
</script>

<body>
    <div class="voucher-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="company-name">{{ $company_info->name }}</div>
            <div class="company-info">
                {{ $company_info->address }}<br>
                {{ __('messages.email') }}: {{ $company_info->email }} | {{ __('messages.phone') }}:
                {{ $company_info->phone }}
            </div>
        </div>

        <!-- Info Bar -->
        <div class="info-bar">
            <div class="voucher-badge">
                <div class="badge">{{ __('messages.voucher_no') }}: {{ $model->invoice_no }}</div>
                <div class="badge type">{{ __('messages.debit_voucher') }}</div>
            </div>
            <div class="date-info">
                {{ __('messages.date') }}: {{ date('d/m/Y', strtotime($model->date)) }}
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Details -->
            <div class="detail-row">
                <div class="detail-label">{{ __('messages.expense_head') }}:</div>
                <div class="detail-value">
                    @if ($model->head)
                        {{ $model->head->name }}
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">{{ __('messages.payment') }} {{ __('messages.fund') }}:</div>
                <div class="detail-value">
                    @if ($model->fund)
                        {{ $model->fund->name }}
                        @if ($model->bank)
                            | {{ $model->bank->name }}
                            @if ($model->branch)
                                | {{ $model->branch->name }}
                            @endif
                            @if ($model->account)
                                | {{ __('messages.account_no') }}: {{ $model->account->account_number }}
                            @endif
                        @endif
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">{{ __('messages.receiver') }}:</div>
                <div class="detail-value">{{ $model->exp_person ?? '' }}</div>
            </div>

            <!-- Expense Table -->
            <table class="expense-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">{{ __('messages.serial_no') }}</th>
                        <th>{{ __('messages.details') }}</th>
                        <th style="width: 150px;">{{ __('messages.amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><strong>{{ $model->note }}</strong></td>
                        <td class="amount-text">{{ number_format($model->amount, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>{{ __('messages.total_amount') }}:</strong></td>
                        <td class="amount-text"><strong>{{ number_format($model->amount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Signatures -->
            <div class="signatures">
                <div class="sign-box">
                    <div class="sign-line"></div>
                    <div class="sign-label">{{ __('messages.prepared_by') }}</div>
                </div>
                <div class="sign-box">
                    <div class="sign-line"></div>
                    <div class="sign-label">{{ __('messages.checked_by') }}</div>
                </div>
                <div class="sign-box">
                    <div class="sign-line"></div>
                    <div class="sign-label">{{ __('messages.approved_by') }}</div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
