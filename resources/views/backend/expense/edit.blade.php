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
                        {{ __('messages.edit_expense') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                                {{ __('messages.dashboard') }}</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted"> {{ __('messages.expense_management') }}</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted"> {{ __('messages.edit_expense') }}</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
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
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"> {{ __('messages.edit_expense') }}</h4>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body py-4">


                        <form action="{{ route('expense.update', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                @php
                                    $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                                    $sessionBranch = session('branch_id');
                                @endphp
                                @if ($isSuperAdmin && !$sessionBranch)
                                    <div class="col-md-6 mb-3">
                                        <label for="branch_id" class="form-label">{{ __('messages.branch') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="branch_id" id="branch_id" class="form-select">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($branchInfo as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->branch_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="head_id" class="form-label"> {{ __('messages.expense_head') }}<span
                                                class="text-danger">*</span></label>
                                        <select name="head_id" id="head_id"
                                            class="form-select @error('head_id') is-invalid @enderror">
                                            <option value=""> {{ __('messages.select_one') }}</option>
                                            @foreach ($heads as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->head_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('head_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fund_id" class="form-label"> {{ __('messages.fund') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="fund_id" id="fund_id"
                                            class="form-select @error('fund_id') is-invalid @enderror">
                                            <option value=""> {{ __('messages.select_one') }}</option>
                                            @foreach ($funds as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->fund_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fund_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- নিচের অংশ hide করে রাখা হবে -->
                                <div id="bank-section" class="row"
                                    style="display:none; padding:10px; border:none!important; ">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bank_id" class="form-label"> {{ __('messages.bank') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="bank_id" id="bank_id" class="form-select">
                                                <option value=""> {{ __('messages.select_one') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="account_id" class="form-label"> {{ __('messages.bank') }}
                                                {{ __('messages.account') }}<span class="text-danger">*</span></label>
                                            <select name="account_id" id="account_id" class="form-select">
                                                <option value=""> {{ __('messages.select_one') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="amount" class="form-label"> {{ __('messages.amount') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="amount" id="amount"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            placeholder=" {{ __('messages.amount') }}" value="{{ $data->amount }}">
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label"> {{ __('messages.date') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="date" id="date"
                                            class="form-control @error('date') is-invalid @enderror"
                                            value="{{ date('Y-m-d') }}">
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"> {{ __('messages.expense_person') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder=" {{ __('messages.expense_person') }}"
                                            value="{{ $data->exp_person }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="document" class="form-label"> {{ __('messages.attachment') }}</label>
                                        <input type="file" class="form-control @error('document') is-invalid @enderror"
                                            name="document" id="document">

                                        @if ($data->document)
                                            <!-- Single document icon -->
                                            <a href="{{ asset('uploads/expense_document/' . $data->document) }}"
                                                target="_blank">
                                                <i class="fas fa-file" style="font-size: 30px"></i>
                                            </a>
                                        @endif

                                        @error('document')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="details" class="form-label"> {{ __('messages.details') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea name="details" id="details" cols="30" rows="4"
                                            class="form-control @error('details') is-invalid @enderror" placeholder=" {{ __('messages.details') }}">{{ $data->note }}</textarea>
                                        @error('details')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                            </div>
                            <div class="text-end">
                                <a href="#" class="btn btn-secondary"> {{ __('messages.cancel') }}</a>
                                <button type="submit" class="btn btn-success"> {{ __('messages.update') }}</button>
                            </div>
                        </form>


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
    <script src="{{ asset('assets/backend/js/jquery-3.6.0.min.js') }}"></script>
    <script>
        const sessionBranchId = "{{ session('branch_id') ?? '' }}";
    </script>
    <script>
        $(document).ready(function() {
            $('#branch_id').on('change', function() {
                let branchId = $(this).val();
                let headId = $('#head_id').val();
                $('#bank_id').trigger('change');
                let colorText = branchId ? $('#branch_id option:selected').text() : '';
                let selectedHeadId =
                    "{{ $data->head_id }}";

                if (branchId) {
                    $.ajax({
                        url: '/admin/get-head/' + branchId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#branchName').text(colorText || '-');
                            $('#head_id').empty().append(
                                '<option value="">{{ __('messages.select_one') }}</option>'
                            );
                            $.each(data.heads, function(key, value) {
                                let isSelected = selectedHeadId == value.id ?
                                    'selected' : '';
                                $('#head_id').append('<option value="' + value.id +
                                    '" ' + isSelected + '>' + value.name +
                                    '</option>');
                            });
                            $('#head_id').trigger('change');
                        }
                    });
                } else {
                    $('#head_id').empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>');
                    $('#head_id').trigger('change');

                }
            });

            if ($('#branch_id').val()) {
                $('#branch_id').trigger('change');

            }


            $('#fund_id').on('change', function() {
                let dataId = $(this).val();
                $('#bank_id').trigger('change');
                let selectedBankId =
                    "{{ $data->bank_id }}";
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
                                        '" ' + isSelected + '>' + value.name +
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
                    "{{ $data->bank_id }}"; // Preselected value for floor
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
