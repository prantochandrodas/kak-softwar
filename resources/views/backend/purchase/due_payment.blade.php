@extends('layouts.backend')
@section('main')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('messages.due_payment') }}
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-muted text-hover-primary">{{ __('messages.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ __('messages.due_payment') }}</li>
                    </ul>
                </div>
            </div>
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
                padding: 20px;
                border: 1px solid #e5e7eb;
                margin-bottom: 20px
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
                min-height: 100px;
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
                padding: 10px 30px;
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

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-white mb-0">{{ __('messages.due_payment') }}</h4>

                    </div>

                    <div class="card-body py-4">
                        <form id="purchaseForm" action="{{ route('due-payment.store') }}" method="POST">
                            @csrf
                            <div class="payment-box border shadow-sm p-5 mb-3" style="background:#fff; position:relative;">
                                <h3 class="text-center mb-4">{{ __('messages.payment_information') }}</h3>
                                <div class="row">
                                    @php
                                        $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                                        $sessionBranch = session('branch_id');
                                    @endphp

                                    @if ($isSuperAdmin && !$sessionBranch)
                                        <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('messages.supplier') }} <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select supplier_id" id="supplier_id">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('messages.purchase_invoice') }} <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select invoice_id select">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('messages.due_amount') }}</label>
                                        <input type="text" class="form-control due_amount" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('messages.fund') }}</label>
                                        <select class="form-select fund_id">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($funds as $fund)
                                                <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="bank-section row"
                                        style="display:none; border:none; padding-left:20px; padding-top:0px; padding-bottom:0px; padding-right:0px">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('messages.bank') }}</label>
                                            <select class="form-select bank_id">
                                                <option value="">{{ __('messages.select_one') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('messages.bank_account') }}</label>
                                            <select class="form-select account_id">
                                                <option value="">{{ __('messages.select_one') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('messages.amount') }}</label>
                                        <input type="number" class="form-control amount">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('messages.date') }}</label>
                                        <input type="date" class="form-control date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-12" style="display: flex; justify-content:end;">
                                        <div class="mt-3">
                                            <button type="button" class="add-more-btn btn btn-success" id="addToCart">+
                                                {{ __('messages.add') }}</button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <h4 style="margin-top: 20px">{{ __('messages.payment_details') }}</h4>
                            <table class="table table-bordered" id="cartTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.supplier') }}</th>
                                        <th>{{ __('messages.invoice_no') }}</th>
                                        <th>{{ __('messages.due_amount') }}</th>
                                        <th>{{ __('messages.fund') }}</th>
                                        <th>{{ __('messages.bank') }}</th>
                                        <th>{{ __('messages.bank_account') }}</th>
                                        <th>{{ __('messages.paid_amount') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <button type="submit" class="btn btn-success mt-3">{{ __('messages.payment') }} </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/backend/js/jquery-3.6.0.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const sessionBranchId = "{{ session('branch_id') ?? '' }}";
    </script>
    <script>
        $(document).ready(function() {

            $('#addToCart').click(function() {
                let box = $('.payment-box');
                let supplierText = box.find('.supplier_id option:selected').text();
                let supplierVal = box.find('.supplier_id').val();
                let invoiceText = box.find('.invoice_id option:selected').text();
                let invoiceVal = box.find('.invoice_id').val();
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
                if (!supplierVal) emptyFields.push('{{ __('messages.supplier') }}');
                if (!invoiceVal) emptyFields.push('{{ __('messages.invoice_no') }}');
                if (!fundVal) emptyFields.push('{{ __('messages.fund') }}');
                if (!bankVal && box.find('.bank-section').is(':visible')) emptyFields.push(
                    '{{ __('messages.bank') }}');
                if (!accountVal && box.find('.bank-section').is(':visible')) emptyFields.push(
                    '{{ __('messages.bank_account') }}');
                if (!amount) emptyFields.push('{{ __('messages.amount') }}');
                if (!date) emptyFields.push('{{ __('messages.date') }}');
                if (emptyFields.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ __('messages.field_required') }}',
                        html: '{{ __('messages.fill_the_following_fields') }}: <br><b>' +
                            emptyFields.join(', ') +
                            '</b>',
                        timer: 2000, // 2 সেকেন্ড পরে auto-close
                        showConfirmButton: true, // confirm button থাকবে
                        timerProgressBar: true // progress bar দেখাবে
                    });
                    return;
                }

                let row = `<tr>
                    <td>${date}<input type="hidden" name="date[]" value="${date}"></td>
                    <td>${supplierText}<input type="hidden" name="supplier_id[]" value="${supplierVal}"></td>
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
                box.find('select').not('#branch_id').val('').trigger('change');
                box.find('.due_amount').val('');
                box.find('.amount').val('');
                let today = new Date().toISOString().split('T')[0];
                box.find('.date').val(today);
                box.find('.bank-section').hide();
            });

            // Remove row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
            // Step 1: শুধুমাত্র প্রথম payment box-এর select2
            $('#paymentContainer .payment-box:first .select').select2({
                width: '100%'
            });



            // Handle fund change
            $(document).on('change', '.fund_id', function() {
                let box = $(this).closest('.payment-box');
                let fundId = $(this).val();
                let bankSelect = box.find('.bank_id');
                let accountSelect = box.find('.account_id');
                let bankSection = box.find('.bank-section');

                bankSelect.empty().append('<option value="">{{ __('messages.select_one') }}</option>');
                accountSelect.empty().append('<option value="">{{ __('messages.select_one') }}</option>');

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

            // Handle bank change
            $(document).on('change', '.bank_id', function() {
                let box = $(this).closest('.payment-box');
                let bankId = $(this).val();

                var branchId = $('#branch_id').val();
                let finalBranchId = branchId || sessionBranchId;
                let accountSelect = box.find('.account_id');
                if (!finalBranchId) {
                    accountSelect.empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>');

                    return;
                }

                accountSelect.empty().append('<option value="">{{ __('messages.select_one') }}</option>');


                if (bankId) {
                    $.ajax({
                        url: '/admin/get-account-by-bank/' + bankId + '/' + (finalBranchId ?? ''),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data.data, function(key, value) {
                                accountSelect.append('<option value="' + value.id +
                                    '">' + value.account_name + ' (' + value
                                    .account_number + ')</option>');
                            });
                        }
                    });
                }
            });

            $('#branch_id').on('change', function() {
                let branchId = $(this).val();
                let supplierId = $('#supplier_id').val();

                // 👉 Branch change হলেই আগে cart table clear হবে
                $('#cartTable tbody').empty();

                // 👉 Branch change হলে payment box reset হবে
                let box = $('.payment-box');
                box.find('select').not('#branch_id').val('').trigger('change');
                box.find('.due_amount').val('');
                box.find('.amount').val('');
                let today = new Date().toISOString().split('T')[0];
                box.find('.date').val(today);
                box.find('.bank-section').hide();
                if (branchId) {

                    $.ajax({
                        url: '/admin/get-supplier/' + branchId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
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
                    $('.supplier_id').trigger('change');

                }
            });

            // Supplier change -> Get invoice
            $(document).on('change', '.supplier_id', function() {
                let box = $(this).closest('.payment-box');
                let supplierId = $(this).val();
                let invoiceSelect = box.find('.invoice_id');
                invoiceSelect.empty().append('<option value="">{{ __('messages.select_one') }}</option>');

                if (supplierId) {
                    $.ajax({
                        url: '/admin/get-invoice/' + supplierId,
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
            });

            // Invoice change -> Get due amount
            $(document).on('change', '.invoice_id', function() {
                let box = $(this).closest('.payment-box');
                let invoiceId = $(this).val();
                let dueInput = box.find('.due_amount');
                dueInput.val('');
                if (invoiceId) {
                    $.ajax({
                        url: '/admin/get-invoice-due/' + invoiceId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            dueInput.val(data.due_amount ?? 0);
                        }
                    });
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


            $('#purchaseForm').on('submit', function(e) {
                let rowCount = $('#cartTable tbody tr').length;

                if (rowCount === 0) {
                    e.preventDefault(); // ফর্ম সাবমিট বন্ধ
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('messages.error') }}!',
                        text: '{{ __('messages.no_payment_data_added') }}!',
                        timer: 2000, // ২ সেকেন্ড পরে alert বন্ধ হবে
                        showConfirmButton: false
                    });

                    hideLoading();
                }
            });
        });
    </script>
@endpush
