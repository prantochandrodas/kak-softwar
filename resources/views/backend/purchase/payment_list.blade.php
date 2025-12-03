@extends('layouts.backend')

@section('title')
    {{ __('messages.payment-list') }}
@endsection

@section('main')
    <div class="container py-4">
        <h3 class="mb-4 text-primary fw-bold">{{ __('messages.payment_list') }}</h3>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('purchase-payment-list') }}" method="GET" class="row g-3">
                    @php
                        $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                        $sessionBranch = session('branch_id');
                    @endphp
                    @if ($isSuperAdmin && !$sessionBranch)
                        <div class="col-md-3">
                            <label for="branch_id" class="form-label mb-1"> {{ __('messages.branch') }}</label>
                            <select id="branch_id" name="branch_id" class="form-select form-select-sm">
                                <option value=""> {{ __('messages.select_one') }}</option>
                                @foreach ($branchInfo as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <label for="supplier_id" class="form-label fw-semibold">{{ __('messages.supplier') }} </label>
                        <select name="supplier_id" id="supplier_id" class="form-select">
                            <option value="">-- {{ __('messages.select_one') }} --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="from_date" class="form-label fw-semibold">{{ __('messages.start_date') }}</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ request('from_date') ?? $today }}">
                    </div>

                    <div class="col-md-3">
                        <label for="to_date" class="form-label fw-semibold">{{ __('messages.end_date') }}</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ request('to_date') ?? $today }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i
                                class="bi bi-search me-2"></i>{{ __('messages.search') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report Table -->
        @if (isset($reportData) && count($reportData) > 0)
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="mb-3 text-end">
                        <button onclick="printReport()" class="btn btn-success"><i
                                class="bi bi-printer me-2"></i>Print</button>
                    </div>

                    <div class="table-responsive" id="printableArea">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold">{{ __('messages.payment_list') }}</h4>
                            <p class="mb-0">
                                {{ __('messages.date') }}:
                                {{ \Carbon\Carbon::parse($from_date)->format('j F Y') }} to
                                {{ \Carbon\Carbon::parse($to_date)->format('j F Y') }}
                            </p>

                        </div>

                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th>{{ __('messages.supplier') }}</th>
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.bank') }}</th>
                                    <th>{{ __('messages.bank_account') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reportData as $data)
                                    <tr>
                                        <td class="text-start ps-3">{{ $data->supplier_name }}</td>
                                        <td>{{ $data->fund_name ?? '-' }}</td>
                                        <td>{{ $data->bank_name ?? '-' }}</td>
                                        <td>{{ $data->account_no ?? '-' }}</td>
                                        <td>{{ $data->amount }}</td>
                                        <td>{{ $data->date }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ __('messages.no_data_found') }}।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td class="text-end pe-3" colspan="4">{{ __('messages.total_amount') }}:</td>
                                    <td colspan="1" class="text-center">{{ $reportData->sum('amount') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        @else
            <div class="alert alert-warning text-center" role="alert">
                {{ __('messages.no_data_found') }}
            </div>
        @endif
    </div>

    <style>
        table th,
        table td {
            vertical-align: middle !important;
            padding: 0.75rem;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Print specific styles */
        @media print {
            body {
                margin: 20px;
                font-size: 12pt;
            }

            #printableArea {
                width: 100%;
            }

            #printableArea table {
                border-collapse: collapse;
                width: 100%;
            }

            #printableArea th,
            #printableArea td {
                border: 1px solid #000 !important;
                padding: 8px !important;
            }

            #printableArea thead th {
                background-color: #000 !important;
                color: #fff !important;
            }

            .btn,
            .alert,
            form,
            .card .card-body>.mb-3 {
                display: none !important;
                /* Hide buttons and form in print */
            }
        }
    </style>

    <script>
        function printReport() {
            var printContents = document.getElementById('printableArea').innerHTML;
            var printWindow = window.open('', '', 'height=800,width=1200');

            printWindow.document.write('<html><head><title>{{ __('messages.payment_list') }}</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; font-size: 12pt; }');

            // হেডার সেন্টার করা
            printWindow.document.write('.report-header { text-align: center; margin-bottom: 20px; }');
            printWindow.document.write('.report-header h4 { margin: 0; font-weight: bold; }');
            printWindow.document.write('.report-header p { margin: 2px 0; }');

            printWindow.document.write('table { border-collapse: collapse; width: 100%; margin-top: 10px; }');
            printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
            printWindow.document.write('thead th { background-color: #000; color: #fff; }');
            printWindow.document.write('td.text-start { text-align: left; padding-left: 12px; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');

            // হেডার div wrap করে inject করা
            printWindow.document.write('<div class="report-header">' +
                document.querySelector('#printableArea .text-center').innerHTML +
                '</div>');

            // টেবিল inject করা
            printWindow.document.write(document.querySelector('#printableArea table').outerHTML);

            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>


@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#branch_id').on('change', function() {
                let branchId = $(this).val();
                let supplierId = $('#supplier_id').val();

                let colorText = branchId ? $('#branch_id option:selected').text() : '';

                if (branchId) {
                    $.ajax({
                        url: '/admin/get-supplier/' + branchId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#branchName').text(colorText || '-');
                            $('#supplier_id').empty().append(
                                '<option value="">{{ __('messages.select_one') }}</option>'
                            );
                            $.each(data.supplier, function(key, value) {
                                $('#supplier_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                            $('#supplier_id').trigger('change');
                        }
                    });
                } else {
                    $('#supplier_id').empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>');
                    $('#supplier_id').trigger('change');

                }
            });
        });
    </script>
@endpush
