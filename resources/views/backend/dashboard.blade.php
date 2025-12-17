@extends('layouts.backend')

@section('main')
    <style>
        .app-container {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

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


                <style>
                    /* Stock Table Modern Styling - শুধুমাত্র CSS */

                    /* Table Container */
                    #stockTable {
                        width: 100%;
                        border-collapse: separate;
                        border-spacing: 0;
                        background: white;
                        border-radius: 12px;
                        overflow: hidden;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        margin-top: 10px;
                        border: 1px solid #e2e8f0;
                        animation: fadeInTable 0.5s ease;
                    }

                    /* Table Header Styling */
                    #stockTable thead {
                        background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
                        position: sticky;
                        top: 0;
                        z-index: 10;
                    }

                    #stockTable thead th {
                        padding: 18px 16px;
                        text-align: center;
                        font-weight: 600;
                        color: white;
                        font-size: 13px;
                        text-transform: uppercase;
                        letter-spacing: 0.8px;
                        border-bottom: 3px solid #667eea;
                        white-space: normal !important;
                        vertical-align: middle;
                    }

                    #stockTable thead th:first-child {
                        border-top-left-radius: 12px;
                    }

                    #stockTable thead th:last-child {
                        border-top-right-radius: 12px;
                    }

                    /* Table Body Rows */
                    #stockTable tbody tr {
                        transition: all 0.3s ease;
                        border-bottom: 1px solid #e2e8f0;
                        background: white;
                    }

                    #stockTable tbody tr:nth-child(even) {
                        background: #f8fafc;
                    }

                    #stockTable tbody tr:hover {
                        background: linear-gradient(90deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
                        transform: translateX(4px);
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }

                    /* Table Body Cells */
                    #stockTable tbody td {
                        padding: 16px 14px;
                        text-align: center;
                        color: #4a5568;
                        font-size: 14px;
                        border-right: 1px solid #f0f0f0;
                        vertical-align: middle;
                        font-weight: 500;
                    }

                    #stockTable tbody td:last-child {
                        border-right: none;
                    }

                    #stockTable tbody td:first-child {
                        font-weight: 600;
                        color: #2d3748;
                    }

                    /* Stock Numbers Styling */
                    #stockTable tbody td:nth-child(6),
                    #stockTable tbody td:nth-child(7),
                    #stockTable tbody td:nth-child(8),
                    #stockTable tbody td:nth-child(9),
                    #stockTable tbody td:nth-child(10) {
                        font-weight: 700;
                        font-size: 15px;
                    }

                    /* Stock Level Classes */
                    .stock-high {
                        color: #48bb78;
                        background: rgba(72, 187, 120, 0.1);
                        padding: 6px 12px;
                        border-radius: 6px;
                    }

                    .stock-medium {
                        color: #ed8936;
                        background: rgba(237, 137, 54, 0.1);
                        padding: 6px 12px;
                        border-radius: 6px;
                    }

                    .stock-low {
                        color: #f56565;
                        background: rgba(245, 101, 101, 0.1);
                        padding: 6px 12px;
                        border-radius: 6px;
                    }

                    /* Current Stock Column (Last Column) Special Styling */
                    #stockTable tbody td:last-child {
                        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
                        font-weight: 700;
                        font-size: 16px;
                        color: #667eea;
                    }

                    /* Empty State Styling */
                    #stockTable tbody:empty::after {
                        content: "No data available";
                        display: block;
                        text-align: center;
                        padding: 40px;
                        color: #a0aec0;
                        font-size: 16px;
                        font-weight: 500;
                    }

                    /* Animation */
                    @keyframes fadeInTable {
                        from {
                            opacity: 0;
                            transform: translateY(20px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                    /* Scrollbar Styling */
                    .table-responsive::-webkit-scrollbar {
                        height: 8px;
                    }

                    .table-responsive::-webkit-scrollbar-track {
                        background: #f1f1f1;
                        border-radius: 10px;
                    }

                    .table-responsive::-webkit-scrollbar-thumb {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        border-radius: 10px;
                    }

                    .table-responsive::-webkit-scrollbar-thumb:hover {
                        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
                    }

                    /* ====== RESPONSIVE DESIGN - Smaller Devices ====== */

                    /* Laptop/Desktop (1200px - 1400px) - Slightly smaller */
                    @media (max-width: 1400px) {
                        #stockTable thead th {
                            padding: 14px 12px;
                            font-size: 12px;
                            letter-spacing: 0.6px;
                        }

                        #stockTable tbody td {
                            padding: 14px 10px;
                            font-size: 13px;
                        }

                        #stockTable tbody td:nth-child(6),
                        #stockTable tbody td:nth-child(7),
                        #stockTable tbody td:nth-child(8),
                        #stockTable tbody td:nth-child(9),
                        #stockTable tbody td:nth-child(10) {
                            font-size: 14px;
                        }

                        #stockTable tbody td:last-child {
                            font-size: 15px;
                        }
                    }

                    /* Medium Laptop (992px - 1199px) */
                    @media (max-width: 1199px) {
                        #stockTable thead th {
                            padding: 12px 10px;
                            font-size: 11px;
                            letter-spacing: 0.5px;
                        }

                        #stockTable tbody td {
                            padding: 12px 8px;
                            font-size: 12px;
                        }

                        #stockTable tbody td:nth-child(6),
                        #stockTable tbody td:nth-child(7),
                        #stockTable tbody td:nth-child(8),
                        #stockTable tbody td:nth-child(9),
                        #stockTable tbody td:nth-child(10) {
                            font-size: 13px;
                        }

                        #stockTable tbody td:last-child {
                            font-size: 14px;
                        }

                        .stock-high,
                        .stock-medium,
                        .stock-low {
                            padding: 4px 8px;
                            font-size: 11px;
                        }
                    }

                    /* Tablet/iPad (768px - 991px) */
                    @media (max-width: 991px) {
                        #stockTable {
                            font-size: 11px;
                        }

                        #stockTable thead th {
                            padding: 10px 8px;
                            font-size: 10px;
                            letter-spacing: 0.4px;
                        }

                        #stockTable tbody td {
                            padding: 10px 6px;
                            font-size: 11px;
                        }

                        #stockTable tbody td:nth-child(6),
                        #stockTable tbody td:nth-child(7),
                        #stockTable tbody td:nth-child(8),
                        #stockTable tbody td:nth-child(9),
                        #stockTable tbody td:nth-child(10) {
                            font-size: 12px;
                        }

                        #stockTable tbody td:last-child {
                            font-size: 13px;
                        }

                        .stock-high,
                        .stock-medium,
                        .stock-low {
                            padding: 3px 6px;
                            font-size: 10px;
                        }
                    }

                    /* Mobile (576px - 767px) */
                    @media (max-width: 767px) {
                        #stockTable {
                            font-size: 10px;
                        }

                        #stockTable thead th {
                            padding: 8px 5px;
                            font-size: 9px;
                            letter-spacing: 0.3px;
                        }

                        #stockTable tbody td {
                            padding: 8px 4px;
                            font-size: 10px;
                        }

                        #stockTable tbody td:nth-child(6),
                        #stockTable tbody td:nth-child(7),
                        #stockTable tbody td:nth-child(8),
                        #stockTable tbody td:nth-child(9),
                        #stockTable tbody td:nth-child(10) {
                            font-size: 11px;
                        }

                        #stockTable tbody td:last-child {
                            font-size: 12px;
                        }

                        .stock-high,
                        .stock-medium,
                        .stock-low {
                            padding: 2px 4px;
                            font-size: 9px;
                        }
                    }

                    /* Small Mobile (< 576px) */
                    @media (max-width: 575px) {
                        .table-responsive {
                            overflow-x: auto;
                            -webkit-overflow-scrolling: touch;
                        }

                        #stockTable {
                            min-width: 700px;
                            font-size: 9px;
                        }

                        #stockTable thead th {
                            padding: 6px 4px;
                            font-size: 8px;
                            letter-spacing: 0.2px;
                        }

                        #stockTable tbody td {
                            padding: 6px 3px;
                            font-size: 9px;
                        }

                        #stockTable tbody td:nth-child(6),
                        #stockTable tbody td:nth-child(7),
                        #stockTable tbody td:nth-child(8),
                        #stockTable tbody td:nth-child(9),
                        #stockTable tbody td:nth-child(10) {
                            font-size: 10px;
                        }

                        #stockTable tbody td:last-child {
                            font-size: 11px;
                        }

                        .stock-high,
                        .stock-medium,
                        .stock-low {
                            padding: 2px 3px;
                            font-size: 8px;
                        }

                        /* Make first column sticky on horizontal scroll */
                        #stockTable th:first-child,
                        #stockTable td:first-child {
                            position: sticky;
                            left: 0;
                            background-color: #fff;
                            z-index: 5;
                        }

                        #stockTable thead th:first-child {
                            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
                            z-index: 11;
                        }

                        #stockTable tbody tr:nth-child(even) td:first-child {
                            background: #f8fafc;
                        }
                    }

                    body {
                        background: #f5f7fa;
                        padding: 20px;
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    }

                    .dashboard-card {
                        background: white;
                        border-radius: 12px;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                        border: 1px solid #e5e7eb;
                        transition: all 0.3s ease;
                    }

                    .dashboard-card:hover {
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
                    }

                    .card-header-compact {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        padding: 12px 18px;
                        border-radius: 12px 12px 0 0;
                        border: none;
                    }

                    .card-header-compact h6 {
                        color: white;
                        margin: 0;
                        font-weight: 600;
                        font-size: 0.95rem;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    }

                    .card-body-compact {
                        padding: 18px;
                    }

                    .form-label-compact {
                        font-weight: 500;
                        color: #6b7280;
                        margin-bottom: 6px;
                        font-size: 0.8rem;
                    }

                    .form-control-compact,
                    .form-select-compact {
                        border: 1px solid #d1d5db;
                        border-radius: 8px;
                        padding: 8px 12px;
                        font-size: 0.9rem;
                        transition: all 0.2s ease;
                        height: 38px;
                    }

                    .form-control-compact:focus,
                    .form-select-compact:focus {
                        border-color: #667eea;
                        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                        outline: none;
                    }

                    .btn-search-compact {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        border: none;
                        border-radius: 8px;
                        padding: 8px 20px;
                        font-weight: 500;
                        font-size: 0.9rem;
                        color: white;
                        height: 38px;
                        transition: all 0.2s ease;
                        width: 100%;
                    }

                    .btn-search-compact:hover {
                        transform: translateY(-1px);
                        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
                    }

                    .input-icon-compact {
                        position: absolute;
                        left: 12px;
                        top: 50%;
                        transform: translateY(-50%);
                        color: #9ca3af;
                        font-size: 0.9rem;
                        pointer-events: none;
                    }

                    .form-control-compact.with-icon {
                        padding-left: 35px;
                    }

                    .input-wrapper {
                        position: relative;
                    }

                    @media (max-width: 768px) {
                        .btn-search-compact {
                            margin-top: 8px;
                        }
                    }
                </style>
                <div class="row mt-3">
                    <div class="col-3" style="margin-left: 10px;">
                        <button id="showHistoryBtn" class="btn btn-primary mb-3">
                            Show Product History
                        </button>
                    </div>
                </div>
                <!-- Dashboard Example Container -->
                <div id="productHistoryCard" style="display:none;">
                    <div class="dashboard-card">
                        <div class="card-header-compact d-flex justify-content-between align-items-center">
                            <h6>
                                <i class="fas fa-history"></i>
                                Product History
                            </h6>

                            <!-- Hide Button -->
                            <button id="hideHistoryBtn" class="btn btn-sm btn-danger">
                                <i class="fas fa-times"></i> Hide
                            </button>
                        </div>

                        <div class="card-body-compact">
                            <form method="POST" action="{{ route('product-stock-report') }}" id="searchForm">
                                @csrf
                                <div class="row g-2">
                                    @php
                                        $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                                        $sessionBranch = session('branch_id');
                                    @endphp
                                    @if ($isSuperAdmin && !$sessionBranch)
                                        <div class="col-md-3">
                                            <label for="branch_id" class="form-label mb-1">
                                                {{ __('messages.branch') }}</label>
                                            <select id="branch_id" name="branch_id" class="form-select form-select-sm">
                                                <option value=""> {{ __('messages.select_one') }}</option>
                                                @foreach ($branchInfo as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                        {{ $branch->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <!-- Barcode Input -->
                                    <div class="col-3">
                                        <label for="barcode" class="form-label-compact">Barcode</label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-barcode input-icon-compact"></i>
                                            <input type="text" name="barcode" id="barcode"
                                                class="form-control form-control-compact with-icon"
                                                placeholder="Scan barcode">
                                        </div>
                                    </div>

                                    <!-- Product Select -->
                                    <div class="col-3">
                                        <label for="product_id" class="form-label-compact">Product</label>
                                        <select name="product_id" id="product_id"
                                            class="form-select form-select-compact">
                                            <option value="">All Products</option>
                                            @foreach ($products as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Search Button -->
                                    <div class="col-3 mt-2" style="display: flex; align-items: end">
                                        <button type="submit" class="btn btn-search-compact">
                                            <i class="fas fa-search me-1"></i> Search
                                        </button>
                                    </div>

                                </div>
                            </form>

                            @php
                                $isSuperAdmin = auth()->user()->roles->pluck('name')->contains('Super Admin');
                                $sessionBranch = session('branch_id');
                            @endphp
                            <div class="table-responsive">
                                <table id="stockTable" class="table table-bordered table-hover align-middle text-center"
                                    style="display:none;">
                                    <thead class="table-dark text-white">
                                        <tr>
                                            @if ($isSuperAdmin && !$sessionBranch)
                                                <th> {{ __('messages.branch') }}</th>
                                            @endif
                                            <th> {{ __('messages.product') }} {{ __('messages.code') }}</th>
                                            <th> {{ __('messages.product') }}</th>
                                            <th> {{ __('messages.size') }}</th>
                                            <th> {{ __('messages.color') }}</th>
                                            <th> {{ __('messages.purchase') }} {{ __('messages.stock') }}</th>
                                            <th> {{ __('messages.sale') }} {{ __('messages.stock') }} </th>
                                            <th> {{ __('messages.stock_received') }}</th>
                                            <th> {{ __('messages.stock_transfer') }}</th>
                                            <th> {{ __('messages.current_stock') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>





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
                @endif
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // Show Form
        $('#showHistoryBtn').on('click', function() {
            $('#productHistoryCard').slideDown(); // Show form
            $('#showHistoryBtn').hide(); // Hide button
        });

        // Hide Form
        $('#hideHistoryBtn').on('click', function() {
            $('#productHistoryCard').slideUp(); // Hide form
            $('#showHistoryBtn').show(); // Show button again
        });
    </script>
    <script>
        const showBranchColumn = {{ $isSuperAdmin && !$sessionBranch ? 'true' : 'false' }};
    </script>
    <script>
        $(document).ready(function() {

            // Barcode scan
            $('#barcode').on('keypress', function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    let barcode = $(this).val().trim();
                    if (!barcode) return;

                    $.ajax({
                        url: '/admin/get-product-by-barcode/' + barcode,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {

                                $('#product_id').val(res.product.id).trigger('change');

                                $("#searchForm").submit();
                            }
                        }
                    });
                }
            });


            // Search Form Submit
            $("#searchForm").on('submit', function(e) {
                e.preventDefault();

                let selectedProductId = $('#product_id').val(); // <-- Store selected product

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('product-stock-report') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {
                        showLoading();
                    },

                    success: function(res) {
                        hideLoading();

                        let tbody = "";

                        res.data.forEach(function(row) {
                            tbody += `
                        <tr>
                            ${ showBranchColumn ? `<td>${row.branch}</td>` : `` }
                            <td>${row.product_code}</td>
                            <td>${row.product}</td>
                            <td>${row.size}</td>
                            <td>${row.color}</td>
                            <td>${row.purchase}</td>
                            <td>${row.sale}</td>
                            <td>${row.received}</td>
                            <td>${row.transfer}</td>
                            <td>${row.current_stock}</td>
                        </tr>
                    `;
                        });

                        $("#stockTable tbody").html(tbody);
                        $("#stockTable").fadeIn();

                        // Re-select product after reload
                        $('#product_id').val(selectedProductId);
                    },

                    error: function() {
                        hideLoading();
                        alert("Something went wrong!");
                    }
                });
            });

        });
    </script>
@endpush
