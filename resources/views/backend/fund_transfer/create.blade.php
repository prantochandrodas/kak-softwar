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
                        {{ __('messages.fund_transfer') }}</h1>
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
                        <li class="breadcrumb-item text-muted"> {{ __('messages.fund_transfer') }}</li>
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
                    <form role="form" id="duePaymentForm" action="{{ route('fund-transfer.store') }}" method="POST"
                        enctype="multipart/form-data" id="transferForm">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset style="position: relative; margin-bottom:30px!important;">
                                        <legend style="position: absolute; top:-20px">
                                            {{ __('messages.fund_transfer') }}



                                        </legend>

                                        <div class="row payment-box" style="margin-top: 20px">


                                            {{-- from fund  --}}
                                            <div class="col-md-6">
                                                <div class="row">
                                                    @php
                                                        $isSuperAdmin = auth()
                                                            ->user()
                                                            ->roles->pluck('name')
                                                            ->contains('Super Admin');
                                                        $sessionBranch = session('branch_id');
                                                    @endphp
                                                    @if ($isSuperAdmin && !$sessionBranch)
                                                        <div class="col-sm-12" style="margin-top: 5px">
                                                            <label>{{ __('messages.from_branch') }}</label>
                                                            <select id="from_branch_id" name="from_branch_id"
                                                                class="form-select form-select-sm">
                                                                <option value=""> {{ __('messages.select_one') }}
                                                                </option>
                                                                @foreach ($branchInfo as $branch)
                                                                    <option value="{{ $branch->id }}"
                                                                        {{ old('from_branch_id') == $branch->id ? 'selected' : '' }}>
                                                                        {{ $branch->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-12" style="margin-top: 5px">
                                                            <label>{{ __('messages.from_branch') }}</label>
                                                            <select id="from_branch_id" class="form-select form-select-sm"
                                                                disabled>
                                                                <option value=""> {{ __('messages.select_one') }}
                                                                </option>
                                                                @foreach ($branchInfo as $branch)
                                                                    <option value="{{ $branch->id }}"
                                                                        {{ session('branch_id') == $branch->id ? 'selected' : '' }}>
                                                                        {{ $branch->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="from_branch_id"
                                                            value="{{ session('branch_id') }}">
                                                    @endif

                                                    <div class="col-sm-12" style="margin-top: 5px">
                                                        <label>{{ __('messages.from_fund') }}</label>
                                                        <select id="from_fund_id" name="from_fund_id"
                                                            class="form-select select2 from_fund_id" required>
                                                            <option value="">{{ __('messages.select_one') }}</option>
                                                            @foreach ($funds as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('from_fund_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div style="display:none;" class="col-sm-12 from-bank-section">
                                                        <div class="row">
                                                            {{-- bank  --}}
                                                            <div class="col-sm-12">
                                                                <div class="mb-3">
                                                                    <label for="from_bank_id"
                                                                        class="form-label">{{ __('messages.bank') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <select name="from_bank_id" id="from_bank_id"
                                                                        class="form-select select2 from_bank_id">
                                                                        <option value="">
                                                                            {{ __('messages.select_one') }}
                                                                        </option>
                                                                    </select>
                                                                    @error('from_bank_id')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- bank account  --}}
                                                            <div class="col-sm-12">
                                                                <div class="mb-3">
                                                                    <label for="from_account_id"
                                                                        class="form-label">{{ __('messages.bank_account') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <select name="from_account_id" id="from_account_id"
                                                                        class="form-select select2 from_account_id">
                                                                        <option value="">
                                                                            {{ __('messages.select_one') }}
                                                                        </option>
                                                                    </select>
                                                                    @error('from_account_id')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">

                                                    <div class="col-sm-12" style="margin-top: 5px">
                                                        <label>{{ __('messages.to_branch') }}</label>
                                                        <select id="to_branch_id" name="to_branch_id"
                                                            class="form-select form-select-sm">
                                                            <option value=""> {{ __('messages.select_one') }}
                                                            </option>
                                                            @foreach ($branchInfo as $branch)
                                                                <option value="{{ $branch->id }}"
                                                                    {{ old('to_branch_id') == $branch->id ? 'selected' : '' }}>
                                                                    {{ $branch->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12" style="margin-top: 5px">
                                                        <label>{{ __('messages.to_fund') }}</label>
                                                        <select id="to_fund_id" name="to_fund_id"
                                                            class="form-select select2 to_fund_id" required>
                                                            <option value="">{{ __('messages.select_one') }}
                                                            </option>
                                                            @foreach ($funds as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('to_fund_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div style="display:none;" class="col-sm-12 to-bank-section">
                                                        <div class="row">
                                                            {{-- bank  --}}
                                                            <div class="col-sm-12">
                                                                <div class="mb-3">
                                                                    <label for="to_bank_id"
                                                                        class="form-label">{{ __('messages.bank') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <select name="to_bank_id" id="to_bank_id"
                                                                        class="form-select select2 to_bank_id">
                                                                        <option value="">
                                                                            {{ __('messages.select_one') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            {{-- bank account  --}}
                                                            <div class="col-sm-12">
                                                                <div class="mb-3">
                                                                    <label for="to_account_id"
                                                                        class="form-label">{{ __('messages.bank_account') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <select name="to_account_id" id="to_account_id"
                                                                        class="form-select select2 to_account_id">
                                                                        <option value="">
                                                                            {{ __('messages.select_one') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                    <div class="col-sm-12" style="margin-top: 5px">
                                                        <label>{{ __('messages.amount') }}</label>
                                                        <input type="number" name="amount" class="form-control"
                                                            id="amount">
                                                        @error('amount')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-12" style="margin-top: 5px">
                                                        <label>{{ __('messages.date') }}</label>
                                                        <input type="date" name="date" value="{{ date('Y-m-d') }}"
                                                            class="form-control" id="date">
                                                        @error('date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-12" style="margin-top: 5px">
                                                        <label>{{ __('messages.remarks') }}</label>
                                                        <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="10" placeholder="remarks"></textarea>
                                                        @error('remarks')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-12" style="margin-top: 5px">
                                                        <label>{{ __('messages.attachment') }}</label>
                                                        <input type="file" name="attachment" id="attachment">
                                                        @error('attachment')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="mt-3 text-center">
                                                <button type="submit" class="add-more-btn btn btn-success"
                                                    id="addToCart">+
                                                    {{ __('messages.save') }}</button>
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






            $(document).on('change', '.from_fund_id', function() {


                let box = $(this).closest('.payment-box');
                let fundId = $(this).val();
                let bankSelect = box.find('.from_bank_id');
                let accountSelect = box.find('.from_account_id');
                let bankSection = box.find('.from-bank-section');

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






            // Handle bank change
            $(document).on('change', '.from_bank_id', function() {
                var branchId = $('#from_branch_id').val();
                let finalBranchId = branchId || sessionBranchId;

                let box = $(this).closest('.payment-box');
                let bankId = $(this).val();
                let accountSelect = box.find('.from_account_id');

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

            $('#from_branch_id').on('change', function() {
                $('.from_bank_id').trigger('change');

            });


        });
        $(document).ready(function() {






            $(document).on('change', '.to_fund_id', function() {


                let box = $(this).closest('.payment-box');
                let fundId = $(this).val();
                let bankSelect = box.find('.to_bank_id');
                let accountSelect = box.find('.to_account_id');
                let bankSection = box.find('.to-bank-section');

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






            // Handle bank change
            $(document).on('change', '.to_bank_id', function() {
                var branchId = $('#to_branch_id').val();
                let finalBranchId = branchId || sessionBranchId;

                let box = $(this).closest('.payment-box');
                let bankId = $(this).val();
                let accountSelect = box.find('.to_account_id');

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

            $('#to_branch_id').on('change', function() {
                $('.to_bank_id').trigger('change');

            });


        });
    </script>
@endpush
