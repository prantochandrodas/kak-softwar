<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="" />
    <title>{{ $generalSetting->name }} || @yield('title')</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @php
        $company = \App\Models\GeneralSetting::first();
        $companyName = $company ? $company->name : '';
        $companyLogo = $company ? $company->favicon : '';
    @endphp
    <link rel="shortcut icon" href="{{ asset('uploads/settings/' . $companyLogo) }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/backend/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/backend/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @stack('style')
    <style>
        .table-wrapper {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            border-radius: 34px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: 0.4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
            /* Blue when active */
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .slider.round {
            border-radius: 34px;
        }
    </style>

    <style>
        #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            /* Make sure it appears on top */
        }

        #backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }

        .spinner-border {
            color: white;
            /* Change the color to white */
        }

        /* Custom DataTable Styling with Visible Borders */

        /* Table Header Styling */
        #featuredProjectTitleHeading thead th {
            background-color: #1f2937 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            padding: 12px 15px !important;
            border: 1px solid #374151 !important;
            text-align: center !important;
            vertical-align: middle !important;

            /* Allow text to wrap */
            white-space: normal !important;
            word-wrap: break-word !important;
            /* ensures long words break */
            overflow: visible !important;
            /* prevent hiding overflowing text */
        }

        /* Table Body Styling with Borders */
        #featuredProjectTitleHeading tbody td {
            padding: 10px 15px !important;
            vertical-align: middle !important;
            text-align: center !important;
            border: 1px solid #e5e7eb !important;
        }

        /* Alternate Row Colors */
        #featuredProjectTitleHeading tbody tr:nth-child(odd) {
            background-color: #f9fafb !important;
        }

        #featuredProjectTitleHeading tbody tr:nth-child(even) {
            background-color: #ffffff !important;
        }

        /* Row Hover Effect */
        #featuredProjectTitleHeading tbody tr:hover {
            background-color: #dbeafe !important;
            cursor: pointer;
        }

        /* Table Footer Styling with Borders */
        #featuredProjectTitleHeading tfoot th {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
            font-weight: 700 !important;
            padding: 12px 15px !important;
            border: 1px solid #d1d5db !important;
            text-align: center !important;
        }

        /* Table Container */
        .table-wrapper {
            background-color: #ffffff;
            border-radius: 0;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* DataTable Wrapper */
        #featuredProjectTitleHeading_wrapper {
            margin-top: 20px;
        }

        /* Table with Visible Borders */
        #featuredProjectTitleHeading {
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            width: 100% !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0 !important;
            overflow: hidden !important;
        }

        /* Action Buttons Styling */
        .btn-sm {
            padding: 6px 12px !important;
            font-size: 13px !important;
            border-radius: 4px !important;
            margin: 0 2px !important;
        }

        /* Status Badge Styling */
        .badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 12px;
        }

        /* Search Box Styling */
        #featuredProjectTitleHeading_filter input {
            border: 1px solid #e4e6ef !important;
            border-radius: 4px !important;
            padding: 6px 12px !important;
        }

        /* Pagination Styling */
        .dataTables_paginate .paginate_button {
            border-radius: 4px !important;
            margin: 0 2px !important;
        }

        .dataTables_paginate .paginate_button.current {
            background: #1e1e2d !important;
            color: white !important;
            border: 1px solid #1e1e2d !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background: #3f4254 !important;
            color: white !important;
            border: 1px solid #3f4254 !important;
        }

        /* Length Menu Styling */
        #featuredProjectTitleHeading_length select {
            border: 1px solid #e4e6ef !important;
            border-radius: 4px !important;
            padding: 4px 8px !important;
        }

        /* Loading Overlay */
        .dataTables_processing {
            background-color: rgba(30, 30, 45, 0.9) !important;
            color: white !important;
            border-radius: 4px !important;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
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
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            @include('backend.partials._header')
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                @include('backend.partials._sidebar')
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div id="loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="backdrop"></div>
                    <!--begin::Content wrapper-->
                    @yield('main')
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    @include('backend.partials._footer')
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->



    <!--end::Modal - Users Search-->

    <!--end::Modal - Invite Friend-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/backend/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/backend/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script>
        // Show the loading spinner when navigating to the page
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Handle page load from the back-forward cache
                document.getElementById('loading').style.display = 'none';
                document.getElementById('backdrop').style.display = 'none';
            }
        });

        // Hide the loading spinner when the page finishes loading
        window.addEventListener('load', function() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('backdrop').style.display = 'none';
        });

        // Show the loading spinner
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('backdrop').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('backdrop').style.display = 'none';
        }

        // Event listener for page navigation (including back button)
        window.addEventListener('beforeunload', function() {
            showLoading();
        });

        // Optional: Attach the loading spinner to form submission
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                showLoading();
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


    <script src="{{ asset('assets/backend/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/backend/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/utilities/modals/new-target.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--end::Custom Javascript-->
    @stack('script')
    @include('sweetalert::alert')

    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
