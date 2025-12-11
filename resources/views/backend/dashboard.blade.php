@extends('layouts.backend')

@section('main')
    <style>
        .my-button {
            color: white;
            border: 1px solid white !important;
            padding: 4px 15px !important;
        }

        .my-button:hover {
            color: black;
            border-color: black;
        }

        .card-icon {
            color: white !important;
            font-size: 30px !important;
        }

        .card-background-icon {
            font-size: 90px !important;
            color: white !important;
        }

        .product-summary-card {
            background: linear-gradient(135deg, #ff5c5c, #ff7b7b);
            color: white;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .product-summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .dashboard-section-title {
            font-weight: 700;
            color: #444;
            margin-bottom: 20px;
            border-left: 5px solid #ff3b3b;
            padding-left: 10px;
        }

        .branch-card {
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .branch-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .branch-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0 0 0 100%;
        }

        .branch-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            background: green;
            padding: 4px;
            border-radius: 5px;
        }

        .sale-info {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
        }

        .sale-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .sale-amount {
            font-size: 24px;
            font-weight: 800;
            color: #000000;
            font-size: 12px;
            opacity: 0.9;
        }

        .summary-card {
            border-radius: 12px;
            padding: 25px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .summary-card::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .summary-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .summary-value {
            font-size: 32px;
            font-weight: 800;
        }
    </style>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-5 g-xl-10 mb-2 mt-4">
                <div class="col-12">
                    <h5 class="dashboard-section-title"
                        style="font-weight: 700; color: #ff3b3b; font-size: 18px; border-left: 5px solid #ff3b3b;
                       padding-left: 12px; background: #fff3f3; border-radius: 6px; padding-top: 8px; padding-bottom: 8px;">
                        {{ __('messages.dashboard') }}
                    </h5>
                </div>
            </div>

            <div class="row g-5 g-xl-10 mb-5 mb-xl-10 mt-4">
                @php
                    $branchId = session('branch_id');
                @endphp
                @php
                    $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                    $sessionBranch = session('branch_id');
                @endphp
                @if ($isSuperAdmin && !$sessionBranch)
                    <div class="col-md-4 col-xl-3 mt-0">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: #ff3b3b; color: white; padding: 15px; border-radius: 6px;">
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-images fa-8x"></i>
                            </div>
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.total') }} {{ __('messages.product') }}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 36px;">
                                        {{ optional($products)->count() ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                            <div class="position-absolute" style="bottom: -15px; right: -15px; opacity: 0.1;">
                                <i class="fas fa-wrench card-background-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-xl-3 mt-0">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #6f42c1, #6610f2); color: white; padding: 15px; border-radius: 6px;">
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-users fa-8x"></i>
                            </div>
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.total') }} {{ __('messages.supplier') }}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 36px;">
                                        {{ optional($suppliers)->count() ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                            <div class="position-absolute" style="bottom: -15px; right: -15px; opacity: 0.1;">
                                <i class="fas fa-user-circle card-background-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-xl-3 mt-0">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #28a745, #218838); color: white; padding: 15px; border-radius: 6px;">
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-cogs fa-8x"></i>
                            </div>
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.total') }} {{ __('messages.customer') }}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 36px;">
                                        {{ optional($customers)->count() ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                            <div class="position-absolute" style="bottom: -15px; right: -15px; opacity: 0.1;">
                                <i class="fas fa-receipt card-background-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-xl-3 mt-0">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 15px; border-radius: 6px;">
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-users fa-8x"></i>
                            </div>
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.general_settings') }}
                                    </h6>
                                </div>
                                <a href="{{ route('admin.setting.general') }}" style="margin-top:22px"
                                    class="btn btn-outline-light my-button">
                                    View
                                </a>
                            </div>
                            <div class="position-absolute" style="bottom: -15px; right: -15px; opacity: 0.1;">
                                <i class="fas fa-user-circle card-background-icon"></i>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-4 col-xl-3 mt-0">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: #ff3b3b; color: white; padding: 15px; border-radius: 6px;">
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-images fa-8x"></i>
                            </div>
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.total') }} {{ __('messages.product') }}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 36px;">
                                        {{ optional($products)->count() ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                            <div class="position-absolute" style="bottom: -15px; right: -15px; opacity: 0.1;">
                                <i class="fas fa-wrench card-background-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-xl-3 mt-0">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #6f42c1, #6610f2); color: white; padding: 15px; border-radius: 6px;">
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-users fa-8x"></i>
                            </div>
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.total') }} {{ __('messages.supplier') }}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 36px;">
                                        {{ optional($suppliers)->count() ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                            <div class="position-absolute" style="bottom: -15px; right: -15px; opacity: 0.1;">
                                <i class="fas fa-user-circle card-background-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-xl-3 mt-0">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #28a745, #218838); color: white; padding: 15px; border-radius: 6px;">
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-cogs fa-8x"></i>
                            </div>
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.total') }} {{ __('messages.customer') }}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 36px;">
                                        {{ optional($customers)->count() ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                            <div class="position-absolute" style="bottom: -15px; right: -15px; opacity: 0.1;">
                                <i class="fas fa-receipt card-background-icon"></i>
                            </div>
                        </div>
                    </div>
                @endif



                @if ($isSuperAdmin && !$sessionBranch)
                    <!-- Branch Cards Section -->
                    <div class="col-12">
                        {{-- <h5 class="dashboard-section-title"
                            style="font-weight: 700; color: #2c3e50; font-size: 18px; border-left: 5px solid #3498db;
                           padding-left: 12px; background: #ecf7ff; border-radius: 6px; padding-top: 8px; padding-bottom: 8px; margin-bottom: 20px;">
                            <i class="fas fa-store me-2"></i>Branch Wise Sales Report
                        </h5> --}}

                        <div class="row g-4">
                            @php
                                $colors = [
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                ];
                            @endphp
                            <div class="col-md-6 col-lg-4 col-xl-4">
                                <div class="branch-card" style="background: #ffffff">
                                    <div class="branch-name">
                                        <i class="fas fa-map-marker-alt me-2"></i>{{ __('messages.all_branch') }}
                                    </div>
                                    <div class="sale-info">
                                        <div class="sale-label">
                                            <i class="fas fa-list me-1"></i>{{ __('messages.total_sales') }}
                                        </div>
                                        <div class="sale-amount">{{ $todaySaleCount }}</div>
                                    </div>

                                    <div class="sale-info">
                                        <div class="sale-label">
                                            <i class="fas fa-sun me-1"></i>{{ __('messages.today_sale_amount') }}
                                        </div>
                                        <div class="sale-amount">{{ number_format($todaySale, 2) }}</div>
                                    </div>

                                    <div class="sale-info">
                                        <div class="sale-label">
                                            <i class="fas fa-list me-1"></i>{{ __('messages.monthly_sale') }}
                                        </div>
                                        <div class="sale-amount">{{ $monthlySaleCount }}</div>
                                    </div>

                                    <div class="sale-info" style="margin-bottom: 0;">
                                        <div class="sale-label">
                                            <i class="fas fa-calendar me-1"></i>{{ __('messages.monthly_sale_amount') }}
                                        </div>
                                        <div class="sale-amount">{{ number_format($monthlySale, 2) }}</div>
                                    </div>

                                    <div class="sale-info">
                                        <div class="sale-label">
                                            <i class="fas fa-chart-line me-1"></i>{{ __('messages.monthly_avg_sale') }}
                                        </div>
                                        <div class="sale-amount">{{ number_format($monthlyAverageSale, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                            @foreach ($branchSales as $index => $row)
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="branch-card" style="background: {{ $colors[$index % count($colors)] }}">
                                        <div class="branch-name">
                                            <i class="fas fa-map-marker-alt me-2"></i>{{ $row->name }}
                                        </div>
                                        <div class="sale-info">
                                            <div class="sale-label"><i class="fas fa-list me-1"></i>Today Sale</div>
                                            <div class="sale-amount">{{ $row->today_sale_count }}</div>
                                        </div>
                                        <div class="sale-info">
                                            <div class="sale-label">
                                                <i class="fas fa-sun me-1"></i>{{ __('messages.today_sale_amount') }}
                                            </div>
                                            <div class="sale-amount"> {{ number_format($row->today_sale, 2) }}</div>
                                        </div>
                                        <div class="sale-info">
                                            <div class="sale-label"><i
                                                    class="fas fa-list me-1"></i>{{ __('messages.monthly_sale') }}
                                            </div>
                                            <div class="sale-amount">{{ $row->monthly_sale_count }}</div>
                                        </div>
                                        <div class="sale-info" style="margin-bottom: 0;">
                                            <div class="sale-label">
                                                <i
                                                    class="fas fa-calendar me-1"></i>{{ __('messages.monthly_sale_amount') }}
                                            </div>
                                            <div class="sale-amount"> {{ number_format($row->monthly_sale, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-md-4 col-xl-3 mt-4">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 20px; border-radius: 6px;">

                            <!-- Background Icon -->
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-money-bill-wave fa-8x"></i>
                            </div>

                            <!-- Card Content -->
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        Today Sale
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 20px;">
                                        {{ number_format($todaySale, 2) }}
                                    </h2>
                                    <span class="fs-2 fw-bold">৳</span>
                                </div>
                            </div>

                            <div class="position-absolute" style="bottom: -10px; right: -10px; opacity: 0.1;">
                                <i class="fas fa-coins card-background-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-3 mt-4">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #20c997, #198754); color: white; padding: 20px; border-radius: 6px;">

                            <!-- Background Icon -->
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-chart-line fa-8x"></i>
                            </div>

                            <!-- Card Content -->
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        {{ __('messages.monthly_sale') }}
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 20px;">
                                        {{ number_format($monthlySale, 2) }}
                                    </h2>
                                    <span class="fs-2 fw-bold">৳</span>
                                </div>
                            </div>

                            <div class="position-absolute" style="bottom: -10px; right: -10px; opacity: 0.1;">
                                <i class="fas fa-coins card-background-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-3 mt-4">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #fd7e14, #fd5500); color: white; padding: 20px; border-radius: 6px;">

                            <!-- Background Icon -->
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-shopping-cart fa-8x"></i>
                            </div>

                            <!-- Card Content -->
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        Today Purchase
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 20px;">
                                        {{ number_format($todaypurchase, 2) }}
                                    </h2>
                                    <span class="fs-2 fw-bold">৳</span>
                                </div>
                            </div>

                            <div class="position-absolute" style="bottom: -10px; right: -10px; opacity: 0.1;">
                                <i class="fas fa-coins card-background-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-3 mt-4">
                        <div class="card shadow-sm border-0 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #17a2b8, #117a8b); color: white; padding: 20px; border-radius: 6px;">

                            <!-- Background Icon -->
                            <div class="position-absolute" style="top: -5px; right: -5px; opacity: 0.1;">
                                <i class="fas fa-hand-holding-usd fa-8x"></i>
                            </div>

                            <!-- Card Content -->
                            <div class="card-body" style="padding: 5px!important">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-uppercase fw-bold mb-3 text-white"
                                        style="letter-spacing: 0.5px; font-size: 14px;">
                                        Monthly Purchase
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="fw-bold mb-3 text-white" style="font-size: 20px;">
                                        {{ number_format($monthlypurchase, 2) }}
                                    </h2>
                                    <span class="fs-2 fw-bold">৳</span>
                                </div>
                            </div>

                            <div class="position-absolute" style="bottom: -10px; right: -10px; opacity: 0.1;">
                                <i class="fas fa-coins card-background-icon"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
