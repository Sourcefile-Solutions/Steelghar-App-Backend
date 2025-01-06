@extends('console.layouts.app')
@section('title', 'Products')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link"
                    href="http://localhost:8000/settings">
                    <!--begin::Page title-->
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Steel Detail</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Steel Detail</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <a href="{{ route('products.create') }}" class="btn fw-bold btn-dark" id="addNewPincode">Add Steel
                    Detail</a>
            </div>
            <!--end::Toolbar container-->
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row">
                    <div class="col-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="product_add_form" class="form d-flex flex-column flex-lg-row"
                            action="{{ route('steeldetails.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card card-flush h-xl-100 mt-5">
                                <div class="card-header pt-7">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">Add Steel Detail</span>
                                        <span class="text-gray-400 mt-1 fw-semibold fs-6"></span>
                                    </h3>
                                </div>
                                <div class="row p-10">
                                    <div class="col-12 mb-10 fv-row">
                                        <label class="required form-label">Category</label>
                                        <select name="category_id" class="form-control form-control-solid" id="category">
                                            <option value="" disabled selected>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-10 fv-row">
                                        <label class="required form-label">Type</label>
                                        <select type="text" name="type" class="form-control mb-2" id="type">
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="1">Type 1</option>
                                            <option value="2">Type 2</option>
                                            <option value="3">Type 3</option>
                                        </select>
                                        @error('type')
                                            <div class="alert text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-10 fv-row" id="subcategory">
                                        <label class="required form-label">Subcategory</label>
                                        <select name="subcategory_id" class="form-control form-control-solid">
                                            <option value="" disabled selected>Select Subcategory</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-10 fv-row" id="division">
                                        <label class="required form-label">Division</label>
                                        <select name="division_id" class="form-control form-control-solid">
                                            <option value="" disabled selected>Select Division</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->division_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-10 fv-row" id="dimension">
                                        <label class="required form-label">Dimension</label>
                                        <input type="text" name="dimension" class="form-control mb-2"
                                            placeholder="Dimension" value="{{ old('dimension') }}" />
                                    </div>

                                    <div class="col-12 mb-10 fv-row" id="thickness">
                                        <label class="required form-label">Thickness</label>
                                        <input type="text" name="thickness" class="form-control mb-2"
                                            placeholder="Thickness" value="{{ old('thickness') }}" />
                                    </div>

                                    <div class="col-12 mb-10 fv-row" id="material">
                                        <label class="required form-label">Material</label>
                                        <input type="text" name="material" class="form-control mb-2"
                                            placeholder="Material" value="{{ old('material') }}" />
                                    </div>

                                    <div class="col-12 mb-10 fv-row" id="weight">
                                        <label class="required form-label">Weight</label>
                                        <input type="text" name="weight" class="form-control mb-2" placeholder="Weight"
                                            value="{{ old('weight') }}" />
                                    </div>

                                    <div class="col-12 mb-10 fv-row">
                                        <label class="required form-label">Status</label>
                                        <select type="text" name="status" class="form-control mb-2">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        @error('status')
                                            <div class="alert text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button id="product_submit" type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Save</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-8">
                        <div class="card card-flush h-xl-100 mt-5">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Products</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6"></span>
                                </h3>
                                <div class="card-toolbar">
                                    <div class="d-flex flex-stack flex-wrap gap-4">
                                        <div class="position-relative my-1">
                                            <span
                                                class="svg-icon svg-icon-2 position-absolute top-50 translate-middle-y ms-4">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                        height="2" rx="1"
                                                        transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                    <path
                                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <input type="text" data-kt-table-widget-4="search"
                                                class="form-control w-150px fs-7 ps-12" placeholder="Search" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-2">
                                <table class="table align-middle table-row-dashed fs-6 gy-3" id="steelTable">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-30px pe-2">#</th>
                                            <th>Product Fields</th>
                                            <th>Steel Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#subcategory").hide();
            $("#division").hide();
            $("#dimension").hide();
            $("#thickness").hide();
            $("#weight").hide();
            $("#material").hide();
            $("#type").change(function() {
                if ($(this).val() === '1') {
                    $("#subcategory").show();
                    $("#division").show();
                    $("#dimension").show();
                    $("#thickness").show();
                    $("#weight").show();
                    $("#material").hide();
                } else if ($(this).val() === '2') {
                    $("#subcategory").hide();
                    $("#division").hide();
                    $("#dimension").show();
                    $("#thickness").show();
                    $("#weight").show();
                    $("#material").hide();
                } else {
                    $("#subcategory").hide();
                    $("#division").hide();
                    $("#dimension").hide();
                    $("#thickness").hide();
                    $("#weight").show();
                    $("#material").show();
                }
            });
        });
    </script>
    <script src="{{ asset('console/assets/steelghar/steeldetail/index.js') }}"></script>
@endsection
