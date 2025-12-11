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
    {{ __('messages.fund_adjustment_list') }}
@endsection

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ __('messages.fund_adjustment_list') }}

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
                <li class="breadcrumb-item text-muted"> {{ __('messages.fund_adjustment_list') }} </li>
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
                        @php
                            $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                            $sessionBranch = session('branch_id');
                        @endphp
                        @if ($isSuperAdmin && !$sessionBranch)
                            <div class="col-md-3">
                                <label for="branch_id" class="form-label mb-1"> {{ __('messages.branch') }}</label>
                                <select id="branch_id" name="branch_id" class="form-select form-select-sm">
                                    <option value=""> {{ __('messages.select_one') }}</option>
                                    @foreach ($branchInfo as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- From Date -->
                        <div class="col-md-2">
                            <label for="from_date" class="form-label mb-1"> {{ __('messages.start_date') }}</label>
                            <input type="date" id="from_date" name="from_date" class="form-control form-control-sm">
                        </div>

                        <!-- To Date -->
                        <div class="col-md-2">
                            <label for="to_date" class="form-label mb-1">{{ __('messages.end_date') }}</label>
                            <input type="date" id="to_date" name="to_date" class="form-control form-control-sm">
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 text-end">
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
            <div class="table-responsive ">
                <table id="featuredProjectTitleHeading" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('messages.sl') }}</th>
                            @if ($isSuperAdmin && !$sessionBranch)
                                <th>{{ __('messages.branch') }}</th>
                            @endif
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.type') }} </th>
                            <th>{{ __('messages.fund') }}</th>
                            <th>{{ __('messages.bank') }}</th>
                            <th>{{ __('messages.account') }}</th>
                            <th>{{ __('messages.note') }}</th>
                            <th>{{ __('messages.amount') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="{{ $isSuperAdmin && !$sessionBranch ? 8 : 7 }}" class="text-end">
                                {{ __('messages.total') }}:
                            </th>
                            <th></th> <!-- amount -->
                        </tr>
                    </tfoot>

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
            ajax: {
                url: '{{ route('fund-adjustment.getdata') }}',
                data: function(d) {
                    d.branch_id = $('#branch_id').val();
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
                        data: 'branch',
                        name: 'branch'
                    },
                @endif {
                    data: 'date',
                    name: 'date'
                },

                {
                    data: 'type',
                    name: 'type'
                },
                {
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
                    data: 'note',
                    name: 'note'
                },
                {
                    data: 'amount',
                    name: 'amount'
                }
            ],

            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                var total = api
                    .column({{ $isSuperAdmin && !$sessionBranch ? 8 : 7 }})
                    .data()
                    .reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                $(api.column({{ $isSuperAdmin && !$sessionBranch ? 8 : 7 }}).footer()).html(total
                    .toFixed(2));
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
