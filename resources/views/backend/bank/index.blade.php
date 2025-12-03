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
    {{ __('messages.bank_list') }}
@endsection

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ __('messages.bank_list') }}
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
                <li class="breadcrumb-item text-muted"> {{ __('messages.bank_list') }}</li>
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
            <button data-bs-toggle="modal" data-bs-target="#dataCreateModal" class="btn btn-sm btn-success mb-2"><svg
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    style="width: 20px; height:20px">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="m3.99 16.854-1.314 3.504a.75.75 0 0 0 .966.965l3.503-1.314a3 3 0 0 0 1.068-.687L18.36 9.175s-.354-1.061-1.414-2.122c-1.06-1.06-2.122-1.414-2.122-1.414L4.677 15.786a3 3 0 0 0-.687 1.068zm12.249-12.63 1.383-1.383c.248-.248.579-.406.925-.348.487.08 1.232.322 1.934 1.025.703.703.945 1.447 1.025 1.934.058.346-.1.677-.348.925L19.774 7.76s-.353-1.06-1.414-2.12c-1.06-1.062-2.121-1.415-2.121-1.415z"
                            fill="#ffffff"></path>
                    </g>
                </svg> {{ __('messages.create_bank') }}
            </button>
        @endif

        <table id="featuredProjectTitleHeading" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __('messages.serial_no') }}</th>
                    <th>{{ __('messages.fund') }} {{ __('messages.name') }}</th>
                    <th>{{ __('messages.bank') }} {{ __('messages.name') }}</th>
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
<!-- Custom CSS for Table Borders -->
@include('backend.bank.create')
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
            ajax: '{{ route('bank.getdata') }}',
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
                    data: 'fund',
                    name: 'fund'
                },
                {
                    data: 'name',
                    name: 'name'
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



    $(document).on('click', '.edit', function() {
        var dataId = $(this).data('id');
        $.ajax({
            url: '/admin/bank/edit/' + dataId,
            type: 'GET',
            success: function(response) {
                $('#modalShow').html(response);
                $('#dataEditModal').modal('show');
            }
        })
    });

    $(document).on('click', '.delete', function(event) {
        event.preventDefault(); // Prevent the default form submission
        let form = $(this).closest('form'); // Get the closest form element
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });
    $(document).on('click', '.toggle-status', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route('bank.toggleStatus') }}',
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
