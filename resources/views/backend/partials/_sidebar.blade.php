<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        @php
            $company = \App\Models\GeneralSetting::first();
            $companyName = $company ? $company->name : '';
            $companyLogo = $company ? $company->logo : '';
            $branchId = session('branch_id'); // session থেকে branch_id নিলাম
            $branch = \App\Models\Branch::find($branchId);
            $branchName = $branch ? $branch->name : '';

            $user = auth()->user(); // logged-in user
            $userName = $user->name ?? '';
            $userImage = $user->photo;
        @endphp
        <a href="{{ route('admin.dashboard') }}">
            <img alt="Logo" src="{{ asset('uploads/logo/' . $companyLogo) }}"
                class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('uploads/logo/' . $companyLogo) }}"
                class="h-20px app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <!--begin::Minimized sidebar setup:
if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
    1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
    2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
    3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
    4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
}
-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-double-left fs-2 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y " data-kt-scroll="true"
            data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div class="menu-item">
                    <div
                        style="display: flex;
                flex-direction: column;
                align-items: center;
                padding: 15px 10px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 10px;
                margin: 10px 0;">
                        <!-- User Info Section -->
                        <div style="display: flex; align-items: center; width: 100%; margin-bottom: 10px;">
                            @if ($userImage)
                                <img src="{{ asset('uploads/users/' . $userImage) }}" alt="User Image"
                                    style="width: 40px;
                                    height: 40px;
                                    border-radius: 50%;
                                    object-fit: cover;
                                    margin-right: 12px;
                                    flex-shrink: 0;
                                    border: 2px solid rgba(255, 255, 255, 0.3);">
                            @else
                                <img src="{{ asset('uploads/default.png') }}" alt="User Image"
                                    style="width: 40px;
                                    height: 40px;
                                    border-radius: 50%;
                                    object-fit: cover;
                                    margin-right: 12px;
                                    flex-shrink: 0;
                                    border: 2px solid rgba(255, 255, 255, 0.3);">
                            @endif
                            <!-- User Image -->


                            <!-- User Name -->
                            <span class="menu-title text-white"
                                style="font-size: 16px;
                         font-weight: 600;
                         line-height: 1.3;
                         word-break: break-word;">
                                {{ $userName }}
                            </span>
                        </div>

                        <!-- Branch Name -->
                        <span class="menu-title text-white text-center"
                            style="font-size: 18px;
                     font-weight: 700;
                     margin-top: 5px;
                     word-break: break-word;">
                            {{ $branchName }}
                        </span>
                    </div>
                </div>





                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('messages.settings') }}</span>
                    </div>
                    <!--end:Menu content-->
                </div>

                @if (check_permission(['dashboard']))
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('admin') ? ' active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-element-11 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">{{ __('messages.dashboard') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endif

                @if (check_permission(['purchase.list', 'purchase.create', 'purchase.edit', 'purchase.delete', 'purchase.status']))


                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('purchase-payment-list') || request()->routeIs('due.payment') || request()->routeIs('purchase.form') || request()->routeIs('purchase.index') || request()->routeIs('purchase.create') || request()->routeIs('purchase.edit') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.purchase_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            @if (check_permission(['purchase.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('purchase.form') ? ' active' : '' }}"
                                        href="{{ route('purchase.form') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.purchase_form') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['purchase.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('purchase.index') ? ' active' : '' }}"
                                        href="{{ route('purchase.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.purchase_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('due.payment') ? ' active' : '' }}"
                                    href="{{ route('due.payment') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.purchase') }}
                                        {{ __('messages.due_payment') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('purchase-payment-list') ? ' active' : '' }}"
                                    href="{{ route('purchase-payment-list') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.purchase') }}
                                        {{ __('messages.payment_list') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>




                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if (check_permission(['sale.create', 'sale.delete', 'sale.list', 'sale.due.payment']))


                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('sale.form') || request()->routeIs('sale-payment-list') || request()->routeIs('sale.due.payment') || request()->routeIs('sale.list') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-credit-card"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.sales_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            @if (check_permission(['sale.create']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('sale.form') ? ' active' : '' }}"
                                        href="{{ route('sale.form') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.sale_form') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['sale.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('sale.list') ? ' active' : '' }}"
                                        href="{{ route('sale.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.sale_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['sale.due.payment']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('sale.due.payment') ? ' active' : '' }}"
                                        href="{{ route('sale.due.payment') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.sale') }}
                                            {{ __('messages.due_payment') }} </span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('sale-payment-list') ? ' active' : '' }}"
                                    href="{{ route('sale-payment-list') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.payment_list') }} </span>
                                </a>
                                <!--end:Menu link-->
                            </div>


                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif


                @if (check_permission([
                        'expense-head.list',
                        'expense-head.create',
                        'expense-head.edit',
                        'expense-head.delete',
                        'expense-head.status',
                        'expense.list',
                        'expense.create',
                        'expense.edit',
                        'expense.delete',
                        'expense.status',
                    ]))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('expense-head.index') || request()->routeIs('expense.index') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.expense_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            @if (check_permission(['expense-head.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('expense-head.index') ? ' active' : '' }}"
                                        href="{{ route('expense-head.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.expense_head') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif

                            @if (check_permission(['expense.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('expense.index') ? ' active' : '' }}"
                                        href="{{ route('expense.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.expense') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif



                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif


                @if (check_permission(['fund-transfer.list', 'fund-transfer.delete', 'fund-receive-list', 'fund-transfer.create']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('fund.transfer.list') || request()->routeIs('fund-transfer') || request()->routeIs('fund.receive.list') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-arrows-rotate"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.fund_transfer') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            @if (check_permission(['fund-transfer.create']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('fund-transfer') ? ' active' : '' }}"
                                        href="{{ route('fund-transfer') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.fund_transfer') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['fund-transfer.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('fund.transfer.list') ? ' active' : '' }}"
                                        href="{{ route('fund.transfer.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.fund_transfer_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['fund-receive-list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('fund.receive.list') ? ' active' : '' }}"
                                        href="{{ route('fund.receive.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.fund_receive_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif

                            <!--begin:Menu item-->


                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif

                @if (check_permission([
                        'fund.list',
                        'fund.create',
                        'fund.edit',
                        'fund.delete',
                        'fund.status',
                        'bank.list',
                        'bank.create',
                        'bank.edit',
                        'bank.delete',
                        'bank.status',
                        'bank-account.list',
                        'bank-account.create',
                        'bank-account.edit',
                        'bank-account.delete',
                        'bank-account.status',
                        'bank_branch.list',
                        'bank_branch.create',
                        'bank_branch.edit',
                        'bank_branch.delete',
                        'bank_branch.status',
                        'fund-adjustment.list',
                        'fund-adjustment.create',
                    ]))


                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('bank-branch.index') || request()->routeIs('fund-adjustment.index') || request()->routeIs('fund-adjustment.form') || request()->routeIs('fund.current_balance') || request()->routeIs('fund.index') || request()->routeIs('bank.index') || request()->routeIs('branch.index') || request()->routeIs('bank-account.index') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.fund_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('fund.current_balance') ? ' active' : '' }}"
                                    href="{{ route('fund.current_balance') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.fund') }}
                                        {{ __('messages.current_balance') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            @if (check_permission(['fund-adjustment.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('fund-adjustment.form') ? ' active' : '' }}"
                                        href="{{ route('fund-adjustment.form') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.fund_adjustment') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['fund-adjustment.create']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('fund-adjustment.index') ? ' active' : '' }}"
                                        href="{{ route('fund-adjustment.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.fund_adjustment_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['fund.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('fund.index') ? ' active' : '' }}"
                                        href="{{ route('fund.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.fund_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['bank.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('bank.index') ? ' active' : '' }}"
                                        href="{{ route('bank.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.bank_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['bank_branch.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('bank-branch.index') ? ' active' : '' }}"
                                        href="{{ route('bank-branch.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.bank_branch_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['bank-account.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('bank-account.index') ? ' active' : '' }}"
                                        href="{{ route('bank-account.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.bank_account_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif



                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if (check_permission([
                        'category.list',
                        'category.create',
                        'category.edit',
                        'category.delete',
                        'category.status',
                        'sub_category.list',
                        'sub_category.create',
                        'sub_category.edit',
                        'sub_category.delete',
                        'sub_category.status',
                        'unit.list',
                        'unit.create',
                        'unit.edit',
                        'unit.delete',
                        'unit.status',
                        'brand.list',
                        'brand.create',
                        'brand.edit',
                        'brand.delete',
                        'brand.status',
                        'color.list',
                        'color.create',
                        'color.edit',
                        'color.delete',
                        'color.status',
                        'size.list',
                        'size.create',
                        'size.edit',
                        'size.delete',
                        'size.status',
                    ]))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('category.index') || request()->routeIs('product.index') || request()->routeIs('product.edit') || request()->routeIs('product.create') || request()->routeIs('sub-category.index') || request()->routeIs('unit.index') || request()->routeIs('brand.index') || request()->routeIs('color.index') || request()->routeIs('size.index') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-gear fa-2x"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.product_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            @if (check_permission(['product.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('product.index') || request()->routeIs('product.edit') || request()->routeIs('product.create') ? ' active' : '' }}"
                                        href="{{ route('product.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.product_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['category.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('category.index') ? ' active' : '' }}"
                                        href="{{ route('category.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.category') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['sub_category.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('sub-category.index') ? ' active' : '' }}"
                                        href="{{ route('sub-category.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.sub_category') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['unit.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('unit.index') ? ' active' : '' }}"
                                        href="{{ route('unit.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.unit') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['brand.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('brand.index') ? ' active' : '' }}"
                                        href="{{ route('brand.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.brand') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['size.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('size.index') ? ' active' : '' }}"
                                        href="{{ route('size.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.size') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['color.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('color.index') ? ' active' : '' }}"
                                        href="{{ route('color.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.color') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif


                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif




                @if (check_permission([
                        'product-transfer.list',
                        'product-transfer.create',
                        'product-transfer.edit',
                        'product-transfer.delete',
                        'product-transfer.status',
                        'transfer-list',
                        'recived-list',
                    ]))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('product.transfer.form') || request()->routeIs('transfer.list') || request()->routeIs('transfer.received.list') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-box"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.transfer') }}
                                {{ __('messages.product') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            @if (check_permission(['product-transfer.create']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('product.transfer.form') ? ' active' : '' }}"
                                        href="{{ route('product.transfer.form') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.transfer') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['transfer-list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('transfer.list') ? ' active' : '' }}"
                                        href="{{ route('transfer.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.transfer_list') }} </span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['recived-list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('transfer.received.list') ? ' active' : '' }}"
                                        href="{{ route('transfer.received.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.received_list') }} </span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if (check_permission(['stock-report', 'purchase-report', 'sale-report', 'customer-report', 'fund-history-report']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('stock-report') || request()->routeIs('profit-report') || request()->routeIs('fund-history-report') || request()->routeIs('customer-report') || request()->routeIs('purchase-report') || request()->routeIs('sale-report') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-chart-area"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.report') }}
                            </span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        @if (check_permission(['stock-report']))
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('stock-report') ? ' active' : '' }}"
                                        href="{{ route('stock-report') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.stock_report') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>

                            </div>
                        @endif
                        @if (check_permission(['purchase-report']))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('purchase-report') ? ' active' : '' }}"
                                        href="{{ route('purchase-report') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.purchase_report') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>

                            </div>
                        @endif
                        @if (check_permission(['sale-report']))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('sale-report') ? ' active' : '' }}"
                                        href="{{ route('sale-report') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.sale_report') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            </div>
                        @endif
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('profit-report') ? ' active' : '' }}"
                                    href="{{ route('profit-report') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.profit_report') }}
                                    </span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                        @if (check_permission(['customer-report']))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('customer-report') ? ' active' : '' }}"
                                        href="{{ route('customer-report') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.customer') }}
                                            {{ __('messages.report') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            </div>
                        @endif
                        @if (check_permission(['fund-history-report']))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('fund-history-report') ? ' active' : '' }}"
                                        href="{{ route('fund-history-report') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.fund_history') }}
                                        </span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            </div>
                        @endif
                        <!--end:Menu sub-->
                    </div>
                @endif




                @if (check_permission(['supplier.list', 'supplier.create', 'supplier.edit', 'supplier.delete', 'supplier.status']))


                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('supplier.index') || request()->routeIs('supplier-due-payment-list') || request()->routeIs('supplier.due.payment') || request()->routeIs('supplier.create') || request()->routeIs('supplier.edit') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.supplier_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            @if (check_permission(['supplier.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('supplier.index') ? ' active' : '' }}"
                                        href="{{ route('supplier.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.supplier_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif

                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('supplier.due.payment') ? ' active' : '' }}"
                                    href="{{ route('supplier.due.payment') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.opening') }} {{ __('messages.due') }}
                                        {{ __('messages.payment') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('supplier-due-payment-list') ? ' active' : '' }}"
                                    href="{{ route('supplier-due-payment-list') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.payment_list') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>


                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if (check_permission([
                        'district.list',
                        'district.create',
                        'district.edit',
                        'district.delete',
                        'district.status',
                        'customer-information.list',
                        'customer-information.create',
                        'customer-information.edit',
                        'customer-information.delete',
                        'customer-information.status',
                    ]))


                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('customer-information.index') || request()->routeIs('customer-due-payment-list') || request()->routeIs('customer.due.payment') || request()->routeIs('customer-information.create') || request()->routeIs('customer-information.edit') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.customer_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">

                            @if (check_permission(['customer-information.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('customer-information.index') || request()->routeIs('customer-information.create') || request()->routeIs('customer-information.edit') ? ' active' : '' }}"
                                        href="{{ route('customer-information.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.customer_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('customer.due.payment') ? ' active' : '' }}"
                                    href="{{ route('customer.due.payment') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.opening') }} {{ __('messages.due') }}
                                        {{ __('messages.payment') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->routeIs('customer-due-payment-list') ? ' active' : '' }}"
                                    href="{{ route('customer-due-payment-list') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('messages.payment_list') }}
                                    </span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif




                @if (check_permission([
                        'user.list',
                        'user.create',
                        'user.edit',
                        'user.delete',
                        'role.list',
                        'role.create',
                        'role.edit',
                        'role.delete',
                        'role.permissions',
                    ]))


                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('admin.user') || request()->routeIs('admin.role') || request()->routeIs('admin.role.create') || request()->routeIs('admin.role.edit') || request()->routeIs('admin.role.permissions') || request()->routeIs('admin.user') || request()->routeIs('admin.user.create') || request()->routeIs('admin.user.edit') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-users fa-2x"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.user_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">

                            @if (check_permission(['user.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('admin.user') || request()->routeIs('admin.user.edit') ? ' active' : '' }}"
                                        href="{{ route('admin.user') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.user_list') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['user.create']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('admin.user.create') ? ' active' : '' }}"
                                        href="{{ route('admin.user.create') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.create_new_user') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['role.list', 'role.create', 'role.edit', 'role.delete']))
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click"
                                    class="menu-item menu-accordion {{ request()->routeIs('admin.role.create') || request()->routeIs('admin.role') || request()->routeIs('admin.role.edit') ? ' show' : '' }}">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.roles_management') }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <!--begin:Menu item-->

                                        @if (check_permission(['role.list']))
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ request()->routeIs('admin.role') || request()->routeIs('admin.role.edit') ? ' active' : '' }}"
                                                    href="{{ route('admin.role') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">{{ __('messages.roles_list') }}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endif
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->

                                        @if (check_permission(['role.create']))
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ request()->is('admin/roles/create') ? ' active' : '' }}"
                                                    href="{{ route('admin.role.create') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span
                                                        class="menu-title">{{ __('messages.create_new_role') }}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endif
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                            <!--begin:Menu item-->


                            @if (check_permission(['role.permissions']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->is('admin/roles/permissions') ? ' active' : '' }}"
                                        href="{{ route('admin.role.permissions') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.permissions') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if (check_permission([
                        'general.settings',
                        'branch.list',
                        'branch.create',
                        'branch.edit',
                        'branch.delete',
                        'branch.status',
                        'currency.list',
                        'currency.create',
                        'currency.edit',
                        'currency.delete',
                        'currency.status',
                    ]))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('admin.user.profile') || request()->routeIs('admin.user.profile.edit') || request()->is('admin/settings/general', 'admin/settings/slider', 'admin/contact') || request()->routeIs('branch.index') ? ' show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa-solid fa-gear fa-2x"></i>
                            </span>
                            <span class="menu-title">{{ __('messages.settings') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            {{-- @if (check_permission(['profile.view']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('admin.user.profile') || request()->routeIs('admin.user.profile.edit') ? ' active' : '' }}"
                                        href="{{ route('admin.user.profile') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Profile</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif --}}
                            @if (check_permission(['branch.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('branch.index') ? ' active' : '' }}"
                                        href="{{ route('branch.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.branch') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['currency.list']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('currency.index') ? ' active' : '' }}"
                                        href="{{ route('currency.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.currency') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['profile.view']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('admin.user.profile') || request()->routeIs('admin.user.profile.edit') ? ' active' : '' }}"
                                        href="{{ route('admin.user.profile') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.profile') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            @if (check_permission(['general.settings']))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->is('admin/settings/general') ? ' active' : '' }}"
                                        href="{{ route('admin.setting.general') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('messages.general_settings') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif

                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endif



                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    {{-- <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a href="{{ route('admin.dashboard') }}"
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Dashboard">
            <span class="btn-label">Dashboard</span>
            <i class="ki-duotone ki-document btn-icon fs-2 m-0">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </a>
    </div> --}}
    <!--end::Footer-->
</div>
