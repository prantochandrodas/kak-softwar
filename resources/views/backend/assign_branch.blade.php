<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../" />
    <title>{{ $generalSetting->name }} || Assign Branch</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @php
        $company = \App\Models\GeneralSetting::first();
        $companyName = $company ? $company->name : '';
        $companyLogo = $company ? $company->favicon : '';
    @endphp
    <link rel="shortcut icon" href="{{ asset('uploads/settings/' . $companyLogo) }}" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle-->
    <link href="{{ asset('assets/backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <style>
        /* Enhanced Design Styles */
        #kt_app_root {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .form-wrapper {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 3rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);
        }

        .logo-container {
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .form-subtitle {
            color: #64748b;
            font-size: 1rem;
            animation: fadeIn 1.2s ease-out;
        }

        .form-label {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }

        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background-color: #ffffff;
            outline: none;
        }

        .form-select:hover {
            border-color: #cbd5e1;
            background-color: #ffffff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-weight: 600;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .text-danger {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }

        .text-danger::before {
            content: "⚠";
            margin-right: 0.5rem;
        }

        .input-group-wrapper {
            animation: slideInUp 0.6s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading spinner enhancement */
        .spinner-border {
            border-width: 2px;
        }

        /* Select2 styling enhancement */
        .select2-container--default .select2-selection--single {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            height: auto;
            padding: 0.5rem;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #667eea;
        }

        /* Decorative elements */
        .decorative-circle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0.1;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: #ffffff;
            top: -150px;
            right: -150px;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            background: #ffffff;
            bottom: -100px;
            left: -100px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-wrapper {
                padding: 2rem 1.5rem;
            }

            .form-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    @php
        $company = \App\Models\GeneralSetting::first();
        $companyLogo = $company ? $company->logo : '';
    @endphp
    <!--end::Theme mode setup on page load-->

    <!-- Decorative elements -->
    <div class="decorative-circle circle-1"></div>
    <div class="decorative-circle circle-2"></div>

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Assign Branch -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10">
                        <!--begin::Form-->
                        <div class="form-wrapper">
                            <form class="form w-100" action="{{ route('admin.branch.assign.update') }}" method="post">
                                @csrf
                                <!--begin::Heading-->
                                <div class="text-center mb-11 logo-container">
                                    <img alt="Logo" src="{{ asset('uploads/logo/' . $companyLogo) }}"
                                        class="h-60px h-lg-75px mb-4" />
                                    <!--begin::Title-->
                                    <h1 class="form-title">Select Your Branch</h1>
                                    <!--end::Title-->
                                    <!--begin::Subtitle-->
                                    <div class="form-subtitle">Please select your branch to continue</div>
                                    <!--end::Subtitle=-->
                                </div>
                                <!--begin::Heading-->


                                <!--begin::Input group-->
                                <div class="fv-row mb-8 input-group-wrapper">
                                    <!--begin::Label-->
                                    <label class="form-label">Select Branch</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="branch_id"
                                        class="form-select form-select-solid @error('branch_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Select a branch" required>
                                        <option value="">Select a branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <!--end::Select-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Confirm Selection</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <!--end::Submit button-->
                            </form>
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Assign Branch-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle-->
    <script src="{{ asset('assets/backend/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/backend/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    @include('sweetalert::alert')
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
