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
                        {{ __('messages.edit_product') }}</h1>
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
                        <li class="breadcrumb-item text-muted">{{ __('messages.edit_product') }}</li>
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
            /* === Modern Form Card Styling === */
            .card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                background: #ffffff;
                overflow: hidden;
            }

            .card-header {
                background: linear-gradient(135deg, #007bff, #00c6ff);
                color: #fff;
                padding: 15px 20px;
                border-bottom: none;
                border-radius: 15px 15px 0 0;
            }

            .card-header .card-title {
                font-weight: 600;
                font-size: 1.25rem;
                margin: 0;
                color: #ffffff;
            }

            .card-body {
                background: #fafbfc;
                padding: 25px;
            }

            .form-label {
                font-weight: 600;
                color: #333;
            }

            .form-control,
            .form-select {
                border-radius: 10px;
                border: 1px solid #ced4da;
                padding: 10px 12px;
                transition: all 0.2s ease-in-out;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
            }

            .form-control::placeholder {
                color: #999;
                font-size: 0.95rem;
            }

            .mb-3 {
                margin-bottom: 1.2rem !important;
            }

            .btn-success {
                background: linear-gradient(135deg, #28a745, #4cd964);
                border: none;
                border-radius: 10px;
                padding: 10px 25px;
                font-weight: 600;
                transition: 0.3s;
            }

            .btn-success:hover {
                background: linear-gradient(135deg, #218838, #43c057);
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            }

            .btn-secondary {
                border-radius: 10px;
                padding: 10px 25px;
                font-weight: 600;
            }

            .text-end {
                margin-top: 15px;
            }

            /* Small subtle hover for inputs */
            .form-control:hover,
            .form-select:hover {
                border-color: #80bdff;
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
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('messages.edit_product') }}</h4>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body py-4">


                        <form action="{{ route('product.update', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                {{-- category_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.category') }}</label>
                                        <select name="category_id" id="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($productCat as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->category_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{-- subcategory_id --}}
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
                                        <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') ?? $data->name }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- unit --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.unit') }} <span class="text-danger">*</span></label>
                                        <select name="unit" id="unit"
                                            class="form-select  @error('unit') is-invalid @enderror">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($productUnit as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->unit_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- brand_id --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="brand_id" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.brand') }} <small class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <select name="brand_id" id="brand_id"
                                            class="form-select  @error('brand_id') is-invalid @enderror">
                                            <option value="">{{ __('messages.select_one') }}</option>
                                            @foreach ($productBrand as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->brand_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- product_code --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode" class="form-label">{{ __('messages.product') }}
                                            {{ __('messages.barcode') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="barcode" id="barcode"
                                            class="form-control @error('barcode') is-invalid @enderror"
                                            value="{{ $data->barcode }}" placeholder="Enter barcode">
                                        @error('barcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shit_no" class="form-label">{{ __('messages.shit_number') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="shit_no" id="shit_no"
                                            class="form-control @error('shit_no') is-invalid @enderror"
                                            value="{{ $data->shit_no }}" placeholder="{{ __('messages.shit_number') }}">
                                        @error('shit_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                {{-- purchase_price --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="purchase_price"
                                            class="form-label">{{ __('messages.purchase_price') }}<small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <input type="text" name="purchase_price" id="purchase_price"
                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                            value="{{ $data->purchase_price }}"
                                            placeholder="{{ __('messages.purchase_price') }}">
                                        @error('purchase_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- sale_price  --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sale_price" class="form-label">{{ __('messages.sale_price') }}<small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <input type="text" name="sale_price" id="sale_price"
                                            class="form-control @error('sale_price') is-invalid @enderror"
                                            value="{{ $data->sale_price }}"
                                            placeholder="{{ __('messages.sale_price') }}">
                                        @error('sale_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- image --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">{{ __('messages.image') }}<small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <input type="file" name="image" id="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            value="{{ old('image') }}">
                                        @if ('image')
                                            <img src="{{ asset('uploads/products/' . $data->image) }}" alt=""
                                                style="width: 80px; height: auto; margin-top: 10px;">
                                        @endif
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- details --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="details" class="form-label">{{ __('messages.details') }} <small
                                                class="text-muted"
                                                style="font-size: 12px;">({{ __('messages.optional') }})</small></label>
                                        <textarea name="details" id="summernote" class="form-control @error('details') is-invalid @enderror" cols="30"
                                            rows="4">{!! $data->details !!}</textarea>
                                        @error('details')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status"
                                        class="form-label fw-bold text-dark">{{ __('messages.status') }}:</label><br>

                                    <label class="switch">
                                        <input type="checkbox" id="status" name="status" value="1"
                                            {{ isset($data->status) && $data->status == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>

                                    <div class="invalid-feedback status-error"></div>
                                </div>

                            </div>



                            <div class="text-end">
                                <a href="#" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                                <button type="submit" class="btn btn-success">{{ __('messages.update') }}</button>
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
                let selectedCategoryId = "{{ $data->subcategory_id }}" // Preselected value for floor
                if (dataId) {
                    $.ajax({
                        url: '/admin/get-subcategory/' + dataId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(selectedCategoryId);
                            $('#subcategory_id').empty().append(
                                '<option value="">{{ __('messages.select_one') }}</option>'
                            );
                            $.each(data.data, function(key, value) {

                                let isSelected = selectedCategoryId == value
                                    .id ?
                                    'selected' : '';
                                $('#subcategory_id').append('<option value="' + value
                                    .id +
                                    '" ' + isSelected + '>' + value.name +
                                    '</option>');
                            });
                            $('#subcategory_id').trigger(
                                'change'); // Optional: Trigger change if needed
                        }
                    });
                } else {
                    $('#subcategory_id').empty().append(
                        '<option value="">{{ __('messages.select_one') }}</option>');

                }
            });

            if ($('#category_id').val()) {
                $('#category_id').trigger('change');
            }
        });
    </script>
@endpush
