@extends('layouts.backend')


@section('title')
    {{ __('messages.sale_report') }}
@endsection
@section('main')
    <div class="container py-4">
        <h3 class="mb-4 text-primary fw-bold">{{ __('messages.sale_report') }}</h3>

        <div class="card mb-4 shadow-sm no-print">
            <div class="card-body">
                <form action="{{ route('sale-report') }}" id="submitForm" method="GET" class="row g-3">
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
                                    <option value="{{ $branch->id }}" {{ $branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ __('messages.start_date') }}</label>
                        <input type="date" id="from_date" name="from_date" class="form-control"
                            value="{{ $from_date ?? date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ __('messages.end_date') }}</label>
                        <input type="date" id="to_date" name="to_date" class="form-control"
                            value="{{ $to_date ?? date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>{{ __('messages.search') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- 🖨️ Print Button -->
        <div class="text-end mt-3 no-print">
            <button class="btn btn-primary" onclick="printReport()">
                <i class="bi bi-printer-fill me-2"></i> {{ __('messages.print') }}
            </button>
        </div>
        @if ($from_date && $to_date)
            <div id="printArea" class="p-4 bg-white shadow rounded">
                @php
                    $company = \App\Models\GeneralSetting::first();
                @endphp
                <!-- Report Header -->
                <div class="text-center mb-4 border-bottom pb-3">
                    @if ($company)
                        <h4 class="fw-bold">{{ $company->name }}</h4>
                    @endif
                    <h3 class="fw-bold text-uppercase">{{ __('messages.sale_report') }}</h3>

                    <p class="mb-0">
                        {{ __('messages.date') }}: {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }} to
                        {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}
                    </p>
                </div>

                <!-- sale Details -->
                <div class="mb-4">
                    <h5 class="fw-bold text-primary border-start border-3 border-primary ps-2 mb-3">
                        {{ __('messages.sale_information') }}
                    </h5>
                    @if ($sales->count() || ($summary['previous_due'] ?? 0) > 0)
                        <table class="table table-bordered text-center align-middle report-table">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>{{ __('messages.serial_no') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.invoice_no') }}</th>
                                    <th>{{ __('messages.total_amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- 🔹 আগের বকেয়া --}}
                                @if (($summary['previous_due'] ?? 0) > 0)
                                    <tr class="table-warning fw-bold">
                                        <td colspan="3" class="text-end">{{ __('messages.previous_due') }}:</td>
                                        <td>{{ number_format($summary['previous_due'], 2) }}</td>
                                    </tr>
                                @endif

                                {{-- 🔹 বিক্রয় তথ্য --}}
                                @php $total_sale_amount = 0; @endphp
                                @foreach ($sales as $index => $p)
                                    @php
                                        $sale_amount = $p->details->sum('amount') - $p->discount + $p->vat;
                                        $total_sale_amount += $sale_amount;
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->date }}</td>
                                        <td>{{ $p->invoice_no ?? 'N/A' }}</td>
                                        <td>{{ number_format($sale_amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            {{-- 🔹 Footer Total Row --}}
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="3" class="text-end">{{ __('messages.total') }}
                                        {{ __('messages.sale') }}:</td>
                                    <td>
                                        {{ number_format($total_sale_amount + ($summary['previous_due'] ?? 0), 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <table class="table table-bordered text-center align-middle report-table">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>{{ __('messages.serial_no') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.invoice_no') }}</th>
                                    <th>{{ __('messages.total_amount') }}</th>
                                </tr>
                            </thead>


                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="3" class="text-end">{{ __('messages.total') }}
                                        {{ __('messages.amount') }}:</td>
                                    <td>
                                        0
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif

                </div>

                <!-- 💰 Payment Details -->
                <div class="mb-4">
                    <h5 class="fw-bold text-success border-start border-3 border-success ps-2 mb-3">
                        {{ __('messages.payment_information') }}
                    </h5>
                    @if ($payments->count())
                        <table class="table table-bordered text-center align-middle report-table">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>{{ __('messages.serial_no') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.bank') }} {{ __('messages.account') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_payment_amount = 0; @endphp
                                @foreach ($payments as $index => $pay)
                                    @php $total_payment_amount += $pay->amount; @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pay->date }}</td>
                                        <td>{{ $pay->fund->name ?? '-' }}</td>
                                        <td>{{ $pay->bank->name ?? ($pay->account->name ?? '-') }}</td>
                                        <td>{{ number_format($pay->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            {{--  Footer Total Row --}}
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="4" class="text-end">{{ __('messages.total') }}
                                        {{ __('messages.payment') }}:</td>
                                    <td>{{ number_format($total_payment_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <table class="table table-bordered text-center align-middle report-table">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>{{ __('messages.serial_no') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.bank') }} {{ __('messages.account') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="4" class="text-end">{{ __('messages.total') }}
                                        {{ __('messages.payment') }}:</td>
                                    <td>0</td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>

                <!-- 📊 Summary -->
                <div class="mb-4">
                    <h5 class="fw-bold text-secondary border-start border-3 border-secondary ps-2 mb-3">
                        {{ __('messages.summary') }}
                    </h5>
                    <table class="table table-bordered text-center align-middle report-table  mx-auto">
                        <tbody>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.total') }}
                                    {{ __('messages.sale') }}</th>
                                <td class="fw-bold text-end pe-3">{{ number_format($summary['total_sale'], 2) }}</td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.total_payment') }}</th>
                                <td class="fw-bold text-end pe-3">{{ number_format($summary['total_payment'], 2) }}</td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.due') }}</th>
                                <td class="fw-bold text-end pe-3">{{ number_format($summary['due'], 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        @else
            <div class="alert alert-info text-center">{{ __('messages.select_date_search') }}।</div>
        @endif
    </div>

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

    <!-- 🖨️ Print Function -->
    <script>
        function printReport() {
            window.print();
        }
    </script>
@endsection
@push('script')
    <script>
        document.getElementById('submitForm').addEventListener('submit', function(e) {

            var fromDate = document.getElementById('from_date').value;
            var toDate = document.getElementById('to_date').value;

            var messages = [];


            if (!fromDate) {
                messages.push('{{ __('messages.from_date_not_given') }}');
            }
            if (!toDate) {
                messages.push('{{ __('messages.to_date_not_given') }}');
            }

            if (messages.length > 0) {
                e.preventDefault(); // ফর্ম সাবমিট রোধ করবে
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __('messages.warning') }}!',
                    html: messages.join('<br>'),
                    timer: 1500, // 3 সেকেন্ড পরে স্বয়ংক্রিয়ভাবে বন্ধ হবে
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            }
            hideLoading();
        });
    </script>
@endpush
