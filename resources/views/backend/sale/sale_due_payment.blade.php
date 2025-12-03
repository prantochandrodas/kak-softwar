@extends('layouts.backend')
@section('main')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('messages.due_payment') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-muted text-hover-primary">{{ __('messages.dashboard') }}</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted"> {{ __('messages.due_payment') }}</li>
                        <!--end::Item-->

                        <!--end::Item-->
                        <!--begin::Item-->
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>



        <style>
            :root {
                --yellow: yellow;
                --green: green;
                --blue: #007bff;
                --indigo: #6610f2;
                --purple: #6f42c1;
                --pink: #e83e8c;
                --red: #dc3545;
                --orange: #fd7e14;
                --yellow: #ffc107;
                --green: #28a745;
                --teal: #20c997;
                --cyan: #17a2b8;
                --white: #ffffff;
                --gray: #6c757d;
                --gray-dark: #343a40;
                --primary: #007bff;
                --secondary: #6c757d;
                --success: #28a745;
                --info: #17a2b8;
                --warning: #ffc107;
                --danger: #dc3545;
                --light: #f8f9fa;
                --dark: #343a40;
                --breakpoint-xs: 0;
                --breakpoint-sm: 576px;
                --breakpoint-md: 768px;
                --breakpoint-lg: 992px;
                --breakpoint-xl: 1200px;
                --font-family-sans-serif: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
                --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            }

            body {
                font-size: 0.88rem !important;
            }


            .btn {
                padding: 3px 10px !important;
            }



            .modal-header .close,
            .modal-header .mailbox-attachment-close {
                border-radius: 5px;
            }


            .select2-container .select2-selection--single {
                height: 30px !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 22px !important;
            }

            .select2 {
                width: 100% !important;
            }

            /* Input Number Remove Arrows/Spinners*/
            /* Chrome, Safari, Edge, Opera */
            /* input::-webkit-outer-spin-button,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                input::-webkit-inner-spin-button {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -webkit-appearance: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    margin: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } */

            /* Firefox */
            /* input[type=number] {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -moz-appearance: textfield;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } */


            .btn-sm {
                font-size: .79rem !important;
                line-height: 1.2 !important;
            }


            fieldset {
                border: 2px solid #007bff96 !important;
                margin: 0 !important;
                xmin-width: 0 !important;
                padding: 3px !important;
                position: relative !important;
                border-radius: 4px !important;
                background-color: #f5f5f5 !important;
                padding-left: 10px !important;
                margin-bottom: 7px !important;
            }

            legend {
                font-size: 18px !important;
                font-weight: bold !important;
                margin-bottom: 0px !important;
                width: 50% !important;
                border: 1px solid #ddd !important;
                border-radius: 4px !important;
                padding: 1px 1px 1px 10px !important;
                background-color: #cceed6 !important;
            }

            label {
                font-weight: 700;
                margin-bottom: .1rem;
                font-size: 14px;
            }

            .form-group {
                margin-bottom: .2rem;
            }

            .card-body {
                padding: .25rem;
            }

            .table {
                margin-bottom: .1rem;
            }

            .table td,
            .table th {
                padding: .2rem;
                font-size: 14px;
            }

            .modal-header .close,
            .modal-header .mailbox-attachment-close {
                padding: .8rem !important;
                margin: -.5rem -.5rem -.5rem auto !important;
            }

            .close,
            .mailbox-attachment-close {
                line-height: .5 !important;
            }

            .modal-header {
                padding: .5rem !important;
            }


            .modal-title {
                line-height: 1 !important;
            }

            .modal-footer {
                padding: .3rem !important;
            }

            .search-box {
                font-size: 20px;
                box-shadow: 0 0 5px rgb(62, 196, 118);
                padding: 3px 0px 3px 3px;
                margin: 5px 1px 3px 0px;
                border: 1px solid rgb(62, 196, 118);
            }

            @media (min-width: 1200px) {
                .modal-xl {
                    max-width: 1280px;
                }
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #797474 !important;
            }


            #toast-container .toast {
                font-size: 1.4rem;
            }

            code {
                font-size: 20px !important;
            }

            .list-group-item {
                padding: .5rem .75rem !important;
            }

            .navbar-light .navbar-nav .active>.nav-link,
            .navbar-light .navbar-nav .nav-link.active,
            .navbar-light .navbar-nav .nav-link.show,
            .navbar-light .navbar-nav .show>.nav-link {
                font-weight: bold;
            }


            .btn-success:not(:disabled):not(.disabled).active,
            .btn-success:not(:disabled):not(.disabled):active,
            .show>.btn-success.dropdown-toggle {
                background-color: #1a4223;
            }

            .select2-container--default .select2-selection--single .select2-selection__clear {
                font-size: 12px;
            }

            .form-control {
                height: calc(1.6rem + 2px);
            }

            .table-bordered {
                border: 1px solid #dee2e6;
            }
        </style>

        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="content">
                    <form role="form" id="duePaymentForm" action="{{ route('sale-due-payment.store') }}" method="POST"
                        enctype="multipart/form-data" id="transferForm">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset style="position: relative; margin-bottom:30px!important;">
                                        <legend style="position: absolute; top:-20px">
                                            @if ($paymentType == 'invoice_payment')
                                                {{ __('messages.sale') }} {{ __('messages.due_payment') }}
                                            @endif
                                            @if ($paymentType == 'opening_due')
                                                {{ __('messages.opening') }} {{ __('messages.due') }}
                                                {{ __('messages.payment') }}
                                            @endif


                                        </legend>

                                        <div class="row payment-box" style="margin-top: 20px">


                                            {{-- customer  --}}

                                            <input type="hidden" class="payment_type" name="payment_type"
                                                value="{{ $paymentType }}">
                                            @php
                                                $isSuperAdmin = auth()
                                                    ->user()
                                                    ->roles->pluck('name')
                                                    ->contains('Super Admin');
                                                $sessionBranch = session('branch_id');
                                            @endphp
                                            @if ($isSuperAdmin && !$sessionBranch)
                                                <div class="col-sm-6" style="margin-top: 5px">
                                                    <label>{{ __('messages.branch') }}</label>
                                                    <select id="branch_id" name="branch_id"
                                                        class="form-select form-select-sm">
                                                        <option value=""> {{ __('messages.select_one') }}</option>
                                                        @foreach ($branchInfo as $branch)
                                                            <option value="{{ $branch->id }}"
                                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                                {{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <div class="col-sm-6" style="margin-top: 5px">
                                                <label>{{ __('messages.customer') }}</label>
                                                <select id="customer_id" class="form-select select2 customer_id">
                                                    <option value="">{{ __('messages.select_one') }}</option>
                                                    @foreach ($customers as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($paymentType == 'invoice_payment')
                                                <div class="col-sm-6" style="margin-top: 5px">
                                                    <label>{{ __('messages.sale_invoice') }}</label>
                                                    <select id="invoice_id" class="form-select select2 invoice_id">
                                                        <option value="">{{ __('messages.select_one') }}</option>

                                                    </select>
                                                </div>
                                            @endif


                                            <div class="col-sm-6" style="margin-top: 5px">
                                                <label>{{ __('messages.due_amount') }}</label>
                                                <input type="number" class="form-control due_amount" id="due_amount"
                                                    name="due_amount">
                                            </div>



                                            <div class="col-sm-6" style="margin-top: 5px">
                                                <label>{{ __('messages.fund') }}</label>
                                                <select id="fund_id" class="form-select select2 fund_id">
                                                    <option value="">{{ __('messages.select_one') }}</option>
                                                    @foreach ($funds as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div style="display:none;" class="col-sm-12 bank-section">
                                                <div class="row">
                                                    {{-- bank  --}}
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="bank_id"
                                                                class="form-label">{{ __('messages.bank') }}
                                                                <span class="text-danger">*</span></label>
                                                            <select name="bank_id" id="bank_id"
                                                                class="form-select select2 bank_id">
                                                                <option value="">{{ __('messages.select_one') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- bank account  --}}
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="account_id"
                                                                class="form-label">{{ __('messages.bank_account') }}
                                                                <span class="text-danger">*</span></label>
                                                            <select name="account_id" id="account_id"
                                                                class="form-select select2 account_id">
                                                                <option value="">{{ __('messages.select_one') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>



                                            <div class="col-sm-6" style="margin-top: 5px">
                                                <label>{{ __('messages.payment_amount') }}</label>
                                                <input type="number" class="form-control amount" id="payment_amount"
                                                    name="payment_amount">
                                            </div>


                                            <div class="col-sm-6" style="margin-top: 5px">
                                                <label>{{ __('messages.date') }}</label>
                                                <input type="date" class="form-control date" id="date"
                                                    name="date" value="{{ date('Y-m-d') }}">
                                            </div>

                                            <div class="mt-3 text-center">
                                                <button type="button" class="add-more-btn btn btn-success"
                                                    id="addToCart">+
                                                    {{ __('messages.add') }}
                                                    {{ __('messages.payment') }}</button>
                                            </div>


                                    </fieldset>


                                </div>
                                <div class="col-lg-12">
                                    <fieldset style="position: relative;">
                                        <legend style="position: absolute; top:-20px">
                                            {{ __('messages.payment_information') }}
                                        </legend>


                                        <div class="col-12 mt-4" id="payment_table_section">

                                            <table class="table table-bordered" id="cartTable">
                                                <thead>
                                                    <tr>
                                                        <th> {{ __('messages.date') }}</th>
                                                        <th> {{ __('messages.customer') }}</th>
                                                        <th> {{ __('messages.invoice_no') }}</th>
                                                        <th> {{ __('messages.due_payment') }}</th>
                                                        <th> {{ __('messages.fund') }}</th>
                                                        <th> {{ __('messages.bank') }}</th>
                                                        <th> {{ __('messages.account') }}</th>
                                                        <th> {{ __('messages.payment_amount') }}</th>
                                                        <th> {{ __('messages.action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="7" style="text-align: right">
                                                            {{ __('messages.total') }}:</th>
                                                        <th id="total_payment">0.00</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div style="display: flex; justify-content:center;">
                                            <button type="submit" id="save_btn"
                                                class="btn btn-success ">{{ __('messages.save') }}</button>
                                        </div>
                                    </fieldset>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection
@push('script')
    <!-- jQuery (required by Select2) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const sessionBranchId = "{{ session('branch_id') ?? '' }}";
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "{{ __('messages.select_one') }}",
                allowClear: true,
                width: '100%' // make it responsive
            });
            $('#duePaymentForm').on('submit', function(e) {
                let rowCount = $('#cartTable tbody tr').length;

                if (rowCount === 0) {
                    e.preventDefault(); // ফর্ম সাবমিট বন্ধ
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('messages.error') }}',
                        text: '{{ __('messages.no_payment_data_added') }}',
                        timer: 2000, // ২ সেকেন্ড পরে alert বন্ধ হবে
                        showConfirmButton: false
                    });

                    hideLoading();
                }
            });
            $(document).on('change', '.customer_id', function() {
                let box = $(this).closest('.payment-box');
                let customerId = $(this).val();
                let paymentType = box.find('.payment_type').val();
                let invoiceSelect = box.find('.invoice_id');
                let dueInput = box.find('.due_amount');

                invoiceSelect.empty().append('<option value="">{{ __('messages.select_one') }}</option>');
                dueInput.val('');

                if (!customerId) return;

                // If invoice payment → Load invoices
                if (paymentType === 'invoice_payment') {
                    $.ajax({
                        url: '/admin/get-sale-invoice/' + customerId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data.data, function(key, value) {
                                invoiceSelect.append('<option value="' + value.id +
                                    '">' + value.invoice_no + '</option>');
                            });
                        }
                    });
                }

                // If opening due → Load opening balance
                if (paymentType === 'opening_due') {
                    $.ajax({
                        url: '/admin/get-customer-opening-balance/' + customerId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            dueInput.val(data.opening_balance ?? 0);
                        }
                    });
                }
            });

            // Invoice change -> Get due amount
            $(document).on('change', '.invoice_id', function() {
                let box = $(this).closest('.payment-box');
                let invoiceId = $(this).val();
                let dueInput = box.find('.due_amount');
                dueInput.val('');
                if (invoiceId) {
                    $.ajax({
                        url: '/admin/get-sale-invoice-due/' + invoiceId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            dueInput.val(data.due_amount ?? 0);
                        }
                    });
                }
            });

            // Handle fund change
            $(document).on('change', '#branch_id', function() {
                let box = $(this).closest('.payment-box');
                let branchId = $(this).val();
                let customerSelect = box.find('#customer_id');


                $('#cartTable tbody').empty();
                updateTotalPayment();

                customerSelect.empty().append('<option value="">{{ __('messages.select_one') }}</option>');

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
            $(document).on('change', '.fund_id', function() {


                let box = $(this).closest('.payment-box');
                let fundId = $(this).val();
                let bankSelect = box.find('.bank_id');
                let accountSelect = box.find('.account_id');
                let bankSection = box.find('.bank-section');

                bankSelect.empty().append('<option value="">{{ __('messages.date') }}</option>');
                accountSelect.empty().append('<option value="">{{ __('messages.date') }}</option>');

                if (fundId) {
                    $.ajax({
                        url: '/admin/get-bank/' + fundId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.hasBank) {
                                bankSection.show();

                                $.each(data.data, function(key, value) {
                                    bankSelect.append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                            } else {
                                bankSection.hide();
                            }
                        }
                    });
                } else {
                    bankSection.hide();
                }
            });
            $(document).on('input', '.amount', function() {
                let box = $(this).closest('.payment-box');
                let dueInput = box.find('.due_amount');
                let due = parseFloat(dueInput.val()) || 0;
                let entered = parseFloat($(this).val()) || 0;

                if (entered > due) {
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ __('messages.warning') }}!',
                        text: '{{ __('messages.payment_cannot_exceed_due') }}',
                        showConfirmButton: false, // confirm button দেখাবে না
                        timer: 2000 // 2 সেকেন্ড পরে বন্ধ হবে
                    });

                    // শুধু due_amount পর্যন্ত রাখুন, extra portion block হবে
                    $(this).val(due);
                }
            });


            $('#addToCart').click(function() {
                let box = $('.payment-box');
                let customerText = box.find('.customer_id option:selected').text();
                let paymentTypeVal = box.find('.payment_type').val();
                let paymentTypeValText = box.find('.payment_type option:selected').text();
                let customerVal = box.find('.customer_id').val();
                let invoiceVal = box.find('.invoice_id').val();
                let invoiceText = invoiceVal ? box.find('.invoice_id option:selected').text() : '';
                let due = box.find('.due_amount').val();
                let fundText = box.find('.fund_id option:selected').text();
                let fundVal = box.find('.fund_id').val();
                let bankVal = box.find('.bank_id').val();

                let bankText = bankVal ? $('.bank_id option:selected').text() : '';
                let accountVal = box.find('.account_id').val();
                let accountText = accountVal ? box.find('.account_id option:selected').text() : '';
                let amount = box.find('.amount').val();
                let date = box.find('.date').val();

                let emptyFields = [];
                if (!customerVal) emptyFields.push('{{ __('messages.customer') }}');
                if (!fundVal) emptyFields.push('{{ __('messages.fund') }}');
                if (!bankVal && box.find('.bank-section').is(':visible')) emptyFields.push(
                    '{{ __('messages.bank') }}');
                if (!accountVal && box.find('.bank-section').is(':visible')) emptyFields.push(
                    '{{ __('messages.account') }}');
                if (!amount) emptyFields.push('{{ __('messages.amount') }}');
                if (!date) emptyFields.push('{{ __('messages.date') }}');

                if (emptyFields.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ __('messages.field_required') }}!',
                        html: '{{ __('messages.fill_the_following_fields') }}: <br><b>' +
                            emptyFields.join(', ') +
                            '</b>',
                        timer: 2000,
                        showConfirmButton: true,
                        timerProgressBar: true
                    });
                    return;
                }

                let row = `<tr>
                        <td>${date}<input type="hidden" name="date[]" value="${date}"></td>
                        <td>${customerText}<input type="hidden" name="customer_id[]" value="${customerVal}"></td>
                        <td>${invoiceText}<input type="hidden" name="invoice_id[]" value="${invoiceVal}"></td>
                        <td>${due}<input type="hidden" name="due_amount[]" value="${due}"></td>
                        <td>${fundText}<input type="hidden" name="fund_id[]" value="${fundVal}"></td>
                        <td>${bankText}<input type="hidden" name="bank_id[]" value="${bankVal}"></td>
                        <td>${accountText}<input type="hidden" name="account_id[]" value="${accountVal}"></td>
                        <td>${amount}<input type="hidden" name="amount[]" value="${amount}"></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                    </tr>`;

                $('#cartTable tbody').append(row);

                // Reset form

                box.find('.customer_id, .invoice_id, .fund_id, .bank_id, .account_id').val(
                    '').trigger('change');
                box.find('.due_amount').val('');
                box.find('.amount').val('');
                box.find('.date').val('');
                box.find('.bank-section').hide();

                // ⬅ total update call
                updateTotalPayment();
            });

            function updateTotalPayment() {
                let total = 0;

                $('#cartTable tbody tr').each(function() {
                    let amount = parseFloat($(this).find('input[name="amount[]"]').val()) || 0;
                    total += amount;
                });

                $('#total_payment').text(total.toFixed(2));
            }

            // Remove row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();

                // Row remove হওয়ার পরে total update করো
                updateTotalPayment();
            });

            // Handle bank change
            $(document).on('change', '.bank_id', function() {
                var branchId = $('#branch_id').val();
                let finalBranchId = branchId || sessionBranchId;

                let box = $(this).closest('.payment-box');
                let bankId = $(this).val();
                let accountSelect = box.find('.account_id');

                // Reset account dropdown
                accountSelect.empty().append('<option value="">{{ __('messages.select_one') }}</option>');

                // If branch is missing → stop here
                if (!finalBranchId) {
                    return; // <-- IMPORTANT
                }

                if (bankId) {
                    $.ajax({
                        url: '/admin/get-account-by-bank/' + bankId + '/' + (finalBranchId ?? ''),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data.data, function(key, value) {
                                accountSelect.append(
                                    '<option value="' + value.id + '">' +
                                    value.account_name + ' (' + value
                                    .account_number + ')' +
                                    '</option>'
                                );
                            });
                        }
                    });
                }
            });

            $('#branch_id').on('change', function() {
                $('.bank_id').trigger('change');

            });


        });
    </script>
@endpush
