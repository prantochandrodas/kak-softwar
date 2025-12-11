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
                        {{ __('messages.create_product') }}</h1>
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
                        <li class="breadcrumb-item text-muted">{{ __('messages.product_management') }}</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{ __('messages.create_product') }}</li>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h4 class="card-title text-white mb-0">{{ __('messages.create_product') }}</h4>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- category  --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.category') }}
                                            <span class="text-danger">*</span> </label>
                                        <select name="category_id" id="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($productCat as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- subcategory --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subcategory_id" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.sub_category') }} <small class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <select name="subcategory_id" id="subcategory_id"
                                            class="form-select @error('subcategory_id') is-invalid @enderror">
                                            <option value="">{{ __('messages.select_one') }}</option>

                                        </select>
                                        @error('subcategory_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- name --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.name') }} (English) <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}"
                                            placeholder="{{ __('messages.product') }} {{ __('messages.name') }} English">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- name_arabic --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name_arabic" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.name') }} (Arabic) <span class="text-danger">*</span></label>
                                        <input type="text" name="name_arabic" id="name_arabic"
                                            class="form-control @error('name_arabic') is-invalid @enderror"
                                            value="{{ old('name_arabic') }}"
                                            placeholder="{{ __('messages.product') }} {{ __('messages.name') }} Arabic">
                                        @error('name_arabic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- unit  --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.unit') }} <span class="text-danger">*</span></label>
                                        <select name="unit" id="unit"
                                            class="form-select  @error('unit') is-invalid @enderror">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($productUnit as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- brand  --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="brand_id" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.brand') }} <small class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <select name="brand_id" id="brand_id"
                                            class="form-select  @error('brand_id') is-invalid @enderror">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($productBrand as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- barcode  --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.barcode') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="barcode" id="barcode"
                                            class="form-control @error('barcode') is-invalid @enderror"
                                            value="{{ old('barcode') }}"
                                            placeholder="{{ __('messages.product') }} {{ __('messages.barcode') }}">
                                        @error('barcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- shit
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shit_no" class="form-label">
                                            {{ __('messages.shit_number') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="shit_no" id="shit_no"
                                            class="form-control @error('shit_no') is-invalid @enderror"
                                            value="{{ old('shit_no') }}" placeholder="{{ __('messages.shit_number') }}">
                                        @error('shit_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                {{-- purchase price --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="purchase_price"
                                            class="form-label">{{ __('messages.purchase_price') }}<small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <input type="text" name="purchase_price" id="purchase_price"
                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                            value="{{ old('purchase_price') }}"
                                            placeholder="{{ __('messages.purchase_price') }}">
                                        @error('purchase_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- sale price --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sale_price" class="form-label">{{ __('messages.sale_price') }}<small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <input type="text" name="sale_price" id="sale_price"
                                            class="form-control @error('sale_price') is-invalid @enderror"
                                            value="{{ old('sale_price') }}"
                                            placeholder="{{ __('messages.sale_price') }}">
                                        @error('sale_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- image  --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">{{ __('messages.image') }}<small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <input type="file" name="image" id="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            value="{{ old('image') }}">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- details  --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="details" class="form-label">{{ __('messages.details') }} <small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <textarea name="details" id="summernote" class="form-control @error('details') is-invalid @enderror" cols="30"
                                            rows="4"></textarea>
                                        @error('details')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="text-end">
                                <a href="#" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                                <button type="submit" class="btn btn-success">{{ __('messages.create') }}</button>
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
    <script>
        $(document).ready(function() {

            // Initialize Summernote
            $('#summernote').summernote({
                height: 100
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#category_id').on('change', function() {
                let dataId = $(this).val();
                if (dataId) {
                    $.ajax({
                        url: '/admin/get-subcategory/' + dataId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#subcategory_id').empty().append(
                                '<option value="">Select One</option>');
                            $.each(data.data, function(key, value) {

                                $('#subcategory_id').append('<option value="' + value
                                    .id +
                                    '">' + value.name +
                                    '</option>');
                            });
                            $('#subcategory_id').trigger(
                                'change'
                            ); // {{ __('messages.optional') }}: Trigger change if needed
                        }
                    });
                } else {
                    $('#subcategory_id').empty().append('<option value="">Select One</option>');

                }
            });
        });
    </script>
@endpush
