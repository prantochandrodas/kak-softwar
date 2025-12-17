@extends('layouts.backend')

@section('title')
    {{ __('messages.profit_report') }}
@endsection
@section('main')
    <div class="container py-4">
        <h3 class="mb-4 text-primary fw-bold">{{ __('messages.profit_report') }}</h3>

        <!-- 🔍 Filter Section -->
        <div class="card mb-4 shadow-sm no-print">
            <div class="card-body">
                <form action="{{ route('profit-report') }}" method="GET" class="row g-3">
                    {{-- <div class="col-md-4">
                        <label>Product</label>
                        <select name="product_id" class="form-select">
                            <option value="">All Products</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" {{ $product_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col-md-3">
                        <label>{{ __('messages.start_date') }}</label>
                        <input type="date" name="from_date" class="form-control" value="{{ $from_date }}">
                    </div>
                    <div class="col-md-3">
                        <label>{{ __('messages.end_date') }}</label>
                        <input type="date" name="to_date" class="form-control" value="{{ $to_date }}">
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button class="btn btn-primary w-100">{{ __('messages.search') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 🖨️ Print Button -->
        <div class="text-end mb-3 no-print">
            <button class="btn btn-primary" onclick="printReport()">
                <i class="bi bi-printer-fill me-2"></i> {{ __('messages.print') }}
            </button>
        </div>

        @if (!empty($reportData))
            <div id="printArea" class="p-4 bg-white shadow rounded">
                @php
                    $company = \App\Models\GeneralSetting::first();
                @endphp

                <!-- Report Header -->
                <div class="text-center mb-4 border-bottom py-3 ">

                    @if ($company)
                        <h4 class="fw-bold">{{ $company->name }}</h4>
                    @endif

                    <h3 class="fw-bold text-uppercase mt-2">{{ __('messages.profit_report') }}</h3>
                    <p class="mb-0">
                        {{ __('messages.date') }}: {{ \Carbon\Carbon::parse($from_date)->format('j F Y') }} to
                        {{ \Carbon\Carbon::parse($to_date)->format('j F Y') }}
                    </p>

                    @if ($product_id)
                        <p class="mb-0">{{ __('messages.product') }}:
                            {{ $products->where('id', $product_id)->first()->name ?? '-' }}</p>
                    @endif
                </div>

                <!-- Profit Details Table -->
                <div class="mb-4">
                    <table class="table table-bordered text-center align-middle report-table">
                        <thead class="table-light fw-bold">
                            <tr>
                                <th>{{ __('messages.serial_no') }}</th>
                                <th>{{ __('messages.product') }} {{ __('messages.name') }}</th>
                                <th>{{ __('messages.total_sale_quantity') }}</th>
                                <th>{{ __('messages.sale_amount') }} ({{ __('messages.per_unit') }})</th>
                                <th>{{ __('messages.today_sale_amount') }} </th>
                                <th>{{ __('messages.purchase_amount') }} ({{ __('messages.per_unit') }})</th>
                                <th>{{ __('messages.total') }} ({{ __('messages.purchase_amount') }})</th>
                                <th>{{ __('messages.profit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_quantity = 0;
                                $total_purchase_cost = 0;
                                $total_sale_amount = 0;
                                $total_profit = 0;
                            @endphp

                            @foreach ($reportData as $index => $data)
                                @php
                                    $total_quantity += $data['quantity'];
                                    $total_purchase_cost += $data['purchase_cost'];
                                    $total_sale_amount += $data['sale_amount'];
                                    $total_profit += $data['profit'];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data['product_name'] }}</td>
                                    <td>{{ $data['quantity'] }} ({{ $data['product_unit'] }})</td>
                                    <td>{{ number_format($data['sale_price'], 2) }}</td>
                                    <td>{{ number_format($data['sale_amount'], 2) }}</td>
                                    <td>{{ number_format($data['purchase_price'], 2) }}</td>
                                    <td>{{ number_format($data['purchase_cost'], 2) }}</td>

                                    <td class="{{ $data['profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($data['profit'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <!-- 🔹 Footer Total Row -->
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="4" class="text-end">{{ __('messages.profit') }}:</td>

                                <td>{{ number_format($total_sale_amount, 2) }}</td>
                                <td>-</td>
                                <td>{{ number_format($total_purchase_cost, 2) }}</td>
                                <td>{{ number_format($total_profit, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <h3>{{ __('messages.summary') }}</h3>
                <!-- Summary Section -->
                <div class="mt-4">
                    <table class="table table-bordered  mx-auto text-center">
                        <tbody>
                            <tr>
                                <th>{{ __('messages.today_sale_amount') }}</th>
                                <td>{{ number_format($total_sale_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('messages.total') }} {{ __('messages.purchase_amount') }}</th>
                                <td>{{ number_format($total_purchase_cost, 2) }}</td>
                            </tr>

                            <tr>
                                <th>{{ __('messages.total') }} {{ __('messages.profit') }}</th>
                                <td>{{ number_format($total_profit, 2) }}</td>
                            </tr>
                            <tr class="table-warning">
                                <th>{{ __('messages.total') }} {{ __('messages.expense') }}</th>
                                <td>{{ number_format($total_expense, 2) }}</td>
                            </tr>
                            <tr class="table-success fw-bold">
                                <th>{{ __('messages.net_profit') }}</th>
                                <td>{{ number_format($net_profit, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="text-end mt-5">
                    <p class="fw-semibold mb-5">Prepared By: ____________________</p>
                    <p class="fw-semibold">Authorized Signature: ____________________</p>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center">{{ __('messages.no_data_found') }}</div>
        @endif

        <!-- 🧾 Custom Print Styles -->
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #printArea,
                #printArea * {
                    visibility: visible;
                }

                #printArea {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    background: white;
                    padding: 40px;
                }

                .no-print {
                    display: none !important;
                }

                @page {
                    size: A4;
                    margin: 20mm;
                }
            }

            .report-table th,
            .report-table td {
                border: 1px solid #dee2e6 !important;
                padding: 8px;
            }

            .report-table thead {
                background-color: #f8f9fa;
            }
        </style>

        <script>
            function printReport() {
                window.print();
            }
        </script>
    </div>
@endsection
