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
    {{ __('messages.fund') }} {{ __('messages.current_balance') }}
@endsection

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ __('messages.fund') }} {{ __('messages.current_balance') }}
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
                <li class="breadcrumb-item text-muted"> {{ __('messages.fund') }} {{ __('messages.current_balance') }}
                </li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->


@php
    $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
    $sessionBranch = session('branch_id');
@endphp
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

        <table id="featuredProjectTitleHeading" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __('messages.serial_no') }}</th>
                    @if ($isSuperAdmin && !$sessionBranch)
                        <th>{{ __('messages.branch') }} </th>
                    @endif
                    <th>{{ __('messages.fund') }} {{ __('messages.name') }}</th>
                    <th>{{ __('messages.bank') }} {{ __('messages.name') }}</th>
                    <th>{{ __('messages.account') }} {{ __('messages.number') }} </th>
                    <th>{{ __('messages.amount') }}</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    @if ($isSuperAdmin && !$sessionBranch)
                        <th></th>
                    @endif
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th id="totalAmount"></th>
                </tr>
            </tfoot>
        </table>
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
            ajax: '{{ route('fund.current_balance.getdata') }}',
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
                        name: 'branch',
                    },
                @endif {
                    data: 'fund',
                    name: 'fund'
                },
                {
                    data: 'bank',
                    name: 'bank'
                },
                {
                    data: 'account',
                    name: 'account'
                },
                {
                    data: 'balance',
                    name: 'balance'
                },

            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Helper function
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        parseFloat(i.replace(/,/g, '')) || 0 :
                        typeof i === 'number' ?
                        i :
                        0;
                };

                // Column index for balance (last column)
                var totalBalance = api
                    .column(
                        @if ($isSuperAdmin && !$sessionBranch)
                            5
                        @else
                            4
                        @endif )
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Show in footer
                $(api.column(
                        @if ($isSuperAdmin && !$sessionBranch)
                            5
                        @else
                            4
                        @endif ).footer())
                    .html(totalBalance.toFixed(2));
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
