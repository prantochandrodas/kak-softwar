@extends('layouts.backend')


@section('title')
    {{ __('messages.fund_history') }}
@endsection
@section('main')
    <div class="container py-4">
        <h3 class="mb-4 text-primary fw-bold">{{ __('messages.fund_history') }}</h3>

        <div class="card mb-4 shadow-sm no-print">
            <div class="card-body">
                <form action="{{ route('fund-history-report') }}" id="submitForm" method="GET" class="row g-3">
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
                        <div class="mb-3">
                            <label for="fund_id" class="form-label">{{ __('messages.fund') }} </label>
                            <select name="fund_id" id="fund_id" class="form-select">
                                <option value="">{{ __('messages.select_one') }}</option>
                                @foreach ($funds as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('fund_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback fund-error"></div>
                        </div>
                    </div>
                    <div id="bank-section" class="col-md-6"
                        style="display:none; margin:10px 0px; border:none!important; padding:0px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bank_id" class="form-label">{{ __('messages.bank') }}
                                        <span class="text-danger">*</span></label>
                                    <select name="bank_id" id="bank_id" class="form-select">
                                        <option value="">{{ __('messages.select_one') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="account_id" class="form-label">{{ __('messages.bank_account') }}
                                        <span class="text-danger">*</span></label>
                                    <select name="account_id" id="account_id" class="form-select">
                                        <option value="">{{ __('messages.select_one') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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
        @if ($from_date && $to_date && $fund_id)
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
                        {{ __('messages.sale_collections') }}
                    </h5>
                    @if ($salesPayments->count() > 0)
                        <table class="table table-bordered text-center align-middle report-table">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>{{ __('messages.serial_no') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>


                                {{-- 🔹 বিক্রয় তথ্য --}}
                                @php $total_sale_payment_amount = 0; @endphp
                                @foreach ($salesPayments as $index => $p)
                                    @php
                                        $sale_payment_amount = $p->amount;
                                        $total_sale_payment_amount += $sale_payment_amount;
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->date }}</td>
                                        <td>{{ $p->fund->name ?? 'N/A' }}</td>
                                        <td>{{ $p->bank->name ?? '' }} ({{ $p->account->account_number ?? '-' }})</td>
                                        <td>{{ number_format($sale_payment_amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            {{-- 🔹 Footer Total Row --}}
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="4" class="text-end">{{ __('messages.total') }}
                                        :</td>
                                    <td>
                                        {{ number_format($total_sale_payment_amount, 2) }}
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
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
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
                @if ($customerDuePayments->count())
                    <div class="mb-4">
                        <h5 class="fw-bold text-success border-start border-3 border-success ps-2 mb-3">
                            {{ __('messages.customer_due_payments') }}
                        </h5>

                        @if ($customerDuePayments->count())
                            <table class="table table-bordered text-center align-middle report-table">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>{{ __('messages.serial_no') }}</th>
                                        <th>{{ __('messages.customer') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $total_payment_amount = 0;
                                        $sr = 1;
                                    @endphp

                                    {{-- 🔹 Purchase Payments --}}
                                    @foreach ($customerDuePayments as $pay)
                                        @php $total_payment_amount += $pay->amount; @endphp
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $pay->customer->name ?? '' }}</td>
                                            <td>{{ $pay->date }}</td>
                                            <td>{{ $pay->fund->name ?? '-' }}</td>
                                            <td>{{ $pay->bank->name ?? '' }} ({{ $pay->account->account_number ?? '-' }})
                                            </td>
                                            <td>{{ number_format($pay->amount, 2) }}</td>
                                        </tr>
                                    @endforeach


                                </tbody>

                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="5" class="text-end">{{ __('messages.total') }}
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
                                        <th>{{ __('messages.customer') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="5" class="text-end">{{ __('messages.total') }}
                                            {{ __('messages.payment') }}:</td>
                                        <td>0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                @endif


                <div class="mb-4">
                    <h5 class="fw-bold text-success border-start border-3 border-success ps-2 mb-3">
                        {{ __('messages.supplier_payments') }}
                    </h5>

                    @if ($purchasePayments->count() || $supplierPayments->count())
                        <table class="table table-bordered text-center align-middle report-table">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>{{ __('messages.serial_no') }}</th>
                                    <th>{{ __('messages.supplier') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $total_payment_amount = 0;
                                    $sr = 1;
                                @endphp

                                {{-- 🔹 Purchase Payments --}}
                                @foreach ($purchasePayments as $pay)
                                    @php $total_payment_amount += $pay->amount; @endphp
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>{{ $pay->purchase->supplier->name ?? '' }}</td>
                                        <td>{{ $pay->date }}</td>
                                        <td>{{ $pay->fund->name ?? '-' }}</td>
                                        <td>{{ $pay->bank->name ?? '' }} ({{ $pay->account->account_number ?? '-' }})</td>
                                        <td>{{ number_format($pay->amount, 2) }}</td>
                                    </tr>
                                @endforeach

                                {{-- 🔹 Supplier Payments --}}
                                @foreach ($supplierPayments as $pay)
                                    @php $total_payment_amount += $pay->amount; @endphp
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>{{ $pay->supplier->name ?? ($pay->purchase->supplier->name ?? '') }}</td>
                                        <td>{{ $pay->date }}</td>
                                        <td>{{ $pay->fund->name ?? '-' }}</td>
                                        <td>{{ $pay->bank->name ?? '' }} ({{ $pay->account->account_number ?? '-' }})</td>
                                        <td>{{ number_format($pay->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="5" class="text-end">{{ __('messages.total') }}
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
                                    <th>{{ __('messages.supplier') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.fund') }}</th>
                                    <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="5" class="text-end">{{ __('messages.total') }}
                                        {{ __('messages.payment') }}:</td>
                                    <td>0</td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>


                @if ($expenses->count())
                    <div class="mb-4">
                        <h5 class="fw-bold text-success border-start border-3 border-success ps-2 mb-3">
                            {{ __('messages.expense_history') }}
                        </h5>
                        @if ($expenses->count())
                            <table class="table table-bordered text-center align-middle report-table">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>{{ __('messages.serial_no') }}</th>
                                        <th>{{ __('messages.expense_head') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_payment_amount = 0; @endphp
                                    @foreach ($supplierPayments as $index => $pay)
                                        @php $total_payment_amount += $pay->amount; @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pay->head->name ?? '' }}</td>
                                            <td>{{ $pay->date }}</td>
                                            <td>{{ $pay->fund->name ?? '-' }}</td>
                                            <td>{{ $pay->bank->name ?? '' }}
                                                ({{ $pay->account->account_number ?? '-' }})
                                            </td>
                                            <td>{{ number_format($pay->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                {{--  Footer Total Row --}}
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="5" class="text-end">{{ __('messages.total') }}
                                            :</td>
                                        <td>{{ number_format($total_payment_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <table class="table table-bordered text-center align-middle report-table">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>{{ __('messages.serial_no') }}</th>
                                        <th>{{ __('messages.expense_head') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="5" class="text-end">{{ __('messages.total') }}
                                            :</td>
                                        <td>0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                @endif

                @if ($adjustments->count())
                    <div class="mb-4">
                        <h5 class="fw-bold text-success border-start border-3 border-success ps-2 mb-3">
                            {{ __('messages.fund_adjustment') }}
                        </h5>
                        @if ($adjustments->count())
                            <table class="table table-bordered text-center align-middle report-table">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>{{ __('messages.serial_no') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_payment_amount = 0; @endphp
                                    @foreach ($adjustments as $index => $pay)
                                        @php $total_payment_amount += $pay->amount; @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pay->date }}</td>
                                            <td>{{ $pay->fund->name ?? '-' }}</td>
                                            <td>{{ $pay->bank->name ?? '' }}
                                                ({{ $pay->account->account_number ?? '-' }})
                                            </td>
                                            <td>{{ number_format($pay->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                {{--  Footer Total Row --}}
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="4" class="text-end">{{ __('messages.total') }}
                                            :</td>
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
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="4" class="text-end">{{ __('messages.total') }}
                                            :</td>
                                        <td>0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                @endif
                @if ($transfers->count())
                    <div class="mb-4">
                        <h5 class="fw-bold text-success border-start border-3 border-success ps-2 mb-3">
                            {{ __('messages.fund_transfer') }}
                        </h5>
                        @if ($transfers->count())
                            <table class="table table-bordered text-center align-middle report-table">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>{{ __('messages.serial_no') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_payment_amount = 0; @endphp
                                    @foreach ($transfers as $index => $pay)
                                        @php $total_payment_amount += $pay->transaction_amount; @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pay->transaction_date }}</td>
                                            <td>{{ $pay->fund->name ?? '-' }}</td>
                                            <td>{{ $pay->bank->name ?? '' }}
                                                ({{ $pay->account->account_number ?? '-' }})
                                            </td>
                                            <td>{{ number_format($pay->transaction_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                {{--  Footer Total Row --}}
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="4" class="text-end">{{ __('messages.total') }}
                                            :</td>
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
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="4" class="text-end">{{ __('messages.total') }}
                                            :</td>
                                        <td>0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                @endif
                @if ($reviceTransfers->count())
                    <div class="mb-4">
                        <h5 class="fw-bold text-success border-start border-3 border-success ps-2 mb-3">
                            {{ __('messages.fund_receive') }}
                        </h5>
                        @if ($reviceTransfers->count())
                            <table class="table table-bordered text-center align-middle report-table">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>{{ __('messages.serial_no') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_payment_amount = 0; @endphp
                                    @foreach ($reviceTransfers as $index => $pay)
                                        @php $total_payment_amount += $pay->transaction_amount; @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pay->transaction_date }}</td>
                                            <td>{{ $pay->fund->name ?? '-' }}</td>
                                            <td>{{ $pay->bank->name ?? '' }}
                                                ({{ $pay->account->account_number ?? '-' }})
                                            </td>
                                            <td>{{ number_format($pay->transaction_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                {{--  Footer Total Row --}}
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="4" class="text-end">{{ __('messages.total') }}
                                            :</td>
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
                                        <th>{{ __('messages.bank') }} {{ __('messages.information') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="4" class="text-end">{{ __('messages.total') }}
                                            :</td>
                                        <td>0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                @endif

                <!-- 📊 Summary -->
                <div class="mb-4">
                    <h5 class="fw-bold text-secondary border-start border-3 border-secondary ps-2 mb-3">
                        {{ __('messages.history') }}
                    </h5>
                    <table class="table table-bordered text-center align-middle report-table  mx-auto">
                        <tbody>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.previous_balance') }}</th>
                                <td class="fw-bold text-end pe-3">{{ number_format($summary['previous_balance'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.sale_collections') }}</th>
                                <td class="fw-bold text-end pe-3">{{ number_format($summary['totalSellCollection'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">
                                    {{ __('messages.customer_due_payments') }}</th>
                                <td class="fw-bold text-end pe-3">
                                    {{ number_format($summary['totalCustomerDueCollection'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">
                                    {{ __('messages.fund_adjustment') }}</th>
                                <td class="fw-bold text-end pe-3">
                                    {{ number_format($summary['totalAdjustment'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">
                                    {{ __('messages.fund_transfer') }}</th>
                                <td class="fw-bold text-end pe-3">
                                    {{ number_format($summary['totalTransfer'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">
                                    {{ __('messages.fund_receive') }}</th>
                                <td class="fw-bold text-end pe-3">
                                    {{ number_format($summary['reviceTotalTransfer'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.supplier_payments') }}</th>
                                <td class="fw-bold text-end pe-3">
                                    {{ number_format($summary['totalSupplierPaymentCollection'], 2) }}</td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.expense_total') }}</th>
                                <td class="fw-bold text-end pe-3">
                                    {{ number_format($summary['expensesTotal'], 2) }}</td>
                            </tr>
                            <tr>
                                <th class="table-light text-start ps-3">{{ __('messages.balance') }}</th>
                                <td class="fw-bold text-end pe-3">
                                    {{ number_format($summary['balance'], 2) }}</td>
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
        const sessionBranchId = "{{ session('branch_id') ?? '' }}";
    </script>
    <script>
        document.getElementById('submitForm').addEventListener('submit', function(e) {


            var fund = document.getElementById('fund_id').value;
            var branchId = document.getElementById('branch_id').value;
            var fromDate = document.getElementById('from_date').value;
            var toDate = document.getElementById('to_date').value;
            let finalBranchId = branchId || sessionBranchId;
            var messages = [];
            console.log(fund);

            if (!finalBranchId) {
                messages.push('{{ __('messages.branch_not_selected') }}');
            }
            if (!fund) {

                messages.push('{{ __('messages.fund_not_selected') }}');
            }
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
        $(document).ready(function() {
            $('#fund_id').on('change', function() {
                let dataId = $(this).val();
                $('#bank_id').trigger('change');
                let selectedBankId =
                    "{{ $bank_id }}";
                if (dataId) {
                    $.ajax({
                        url: '/admin/get-bank/' + dataId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#bank_id').empty().append(
                                '<option value="">{{ __('messages.select_one') }}</option>'
                            );
                            if (data.hasBank) {
                                $('#bank-section').show();

                                $('#bank_id, #branch_id, #account_id').prop('required', true);
                                $.each(data.data, function(key, value) {
                                    let isSelected = selectedBankId == value.id ?
                                        'selected' : '';
                                    $('#bank_id').append('<option value="' + value
                                        .id +
                                        '"  ' + isSelected + '>' + value.name +
                                        '</option>');
                                });
                            } else {
                                $('#bank-section').hide();
                                $('#bank_id, #branch_id, #account_id').prop('required', false);
                            }


                            $('#bank_id').trigger(
                                'change'); // Optional: Trigger change if needed
                        }
                    });
                } else {
                    $('#bank_id').empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>');
                    $('#bank-section').hide();
                }
            });

            if ($('#fund_id').val()) {
                $('#fund_id').trigger('change');

            }

            $('#bank_id').on('change', function() {
                let dataId = $(this).val();
                var branchId = $('#branch_id').val();
                let finalBranchId = branchId || sessionBranchId;

                // 3. If still no branch found → Stop request
                if (!finalBranchId) {
                    $('#account_id').empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>'
                    );

                    return;
                }
                let selectedFloorId =
                    "{{ old('account_id', request('account_id')) }}"; // Preselected value for floor
                if (dataId) {
                    $.ajax({
                        url: '/admin/get-account-by-bank/' + dataId + '/' + (finalBranchId ?? ''),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#account_id').empty().append(
                                '<option value="">{{ __('messages.select_one') }}</option>'
                            );
                            $.each(data.data, function(key, value) {
                                let isSelected = selectedFloorId == value.id ?
                                    'selected' : '';
                                $('#account_id').append('<option value="' + value.id +
                                    '" ' + isSelected + '>' +
                                    value.account_name + ' (' + value
                                    .account_number + ')' + '</option>');
                            });
                            $('#account_id').trigger(
                                'change'); // Optional: Trigger change if needed
                        }
                    });
                } else {
                    $('#account_id').empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>');

                }
            });

            // When Property is selected

            if ($('#bank_id').val()) {
                $('#bank_id').trigger('change');
            }
        });
    </script>
@endpush
