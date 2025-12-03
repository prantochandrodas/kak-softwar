@extends('layouts.backend')

@section('title')
    {{ __('messages.opening') }} {{ __('messages.due') }} {{ __('messages.payment') }}
@endsection

@section('main')
    <div class="container py-4">
        <h3 class="mb-4 text-primary fw-bold"> {{ __('messages.opening') }} {{ __('messages.due') }}
            {{ __('messages.payment') }}</h3>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('customer-due-payment-list') }}" method="GET" class="row g-3">
                    @php
                        $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                        $sessionBranch = session('branch_id');
                    @endphp
                    @if ($isSuperAdmin && !$sessionBranch)
                        <div class="col-md-3">
                            <label for="branch_id" class="form-label mb-1"> {{ __('messages.branch') }}</label>
                            <select id="branch_id" name="branch_id" class="form-select">
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
                        <label class="form-label fw-semibold">{{ __('messages.customer') }}</label>
                        <select name="customer_id" class="form-select" id="customer_id">
                            <option value="">{{ __('messages.select_one') }}</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ __('messages.start_date') }}</label>
                        <input type="date" name="from_date" class="form-control"
                            value="{{ request('from_date') ?? $today }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ __('messages.end_date') }}</label>
                        <input type="date" name="to_date" class="form-control"
                            value="{{ request('to_date') ?? $today }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>{{ __('messages.search') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        @if (count($reportData) > 0)
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="mb-3 text-end">
                        <button onclick="printReport()" class="btn btn-success"><i
                                class="bi bi-printer me-2"></i>{{ __('messages.print') }}</button>
                    </div>

                    <div class="table-responsive" id="printableArea">
                        <div class="text-center mb-3">
                            @php
                                $company = \App\Models\GeneralSetting::first();
                            @endphp
                            <div class="text-center mb-3">
                                @if ($company)
                                    <h4 class="fw-bold">{{ $company->name }}</h4>
                                @endif
                                <h4 class="fw-bold">{{ __('messages.customer') }} {{ __('messages.opening') }}
                                    {{ __('messages.due') }} {{ __('messages.payment_list') }}
                                </h4>
                                <p class="mb-0">
                                    Period: {{ \Carbon\Carbon::parse($from_date)->format('j F Y') }} to
                                    {{ \Carbon\Carbon::parse($to_date)->format('j F Y') }}
                                </p>
                            </div>
                        </div>

                        <table class="table table-bordered table-hover text-center">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th>{{ __('messages.customer') }}</th>
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.bank') }}</th>
                                    <th>{{ __('messages.account') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reportData as $data)
                                    <tr>
                                        <td class="text-start ps-3">{{ $data->customer_name }}</td>
                                        <td>{{ $data->fund_name ?? '-' }}</td>
                                        <td>{{ $data->bank_name ?? '-' }}</td>
                                        <td>{{ $data->account_no ?? '-' }}</td>
                                        <td>{{ $data->amount }}</td>
                                        <td>{{ $data->date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="4" class="text-end pe-3">{{ __('messages.total_amount') }}:</td>
                                    <td colspan="2">{{ $reportData->sum('amount') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        @else
            <div class="alert alert-warning text-center">{{ __('messages.no_data_found') }}</div>
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

            printWindow.document.write('<html><head><title>স্টক রিপোর্ট</title>');
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
            $(document).on('change', '#branch_id', function() {
                let box = $(this).closest('.payment-box');
                let branchId = $(this).val();
                let customerSelect = box.find('#customer_id');




                customerSelect.empty().append('<option value="">Select One</option>');

                if (branchId) {
                    $.ajax({
                        url: '/admin/get-customer/' + branchId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data.data, function(key, value) {
                                customerSelect.append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
