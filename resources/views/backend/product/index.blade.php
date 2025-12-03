@extends('layouts.backend')
@section('main')
    <!-- success message  -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- error message  -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

@section('title')
    {{ __('messages.product_list') }}
@endsection

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ __('messages.product_list') }}

            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                        {{ __('messages.dashboard') }}
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted"> {{ __('messages.product_list') }} </li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->



<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        {{-- add button  --}}
        <div class="table-wrapper">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="bi bi-funnel-fill me-2 text-primary"></i> {{ __('messages.filter') }}
                    </h6>
                </div>
                <div class="card-body">
                    <form id="filterForm" class="row g-3 align-items-end">

                        <!-- product categories-->
                        <div class="col-md-3">
                            <label for="categories" class="form-label mb-1">{{ __('messages.category') }}</label>
                            <select id="categories" name="categories" class="form-select form-select-sm">
                                <option value="">{{ __('messages.select_one') }}</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="subcategory_id"
                                class="form-label mb-1">{{ __('messages.sub_category') }}</label>
                            <select id="subcategory_id" name="subcategory_id" class="form-select form-select-sm">
                                <option value="">{{ __('messages.select_one') }}</option>

                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="productBrand" class="form-label mb-1">{{ __('messages.brand') }}</label>
                            <select id="productBrand" name="productBrand" class="form-select form-select-sm">
                                <option value="">{{ __('messages.select_one') }}</option>
                                @foreach ($productBrand as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- payment status -->
                        <div class="col-md-3">
                            <label for="status" class="form-label mb-1">{{ __('messages.status') }}</label>
                            <select id="status" name="status" class="form-select form-select-sm">
                                <option value="">{{ __('messages.select_one') }}</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>




                        <!-- Buttons -->
                        <div class="col-12 text-end">
                            <button type="button" id="applyFilter" class="btn btn-sm btn-primary">
                                <i class="bi bi-search me-1"></i>{{ __('messages.search') }}
                            </button>
                            <button type="button" id="resetFilter" class="btn btn-sm btn-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> {{ __('messages.reset') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Secondary button-->
                <a href="{{ route('product.create') }}"
                    class="btn btn-sm fw-bold btn-success">{{ __('messages.create_product') }}</a>
                <!--end::Primary button-->
            </div>
            <div class="table-responsive ">
                <table id="featuredProjectTitleHeading" class="display " style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('messages.serial_no') }}</th>
                            <th>{{ __('messages.product') }} {{ __('messages.name') }}</th>
                            <th>{{ __('messages.product') }} {{ __('messages.product_code') }}</th>
                            {{-- <th> {{ __('messages.shit_number') }}</th> --}}
                            <th>{{ __('messages.product') }} {{ __('messages.barcode') }}</th>
                            <th>{{ __('messages.product') }} {{ __('messages.category') }}</th>
                            <th>{{ __('messages.product') }} {{ __('messages.sub_category') }}</th>
                            <th>{{ __('messages.product') }} {{ __('messages.brand') }}</th>
                            <th>{{ __('messages.product') }} {{ __('messages.unit') }}</th>
                            <th>{{ __('messages.purchase_price') }}</th>
                            <th>{{ __('messages.sale_price') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="dataEditModal" tabindex="-1" aria-labelledby="dataEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modalShow"
            style="background-color: #f8f9fa; border-radius: 8px; border: 1px solid #ddd;">

        </div>
    </div>
</div>
<div class="modal fade" id="dataShowModal" tabindex="-1" aria-labelledby="dataShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modalNEWShow"
            style="background-color: #f8f9fa; border-radius: 8px; border: 1px solid #ddd;">

        </div>
    </div>
</div>
@endsection
@push('script')
<!-- Include jQuery and DataTables with Bootstrap -->
<script src="{{ asset('assets/backend/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    var table;
    $(document).ready(function() {
        table = $('#featuredProjectTitleHeading').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('product.getdata') }}',
            ajax: {
                url: '{{ route('product.getdata') }}',
                data: function(d) {
                    d.categories = $('#categories').val();
                    d.status = $('#status').val();
                    d.productBrand = $('#productBrand').val();
                    d.subcategory_id = $('#subcategory_id').val();
                }
            },
            columns: [{
                    data: null, // Use null to signify that this column does not map directly to any data source
                    name: 'serial_number',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart +
                            1; // Calculate the serial number
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'product_code',
                    name: 'product_code'
                },
                // {
                //     data: 'shit_no',
                //     name: 'shit_no'
                // },
                {
                    data: 'barcode',
                    name: 'barcode'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'subcategory',
                    name: 'subcategory'
                },
                {
                    data: 'brand',
                    name: 'brand'
                },


                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'purchase_price',
                    name: 'purchase_price'
                },

                {
                    data: 'sale_price',
                    name: 'sale_price'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('#applyFilter').on('click', function() {
            table.ajax.reload();
        });

        // Reset Filter Button
        $('#resetFilter').on('click', function() {
            $('#filterForm')[0].reset();
            table.ajax.reload();
        });
    });



    $(document).on('click', '.show', function() {
        var dataId = $(this).data('id');
        $.ajax({
            url: '/admin/product/show/' + dataId,
            type: 'GET',
            success: function(response) {
                $('#modalNEWShow').html(response);
                $('#dataShowModal').modal('show');

            }
        })
    });


    $(document).on('click', '.toggle-status', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route('product.toggleStatus') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                // Reload DataTable without resetting pagination
                $('#featuredProjectTitleHeading').DataTable().ajax.reload(null, false);

                // Show success message with SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Status updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                // Show error message with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON?.message || 'Failed to toggle status!',
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#categories').on('change', function() {
            let dataId = $(this).val();
            if (dataId) {
                $.ajax({
                    url: '/admin/get-subcategory/' + dataId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subcategory_id').empty().append(
                            '<option value="">{{ __('messages.select_one') }}</option>'
                            );
                        $.each(data.data, function(key, value) {

                            $('#subcategory_id').append('<option value="' + value
                                .id +
                                '">' + value.name +
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
    });
</script>
@if (request()->has('added-successfully'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: "success",
                title: "{{ request('added-successfully') }}",
                showConfirmButton: false,
                timer: 2000
            });
            // Clear the query parameter from the URL
            const url = new URL(window.location.href);
            url.searchParams.delete('added-successfully');
            window.history.replaceState(null, '', url);
        });
    </script>
@endif
@endpush
