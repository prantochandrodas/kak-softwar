@extends('layouts.backend')

@section('main')
@section('title')
    {{ __('messages.permissions') }}
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
                    {{ __('messages.permissions') }}</h1>
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

                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{ __('messages.permissions') }}</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
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
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card-header">
                <h4 class="card-title mb-0">{{ __('messages.permissions') }}</h4>
            </div>
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
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
                            @endphp
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="">
                                        <p>{{ $loop->iteration }} : <strong>{{ $group->name }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-sm-9 col-xs-6 role-{{ $loop->iteration }}-management-checkbox">
                                    @foreach ($permissions as $permission)
                                        <div class="">
                                            <p>{{ $loop->iteration }} : <strong>{{ $permission->name }}</strong></p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
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
@endpush
