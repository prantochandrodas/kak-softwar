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
                        {{ __('messages.transfer_product') }}</h1>
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
                        <li class="breadcrumb-item text-muted"> {{ __('messages.transfer_product') }}</li>
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
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }


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
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <form role="form" action="{{ route('product.transfer.store') }}" method="POST"
                                    enctype="multipart/form-data" id="transferForm">
                                    @csrf

                                    <fieldset style="position: relative">
                                        <legend style="position: absolute; top:-20px">
                                            {{ __('messages.product_transfer_information') }}
                                        </legend>
                                        <div class="row" style="margin-top: 15px">
                                            @php
                                                $isSuperAdmin = auth()
                                                    ->user()
                                                    ->roles->pluck('name')
                                                    ->contains('Super Admin');
                                                $sessionBranch = session('branch_id');
                                            @endphp

                                            @if ($isSuperAdmin && !$sessionBranch)
                                                <!-- from Branch -->
                                                <div class="col-md-2" style="margin-top: 5px">
                                                    <label for="form_branch_id">{{ __('messages.from_branch') }}</label>
                                                </div>
                                                <div class="col-md-4" style="margin-top: 5px">
                                                    <select name="form_branch_id" id="form_branch_id"
                                                        class="form-select select2" data-placeholder="Select a Branch"
                                                        data-allow-clear="true" required>
                                                        <option>{{ __('messages.select_one') }}</option>
                                                        @foreach ($branches as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <!-- To Branch -->
                                            <div class="col-md-2" style="margin-top: 5px">
                                                <label for="transfer_branch">{{ __('messages.to_branch') }}</label>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 5px">
                                                <select name="to_branch_id" id="to_branch_id" class="form-select select2"
                                                    data-placeholder="Select a Branch" data-allow-clear="true" required>
                                                    <option>{{ __('messages.select_one') }}</option>
                                                    @foreach ($branches as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="col-md-2" style="margin-top: 5px">
                                                <button type="button" class="btn btn-success" id="add_branch_btn">
                                                    {{ __('messages.add_branch') }}
                                                </button>
                                            </div> --}}
                                        </div>
                                        <div class="row" style="margin-top: 20px">
                                            <div class="col-md-4" style="margin-top: 5px">
                                                <label>{{ __('messages.scan_your_bar_code') }}
                                                </label>
                                            </div>
                                            <div class="col-md-8" style="margin-top: 5px">

                                                <input style="background-color:#FFD700;" type="text" name="bar_code"
                                                    id="bar_code" value="" class="form-control"
                                                    placeholder="Scan Your Bar Code.." autofocus />
                                            </div>


                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <label>{{ __('messages.product') }}</label>
                                            </div>
                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <select id="product_id" class="form-select select2">
                                                    <option>{{ __('messages.select_one') }}</option>
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}">({{ $item->barcode }})
                                                            {{ $item->name }}
                                                            {{ $item->name_arabic }}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Transfer Date -->
                                            <div class="col-md-2" style="margin-top: 5px">
                                                <label for="transfer_date">{{ __('messages.transfer_date') }}</label>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 5px">
                                                <input type="date" name="transfer_date" id="transfer_date"
                                                    value="{{ date('Y-m-d') }}" class="form-control">
                                            </div>





                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <label>{{ __('messages.variant') }}</label>
                                            </div>
                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <select id="variant_id" class="form-select select2"
                                                    data-placeholder="Select Variant" data-allow-clear="true">
                                                    <option>{{ __('messages.select_one') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <label>{{ __('messages.available_stock') }} <span
                                                        style="font-weight: normal; font-size:12px; color:red; "
                                                        id="product_unit"></span></label>
                                            </div>
                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <input type="number" name="available_stock" id="available_stock"
                                                    placeholder="{{ __('messages.available_stock') }}"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <label>{{ __('messages.transfer_quantity') }}</label>
                                            </div>
                                            <div class="col-sm-4" style="margin-top: 5px">
                                                <input type="number" name="transfer_quantity" id="transfer_quantity"
                                                    placeholder="{{ __('messages.transfer_quantity') }}"
                                                    class="form-control">
                                            </div>

                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <button type="button" class="btn btn-success btn-block"
                                                    id="product_add_button">
                                                    {{ __('messages.add') }}
                                                </button>
                                            </div>



                                        </div>

                                        <!-- Transfer Items Table -->
                                        <div class="row" id="transfer_item_table"
                                            style="margin-top: 20px; margin-bottom: 20px">

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="10%">
                                                            <button type="button" class="btn" style="color:black;">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </th>
                                                        <th class="text-center" width="10%">
                                                            {{ __('messages.product') }} {{ __('messages.code') }}
                                                        </th>
                                                        <th class="text-center" width="10%">
                                                            {{ __('messages.product') }} {{ __('messages.name') }}
                                                        </th>
                                                        <th class="text-center" width="20%">
                                                            {{ __('messages.variant') }}
                                                        </th>
                                                        <th class="text-center" width="10%">
                                                            {{ __('messages.rate') }}
                                                        </th>
                                                        <th class="text-center" width="20%">
                                                            {{ __('messages.transfer_quantity') }}</th>
                                                        <th class="text-center" width="20%">
                                                            {{ __('messages.total') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Dynamic rows will be added here -->
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="cart_total_item" value="0">
                                            <input type="hidden" id="cart_total_quantity" value="0">
                                        </div>

                                        <!-- Totals Section -->
                                        <div class="row">
                                            <!-- Total Items -->
                                            <div class="col-md-2" style="margin-top: 5px">
                                                <label for="total_item">{{ __('messages.total_items') }}</label>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 5px">
                                                <input type="text" name="total_item" id="total_item" value="0"
                                                    class="form-control" readonly>
                                            </div>

                                            <!-- Total Quantity -->
                                            <div class="col-md-2" style="margin-top: 5px">
                                                <label for="total_quantity">{{ __('messages.total_quantity') }}</label>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 5px">
                                                <input type="text" name="total_quantity" id="total_quantity"
                                                    value="0" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-12 mt-4" id="from_branch_box" style="display:none;">
                                                <label style="font-weight:bold;">From Branch:</label>
                                                <span id="from_branch_display"
                                                    style="font-weight:bold; color:#000000; font-size:14px"></span>
                                                <input type="hidden" name="selected_from_branch"
                                                    id="selected_from_branch" value="">
                                            </div>

                                            <div class="col-md-12 mt-4" id="to_branch_box" style="display:none;">
                                                <label>{{ __('messages.to_branch') }} :</label>
                                                <span id="branch_display"
                                                    style="font-weight:bold; color:#000000; font-size:14px"></span>
                                                <input type="hidden" name="selected_branch" id="selected_branch"
                                                    value="">
                                            </div>

                                            <div class="col-md-12 text-center mt-2">
                                                <button type="submit" class="btn btn-success">
                                                    {{ __('messages.confirm_transfer') }}
                                                </button>
                                            </div>
                                        </div>

                                    </fieldset>
                                    <input type="hidden" id="purchase_price" value="0">
                                </form>
                            </div>
                        </div>
                    </div>
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
            // FORM SUBMIT VALIDATION
            $('#transferForm').on('submit', function(e) {

                let toBranch = $('#selected_branch').val();
                let fromBranch = $('#selected_from_branch').val();
                let totalItems = parseInt($('#total_item').val());
                let isSuperAdmin = "{{ $isSuperAdmin ? '1' : '0' }}";
                let sessionBranch = "{{ $sessionBranch ? $sessionBranch : '' }}";

                // -----------------------
                // 1. TO BRANCH CHECK
                // -----------------------
                if (!toBranch) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing To Branch',
                        text: 'Please select a To Branch before submitting.',
                    });
                    hideLoading();
                    return false;
                }


                if (totalItems === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cart Empty',
                        text: 'Please add at least one product to transfer.',
                    });
                    hideLoading();
                    return false;
                }


                if (isSuperAdmin === "1" && sessionBranch === "") {
                    if (!fromBranch) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing From Branch',
                            text: 'Please select a From Branch before submitting.',
                        });
                        hideLoading();
                        return false;
                    }
                }
            });


            // $('#add_branch_btn').on('click', function() {
            //     let branchId = $('#to_branch_id').val();
            //     let branchName = $('#to_branch_id option:selected').text();

            //     if (!branchId) {
            //         alert("Please select a branch first.");
            //         return;
            //     }

            //     $('#selected_branch').val(branchId);
            //     $('#to_branch_display').text(branchName);
            //     $('#to_branch_box').show();
            // });
            let cart = [];

            $('#product_add_button').on('click', function() {
                let fullText = $('#product_id option:selected').text();
                let productCode = fullText.split(')')[0].replace('(', '');
                let productName = fullText.split(')')[1].trim();
                let productId = $('#product_id').val();
                let variantId = $('#variant_id').val();
                let variantName = $('#variant_id option:selected').text();
                let availableStock = parseFloat($('#available_stock').val());
                let transferQuantity = parseFloat($('#transfer_quantity').val());
                let rate = parseFloat($('#purchase_price').val()) || 0;

                if (!productId || !variantId) {
                    alert("Please select product and variant.");
                    return;
                }

                if (!transferQuantity || transferQuantity <= 0) {
                    alert("Please enter valid transfer quantity.");
                    return;
                }

                if (transferQuantity > availableStock) {
                    alert("Transfer quantity cannot exceed available stock.");
                    return;
                }

                // Check if already in cart
                let exists = cart.find(item => item.variantId == variantId);
                if (exists) {
                    alert("This variant is already added in the cart.");
                    return;
                }

                // Calculate total (quantity * rate)
                let total = transferQuantity * rate;
                total = parseFloat(total.toFixed(2));

                // Add to cart array
                cart.push({
                    productCode,
                    productId,
                    productName,
                    variantId,
                    variantName,
                    rate,
                    transferQuantity,
                    total
                });

                updateCartTable();
                resetInputFields();
            });

            // Remove from cart
            $(document).on('click', '.remove-item', function() {
                let index = $(this).data('index');
                cart.splice(index, 1);
                updateCartTable();
            });

            // Update cart table
            function updateCartTable() {
                let tbody = $('#transfer_item_table tbody');
                tbody.empty();

                let totalItems = 0;
                let totalQuantity = 0;

                cart.forEach((item, index) => {
                    let row = `<tr>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                        <td class="text-center">${item.productCode}  <input type="hidden""></td>
                        <td class="text-center">${item.productName}  <input type="hidden" name="product_id[]" value="${item.productId}"></td>
                        <td class="text-center">${item.variantName}  <input type="hidden" name="variant_id[]" value="${item.variantId}"></td>
                        <td class="text-center">${item.rate} <input type="hidden" name="rate[]" value="${item.rate}"></td>
                        <td class="text-center">${item.transferQuantity}  <input type="hidden" name="quantity[]" value="${item.transferQuantity}"></td>
                        <td class="text-center">${item.total} <input type="hidden" name="total[]" value="${item.total}"></td>
                    </tr>`;
                    tbody.append(row);

                    totalItems += 1;
                    totalQuantity += item.transferQuantity;
                });

                $('#total_item').val(totalItems);
                $('#total_quantity').val(totalQuantity);
            }

            // Reset input fields after adding
            function resetInputFields() {
                $('#variant_id').val('').trigger('change');
                $('#product_id').val('').trigger('change');
                $('#available_stock').val('');
                $('#transfer_quantity').val('');
                $('#product_unit').text('');
            }

            $('#form_branch_id').on('change', function() {

                let fromBranchId = $(this).val();
                let fromBranchName = $("#form_branch_id option:selected").text();

                // ============================
                // 🔥 RESET ALL FIELDS
                // ============================

                // Product Select2 reset
                $('#product_id').val('').trigger('change.select2');

                // Variant reset
                $('#variant_id').empty()
                    .append('<option value="">Select Variant</option>')
                    .trigger('change.select2');

                // Stock reset
                $('#available_stock').val('');

                // Quantity reset
                $('#transfer_quantity').val('');

                // Rate reset
                $('#purchase_price').val('');

                // Table Cart reset
                $('table tbody').empty();

                // Total calculations reset
                $('#total_item').val(0);
                $('#total_quantity').val(0);

                cart = [];

                // ============================
                // From Branch display update
                // ============================
                if (fromBranchId) {
                    $('#selected_from_branch').val(fromBranchId);
                    $('#from_branch_display').text(fromBranchName);
                    $('#from_branch_box').show();
                } else {
                    $('#selected_from_branch').val('');
                    $('#from_branch_box').hide();
                }
            });

            $('#to_branch_id').on('change', function() {

                let fromBranchId = $(this).val();
                let fromBranchName = fromBranchId ? $("#to_branch_id option:selected").text() : '';

                if (fromBranchId) {
                    $('#selected_branch').val(fromBranchId);
                    $('#branch_display').text(fromBranchName);
                    $('#to_branch_box').show();
                } else {
                    $('#to_branch_box').hide();
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
                let dataId = $(this).val();
                var branchId = $('#form_branch_id').val();
                let finalBranchId = branchId || sessionBranchId;
                if (dataId) {
                    $.ajax({
                        url: '/admin/get-variant/' + dataId + '/' + (finalBranchId ?? ''),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#purchase_price').val(data.purchase_price);
                            $('#variant_id').empty().append(
                                '<option value="">Select One</option>');

                            $.each(data.data, function(key, value) {
                                let variantName = '';

                                // Product name
                                if (value.product && value.product.name) {
                                    variantName += value.product.name;
                                }

                                // Size name
                                if (value.size && value.size.name) {
                                    variantName += ' / ' + value.size.name;
                                }

                                // Color name
                                if (value.color && value.color.name) {
                                    variantName += ' / ' + value.color.name;
                                }

                                $('#variant_id').append('<option value="' + value.id +
                                    '">' + variantName + '</option>');
                            });

                            $('#variant_id').trigger('change'); // Optional
                        }
                    });
                } else {
                    $('#variant_id').empty().append('<option value="">Select One</option>');
                }
            });
            $('#variant_id').on('change', function() {
                let variantId = $(this).val();
                var branchId = $('#form_branch_id').val();
                let finalBranchId = branchId || sessionBranchId;
                let productId = $('#product_id').val();
                if (variantId && productId) {
                    $.ajax({
                        url: '/admin/get-variant-stock/' + variantId + '/' + productId + '/' + (
                            finalBranchId ?? ''),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {

                            if (data.product_unit) {
                                $('#product_unit').text('(' + data.product_unit + ')');
                            } else {
                                $('#product_unit').text(''); // যদি unit না থাকে
                            }
                            if (data.stock !== undefined) {
                                $('#available_stock').val(data.stock);
                            } else {
                                $('#available_stock').val(0);
                            }
                        }
                    });
                } else {
                    $('#available_stock').val('');
                }
            });


        });
    </script>
@endpush
