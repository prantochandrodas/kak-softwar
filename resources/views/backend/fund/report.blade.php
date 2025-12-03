@extends('layouts.backend')

@section('title', 'Fund Cash Report')

@section('main')
    <div class="container py-4">

        <h3 class="mb-4 text-primary fw-bold">ফান্ড ক্যাশ রিপোর্ট</h3>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('fund-report') }}" id="submitForm" method="GET" class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">ফান্ড:</label>
                        <select name="fund_id" id="fund_id" class="form-select">
                            <option value="">নির্বাচন করুন</option>
                            @foreach ($funds as $item)
                                <option value="{{ $item->id }}" {{ $fund_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">শুরুর তারিখ</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ $from_date }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">শেষ তারিখ</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ $to_date }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">সার্চ করুন</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="text-end mt-3 no-print">
            <button class="btn btn-primary" onclick="printReport()">
                <i class="bi bi-printer-fill me-2"></i> রিপোর্ট প্রিন্ট করুন
            </button>
        </div>

        @if ($fund_id && $from_date && $to_date)
            <div id="printArea" class="p-4 bg-white shadow rounded">
                <div class="card p-4">
                    @php
                        $company = \App\Models\GeneralSetting::first();
                    @endphp
                    <div class="text-center mb-4 border-bottom pb-3">
                        @if ($company)
                            <h4 class="fw-bold">{{ $company->name }}</h4>
                        @endif
                        <h4 class="fw-bold text-center mb-3">ফান্ড ক্যাশ রিপোর্ট</h4>
                        <p class="mb-0">
                            তারিখ:
                            {{ \Carbon\Carbon::parse($from_date)->format('j F Y') }}
                            to
                            {{ \Carbon\Carbon::parse($to_date)->format('j F Y') }}
                        </p>
                    </div>

                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>তারিখ</th>
                                <th>ধরণ</th>
                                <th>ট্রান্স. নং</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="table-warning fw-bold">
                                <td colspan="3" class="text-end">Opening Balance</td>
                                <td>{{ $openingBalance < 0 ? number_format(abs($openingBalance), 2) : '0.00' }}</td>
                                <td>{{ $openingBalance > 0 ? number_format($openingBalance, 2) : '0.00' }}</td>
                                <td>{{ number_format($openingBalance, 2) }}</td>
                                <!-- Balance-এ মূল opening balance দেখাবে -->
                            </tr>


                            @php
                                $totalDebit = $openingBalance < 0 ? abs($openingBalance) : 0;
                                $totalCredit = $openingBalance > 0 ? $openingBalance : 0;
                                $balance = $openingBalance;
                            @endphp

                            @foreach ($transactions as $t)
                                @php
                                    // Balance update
                                    $balance += $t['credit'] - $t['debit'];
                                @endphp
                                <tr>
                                    <td>{{ $t['date'] }}</td>
                                    <td>{{ $t['type'] }}</td>
                                    <td>{{ $t['transaction_no'] }}</td>
                                    <td>{{ number_format($t['debit'], 2) }}</td>
                                    <td>{{ number_format($t['credit'], 2) }}</td>
                                    <td>{{ number_format($balance, 2) }}</td>
                                </tr>

                                @php
                                    $totalDebit += $t['debit'];
                                    $totalCredit += $t['credit'];
                                @endphp
                            @endforeach

                        </tbody>

                        <tfoot class="fw-bold">
                            <tr class="table-secondary">
                                <td colspan="3" class="text-end">Total</td>
                                <td>{{ number_format($totalDebit, 2) }}</td>
                                <td>{{ number_format($totalCredit, 2) }}</td>
                                <td>{{ number_format($totalCredit - $totalDebit, 2) }}</td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="4" class="text-end">Closing Balance</td>
                                <td colspan="2">{{ number_format($totalCredit - $totalDebit, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        @endif


    </div>


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
            var fund = document.getElementById('fund_id').value;
            var fromDate = document.getElementById('from_date').value;
            var toDate = document.getElementById('to_date').value;

            var messages = [];

            if (!fund) {
                messages.push('ফান্ড  নির্বাচন করা হয়নি।');
            }
            if (!fromDate) {
                messages.push('শুরুর তারিখ দেওয়া হয়নি।');
            }
            if (!toDate) {
                messages.push('শেষ তারিখ দেওয়া হয়নি।');
            }

            if (messages.length > 0) {
                e.preventDefault(); // ফর্ম সাবমিট রোধ করবে
                Swal.fire({
                    icon: 'warning',
                    title: 'সতর্কতা!',
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
