@extends('layouts.backend')


@section('title')
    {{ __('messages.stock_report') }}
@endsection
@section('main')
    <div class="container py-4">
        <h3 class="mb-4 text-primary fw-bold"> {{ __('messages.stock_report') }}</h3>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('stock-report') }}" method="GET" class="row g-3">
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
                        <label for="bar_code" class="form-label fw-semibold"> {{ __('messages.product') }}
                            {{ __('messages.barcode') }}</label>
                        <input type="text" class="form-control" name="barcode" id="bar_code"
                            placeholder="{{ __('messages.scan_your_bar_code') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="product_id" class="form-label fw-semibold"> {{ __('messages.product') }}</label>
                        <select name="product_id" id="product_id" class="form-select">
                            <option value=""> {{ __('messages.select_one') }}</option>
                            @foreach ($filterProducts as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    ({{ $product->barcode }})
                                    {{ $product->name }} {{ $product->name_arabic }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="from_date" class="form-label fw-semibold"> {{ __('messages.from_date') }}</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ request('from_date') ?? $today }}">
                    </div>

                    <div class="col-md-3">
                        <label for="to_date" class="form-label fw-semibold"> {{ __('messages.to_date') }}</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ request('to_date') ?? $today }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>
                            {{ __('messages.search') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report Table -->
        @if (isset($reportData) && count($reportData) > 0)
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="mb-3 text-end">
                        <button onclick="printReport()" class="btn btn-success"><i class="bi bi-printer me-2"></i>
                            {{ __('messages.print') }}</button>
                    </div>

                    <div class="table-responsive" id="printableArea">
                        @php
                            $company = \App\Models\GeneralSetting::first();
                        @endphp


                        <div class="text-center mb-3">
                            @if ($company)
                                <h4 class="fw-bold">{{ $company->name }}</h4>
                            @endif
                            <h4 class="fw-bold"> {{ __('messages.stock_report') }}</h4>
                            <p class="mb-0">
                                {{ __('messages.date') }}:
                                {{ \Carbon\Carbon::parse(request('from_date') ?? $today)->format('j F Y') }} -
                                {{ \Carbon\Carbon::parse(request('to_date') ?? $today)->format('j F Y') }}
                            </p>

                            @if (request('product_id'))
                                <p class="mb-0"> {{ __('messages.product') }}:
                                    {{ $filterProducts->where('id', request('product_id'))->first()->name }}</p>
                            @else
                                <p class="mb-0"> {{ __('messages.product') }}: {{ __('messages.all') }}</p>
                            @endif
                        </div>

                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-dark text-white">
                                <tr>
                                    @if ($isSuperAdmin && !$sessionBranch)
                                        <th> {{ __('messages.branch') }}</th>
                                    @endif
                                    <th> {{ __('messages.product') }} {{ __('messages.code') }}</th>
                                    <th> {{ __('messages.product') }}</th>
                                    <th> {{ __('messages.size') }}</th>
                                    <th> {{ __('messages.color') }}</th>
                                    <th> {{ __('messages.opening') }} {{ __('messages.stock') }}</th>
                                    <th> {{ __('messages.purchase') }} {{ __('messages.stock') }}</th>
                                    <th> {{ __('messages.sale') }} {{ __('messages.stock') }} </th>
                                    <th> {{ __('messages.stock_received') }}</th>
                                    <th> {{ __('messages.stock_transfer') }}</th>
                                    <th> {{ __('messages.current_stock') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportData as $data)
                                    <tr>
                                        @if ($isSuperAdmin && !$sessionBranch)
                                            <td class="fw-semibold text-start ps-3">{{ $data['branch'] }}</td>
                                        @endif
                                        <td class="fw-semibold text-start ps-3">{{ $data['product_code'] }}</td>
                                        <td class="fw-semibold text-start ps-3">{{ $data['product'] }}</td>
                                        <td class="fw-semibold text-start ps-3">{{ $data['size'] }}</td>
                                        <td class="fw-semibold text-start ps-3">{{ $data['color'] }}</td>
                                        <td>{{ $data['openingBalance'] }}</td>
                                        <td>{{ $data['currentPurchase'] }}</td>
                                        <td>{{ $data['currentSale'] }}</td>
                                        <td>{{ $data['stockRecived'] }}</td>
                                        <td>{{ $data['stockTransfer'] }}</td>
                                        <td class="fw-bold">{{ $data['currentStock'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td class="text-end pe-3" colspan="{{ $isSuperAdmin && !$sessionBranch ? 10 : 9 }}">
                                        {{ __('messages.total') }} {{ __('messages.stock') }}
                                        :</td>
                                    <td>{{ array_sum(array_map(fn($d) => $d['currentStock'], $reportData)) }}</td>
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

            printWindow.document.write('<html><head><title>  {{ __('messages.stock_report') }}</title>');
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
            $('#bar_code').on('keypress', function(e) {
                if (e.which == 13) { // Enter key pressed
                    e.preventDefault();
                    let barcode = $(this).val().trim();
                    if (!barcode) return;

                    $.ajax({
                        url: '/admin/get-product-by-barcode/' + barcode,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                // Product auto select
                                $('#product_id').val(res.product.id).trigger('change');
                                $('#bar_code').closest('form').submit();
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Product not found!',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
