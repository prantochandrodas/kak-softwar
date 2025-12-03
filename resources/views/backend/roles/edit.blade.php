@extends('layouts.backend')

@section('main')
@section('title')
    {{ __('messages.edit_role') }}
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
                    {{ __('messages.edit_role') }}
                </h1>
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
                    <li class="breadcrumb-item text-muted">{{ __('messages.edit_role') }}</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar container-->
    </div>
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
            color: white !important;
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
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">{{ __('messages.edit_role') }}</h4>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">


                    <form action="{{ route('admin.role.edit', $data->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.name') }}</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') ?? $data->name }}"
                                @if ($data->name === 'Super Admin') readonly @endif required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
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

                                    $groupPermissions = Spatie\Permission\Models\Permission::where(
                                        'group_name',
                                        $group->name,
                                    )
                                        ->pluck('name')
                                        ->toArray();
                                    $hasAllPermissions = $data->hasAllPermissions($groupPermissions);
                                @endphp
                                <div class="row">
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="{{ $loop->iteration }}-management" value="{{ $group->name }}"
                                                onclick="checkPermissionByGroup('role-{{ $loop->iteration }}-management-checkbox', this)"
                                                {{ $hasAllPermissions ? 'checked' : '' }}>
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
                                                    onclick="checkSinglePermission('role-{{ $loop->parent->iteration }}-management-checkbox', '{{ $loop->parent->iteration }}-management', {{ count($permissions) }})"
                                                    {{ $data->hasPermissionTo($permission->name) ? 'checked' : '' }}>
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
