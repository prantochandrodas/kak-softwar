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
                        {{ __('messages.purchase_form') }}</h1>
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
                        <li class="breadcrumb-item text-muted"> {{ __('messages.purchase_form') }}</li>
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
            /* ===== SIMPLE CLEAN POS DESIGN ===== */
            .card .card-header {
                min-height: 50px !important;
            }


            /* Main Card */
            .card {
                border: 1px solid #e5e7eb !important;
                border-radius: 0 !important;
                background: #ffffff !important;
                box-shadow: none !important;
            }

            /* Card Header - Simple Dark */
            .card-header {
                background: #1f2937 !important;
                border-bottom: none !important;
                padding: 10px 30px !important;
            }

            .card-header .card-title {
                font-size: 16px;
                font-weight: 600;
                color: #ffffff !important;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0;
            }

            /* Card Body */
            .card-body {
                padding: 30px !important;
                background: #fafafa;
            }

            /* Form Container */
            .card-body .row {
                background: #ffffff;
                padding: 30px;
                border: 1px solid #e5e7eb;
            }

            /* Form Labels - Simple */
            .form-label {
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 6px;
                color: #374151;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }

            .form-label .text-danger {
                color: #dc2626;
                margin-left: 3px;
            }

            /* Input Fields - Clean & Simple */
            .form-control,
            .form-select {
                border: 1px solid #d1d5db !important;
                border-radius: 0 !important;
                background: #ffffff !important;
                padding: 10px 14px !important;
                font-size: 14px;
                color: #374151;
                font-weight: 400;
                transition: border-color 0.2s ease;
            }

            .form-control:hover,
            .form-select:hover {
                border-color: #9ca3af !important;
            }

            .form-control:focus,
            .form-select:focus {
                background: #ffffff !important;
                border-color: #6b7280 !important;
                box-shadow: none !important;
                outline: none;
            }

            .form-control::placeholder {
                color: #9ca3af;
                font-size: 13px;
            }

            /* Textarea */
            textarea.form-control {
                resize: vertical;
                min-height: 50px;
            }

            /* File Input - Simple */
            input[type="file"].form-control {
                padding: 9px 14px !important;
                cursor: pointer;
                background: #f9fafb !important;
                border-style: dashed !important;
            }

            input[type="file"].form-control:hover {
                border-color: #6b7280 !important;
                background: #ffffff !important;
            }

            input[type="file"].form-control::-webkit-file-upload-button {
                background: #374151;
                color: white;
                border: none;
                padding: 6px 16px;
                border-radius: 0;
                cursor: pointer;
                font-weight: 600;
                font-size: 12px;
                text-transform: uppercase;
                margin-right: 12px;
            }

            input[type="file"].form-control::-webkit-file-upload-button:hover {
                background: #1f2937;
            }

            /* Invalid Feedback */
            .invalid-feedback {
                font-size: 12px;
                font-weight: 500;
                margin-top: 5px;
                color: #dc2626;
            }

            .form-control.is-invalid,
            .form-select.is-invalid {
                border-color: #dc2626 !important;
                background: #fef2f2 !important;
            }

            /* Button Container */
            .text-end {
                margin-top: 0;
                margin-left: -30px;
                margin-right: -30px;
                margin-bottom: -30px;
                padding: 20px 30px;
                background: #f3f4f6;
                border-top: 1px solid #e5e7eb;
            }

            /* Buttons - Simple & Clean */
            .btn {
                border-radius: 0 !important;
                font-weight: 600;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 11px 28px !important;
                border: none !important;
                transition: all 0.2s ease;
            }

            .btn:hover {
                opacity: 0.9;
            }

            .btn:active {
                opacity: 1;
            }

            /* Success Button */
            .btn-success {
                background: #16a34a !important;
                color: #fff !important;
            }

            .btn-success:hover {
                background: #15803d !important;
            }

            /* Secondary Button */
            .btn-secondary {
                background: #6b7280 !important;
                color: #fff !important;
            }

            .btn-secondary:hover {
                background: #4b5563 !important;
            }

            /* Primary Button */
            .btn-primary {
                background: #2563eb !important;
                color: #fff !important;
            }

            .btn-primary:hover {
                background: #1d4ed8 !important;
            }

            /* Danger Button */
            .btn-danger {
                background: #dc2626 !important;
                color: #fff !important;
            }

            .btn-danger:hover {
                background: #b91c1c !important;
            }

            /* Column Spacing */
            .col-md-6 {
                margin-bottom: 20px;
            }

            .mb-3 {
                margin-bottom: 0 !important;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .card-body {
                    padding: 20px !important;
                }

                .card-body .row {
                    padding: 20px;
                }

                .card-header {
                    padding: 16px 20px !important;
                }

                .card-header .card-title {
                    font-size: 14px;
                }

                .btn {
                    padding: 10px 24px !important;
                    font-size: 12px;
                    width: 100%;
                    margin-bottom: 10px;
                }

                .text-end {
                    text-align: center !important;
                    padding: 16px 20px;
                    margin-left: -20px;
                    margin-right: -20px;
                    margin-bottom: -20px;
                }

                .form-label {
                    font-size: 12px;
                }

                .form-control,
                .form-select {
                    font-size: 13px;
                    padding: 9px 12px !important;
                }
            }

            /* Print Support */
            @media print {

                .btn,
                .text-end {
                    display: none;
                }

                .card {
                    border: none !important;
                }

                .card-body {
                    padding: 0 !important;
                }
            }
        </style>


        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h4 class="card-title  mb-0">{{ __('messages.purchase_form') }}</h4>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <form id="purchaseForm">
                            @csrf
                            <div class="row" style="padding: 0px!important; border:none!important;">

                                <!-- বাম পাশ (Supplier + Purchase Summary Box) -->
                                <div class="col-md-6">

                                    @php
                                        $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                                        $sessionBranch = session('branch_id');
                                    @endphp


                                    <!-- Purchase Summary Box -->
                                    <div class="card border shadow-sm" style="padding: 20px;">
                                        @if ($isSuperAdmin && !$sessionBranch)
                                            <div class="mb-3">
                                                <label for="branch_id" class="form-label">{{ __('messages.branch') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="branch_id" id="branch_id" class="form-select">
                                                    <option value="">{{ __('messages.select_one') }}</option>
                                                    @foreach ($branchInfo as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="supplier_id" class="form-label">{{ __('messages.supplier') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="supplier_id" id="supplier_id" class="form-select">
                                                <option value="">{{ __('messages.select_one') }}</option>
                                                @foreach ($suppliers as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="purchase_date" class="form-label">{{ __('messages.purchase') }}
                                                {{ __('messages.date') }} <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="purchase_date"
                                                id="purchase_date" value="{{ date('Y-m-d') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="transporation_cost"
                                                class="form-label">{{ __('messages.transporation_cost') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="transporation_cost"
                                                id="transporation_cost" value="0">
                                        </div>



                                        <div class="card-body" style="padding: 0px">
                                            <div id="supplierInfo"
                                                style="display:none;  margin-bottom:20px; border-radius:8px;">
                                                <h4 class="fw-bold mb-2">{{ __('messages.supplier_information') }}</h4>
                                                @php
                                                    $isSuperAdmin = auth()
                                                        ->user()
                                                        ->roles->pluck('name')
                                                        ->contains('Super Admin');
                                                    $sessionBranch = session('branch_id');
                                                @endphp
                                                @if ($isSuperAdmin && !$sessionBranch)
                                                    <p class="mb-1"><strong>{{ __('messages.branch') }}:</strong> <span
                                                            id="branchName"></span></p>
                                                @endif
                                                <p class="mb-1"><strong>{{ __('messages.name') }}:</strong> <span
                                                        id="supName"></span></p>
                                                <p class="mb-1"><strong>{{ __('messages.phone') }}
                                                        {{ __('messages.number') }}:</strong> <span id="supPhone"></span>
                                                </p>
                                                <p class="mb-1"><strong>{{ __('messages.email') }}:</strong> <span
                                                        id="supEmail"></span></p>
                                                <p class="mb-1"><strong>{{ __('messages.address') }}:</strong> <span
                                                        id="supAddress"></span></p>
                                            </div>
                                            <h4>{{ __('messages.purchase_summary') }}</h4>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>{{ __('messages.total_product') }}:</span>
                                                <span id="totalProducts">0</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>{{ __('messages.total_quantity') }}:</span>
                                                <span id="totalQty">0</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>{{ __('messages.total_amount') }}:</span>
                                                <span id="totalAmount">0.00 ৳</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>{{ __('messages.final_total') }}:</span>
                                                <span id="summaryGrandTotal">0.00 ৳</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ডান পাশ (Product, Tank, Price, Qty ফিল্ড) -->
                                <div class="col-md-6 card border shadow-sm" style="padding: 20px;">
                                    <div class="row" style="padding: 0px!important; border:none!important;">
                                        <div class="col-md-12 mb-3">
                                            <label for="product_id" class="form-label">{{ __('messages.product') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="product_id" id="product_id" class="form-select select2">
                                                <option value="">{{ __('messages.select_one') }}</option>
                                                @foreach ($product as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                        ({{ $item->product_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label">{{ __('messages.price') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="price" id="price" class="form-control"
                                                placeholder="{{ __('messages.price') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="qty" class="form-label">{{ __('messages.quantity') }} <span
                                                    id="unit_label"></span><span class="text-danger">*</span></label>
                                            <input type="number" name="qty" id="qty" class="form-control"
                                                placeholder="{{ __('messages.quantity') }}" value="1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="size_id" class="form-label">{{ __('messages.size') }} <small
                                                    class="text-muted"
                                                    style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                            <select name="size_id" id="size_id" class="form-select">
                                                <option value="">{{ __('messages.select_one') }}</option>
                                                @foreach ($sizes as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="color_id" class="form-label">{{ __('messages.color') }} <small
                                                    class="text-muted"
                                                    style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                            <select name="color_id" id="color_id" class="form-select">
                                                <option value="">{{ __('messages.select_one') }}</option>
                                                @foreach ($colors as $item)
                                                    <option value="{{ $item->id }}">{{ $item->color_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class=" my-2">
                                            <button type="button" class="btn btn-success"
                                                id="addToCart">{{ __('messages.add_to_cart') }}</button>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="" class="form-label">{{ __('messages.note') }} <small
                                                    class="text-muted"
                                                    style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                            <textarea name="note" id="note" class="form-control" cols="20" rows="1"></textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="" class="form-label">{{ __('messages.terms_condition') }}
                                                <small class="text-muted"
                                                    style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                            <textarea name="terms_condition" id="terms_condition" class="form-control" cols="20" rows="1"></textarea>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </form>

                        <!-- Cart Table -->
                        <div class="mt-4">
                            <table class="table table-bordered" id="cartTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('messages.serial_no') }}</th>
                                        <th>{{ __('messages.product') }}</th>
                                        <th>{{ __('messages.size') }}</th>
                                        <th>{{ __('messages.color') }}</th>
                                        <th>{{ __('messages.quantity') }}</th>
                                        <th>{{ __('messages.unit') }}</th>
                                        <th>{{ __('messages.price') }}</th>
                                        <th>{{ __('messages.total_price') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end">{{ __('messages.total_price') }}:</th>
                                        <th id="grandTotal">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>


                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-primary"
                                    id="makePaymentBtn">{{ __('messages.make_payment') }}</button>
                                <button class="btn btn-success"
                                    id="saveWithoutPayment">{{ __('messages.save') }}</button>
                            </div>
                        </div>
                        <div>

                        </div>
                        <!-- Payment Form (hidden initially) -->
                        <div id="paymentSection" style="display:none; margin-top:50px">

                            <div class="text-center mb-4">
                                <h3 class="fw-bold">{{ __('messages.payment_section') }}</h3>
                                <p class="text-muted">{{ __('messages.enter_your_purchase_payment_information_here') }}
                                </p>
                            </div>
                            <div class="card border shadow-sm" style="padding: 20px;">
                                <h5>{{ __('messages.payment_details') }}</h5>
                                <p>{{ __('messages.payable_amount') }}: <strong id="cartTotalDisplay">0.00</strong> |
                                    {{ __('messages.due_amount') }}: <strong id="remainingBalance">0.00</strong></p>

                                <form id="paymentForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="fund_id" class="form-label">{{ __('messages.fund') }}</label>
                                            <select name="fund_id" id="fund_id" class="form-select">
                                                <option value="">{{ __('messages.select_one') }}</option>
                                                @foreach ($funds as $fund)
                                                    <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="bank-section" class="row"
                                            style="display:none; margin:10px 0px; border:none!important; padding:0px;">
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
                                                    <label for="account_id"
                                                        class="form-label">{{ __('messages.bank_account') }}
                                                        <span class="text-danger">*</span></label>
                                                    <select name="account_id" id="account_id" class="form-select">
                                                        <option value="">{{ __('messages.select_one') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="amount" class="form-label">{{ __('messages.amount') }}</label>
                                            <input type="number" name="amount" step="0.01" id="amount"
                                                class="form-control" placeholder="{{ __('messages.amount') }}">
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit"
                                                class="btn btn-success">{{ __('messages.add_payment') }}</button>
                                            {{-- <button type="button" class="btn btn-secondary" id="backToCart">Back</button> --}}
                                        </div>
                                    </div>


                                </form>
                            </div>

                            <!-- Payment Cart -->
                            <div class="mt-3">
                                <h6>{{ __('messages.payment_information') }}</h6>
                                <table class="table table-bordered" id="paymentCartTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.fund') }}</th>
                                            <th>{{ __('messages.bank') }} </th>
                                            <th>{{ __('messages.bank_account') }}</th>
                                            <th>{{ __('messages.amount') }}</th>
                                            <th>{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">{{ __('messages.total_paid') }}:</th>
                                            <th id="totalPaid">0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="text-end mt-2">
                                    <button class="btn btn-success"
                                        id="completePaymentBtn">{{ __('messages.save') }}</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!--end::Card body-->
                </div>
                <!--end::Card-->
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
        $('#product_id').on('change', function() {

            let productId = $(this).val();

            if (productId) {
                $.ajax({
                    url: "{{ route('getProductData') }}", // এই route টা তৈরি করতে হবে
                    type: "GET",
                    data: {
                        id: productId
                    },
                    success: function(res) {
                        if (res) {
                            $('#price').val(res.purchase_price); // purchase_price সেট করো
                            $('#unit_label').text('(' + res.unit + ')'); // unit দেখাও
                        }
                    }
                });
            } else {
                $('#price').val('');
                $('#unit_label').text('');
            }
        });
    </script>
    <script>
        const sessionBranchId = "{{ session('branch_id') ?? '' }}";
    </script>
    <script>
        $(document).ready(function() {
            let currentBranchId = "{{ session('branch_id') ?? '' }}";
            // When Floor is selected

            $('#branch_id').on('change', function() {
                let branchId = $(this).val();
                let supplierId = $('#supplier_id').val();
                $('#bank_id').trigger('change');

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
            $('#supplier_id').on('change', function() {
                let supplierId = $(this).val();


                if (supplierId) {
                    if (currentSupplierId && currentSupplierId != supplierId) {
                        cart = [];
                        payments = [];
                        renderCart();
                        renderCartSummary();
                        renderPaymentCart();
                        updateRemainingBalance();
                    }
                    currentSupplierId = supplierId;
                    $.ajax({
                        url: '/admin/get-supplier-data/' + supplierId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                $('#supplierInfo').show();
                                $('#supName').text(res.data.name || '-');
                                $('#supPhone').text(res.data.phone || '-');
                                $('#supEmail').text(res.data.email || '-');
                                let fullAddress = (res.data.address || '');
                                $('#supAddress').text(fullAddress || '-');
                            } else {
                                $('#supplierInfo').hide();
                                currentSupplierId = null;
                            }
                        },
                        error: function() {
                            $('#supplierInfo').hide();
                            currentSupplierId = null;
                        }
                    });
                } else {
                    $('#supplierInfo').hide();
                    currentSupplierId = null;
                }
            });
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

                                $('#bank_id, #branch_id, #account_id').prop('required', true);
                                $.each(data.data, function(key, value) {

                                    $('#bank_id').append('<option value="' + value
                                        .id +
                                        '" >' + value.name +
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
    <script>
        let cart = [];
        let payments = [];
        let currentSupplierId = null;
        let currentBranchId = "{{ session('branch_id') ?? '' }}";
        let currentPurchaseDate = null;
        let currentTransporationCost = null;
        $('#addToCart').on('click', function() {
            let productText = $('#product_id option:selected').text();
            let productId = $('#product_id').val();
            let sizeId = $('#size_id').val();
            let sizeText = sizeId ? $('#size_id option:selected').text() : '';
            let colorId = $('#color_id').val();
            let colorText = colorId ? $('#color_id option:selected').text() : '';

            let price = parseFloat($('#price').val());
            let qtyText = $('#unit_label').text();
            let qty = parseFloat($('#qty').val());
            let purchaseDate = $('#purchase_date').val();
            let total = price * qty;
            let supplierId = $('#supplier_id').val(); // supplier select field
            let bracnId = $('#branch_id').val(); // supplier select field
            let transporationCost = parseFloat($('#transporation_cost').val());
            let missingFields = [];
            if (!purchaseDate) missingFields.push('Purchase Date');
            if (!supplierId) missingFields.push('Supplier');
            if (!productId) missingFields.push('Product');
            if (!price) missingFields.push('Price');
            if (!qty) missingFields.push('Quantity');


            if (missingFields.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Fields',
                    html: 'Please fill out: <b>' + missingFields.join(', ') + '</b>',
                    confirmButtonText: 'OK'
                });
                return; // Stop execution if fields are missing
            }

            // Check if supplier changed
            if (currentSupplierId && currentSupplierId != supplierId) {

                cart = []; // clear previous cart if needed
            }
            currentSupplierId = supplierId;
            currentBranchId = bracnId;
            currentPurchaseDate = purchaseDate;
            currentTransporationCost = transporationCost;
            // Push product to cart
            cart.push({
                qtyText,
                productId,
                productText,
                sizeId,
                sizeText,
                colorId,
                colorText,
                price,
                qty,
                total,
                supplierId,

            });


            renderCartSummary();
            renderCart();


            $('#product_id').val('').trigger('change');
            $('#size_id').val('');
            $('#color_id').val('');
            $('#price').val('');
            $('#qty').val('');
            $('#unit_label').text('');

            // ✅ Optional: focus back to product dropdown for next entry
            // $('#product_id').focus();
        });

        function renderCartSummary() {
            let totalProducts = cart.length;
            let totalQty = 0;
            let totalAmount = 0;

            // ইউনিট অনুযায়ী quantity হিসাব
            let unitSummary = {};

            cart.forEach(item => {
                totalQty += item.qty;
                totalAmount += item.total;

                // ইউনিট অনুযায়ী quantity গ্রুপ করে রাখছে
                if (!unitSummary[item.qtyText]) {
                    unitSummary[item.qtyText] = 0;
                }
                unitSummary[item.qtyText] += item.qty;
            });

            // ইউনিট অনুযায়ী পরিমাণ দেখানো (যেমন: 10 লিটার, 5 কেজি)
            // let qtyDisplay = Object.entries(unitSummary)
            //     .map(([unit, qty]) => `${qty} ${unit}`)
            //     .join(', ');
            let qtyDisplay = Object.values(unitSummary)
                .reduce((sum, qty) => sum + qty, 0);


            $('#totalProducts').text(totalProducts);
            $('#totalQty').text(qtyDisplay || '0');
            $('#totalAmount').text(totalAmount.toFixed(2) + ' ৳');
            $('#summaryGrandTotal').text(totalAmount.toFixed(2) + ' ৳');


            if ($('#paymentSection').is(':visible')) {
                window.cartTotal = totalAmount; // update global cartTotal
                $('#cartTotalDisplay').text(totalAmount.toFixed(2));
                updateRemainingBalance();
            }
        }

        function renderCart() {
            let tbody = $('#cartTable tbody');
            tbody.empty();
            let totalProducts = cart.length;
            let totalQty = 0;
            let cartTotal = 0;
            cart.forEach((item, index) => {
                cartTotal += item.total;
                totalQty += item.qty;
                tbody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${item.productText}</td>
                <td>${item.sizeText}</td>
                <td>${item.colorText}</td>
                <td>${item.qty} </td>
                <td>${item.qtyText} </td>
                <td>${item.price} ৳</td>
                <td>${item.total.toFixed(2)} ৳</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">Remove</button></td>
            </tr>
        `);
            });
            $('#grandTotal').text(cartTotal.toFixed(2) + ' ৳');

            window.cartTotal = cartTotal;

        }

        // Remove from cart
        function removeFromCart(index) {
            // Remove product from cart
            let removedItem = cart.splice(index, 1)[0];

            if (cart.length === 0) {
                currentSupplierId = null;
                currentBranchId = null;
                currentPurchaseDate = null;
                currentTransporationCost = null;
            }
            renderCart();
            renderCartSummary();
        }


        // Show payment form
        $('#makePaymentBtn').on('click', function() {
            if (cart.length === 0) {
                alert("Add at least one item to cart first!");
                return;
            }
            // $('#cartTable').closest('div.mt-4').hide(); // hide cart table & add to cart form
            // $('#purchaseForm').hide();

            $('#saveWithoutPayment').hide();
            $('#paymentSection').show();

            $('#cartTotalDisplay').text(cartTotal.toFixed(2));
            updateRemainingBalance();

            setTimeout(() => {
                $('#amount').val(remainingBalance.toFixed(2));
            }, 100);
        });

        $('#backToCart').on('click', function() {
            $('#paymentSection').hide();
            $('#cartTable').closest('div.mt-4').show();
            $('#purchaseForm').show();
        });

        // Payment form submission
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            let fundText = $('#fund_id option:selected').text();
            let fundId = $('#fund_id').val();
            let bank = $('#bank_id').val();
            let bankText = bank ? $('#bank_id option:selected').text() : '';
            let account = $('#account_id').val();
            let accountText = account ? $('#account_id option:selected').text() : '';
            let amount = parseFloat($('#amount').val());

            let totalPaid = payments.reduce((sum, p) => sum + p.amount, 0);
            let remaining = cartTotal - totalPaid;

            if (!fundId || !amount || amount <= 0) {
                alert("Fund and valid amount required!");
                return;
            }
            if (amount > remaining) {
                alert(`Amount exceeds remaining balance: ${remaining.toFixed(2)}`);
                return;
            }

            payments.push({
                fundId,
                fundText,
                bank,
                bankText,
                account,
                accountText,
                amount
            });
            renderPaymentCart();
            updateRemainingBalance();

            // Clear form
            $('#fund_id').val('');
            $('#bank_id').val('');
            $('#account_id').val('');
            $('#amount').val('');
        });

        function renderPaymentCart() {
            let tbody = $('#paymentCartTable tbody');
            tbody.empty();
            let totalPaid = 0;
            payments.forEach((p, index) => {
                totalPaid += p.amount;
                tbody.append(`
            <tr>
                <td>${p.fundText}</td>
                <td>${p.bankText}</td>
                <td>${p.accountText}</td>
                <td>${p.amount}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removePayment(${index})">Remove</button></td>
            </tr>
        `);
            });
            $('#totalPaid').text(totalPaid.toFixed(2));
        }

        function removePayment(index) {
            payments.splice(index, 1);
            renderPaymentCart();
            updateRemainingBalance();
        }
        let remainingBalance = 0;

        // function updateRemainingBalance() {
        //     let totalPaid = payments.reduce((sum, p) => sum + p.amount, 0);
        //     let remaining = cartTotal - totalPaid;
        //     $('#remainingBalance').text(remaining.toFixed(2));
        // }

        function updateRemainingBalance() {
            let totalPaid = payments.reduce((sum, p) => sum + p.amount, 0);
            remainingBalance = cartTotal - totalPaid;

            $('#remainingBalance').text(remainingBalance.toFixed(2));
        }
        // Complete Payment
        $('#completePaymentBtn').on('click', function() {
            // Calculate total paid and remaining
            let totalPaid = payments.reduce((sum, p) => sum + p.amount, 0);
            let remaining = cartTotal - totalPaid;


            if (cart.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Cart!',
                    text: 'Please add at least one product to the cart.',
                    confirmButtonText: 'OK'
                });
                return; // Stop further execution
            }

            // Check if supplier is selected
            if (!currentSupplierId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Supplier Missing!',
                    text: 'Please select a supplier before saving.',
                    confirmButtonText: 'OK'
                });
                return; // Stop further execution
            }

            if (!currentPurchaseDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Purchase Date Missing!',
                    text: 'Please select purchase date.',
                    confirmButtonText: 'OK'
                });
                return; // Stop further execution
            }

            // Prepare data to send
            let purchaseData = {
                cart: cart,
                payments: payments,
                payabeleAmount: cartTotal,
                purchaseDate: currentPurchaseDate,
                totalPaid: totalPaid,
                remaining: remaining,
                supplierId: currentSupplierId, // currentSupplierId pathano holo
                branchId: currentBranchId, // currentSupplierId pathano holo
                transporationCost: currentTransporationCost, // currentSupplierId pathano holo
                purchaseDate: currentPurchaseDate, // currentSupplierId pathano holo
                note: $('#note').val(), // <-- Note field
                terms_condition: $('#terms_condition').val(),
                _token: "{{ csrf_token() }}"
            };

            // Send Ajax request to purchase.store route
            $.ajax({
                url: "{{ route('purchase.store') }}",
                method: 'POST',
                data: purchaseData,
                success: function(res) {

                    // window.location.href =
                    //     "{{ route('purchase.index') }}?added-successfully=" +
                    //     encodeURIComponent(res.message);
                    window.location.href = "{{ url('admin/purchase-invoice-print') }}/" + res.id;
                },
                error: function(err) {

                    let msg = "Something went wrong!";

                    // Laravel JSON error message
                    if (err.responseJSON && err.responseJSON.error) {
                        msg = err.responseJSON.error;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: msg,
                    });

                }
            });

        });
        $('#saveWithoutPayment').on('click', function() {
            // Calculate total paid and remaining
            let totalPaid = payments.reduce((sum, p) => sum + p.amount, 0);
            let remaining = cartTotal - totalPaid;
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Cart!',
                    text: 'Please add at least one product to the cart.',
                    confirmButtonText: 'OK'
                });
                return; // Stop further execution
            }

            // Check if supplier is selected
            if (!currentSupplierId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Supplier Missing!',
                    text: 'Please select a supplier before saving.',
                    confirmButtonText: 'OK'
                });
                return; // Stop further execution
            }

            if (!currentPurchaseDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Purchase Date Missing!',
                    text: 'Please select purchase date.',
                    confirmButtonText: 'OK'
                });
                return; // Stop further execution
            }

            // Prepare data to send
            let purchaseData = {
                cart: cart,
                payments: payments,
                payabeleAmount: cartTotal,
                totalPaid: totalPaid,
                remaining: remaining,
                supplierId: currentSupplierId, // currentSupplierId pathano holo
                branchId: currentBranchId, // currentSupplierId pathano holo
                transporationCost: currentTransporationCost, // currentSupplierId pathano holo
                purchaseDate: currentPurchaseDate,
                note: $('#note').val(), // <-- Note field
                terms_condition: $('#terms_condition').val(),
                _token: "{{ csrf_token() }}"
            };
            // Send Ajax request to purchase.store route
            $.ajax({
                url: "{{ route('purchase.store') }}",
                method: 'POST',
                data: purchaseData,
                success: function(res) {
                    console.log(res);
                    // window.location.href =
                    //     "{{ route('purchase.index') }}?added-successfully=" +
                    //     encodeURIComponent(res.message);
                    window.location.href = "{{ url('admin/purchase-invoice-print') }}/" + res.id;
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                    console.log(err);
                }
            });

        });
    </script>
@endpush
