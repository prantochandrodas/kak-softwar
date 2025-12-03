@extends('layouts.backend')

@section('main')
@section('title')
    {{ __('messages.create_new_role') }}
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
                    {{ __('messages.create_new_role') }}</h1>
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

                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{ __('messages.create_new_role') }}</li>
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
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
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
                padding: 10px 20px;
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
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">{{ __('messages.create_new_role') }}</h4>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">


                    <form action="{{ route('admin.role.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.name') }}</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check" style="margin-top: 20px">
                            <input class="form-check-input" type="checkbox" id="checkPermissionAll" value="1">
                            <label for="checkPermissionAll" class="form-label">{{ __('messages.all') }}</label>
                        </div>
                        <hr>

                        <div class="mb-3">
                            @foreach ($permissions_groups as $group)
                                @php
                                    $permissions = Spatie\Permission\Models\Permission::where(
                                        'group_name',
                                        $group->name,
                                    )->get();
                                @endphp
                                <div class="row">
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="{{ $loop->iteration }}-management" value="{{ $group->name }}"
                                                onclick="checkPermissionByGroup('role-{{ $loop->iteration }}-management-checkbox', this)">
                                            <label for="{{ $loop->iteration }}-management"
                                                class="form-label">{{ $group->name }}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-xs-6 role-{{ $loop->iteration }}-management-checkbox">
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    id="checkPermission{{ $permission->id }}"
                                                    value="{{ $permission->name }}"
                                                    onclick="checkSinglePermission('role-{{ $loop->parent->iteration }}-management-checkbox', '{{ $loop->parent->iteration }}-management', {{ count($permissions) }})">
                                                <label class="form-label"
                                                    for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endforeach
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
    $("#checkPermissionAll").click(function() {
        if ($(this).is(':checked')) {
            $("input[type=checkbox]").prop('checked', true);
        } else {
            $("input[type=checkbox]").prop('checked', false);
        }
    });

    function checkPermissionByGroup(className, thisObject) {
        var groupIdName = $("#" + thisObject.id);
        var classCheekBox = $('.' + className + ' input[type=checkbox]');

        if (groupIdName.is(':checked')) {
            classCheekBox.prop('checked', true);
        } else {
            classCheekBox.prop('checked', false);
        }

        implementAllChecked();
    }

    function checkSinglePermission(groupClassName, groupID, CountTotalPermission) {
        var classCheckBox = $('.' + groupClassName + ' input');
        var groupIDCheckBox = $('#' + groupID);
        // console.log($("."+groupClassName+" input:checked").length, CountTotalPermission);
        // If there is any occurrence where something is not selected then make selected = false
        if ($("." + groupClassName + " input:checked").length == CountTotalPermission) {
            groupIDCheckBox.prop('checked', true);
        } else {
            groupIDCheckBox.prop('checked', false);
        }

        implementAllChecked();
    }

    function implementAllChecked() {
        const countPermissions = {{ count($all_permissions) }};
        const countPermissionGroups = {{ count($permissions_groups) }};

        // console.log(countPermissions,countPermissionGroups, $("input[type=checkbox]:checked").length);

        if ($("input[type=checkbox]:checked").length == (countPermissions + countPermissionGroups)) {
            $("#checkPermissionAll").prop('checked', true);
        } else {
            $("#checkPermissionAll").prop('checked', false);
        }
    }
</script>
@endpush
