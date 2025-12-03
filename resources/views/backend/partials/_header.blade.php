<div id="kt_app_header" class="app-header">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">
        <!--begin::Sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::Sidebar mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('admin.dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/backend/media/logos/default-small.svg') }}" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->

                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">

                <!--end::Search-->


                {{-- <!--begin::Theme mode-->
                <div class="app-navbar-item ms-1 ms-md-3">

                    <!--begin::Menu toggle-->
                    <a href="#"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-night-day theme-light-show fs-2 fs-lg-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                            <span class="path9"></span>
                            <span class="path10"></span>
                        </i>
                        <i class="ki-duotone ki-moon theme-dark-show fs-2 fs-lg-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                    <!--begin::Menu toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-night-day fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                        <span class="path7"></span>
                                        <span class="path8"></span>
                                        <span class="path9"></span>
                                        <span class="path10"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-moon fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-screen fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div> --}}
                <!--end::Theme mode-->
                <!--begin::User menu-->
                <!--begin::Language menu-->
                <!--begin::Language menu-->
                <style>
                    .customer-navbar-item {
                        margin-left: 10px;
                    }

                    .customer-btn {
                        margin-top: 20px !important;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        background: #f9f9f9;
                        transition: 0.2s;
                    }

                    .customer-btn:hover {
                        background: #e9ecef;
                    }

                    .customer-menu .menu-item button {
                        width: 100%;
                        text-align: left;
                        border: none;
                        background: transparent;
                        padding: 8px 12px;
                        cursor: pointer;
                    }

                    .customer-btn .fw-semibold {
                        color: #7e8299 !important;
                    }

                    .customer-btn .fw-semibold:hover {
                        color: #2563eb !important;
                    }

                    .customer-menu .menu-item button.active {
                        background: #2563eb;
                        color: #fff;
                        border-radius: 4px;
                    }

                    .customer-menu .menu-item button:hover {
                        background: #e5e7eb;
                    }
                </style>
                @php
                    $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                    $currentBranchId = session('branch_id');
                @endphp

                @if ($branchInfo && count($branchInfo) >= 2)
                    <div class="customer-navbar-item ms-1 ms-md-3">
                        <!-- Dropdown Menu toggle -->
                        <a href="#" class="customer-btn btn-light d-flex align-items-center gap-2 px-3 py-2"
                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <i class="fas fa-code-branch fs-5"></i>
                            <span class="fw-semibold">
                                {{ $currentBranchId == 0 ? 'Central Branch' : $branchInfo->firstWhere('id', $currentBranchId)->name ?? 'Select Branch' }}
                            </span>
                            <i class="fas fa-chevron-down fs-6"></i>
                        </a>

                        <!-- Dropdown Menu -->
                        <div class="customer-menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500
                              menu-active-bg menu-state-color fw-semibold py-2 fs-7 w-200px"
                            data-kt-menu="true">

                            <form id="branchForm" action="{{ route('admin.branch.assign.update') }}" method="POST">
                                @csrf
                                @if ($isSuperAdmin)
                                    <div class="menu-item">
                                        <button type="submit" name="branch_id" value="0"
                                            class="menu-link px-3 py-2 d-flex align-items-center gap-2 btn {{ $currentBranchId == 0 ? 'active' : '' }}">
                                            <i class="fas fa-flag-usa fs-6"></i>
                                            <span>Central Branch</span>
                                        </button>
                                    </div>
                                @endif

                                @foreach ($branchInfo as $item)
                                    <div class="menu-item">
                                        <button type="submit" name="branch_id" value="{{ $item->id }}"
                                            class="menu-link px-3 py-2 d-flex align-items-center gap-2 btn {{ $currentBranchId == $item->id ? 'active' : '' }}">
                                            <i class="fas fa-flag fs-6"></i>
                                            <span>{{ $item->name }}</span>
                                        </button>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                @endif




                <div class="app-navbar-item ms-1 ms-md-3">
                    <!-- Menu toggle button -->
                    <a href="#"
                        class="btn btn-light btn-active-light-primary d-flex align-items-center gap-2 px-3 py-2"
                        data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

                        <!-- Font Awesome icon -->
                        <i class="fas fa-language fs-5"></i>

                        <!-- Text -->
                        <span class="fw-semibold"> {{ strtoupper(app()->getLocale()) }}</span>

                        <!-- Dropdown arrow -->
                        <i class="fas fa-chevron-down fs-6"></i>
                    </a>

                    <!-- Dropdown Menu -->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500
                          menu-active-bg menu-state-color fw-semibold py-2 fs-7 w-150px"
                        data-kt-menu="true">

                        <!-- Option 1 -->
                        <div class="menu-item">
                            <a href="{{ route('change.language', 'en') }}"
                                class="menu-link px-3 py-2 d-flex align-items-center gap-2">
                                <i class="fas fa-flag-usa fs-6"></i>
                                <span>English</span>
                            </a>
                        </div>

                        <!-- Option 2 -->
                        <div class="menu-item">
                            <a href="{{ route('change.language', 'bn') }}"
                                class="menu-link px-3 py-2 d-flex align-items-center gap-2">
                                <i class="fas fa-flag fs-6"></i>
                                <span>বাংলা</span>
                            </a>
                        </div>

                        <!-- Option 3 -->
                        <div class="menu-item">
                            <a href="{{ route('change.language', 'ar') }}"
                                class="menu-link px-3 py-2 d-flex align-items-center gap-2">
                                <i class="fas fa-flag fs-6"></i>
                                <span>العربية</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--end::Language menu-->

                <!--end::Language menu-->

                <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <img src="{{ asset('uploads/users/' . auth()->user()->photo) }}"
                            alt="{{ auth()->user()->name }}" />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="{{ auth()->user()->name }}"
                                        src="{{ asset('uploads/users/' . auth()->user()->photo) }}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{ auth()->user()->name }}
                                        {{--                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span> --}}
                                    </div>
                                    <a href="#"
                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->

                        {{-- @if (check_permission(['profile.view']))
                            <div class="menu-item px-5">
                                <a href="{{ route('admin.user.profile') }}" class="menu-link px-5">My Profile</a>
                            </div>
                        @endif --}}
                        <!--end::Menu item-->

                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('admin.logout') }}"
                                class="menu-link px-5">{{ __('messages.sign_out') }}</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                        id="kt_app_header_menu_toggle">
                        <i class="ki-duotone ki-element-4 fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
