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
    {{ __('messages.transfer_list') }}
@endsection

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ __('messages.transfer_list') }}

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
                <li class="breadcrumb-item text-muted"> {{ __('messages.transfer_list') }} </li>
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
        @php
            $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
            $sessionBranch = session('branch_id');
        @endphp

        <div class="table-wrapper">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="bi bi-funnel-fill me-2 text-primary"></i>{{ __('messages.filter') }}
                    </h6>
                </div>
                <div class="card-body">
                    <form id="filterForm" class="row g-3 align-items-end">
                        @if ($isSuperAdmin && !$sessionBranch)
                            <div class="col-md-4">
                                <label for="form_branch_id" class="form-label mb-1">
                                    {{ __('messages.from_branch') }}</label>
                                <select id="form_branch_id" name="form_branch_id" class="form-select form-select-sm">
                                    <option value=""> {{ __('messages.select_one') }}</option>
                                    @foreach ($branchInfo as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('form_branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="to_branch_id" class="form-label mb-1">
                                    {{ __('messages.to_branch') }}</label>
                                <select id="to_branch_id" name="to_branch_id" class="form-select form-select-sm">
                                    <option value=""> {{ __('messages.select_one') }}</option>
                                    @foreach ($branchInfo as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('to_branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- From Date -->
                        <div class="col-md-4">
                            <label for="from_date" class="form-label mb-1">{{ __('messages.start_date') }}</label>
                            <input type="date" id="from_date" name="from_date" class="form-control form-control-sm">
                        </div>

                        <!-- To Date -->
                        <div class="col-md-4">
                            <label for="to_date" class="form-label mb-1">{{ __('messages.end_date') }}</label>
                            <input type="date" id="to_date" name="to_date" class="form-control form-control-sm">
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-4">
                            <button type="button" id="applyFilter" class="btn btn-sm btn-primary">
                                <i class="bi bi-search me-1"></i> {{ __('messages.search') }}
                            </button>
                            <button type="button" id="resetFilter" class="btn btn-sm btn-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> {{ __('messages.reset') }}
                            </button>
                        </div>

                    </form>
                </div>


            </div>

            <table id="featuredProjectTitleHeading" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('messages.serial_no') }}</th>
                        @if ($isSuperAdmin && !$sessionBranch)
                            <th>{{ __('messages.from_branch') }}</th>
                        @endif

                        <th>{{ __('messages.to_branch') }}</th>
                        <th>{{ __('messages.transfer_date') }}</th>
                        <th>{{ __('messages.total_items') }}</th>
                        <th>{{ __('messages.total_amount') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right">{{ __('messages.total') }}:</th>
                        <th></th> <!-- total_amount এখানে দেখাবে -->
                        <th></th> <!-- paid_amount এখানে দেখাবে -->
                        <th></th> <!-- due_amount এখানে দেখাবে -->

                    </tr>
                </tfoot>
            </table>
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
            ajax: {
                url: '{{ route('transfer-list.getdata') }}',
                data: function(d) {

                    d.form_branch_id = $('#form_branch_id').val();
                    d.to_branch_id = $('#to_branch_id').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
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
                @if ($isSuperAdmin && !$sessionBranch)
                    {
                        data: 'form_branch',
                        name: 'form_branch'
                    },
                @endif {
                    data: 'to_branch',
                    name: 'to_branch'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'total_item',
                    name: 'total_item'
                },

                {
                    data: 'total_amount',
                    name: 'total_amount'
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
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Helper function to remove commas and convert to float
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        parseFloat(i.replace(/,/g, '')) :
                        typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                totalAmount = api.column(4).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                totalPaid = api.column(5).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                totalDue = api.column(6).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer
                $(api.column(4).footer()).html(totalAmount.toFixed(2));

            }

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
            url: '/admin/transfer-list/show/' + dataId,
            type: 'GET',
            success: function(response) {
                $('#modalNEWShow').html(response);
                $('#dataShowModal').modal('show');

            }
        })
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
