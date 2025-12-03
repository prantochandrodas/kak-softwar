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
    {{ __('messages.bank_account_list') }}
@endsection

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ __('messages.bank_account_list') }}

            </h1>
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
                <li class="breadcrumb-item text-muted"> {{ __('messages.bank_account_list') }} </li>
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
        @php
            $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
            $sessionBranch = session('branch_id');
        @endphp
        @if ($isSuperAdmin)
            {{-- add button  --}}
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Secondary button-->
                <a href="{{ route('bank-account.create') }}"
                    class="btn btn-sm fw-bold btn-success">{{ __('messages.create') }}</a>
                <!--end::Primary button-->
            </div>
        @endif
        <table id="featuredProjectTitleHeading" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __('messages.serial_no') }}</th>
                    @if ($isSuperAdmin && !$sessionBranch)
                        <th>{{ __('messages.branch') }} {{ __('messages.name') }}</th>
                    @endif
                    <th>{{ __('messages.bank') }} {{ __('messages.name') }}</th>
                    <th>{{ __('messages.bank') }} {{ __('messages.branch') }} {{ __('messages.name') }}</th>
                    <th>{{ __('messages.account') }} {{ __('messages.name') }}</th>
                    <th>{{ __('messages.account_number') }}</th>
                    <th>{{ __('messages.account_type') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    @if ($isSuperAdmin)
                        <th>{{ __('messages.action') }}</th>
                    @endif
                </tr>
            </thead>
        </table>
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
    $(document).ready(function() {
        $('#featuredProjectTitleHeading').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('bank-account.getdata') }}',
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
                @if ($isSuperAdmin && !$sessionBranch)
                    {
                        data: 'branch',
                        name: 'branch'
                    },
                @endif {
                    data: 'bank',
                    name: 'bank'
                },
                {
                    data: 'bank_branch',
                    name: 'bank_branch'
                },
                {
                    data: 'account_name',
                    name: 'account_name'
                },
                {
                    data: 'account_number',
                    name: 'account_number'
                },
                {
                    data: 'account_type',
                    name: 'account_type'
                },

                {
                    data: 'status',
                    name: 'status'
                },
                @if (auth()->user()->hasRole('Super Admin'))
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                @endif
            ]
        });

    });



    $(document).on('click', '.show', function() {
        var dataId = $(this).data('id');
        $.ajax({
            url: '/admin/bank-account/show/' + dataId,
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
            url: '{{ route('bank-account.toggleStatus') }}',
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
