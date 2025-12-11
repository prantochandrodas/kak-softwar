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
                        {{ __('messages.sale_form') }}</h1>
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
                        <li class="breadcrumb-item text-muted"> {{ __('messages.sale_form') }}</li>
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
                    <form role="form" action="{{ route('sale.store') }}" method="POST" enctype="multipart/form-data"
                        id="transferForm">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset style="position: relative; margin-bottom:30px!important;">
                                        <legend style="position: absolute; top:-20px">
                                            {{ __('messages.product_information') }}
                                        </legend>

                                        <div class="row" style="margin-top: 20px">
                                            @php
                                                $isSuperAdmin = auth()
                                                    ->user()
                                                    ->roles->pluck('name')
                                                    ->contains('Super Admin');
                                                $sessionBranch = session('branch_id');
                                            @endphp
                                            @if ($isSuperAdmin && !$sessionBranch)
                                                <div class="col-sm-2" style="margin-top: 5px">
                                                    <label>{{ __('messages.branch') }}</label>
                                                </div>
                                                <div class="col-sm-10" style="margin-top: 5px">
                                                    <select id="branch_id" class="form-select" name="branch_id">
                                                        <option value="">{{ __('messages.select_one') }}</option>
                                                        @foreach ($branchInfo as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}

                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            {{-- scan barcode  --}}

                                            <div class="col-md-4" style="margin-top: 5px">
                                                <label>{{ __('messages.scan_your_bar_code') }}
                                                </label>
                                            </div>
                                            <div class="col-md-8" style="margin-top: 5px">

                                                <input style="background-color:#FFD700;" type="text" name="bar_code"
                                                    id="bar_code" value="" class="form-control"
                                                    placeholder="Scan Your Bar Code.." autofocus />
                                            </div>

                                            {{-- product  --}}

                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <label>{{ __('messages.product') }}</label>
                                            </div>
                                            <div class="col-sm-10" style="margin-top: 5px">
                                                <select id="product_id" class="form-select select2">
                                                    <option value="">{{ __('messages.select_one') }}</option>
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}">({{ $item->barcode }})
                                                            {{ $item->name }}
                                                            {{ $item->name_arabic }}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>




                                        </div>

                                        <!-- Transfer Items Table -->
                                        <div class="row" id="transfer_item_table"
                                            style="margin-top: 20px; margin-bottom: 20px; display: none;">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="10%">{{ __('messages.sl') }}</th>
                                                        <th class="text-center" width="10%">
                                                            {{ __('messages.product') }} {{ __('messages.code') }}
                                                        <th class="text-center" width="10%">{{ __('messages.name') }}
                                                        </th>
                                                        <th class="text-center" width="10%">{{ __('messages.color') }}
                                                        </th>
                                                        <th class="text-center" width="10%">{{ __('messages.size') }}
                                                        </th>
                                                        <th class="text-center" width="10%">{{ __('messages.stock') }}
                                                        </th>
                                                        <th class="text-center" width="10%">{{ __('messages.rate') }}
                                                        </th>
                                                        <th class="text-center" width="20%">{{ __('messages.qty') }}
                                                        </th>
                                                        <th class="text-center" width="10%">{{ __('messages.action') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Dynamic rows will be added here -->
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="cart_total_item" value="0">
                                            <input type="hidden" id="cart_total_quantity" value="0">
                                        </div>



                                    </fieldset>


                                </div>
                                <div class="col-lg-6">
                                    <fieldset style="position: relative;">
                                        <legend style="position: absolute; top:-20px">
                                            {{ __('messages.sale_summary') }}
                                        </legend>
                                        <!-- Cart Table (above customer info) -->
                                        <div class="row" id="cart_table_container"
                                            style="margin-top:20px; display:none;">
                                            <div class="col-12">
                                                <h4>Sale Items</h4>
                                                <table class="table table-bordered" id="cart_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" width="10%">{{ __('messages.sl') }}
                                                            </th>
                                                            <th class="text-center" width="15%">
                                                                {{ __('messages.product') }} {{ __('messages.code') }}
                                                            </th>
                                                            <th class="text-center" width="15%">
                                                                {{ __('messages.product') }}</th>
                                                            <th class="text-center" width="10%">
                                                                {{ __('messages.color') }}</th>
                                                            <th class="text-center" width="10%">
                                                                {{ __('messages.size') }}</th>
                                                            <th class="text-center" width="20%">
                                                                {{ __('messages.qty') }}
                                                            </th>
                                                            <th class="text-center" width="10%">
                                                                {{ __('messages.rate') }}</th>
                                                            <th class="text-center" width="15%">
                                                                {{ __('messages.total') }}</th>
                                                            <th class="text-center" width="10%">
                                                                {{ __('messages.action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Cart rows will go here -->
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="5" class="text-end">
                                                                {{ __('messages.total') }}:</th>
                                                            <th class="text-center" id="cart_total_qty">0</th>
                                                            <th></th>
                                                            <th class="text-center" id="cart_total_amount">0.00</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <input type="hidden" id="cart_total_item" value="0">
                                                <input type="hidden" id="cart_total_quantity" value="0">
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 20px">
                                            {{-- customer phone   --}}
                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <label>{{ __('messages.customer') }} {{ __('messages.phone') }}
                                                </label>
                                            </div>
                                            <div class="col-sm-8" style="margin-top: 5px">
                                                <input type="number" name="phone" id="phone"
                                                    placeholder="{{ __('messages.customer') }} {{ __('messages.phone') }} {{ __('messages.number') }}"
                                                    class="form-control phone">
                                            </div>

                                            {{-- customer name  --}}
                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <label>{{ __('messages.customer') }} {{ __('messages.name') }}
                                                </label>
                                            </div>
                                            <div class="col-sm-8" style="margin-top: 5px">
                                                <input type="text" name="name" id="name"
                                                    placeholder="{{ __('messages.name') }}" class="name form-control">
                                            </div>

                                            {{-- customer address  --}}

                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <label>{{ __('messages.customer') }} {{ __('messages.address') }}
                                                </label>
                                            </div>

                                            <div class="col-sm-8" style="margin-top: 5px">

                                                <textarea name="address" id="address" class="form-control address" cols="30" rows="10"
                                                    placeholder="{{ __('messages.address') }}"></textarea>
                                            </div>

                                        </div>

                                        <div class="row mt-4">
                                            {{--  discount  --}}
                                            {{-- <div class="col-sm-2">
                                                <label>{{ __('messages.discount') }} </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" id="discount_amount" name="discount_amount"
                                                    class="form-control" value="0">
                                            </div> --}}


                                            <!-- Discount Type -->
                                            <div class="col-sm-4">
                                                <label>{{ __('messages.discount') }} {{ __('messages.type') }}</label>
                                            </div>
                                            <div class="col-sm-8 mb-2">
                                                <select id="discount_type" class="form-select select2">
                                                    <option value="">{{ __('messages.select_one') }}</option>
                                                    <option value="percent">Percent (%)</option>
                                                    <option value="flat" selected>Flat Amount</option>
                                                </select>
                                            </div>

                                            <!-- DISCOUNT ENTRY -->
                                            <div class="col-sm-4 mb-2 mt-2 discount-area" style="display:none;">
                                                <label>{{ __('messages.discount') }}</label>
                                            </div>
                                            <div class="col-sm-8 mt-2 discount-area" id="discount_input_area"
                                                style="display:none;">
                                            </div>

                                            <!-- DISCOUNT AMOUNT SHOW ONLY FOR PERCENT -->
                                            <div class="col-sm-4 mb-2 mt-2 percent-discount-amount" style="display:none;">
                                                <label>{{ __('messages.discount') }} {{ __('messages.amount') }}</label>
                                            </div>
                                            <div class="col-sm-8  mt-2 percent-discount-amount" style="display:none;">
                                                <input type="text" id="discount_calculated_amount"
                                                    class="form-control" readonly>
                                            </div>


                                            {{-- payable_amount  --}}
                                            <div class="col-sm-2">
                                                <label>{{ __('messages.vat') }}</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" id="vat_amount" name="vat_amount"
                                                    class="form-control" readonly value="0.00" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>{{ __('messages.payable_amount') }}</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" id="payable_amount" name="payable_amount"
                                                    class="form-control" readonly value="0.00" readonly>
                                            </div>

                                            <div class="col-sm-2">
                                                <label>{{ __('messages.paid_amount') }}</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="number" id="paid_amount" name="paid_amount"
                                                    class="form-control" step="0.01" min="0" value="0"
                                                    readonly>
                                            </div>


                                            {{-- due_amount  --}}
                                            <div class="col-sm-2 mt-3">
                                                <label>{{ __('messages.due_amount') }}</label>
                                            </div>
                                            <div class="col-sm-4 mt-3">
                                                <input type="text" id="due_amount" name="due_amount"
                                                    class="form-control" readonly value="0.00" readonly>
                                            </div>


                                            {{-- date  --}}
                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <label>{{ __('messages.date') }}
                                                </label>
                                            </div>
                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <input type="date" name="date" id="date"
                                                    class="date form-control" required value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="row">
                                                {{-- note  --}}
                                                <div class="col-md-2" style="margin-top: 5px">
                                                    <label for="note">{{ __('messages.note') }}</label>
                                                </div>
                                                <div class="col-md-10" style="margin-top: 5px">
                                                    <textarea name="note" id="note" class="form-control note" cols="30" rows="10"
                                                        placeholder="{{ __('messages.note') }}"></textarea>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Payment Fields (hidden by default) -->


                                        <div id="payment_section" class="row mt-4"
                                            style="border:1px solid #ddd; padding:15px; border-radius:5px;">

                                            {{-- fund  --}}
                                            <div class="col-sm-12">
                                                <label>{{ __('messages.fund') }}</label>
                                                <select id="fund_id" class="form-control select2">
                                                    <option value="">{{ __('messages.select_one') }}</option>
                                                    @foreach ($funds as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>



                                            <div id="bank-section" style="display:none;" class="col-sm-12">
                                                <div class="row">
                                                    {{-- bank  --}}
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="bank_id"
                                                                class="form-label">{{ __('messages.bank') }}
                                                                <span class="text-danger">*</span></label>
                                                            <select id="bank_id" class="form-select select2">
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
                                                            <select id="account_id" class="form-select select2">
                                                                <option value="">{{ __('messages.select_one') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>

                                            {{-- payment_amount --}}
                                            <div class="col-sm-12">
                                                <label>{{ __('messages.payment_amount') }}</label>
                                                <input type="number" id="payment_amount" name="payment_amount"
                                                    class="form-control" step="0.01" min="0">
                                            </div>

                                            <div class="col-sm-12"
                                                style="display: flex; align-items: center; justify-content: end; margin-top:20px;">
                                                <button id="add_payment_btn" type="button"
                                                    class="btn btn-success">{{ __('messages.add') }}
                                                    {{ __('messages.payment') }}
                                                </button>
                                            </div>


                                        </div>

                                        <div class="col-12 mt-4" style="display: none" id="payment_table_section">
                                            <h3>Payment Information</h3>
                                            <table class="table table-bordered" id="payment_table">
                                                <thead>
                                                    <tr>
                                                        <th>Fund</th>
                                                        <th>Bank</th>
                                                        <th>Account</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3" style="text-align: right">Total:</th>
                                                        <th id="total_payment">0.00</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="row mt-4" style="display: flex; justify-content:center;">

                                            <div class="col-sm-3">
                                                <button type="submit" id="save_btn"
                                                    class="btn btn-success ">{{ __('messages.save') }}</button>
                                            </div>
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
    <style>
        .app-container {
            padding-left: 10px !important;
            padding-right: 10px !important;

        }

        .container-xxl {
            max-width: 1400px !important;
        }
    </style>
@endsection

@push('script')
    <!-- jQuery (required by Select2) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "{{ __('messages.select_one') }}",
                allowClear: true,
                width: '100%' // make it responsive
            });
        });
    </script>
    <script>
        const sessionBranchId = "{{ session('branch_id') ?? '' }}";
    </script>
    <script>
        $(document).ready(function() {
            $('#fund_id').on('change', function() {
                let dataId = $(this).val();
                $('#bank_id').trigger('change');
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

                                $.each(data.data, function(key, value) {

                                    $('#bank_id').append('<option value="' + value
                                        .id +
                                        '" >' + value.name +
                                        '</option>');
                                });
                            } else {
                                $('#bank-section').hide();
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

            $('#bank_id').on('change', function() {
                let dataId = $(this).val();
                var branchId = $('#branch_id').val();
                let finalBranchId = branchId || sessionBranchId;

                // 3. If still no branch found → Stop request
                if (!finalBranchId) {
                    $('#account_id').empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>'
                    );
                    Swal.fire({
                        icon: 'error',
                        title: `Please select a branch first!`,
                        confirmButtonText: 'OK',
                        timer: 3000, // 3 second পরে auto close
                        timerProgressBar: true, // progress bar দেখাবে
                        allowOutsideClick: true, // outside click করলেও বন্ধ হবে
                        allowEscapeKey: true, // escape key press করলে বন্ধ হবে
                    });
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



            function togglePaymentTable() {
                if (paymentCart.length > 0) {
                    $('#payment_table_section').show();
                } else {
                    $('#payment_table_section').hide();
                }
            }
            let paymentCart = []; // store all payments

            $(document).on('click', '#add_payment_btn', function(e) {
                e.preventDefault();

                let payable = parseFloat($('#payable_amount').val()) || 0;
                let payment = parseFloat($('#payment_amount').val()) || 0;
                let fund = $('#fund_id').val();
                let fundText = fund ? $('#fund_id option:selected').text() : '';
                let bank = $('#bank_id').val() || "";
                let bankText = bank ? $('#bank_id option:selected').text() || "" : '';
                let account = $('#account_id').val() || "";
                let accountText = account ? $('#account_id option:selected').text() || "" : '';

                if (!fund) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please select a fund',
                        timer: 2000
                    });
                    return;
                }
                if (payment <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Enter a valid amount',
                        timer: 2000
                    });
                    return;
                }

                let totalPaid = paymentCart.reduce((sum, item) => sum + item.amount, 0);
                if ((totalPaid + payment) > payable) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('messages.payment_amount_error') }}',
                        timer: 3000
                    });
                    return;
                }

                paymentCart.push({
                    fund_id: fund,
                    fund_name: fundText,
                    bank_id: bank,
                    bank_name: bankText,
                    account_id: account,
                    account_name: accountText,
                    amount: payment
                });

                updatePaymentTable();
                updateDueAmount();
                togglePaymentTable(); // <-- SHOW PAYMENT TABLE

                $('#payment_amount').val('');
                $('#fund_id').val('').trigger('change');
                $('#bank_id').val('').trigger('change');
                $('#account_id').val('').trigger('change');
            });


            function updatePaymentTable() {
                let html = '';
                let total = 0;

                paymentCart.forEach((item, index) => {
                    html += `
                        <tr>
                            <td>
                                ${item.fund_name}
                                <input type="hidden" name="fund_id[]" value="${item.fund_id}">
                            </td>
                            <td>
                                ${item.bank_name}
                                <input type="hidden" name="bank_id[]" value="${item.bank_id}">
                            </td>
                            <td>
                                ${item.account_name}
                                <input type="hidden" name="account_id[]" value="${item.account_id}">
                            </td>
                            <td class="text-right">
                                ${item.amount.toFixed(2)}
                                <input type="hidden" name="payment_amount[]" value="${item.amount}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove_payment" data-index="${index}">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    `;
                    total += item.amount;
                });

                $('#payment_table tbody').html(html);
                $('#total_payment').text(total.toFixed(2));
            }


            $(document).on('click', '.remove_payment', function() {
                let index = $(this).data('index');
                paymentCart.splice(index, 1);
                updatePaymentTable();
                updateDueAmount();
                togglePaymentTable();


            });



            function updateDueAmount() {
                let payable = parseFloat($('#payable_amount').val()) || 0;
                let totalPaid = paymentCart.reduce((sum, item) => sum + item.amount, 0);

                $('#paid_amount').val(totalPaid.toFixed(2));

                let due = payable - totalPaid;
                if (due < 0) due = 0;

                $('#due_amount').val(due.toFixed(2));
            }






            function checkCustomer() {
                let phone = $('.phone').val();
                let branchId = $('#branch_id').val();
                let finalBranchId = branchId || sessionBranchId; // fallback if branch not selected

                if (phone.length >= 4) {
                    $.ajax({
                        url: '/admin/customer/check/' + (finalBranchId || ''),
                        method: 'GET',
                        data: {
                            phone: phone
                        },
                        success: function(response) {
                            if (response.exists) {
                                $('.name').val(response.name).prop('readonly', true);
                                $('.address').val(
                                    response.address + (response.district ? ', ' + response.district
                                        .name : '')
                                ).prop('readonly', true);
                            } else {
                                $('.name').val('').prop('readonly', false);
                                $('.address').val('').prop('readonly', false);
                            }
                        }
                    });
                } else {
                    $('.name').val('').prop('readonly', false);
                    $('.address').val('').prop('readonly', false);
                }
            }

            // Trigger when phone input changes
            $('.phone').on('keyup change', checkCustomer);

            // Trigger when branch changes
            $('#branch_id').on('change', checkCustomer);


            $('#branch_id').on('change', function() {
                $('#product_id').trigger('change');
                $('#bank_id').trigger('change');
                $('#cart_table tbody').empty();
                $('#cart_table_container').hide();
                $('#transfer_item_table tbody').empty();
                $('#transfer_item_table').hide();
                paymentCart = [];
                $('#payment_table tbody').empty();
                $('#payment_table_section').hide();

                // 4️⃣ Paid amount reset
                $('#paid_amount').val(0);
                $('#total_payment').val(0);

                updateCartTotals();
            });

            $('.qty_input').each(function() {
                let max = parseInt($(this).attr('max'));
                if (max <= 0) {
                    $(this).val(0);
                    $(this).prop('disabled', true); // user input block
                }
            });
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

            $('#product_id').on('change', function() {
                let productId = $(this).val();
                var branchId = $('#branch_id').val();
                if (!productId) {
                    $('#transfer_item_table').hide();
                    $('#transfer_item_table tbody').empty();
                    return;
                }

                let finalBranchId = branchId || sessionBranchId;

                // 3. If still no branch found → Stop request
                if (!finalBranchId) {

                    Swal.fire({
                        icon: 'error',
                        title: `Please select a branch first!`,
                        confirmButtonText: 'OK',
                        timer: 3000, // 3 second পরে auto close
                        timerProgressBar: true, // progress bar দেখাবে
                        allowOutsideClick: true, // outside click করলেও বন্ধ হবে
                        allowEscapeKey: true, // escape key press করলে বন্ধ হবে
                    });
                    return;
                }


                $.ajax({
                    url: '/admin/get-sale-variant/' + productId + '/' + (finalBranchId ?? ''),
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        let tbody = $('#transfer_item_table tbody');
                        tbody.empty();
                        let singleVat = parseFloat(res.vat_amount) || 0;
                        $.each(res.data, function(index, variant) {
                            let variantName = variant.product?.name || '';


                            let stock = variant.stock || 0;
                            let rate = res.sale_price || 0;

                            let row = `<tr data-id="${variant.id}" data-product="${variant.product_id}" data-stock="${stock}" data-vat="${singleVat}">
                                <td class="text-center">${index + 1}</td>
                                <td class="text-center">${variant.product?.barcode || ''}</td>
                                <td class="text-center">${variantName}</td>
                                <td class="text-center">${variant.color?.color_name || ''}</td>
                                <td class="text-center">${variant.size?.name || ''}</td>
                                <td class="text-center">${stock}</td>
                                <td class="text-center rate">${rate}</td>
                                <td class="text-center">
                                    <input type="number" class="form-control qty_input text-center" value="1"   step="1">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success add_row">Add</button>
                                </td>
                            </tr>`;

                            tbody.append(row);
                        });

                        $('#transfer_item_table').show(); // Show table after adding rows
                        if (res.data.length === 1) {
                            tbody.find('.add_row')
                                .click(); // triggers the click handler automatically
                        }
                    }
                });
            });

            $(document).on('click', '.add_row', function() {

                let row = $(this).closest('tr');
                let variantId = row.data('id');
                let productId = row.data('product'); // product id must be sent from backend
                let productCode = row.find('td:eq(1)').text();
                let productName = row.find('td:eq(2)').text();
                let color = row.find('td:eq(2)').text();
                let size = row.find('td:eq(3)').text();

                // let stock = parseFloat(row.find('.qty_input').attr('max')) || 0;
                let stock = parseFloat(row.data('stock')) || 0;

                let qtyToAdd = parseFloat(row.find('.qty_input').val()) || 0;
                let singleVat = parseFloat(row.data('vat')) || 0;
                // Existing row check
                let existingRow = $('#cart_table tbody').find(`tr[data-id="${variantId}"]`);
                let existingQty = 0;

                if (existingRow.length > 0) {
                    existingQty = parseFloat(existingRow.find('.cart_qty').val()) || 0;
                }

                // New total qty
                let newQty = existingQty + qtyToAdd;
                newQty = parseFloat(newQty.toFixed(2));

                if (newQty > stock) {

                    Swal.fire({
                        icon: 'error',
                        title: `Maximum available stock is ${stock}`,
                        confirmButtonText: 'OK',
                        timer: 3000, // 3 second পরে auto close
                        timerProgressBar: true, // progress bar দেখাবে
                        allowOutsideClick: true, // outside click করলেও বন্ধ হবে
                        allowEscapeKey: true, // escape key press করলে বন্ধ হবে
                    });
                    newQty = stock;
                }

                let rate = parseFloat(row.find('.rate').text()) || 0;
                let total = newQty * rate;

                let currentVat = parseFloat($('#vat_amount').val()) || 0;
                let addedVat = qtyToAdd * singleVat;
                $('#vat_amount').val((currentVat + addedVat).toFixed(2));

                if (existingRow.length > 0) {
                    // Update row
                    existingRow.find('.cart_qty').val(newQty);
                    existingRow.find('.hidden_qty').val(newQty);

                    existingRow.find('.cart_total').text(total.toFixed(2));
                    existingRow.find('.hidden_total').val(total.toFixed(2));

                } else {
                    // NEW row create
                    let sl = $('#cart_table tbody tr').length + 1;
                    let cartRow = `
                        <tr data-id="${variantId}" data-stock="${stock}">
                            <td class="text-center">${sl}</td>
                            <td class="text-center">${productCode}</td>
                            <td class="text-center">${productName}</td>
                            <td class="text-center">${color}</td>
                            <td class="text-center">${size}</td>

                            <td class="text-center">
                                <input type="number" class="form-control  cart_qty text-center"
                                     value="${newQty}"  max="${stock}"  step="0.01">

                                <input type="hidden" name="product_id[]" value="${productId}">
                                <input type="hidden" name="variant_id[]" value="${variantId}">
                                <input type="hidden" name="qty[]" class="hidden_qty" value="${newQty}">

                            </td>

                            <td class="text-center rate">
                                ${rate}
                                <input type="hidden" name="rate[]" value="${rate}">
                            </td>

                            <input type="hidden" name="sub_total[]" class="hidden_total" value="${total.toFixed(2)}">
                            <td class="text-center cart_total">
                                ${total.toFixed(2)}

                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-danger remove_row">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;

                    $('#cart_table tbody').append(cartRow);
                }

                $('#cart_table_container').show();
                updateCartTotals();
            });


            // Update cart quantity and total
            $(document).on('input', '.cart_qty', function() {
                let row = $(this).closest('tr');
                let stock = parseFloat(row.data('stock')) || 0;
                let val = parseFloat($(this).val()) || 0;

                if (val > stock) val = stock;
                if (val < 0) val = 0;

                $(this).val(val.toFixed(2));

                // Get rate from table cell
                let rate = parseFloat(row.find('.rate').text()) || 0;
                row.find('.cart_total').text((val * rate).toFixed(2));

                updateCartTotals();
            });

            // Remove item from cart
            $(document).on('click', '.remove_row', function() {
                let row = $(this).closest('tr');

                // Subtract VAT
                let qty = parseFloat(row.find('.cart_qty').val()) || 0;
                let variantId = row.data('id');

                // Find VAT from transfer table (or store VAT per row in cart)
                let vatPerItem = parseFloat($('#transfer_item_table tbody tr[data-id="' + variantId + '"]')
                    .data('vat')) || 0;
                let currentVat = parseFloat($('#vat_amount').val()) || 0;

                let newVat = currentVat - (vatPerItem * qty);
                $('#vat_amount').val(newVat.toFixed(2));

                // Remove row
                row.remove();

                updateCartTotals();
            });


            // $(document).on('input', '#discount_amount', function() {
            //     updateCartTotals();
            // });

            $(document).on('change', '#discount_type', function() {
                let type = $(this).val();

                // Hide all by default
                $(".discount-area").hide();
                $(".percent-discount-amount").hide();
                $('#discount_input_area').html("");

                if (type === "percent") {
                    $(".discount-area").show();
                    $(".percent-discount-amount").show();

                    $('#discount_input_area').html(`
                        <input type="number" id="discount_percent"
                            class="form-control" placeholder="{{ __('messages.discount') }} %">

                    `);

                    $('#discount_calculated_amount').attr('name', 'discount_amount');
                } else if (type === "flat") {
                    $(".discount-area").show();
                    $('#discount_input_area').html(`
                        <input type="number" id="discount_flat"
                            class="form-control" name="discount_amount" placeholder="{{ __('messages.amount') }}">
                    `);

                    $('#discount_calculated_amount').removeAttr('name');
                }

                updateCartTotals();
            });

            if ($('#discount_type').val()) {
                $('#discount_type').trigger('change');
            }


            $(document).on('input', '#discount_percent, #discount_flat', function() {
                updateCartTotals();
            });



            // function updateCartTotals() {
            //     let totalQty = 0;
            //     let totalAmount = 0;

            //     $('#cart_table tbody tr').each(function() {
            //         let qty = parseFloat($(this).find('.cart_qty').val()) || 0;
            //         let rate = parseFloat($(this).find('.rate').text()) || 0;
            //         totalQty += qty;
            //         totalAmount += qty * rate;
            //     });

            //     // Update footer
            //     $('#cart_total_qty').text(totalQty.toFixed(2));
            //     $('#cart_total_amount').text(totalAmount.toFixed(2));

            //     // Update hidden inputs if needed
            //     $('#cart_total_item').val($('#cart_table tbody tr').length);
            //     $('#cart_total_quantity').val(totalQty.toFixed(2));

            //     // Apply discount
            //     let discount = parseFloat($('#discount_amount').val()) || 0;

            //     let payable = totalAmount - discount;
            //     if (payable < 0) payable = 0; // Prevent negative payable

            //     $('#payable_amount').val(payable.toFixed(2));

            //     calculateDue();
            // }

            function updateCartTotals() {
                let totalAmount = 0;
                let totalQty = 0;

                $('#cart_table tbody tr').each(function() {
                    let qty = parseFloat($(this).find('.cart_qty').val()) || 0;
                    let rate = parseFloat($(this).find('.rate').text()) || 0;
                    totalAmount += qty * rate;
                    totalQty += qty;
                });

                $('#cart_total_qty').text(totalQty.toFixed(2));
                $('#cart_total_amount').text(totalAmount.toFixed(2));

                let vat = parseFloat($('#vat_amount').val()) || 0;
                let totalWithVat = totalAmount + vat; // total + VAT

                let discount_type = $('#discount_type').val();
                let discount_amount = 0;

                if (discount_type === "percent") {
                    let percent = parseFloat($('#discount_percent').val()) || 0;
                    if (percent > 100) percent = 100;

                    discount_amount = (totalWithVat * percent) / 100; // calculate on total + VAT
                    $('#discount_calculated_amount').val(discount_amount.toFixed(2));
                    $(".percent-discount-amount").show();
                }

                if (discount_type === "flat") {
                    discount_amount = parseFloat($('#discount_flat').val()) || 0;
                    if (discount_amount > totalWithVat) discount_amount = totalWithVat; // cannot exceed total + VAT
                    $(".percent-discount-amount").hide();
                }

                // Payable = total + VAT - discount
                let payable = totalWithVat - discount_amount;
                if (payable < 0) payable = 0;

                $('#payable_amount').val(payable.toFixed(2));

                calculateDue();
            }




            function calculateDue() {
                let payable = parseFloat($('#payable_amount').val()) || 0;
                let paid = parseFloat($('#paid_amount').val()) || 0;

                let due = payable - paid;
                console.log(due);
                if (due < 0) due = 0; // No return amount shown

                $('#due_amount').val(due.toFixed(2));
            }



        });
    </script>
    <script>
        $(document).ready(function() {
            // FORM SUBMIT VALIDATION
            // Prevent form submission if no items in cart
            $('#transferForm').on('submit', function(e) {
                let rowCount = $('#cart_table tbody tr').length;
                let phone = $('#phone').val().trim();
                let name = $('#name').val().trim();
                let address = $('#address').val().trim(); // make sure your address input has id="address"
                let due = parseFloat($('#due_amount').val()) || 0;

                // Check if cart has items
                if (rowCount === 0) {
                    e.preventDefault();
                    hideLoading();
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ __('messages.no_items_added') }}',
                        text: '{{ __('messages.add_at_least_one_product') }}.',
                        confirmButtonText: 'OK',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    return;
                }
                if (due > 0) {
                    // Check if customer info is filled
                    if (!phone || !name || !address) {
                        e.preventDefault();
                        hideLoading();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Customer information missing!',
                            text: 'Please enter customer phone, name, and address before submitting.',
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        return;
                    }
                }




                // If all validations pass, form will submit
            });



            // $('#product_id').on('change', function() {
            //     alert('hi');
            //     let dataId = $(this).val();
            //     if (dataId) {
            //         $.ajax({
            //             url: '/admin/get-variant/' + dataId,
            //             type: 'GET',
            //             dataType: 'json',
            //             success: function(data) {
            //                 $('#sale_price').val(data.sale_price);
            //                 $('#variant_id').empty().append(
            //                     '<option value="">Select One</option>');

            //                 $.each(data.data, function(key, value) {
            //                     let variantName = '';

            //                     // Product name
            //                     if (value.product && value.product.name) {
            //                         variantName += value.product.name;
            //                     }

            //                     // Size name
            //                     if (value.size && value.size.name) {
            //                         variantName += ' / ' + value.size.name;
            //                     }

            //                     // Color name
            //                     if (value.color && value.color.name) {
            //                         variantName += ' / ' + value.color.name;
            //                     }

            //                     $('#variant_id').append('<option value="' + value.id +
            //                         '">' + variantName + '</option>');
            //                 });

            //                 $('#variant_id').trigger('change'); // Optional
            //             }
            //         });
            //     } else {
            //         $('#variant_id').empty().append('<option value="">Select One</option>');
            //     }
            // });



        });
    </script>
@endpush
