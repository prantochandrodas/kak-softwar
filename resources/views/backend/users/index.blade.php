@extends('layouts.backend')

@section('main')
@section('title')
    {{ __('messages.user_list') }}
@endsection
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('messages.user_list') }}
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-muted text-hover-primary">{{ __('messages.dashboard') }}
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{ __('messages.user_management') }}</li>
                    <!--end::Item-->

                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Secondary button-->
                <a href="{{ route('admin.user.create') }}" class="btn btn-sm fw-bold btn-primary">
                    {{ __('messages.add') }} </a>
                <!--end::Primary button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4 table-responsive">
                    <!--begin::Table-->

                    <table id="data-table" class="display">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>{{ __('messages.serial_no') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.email') }}</th>
                                <th>{{ __('messages.phone') }}</th>
                                <th>{{ __('messages.address') }}</th>
                                <th>{{ __('messages.branch') }}</th>
                                <th>{{ __('messages.image') }}</th>
                                <th>{{ __('messages.roles') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                        </tbody>
                    </table>
                    <!--end::Table-->
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
@push('style')
<link rel="stylesheet" href="{{ asset('assets/backend/css/dataTables.bootstrap5.min.css') }}">
@endpush

@push('script')
<!-- Include jQuery and DataTables with Bootstrap -->
<script src="{{ asset('assets/backend/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.user.data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'branch',
                    name: 'branch'
                },

                {
                    data: 'photo',
                    name: 'photo'
                },
                {
                    data: 'roles',
                    name: 'roles'
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
            ],
            responsive: true
        });
    });
</script>
<script>
    $(document).on('click', '.toggle-status', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route('user.toggleStatus') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                // Reload DataTable without resetting pagination
                $('#data-table').DataTable().ajax.reload(null, false);

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
    $(document).on('click', '.deleteUser', function() {
        var userId = $(this).data('id');
        var userName = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete user: " + userName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('admin.user.delete') }}', // তোমার route অনুযায়ী ঠিক করো
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: userId
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'User has been deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#data-table').DataTable().ajax.reload(null, false);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong!',
                        });
                    }
                });
            }
        });
    });
</script>
@endpush
