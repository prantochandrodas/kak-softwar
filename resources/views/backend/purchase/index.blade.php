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
    {{ __('messages.purchase_list') }}
@endsection

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ __('messages.purchase_list') }}

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
                <li class="breadcrumb-item text-muted"> {{ __('messages.purchase_list') }} </li>
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
                    <h6 class="mb-0"><i class="bi bi-funnel-fill me-2 text-primary"></i>{{ __('messages.filter') }}
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
                        <!--Expense fund-->
                        <div class="col-md-3">
                            <label for="supplier_id" class="form-label mb-1"> {{ __('messages.supplier') }}</label>
                            <select id="supplier_id" name="supplier_id" class="form-select form-select-sm">
                                <option value="">{{ __('messages.select_one') }}</option>
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label mb-1"> {{ __('messages.status') }}</label>
                            <select id="status" name="status" class="form-select form-select-sm">
                                <option value="">{{ __('messages.select_one') }}</option>
                                <option value="0">Un Paid</option>
                                <option value="1">Paid</option>
                                <option value="2">Partial Paid</option>
                            </select>
                        </div>
                        <!-- From Date -->
                        <div class="col-md-2">
                            <label for="from_date" class="form-label mb-1">{{ __('messages.start_date') }}</label>
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
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Secondary button-->
                <a href="{{ route('purchase.form') }}"
                    class="btn btn-sm fw-bold btn-success">{{ __('messages.make_purchase') }}</a>
                <!--end::Primary button-->
            </div>
            <div class="table-responsive">
                <table id="featuredProjectTitleHeading" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('messages.serial_no') }}</th>
                            @if ($isSuperAdmin && !$sessionBranch)
                                <th>{{ __('messages.branch') }}</th>
                            @endif
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.invoice_no') }}</th>
                            <th>{{ __('messages.supplier') }}</th>
                            <th>{{ __('messages.selected_currency_total_amount') }}</th>
                            <th>{{ __('messages.total_amount') }}</th>
                            <th>{{ __('messages.paid_amount') }}</th>
                            <th>{{ __('messages.due_amount') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="@if ($isSuperAdmin && !$sessionBranch) 5 @else 4 @endif" style="text-align:right">
                                {{ __('messages.total') }}:
                            </th>
                            <th></th> <!-- total_amount will show here -->
                            <th></th> <!-- paid_amount will show here -->
                            <th></th> <!-- due_amount will show here -->
                            <th colspan="1"></th> <!-- for status and action columns -->
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
<style>
#featuredProjectTitleHeading th:nth-child(6),
#featuredProjectTitleHeading td:nth-child(6) {
    width: 120px;
    white-space: nowrap;
    /* amount এবং symbol এক লাইনে রাখার জন্য */
}

#featuredProjectTitleHeading th:nth-child(7),
#featuredProjectTitleHeading td:nth-child(7) {
    width: 120px;
    white-space: nowrap;
    /* amount এবং symbol এক লাইনে রাখার জন্য */
}

#featuredProjectTitleHeading th:nth-child(9),
#featuredProjectTitleHeading td:nth-child(9) {
    width: 120px;
    white-space: nowrap;
    /* amount এবং symbol এক লাইনে রাখার জন্য */
}

#featuredProjectTitleHeading th:nth-child(8),
#featuredProjectTitleHeading td:nth-child(8) {
    width: 120px;
    white-space: nowrap;
    /* amount এবং symbol এক লাইনে রাখার জন্য */
}
</style>
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
                url: '{{ route('purchase.getdata') }}',
                data: function(d) {
                    d.branch_id = $('#branch_id').val();
                    d.status = $('#status').val();
                    d.supplier_id = $('#supplier_id').val();
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
                    data: 'invoice_no',
                    name: 'invoice_no'
                },
                {
                    data: 'supplier',
                    name: 'supplier'
                },
                {
                    data: 'sc_total_amount',
                    name: 'sc_total_amount',
                    width: '320px' // এখানে width বাড়ালাম
                },
                {
                    data: 'total_amount',
                    name: 'total_amount'
                },

                {
                    data: 'paid_amount',
                    name: 'paid_amount'
                },
                {
                    data: 'due_amount',
                    name: 'due_amount'
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

                // Determine if branch column exists
                var hasBranch = {{ $isSuperAdmin && !$sessionBranch ? 'true' : 'false' }};

                // Column indexes
                var totalAmountIndex = hasBranch ? 6 : 5;
                var paidAmountIndex = hasBranch ? 7 : 6;
                var dueAmountIndex = hasBranch ? 8 : 7;

                // Total over all pages
                var totalAmount = api.column(totalAmountIndex).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalPaid = api.column(paidAmountIndex).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalDue = api.column(dueAmountIndex).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer
                $(api.column(totalAmountIndex).footer()).html(totalAmount.toFixed(2));
                $(api.column(paidAmountIndex).footer()).html(totalPaid.toFixed(2));
                $(api.column(dueAmountIndex).footer()).html(totalDue.toFixed(2));
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
            url: '/admin/purchase/show/' + dataId,
            type: 'GET',
            success: function(response) {
                $('#modalNEWShow').html(response);
                $('#dataShowModal').modal('show');

            }
        })
    });
</script>

<script>
    $(document).on('click', '.deleteUser', function() {
        var userId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to expense",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('purchase.distroy') }}', // তোমার route অনুযায়ী ঠিক করো
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
                        $('#featuredProjectTitleHeading').DataTable().ajax.reload(null,
                            false);
                    },
                    error: function(xhr) {
                        let message = "Something went wrong!";

                        // যদি ব্যাকএন্ড থেকে কাস্টম মেসেজ আসে
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message,
                        });
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#branch_id').on('change', function() {
            let branchId = $(this).val();
            let supplierId = $('#supplier_id').val();

            let colorText = branchId ? $('#branch_id option:selected').text() : '';

            if (branchId) {
                $.ajax({
                    url: '/admin/get-supplier/' + branchId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#branchName').text(colorText || '-');
                        $('#supplier_id').empty().append(
                            '<option value="">{{ __('messages.select_one') }}</option>'
                        );
                        $.each(data.supplier, function(key, value) {
                            $('#supplier_id').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                        $('#supplier_id').trigger('change');
                    }
                });
            } else {
                $('#supplier_id').empty().append(
                    '<option value="">{{ __('messages.select_one') }}</option>');
                $('#supplier_id').trigger('change');

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
