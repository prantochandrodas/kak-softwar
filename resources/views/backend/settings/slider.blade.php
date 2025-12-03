@extends('layouts.backend')

@section('main')

    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Slider</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Settings</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Slider</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body py-4">


                        <form action="{{ route('admin.setting.slider',$data->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title')??$data->title }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title_end" class="form-label">Title End</label>
                                <input type="text" name="title_end" id="title_end"
                                       class="form-control @error('title_end') is-invalid @enderror"
                                       value="{{ old('title_end')??$data->title_end }}" required>
                                @error('title_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <input type="text" name="bio" id="bio"
                                       class="form-control @error('bio') is-invalid @enderror"
                                       value="{{ old('bio')??$data->bio }}" required>
                                @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="bg_color" class="form-label">Background Color</label>
                                <input type="color" name="bg_color" id="bg_color"
                                       class="form-control form-control-color @error('bg_color') is-invalid @enderror" title="Choose your color"
                                       value="{{ old('bg_color')??$data->bg_color }}" required >
                                @error('bg_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="video_url" class="form-label">Video URL</label>
                                <input type="text" name="video_url" id="video_url"
                                       class="form-control @error('video_url') is-invalid @enderror"
                                       value="{{ old('video_url')??$data->video_url }}" required>
                                @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="button_details" class="form-label">Button Details</label>
                                <textarea name="button_details" id="button_details"
                                          class="form-control @error('button_details') is-invalid @enderror">{{ old('button_details')??$data->button_details }}</textarea>
                                @error('button_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" name="button_text" id="button_text"
                                       class="form-control @error('button_text') is-invalid @enderror"
                                       value="{{ old('button_text')??$data->button_text }}" required>
                                @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="button_url" class="form-label">Button URL</label>
                                <input type="text" name="button_url" id="button_url"
                                       class="form-control @error('button_url') is-invalid @enderror"
                                       value="{{ old('button_url')??$data->button_url }}" required>
                                @error('button_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="#" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Update</button>
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
