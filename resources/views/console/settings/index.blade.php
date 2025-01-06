@extends('console.layouts.app')
@section('title', 'Settings')
@section('styles')
@endsection

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Settings
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Settings</li>
                    </ul>
                </div>

            </div>
        </div>

        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <div class="card card-flush h-xl-100">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Settings</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6" data-settings="updated_st"></span>
                        </h3>
                    </div>
                    <div class="card-body pt-6">
                        <ul class="nav nav-pills nav-pills-custom mb-3">
                            <li class="nav-item mb-3 me-3 me-lg-6">
                                <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-150px h-100px pt-5 pb-2 active"
                                    id="settings_tab_link_1" data-bs-toggle="pill" href="#settings_tab_1">
                                    <div class="nav-icon mb-3">
                                        <i class="fonticon-drive fs-2hx p-0"></i>
                                    </div>
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">General Settings</span>
                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                </a>
                            </li>
                            <li class="nav-item mb-3 me-3 me-lg-6">
                                <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-150px h-100px pt-5 pb-2"
                                    id="settings_tab_link_3" data-bs-toggle="pill" href="#settings_tab_2">
                                    <div class="nav-icon mb-3">
                                        <i class="fonticon-like-1 fs-2hx p-0"></i>
                                    </div>
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Social Media</span>
                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                </a>
                            </li>

                            <li class="nav-item mb-3 me-3 me-lg-6">
                                <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-150px h-100px pt-5 pb-2"
                                    id="settings_tab_link_4" data-bs-toggle="pill" href="#settings_tab_4">
                                    <div class="nav-icon mb-3">
                                        <i class="fonticon-remote-control fs-2hx p-0"></i>
                                    </div>
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Logo & Favicon</span>
                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                </a>
                            </li>
                        </ul>
                        <form id="settingsForm" class="form mt-4"
                            action="{{ route('console.settings.update', ['setting' => 1]) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="settings_tab_1">
                                    <div class="row g-9 mb-8">
                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Site Name</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter site name" name="site_name"
                                                value="{{ $settings->site_name }}" />
                                        </div>

                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Primary Phone</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter 10 digits phone number" name="phone"
                                                value="{{ $settings->phone }}" maxlength="10"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                            @error('phone')
                                                <div class="alert text-danger p-0">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>Secondary Phone</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter 10 digits phone number" name="phone2"
                                                value="{{ $settings->phone2 }}" maxlength="10"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                        </div>

                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>Email</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter email address" name="email"
                                                value="{{ $settings->email }}" />
                                        </div>

                                        <div class="col-md-12 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>Address</span>
                                            </label>
                                            <textarea name="address" class="form-control form-control-solid" cols="10" rows="3">{{ $settings->address }}</textarea>
                                        </div>

                                        <div class="col-md-4 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>City</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter City" name="city" value="{{ $settings->city }}" />
                                        </div>

                                        <div class="col-md-4 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>District</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter district" name="district"
                                                value="{{ $settings->district }}" />
                                        </div>

                                        <div class="col-md-4 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>State</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter state" name="state"
                                                value="{{ $settings->state }}" />
                                        </div>

                                        <div class="col-md-4 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>Pincode</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter pincode" name="pincode"
                                                value="{{ $settings->pincode }}" maxlength="6"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                        </div>

                                        <div class="col-md-4 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>Country</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter Country" name="country" readonly value="India" />
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-5 fv-row">
                                                <label class="required form-label">Site Mode</label>
                                                <select type="text" name="site_mode"
                                                    class="form-control mb-2 form-control-solid">
                                                    <option value="1"
                                                        {{ $settings->site_mode == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="0"
                                                        {{ $settings->site_mode == '0' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-warning settingsFormSubmit">
                                                <span class="indicator-label">Update</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="settings_tab_2">
                                    <div class="row g-9 mb-8">
                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Whatsapp Number</span>
                                            </label>
                                            <input type="tel" class="form-control form-control-solid"
                                                placeholder="Enter 10 diits nuber" name="whatsapp"
                                                value="{{ $settings->whatsapp }}" />
                                        </div>

                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Facebook Link</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter facebook link" name="facebook"
                                                value="{{ $settings->facebook }}" />
                                        </div>

                                        <!--<div class="col-md-6 fv-row">-->
                                        <!--    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">-->
                                        <!--        <span>Twitter link</span>-->
                                        <!--    </label>-->
                                        <!--    <input type="text" class="form-control form-control-solid"-->
                                        <!--        placeholder="Enter twitter link" name="twitter"-->
                                        <!--        value="{{ $settings->twitter }}" />-->
                                        <!--</div>-->

                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>Instagram</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter instagram link" name="instagram"
                                                value="{{ $settings->instagram }}" />
                                        </div>

                                        <!--<div class="col-md-4 fv-row">-->
                                        <!--    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">-->
                                        <!--        <span>Pinterest Link</span>-->
                                        <!--    </label>-->
                                        <!--    <input type="text" class="form-control form-control-solid"-->
                                        <!--        placeholder="Enter pinterest link" name="pinterest"-->
                                        <!--        value="{{ $settings->pinterest }}" />-->
                                        <!--</div>-->

                                        <!--<div class="col-md-4 fv-row">-->
                                        <!--    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">-->
                                        <!--        <span>Linkedin Link</span>-->
                                        <!--    </label>-->
                                        <!--    <input type="text" class="form-control form-control-solid"-->
                                        <!--        placeholder="Enter linkedin link" name="linkedin"-->
                                        <!--        value="{{ $settings->linkedin }}" />-->
                                        <!--</div>-->

                                        <!--<div class="col-md-4 fv-row">-->
                                        <!--    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">-->
                                        <!--        <span>Youtube Channel Link</span>-->
                                        <!--    </label>-->
                                        <!--    <input type="text" class="form-control form-control-solid"-->
                                        <!--        placeholder="Enter youtube channel link" name="youtube"-->
                                        <!--        value="{{ $settings->youtube }}" />-->
                                        <!--</div>-->

                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-warning settingsFormSubmit">
                                            <span class="indicator-label">Update</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="settings_tab_3">
                                    <div class="row g-9 mb-8">
                                        <div class="col-md-12 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">SEO Keywords</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter seo keywords" name="seo_keywords"
                                                value="{{ $settings->seo_keywords }}" />
                                        </div>

                                        <div class="col-md-12 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span>SEO Description</span>
                                            </label>
                                            <textarea name="seo_description" class="form-control form-control-solid" cols="10" rows="3">{{ $settings->seo_description }}</textarea>
                                        </div>

                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-warning settingsFormSubmit">
                                            <span class="indicator-label">Update</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="settings_tab_4">

                                    <style>
                                        /* .image-input-placeholder {
                                                                                                                                                    background-image: url('{{ asset('console/assets/media/svg/files/blank-image.svg') }}');
                                                                                                                                                } */
                                    </style>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-10">
                                                <label class="d-flex align-items-center form-label mb-2">
                                                    <span class="required">Fav_Icon</span>
                                                </label>
                                                <div class="image-input image-input-circle image-input-empty image-input-outline image-input-placeholder"
                                                    data-kt-image-input="true"
                                                    style='background-image: url("{{ asset("/storage/$settings->fav_icon") }}")'>
                                                    <div class="image-input-wrapper subcategory-icon w-125px h-125px">
                                                    </div>
                                                    <label
                                                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        data-bs-dismiss="click" title="Change icon">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <input type="file" name="fav_icon"
                                                            accept=".png, .jpg, .jpeg" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="fv-row mb-10">
                                                <label class="d-flex align-items-center form-label mb-2">
                                                    <span class="required">Logo</span>
                                                </label>
                                                <div class="image-input image-input-outline image-input-empty  image-input-placeholder"
                                                    data-kt-image-input="true"
                                                    style='background-image: url("{{ asset("/storage/$settings->logo") }}")'>
                                                    <div class="image-input-wrapper subcategory-image w-200px h-125px">
                                                    </div>
                                                    <label
                                                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        data-bs-dismiss="click" title="Change image">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <input type="file" name="logo"
                                                            accept=".png, .jpg, .jpeg" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-warning settingsFormSubmit">
                                                <span class="indicator-label">Update</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>


                                    </div>



                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('ecommerce/js/settings.js') }}"></script>
@endsection
