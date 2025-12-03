@extends('layouts.backend')

@section('main')
@section('title')
    {{ __('messages.profile') }}
@endsection
<style>
    /* Container Styling */
    .container-raper {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        padding: 30px;
        transition: all 0.3s ease-in-out;
    }

    .container-raper:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .table-header h2 {
        font-weight: 700;
        color: #333333;
        border-left: 5px solid #0d6efd;
        padding-left: 10px;
    }

    /* Card Design */
    .card {
        border: none;
        background-color: #fff;
        border-radius: 15px;
    }

    /* Profile Section */
    .profile-photo {
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        text-align: center;
        padding: 40px 20px;
    }

    .profile-photo img {
        border: 5px solid #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .profile-photo img:hover {
        transform: scale(1.05);
    }

    .profile-photo h5 {
        font-weight: 600;
        color: #212529;
    }

    .profile-photo small {
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Role badges */
    .role-badge {
        background-color: #0d6efd;
        color: #fff;
        border-radius: 30px;
        font-size: 0.8rem;
        padding: 6px 12px;
        margin: 3px;
        display: inline-block;
    }

    /* Personal Information Section */
    .info-title {
        color: #0d6efd;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 3px;
    }

    .info-value {
        font-weight: 600;
        color: #212529;
        font-size: 1rem;
        word-break: break-word;
    }

    /* Edit Button */
    .edit-btn {
        background-color: #0d6efd;
        color: #fff;
        border-radius: 8px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .edit-btn:hover {
        background-color: #0b5ed7;
        color: #fff;
        transform: translateY(-2px);
    }

    .edit-btn i {
        margin-right: 5px;
    }

    @media (max-width: 768px) {
        .profile-photo {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 30px;
        }
    }
</style>

<div class="container-raper">
    <div class="table-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="table-title mb-0"> {{ __('messages.my_profile') }}</h2>
        {{-- Optional edit button on header --}}
        {{-- <a href="{{ route('hr.user.edit', $data->id) }}" class="btn edit-btn"><i class="fa fa-edit"></i>Edit Profile</a> --}}
    </div>

    <div class="card overflow-hidden">
        <div class="row g-0">
            <!-- Profile Photo Section -->
            <div class="col-md-3 profile-photo">
                <img src="{{ asset('uploads/users/' . $data->photo) }}" alt="User Photo"
                    class="rounded-circle shadow-sm mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="mb-1">{{ $data->name }}</h5>
                <small>{{ $data->email }}</small>

                @if ($data->getRoleNames()->count() > 0)
                    <div class="mt-3">
                        <h6 class="fw-semibold mb-2 text-dark"> {{ __('messages.roles') }}</h6>
                        @foreach ($data->getRoleNames() as $role)
                            <span class="role-badge">{{ ucfirst($role) }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="col-md-9 p-4">
                <h5 class="info-title">{{ __('messages.personal_information') }}</h5>
                <div class="row gy-3">
                    <div class="col-md-6">
                        <p class="info-label">{{ __('messages.name') }}</p>
                        <p class="info-value">{{ $data->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">{{ __('messages.phone') }} {{ __('messages.number') }}</p>
                        <p class="info-value">{{ $data->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">{{ __('messages.email') }} {{ __('messages.address') }}</p>
                        <p class="info-value">{{ $data->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">{{ __('messages.address') }}</p>
                        <p class="info-value">{{ $data->address ?? 'N/A' }}</p>
                    </div>

                </div>

                {{-- Uncomment this if edit option is needed --}}

                <div class="text-end mt-4">
                    <a href="{{ route('admin.user.profile.edit', $data->id) }}" class="btn edit-btn">
                        <i class="fa fa-edit"></i>{{ __('messages.edit') }} {{ __('messages.profile') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
