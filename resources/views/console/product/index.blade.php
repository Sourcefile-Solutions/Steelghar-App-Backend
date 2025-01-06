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
                        Products</h1>
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
                        <li class="breadcrumb-item text-muted">Products</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <a href="/add-tmt-product" class="btn fw-bold btn-dark me-2">Add
                    TMT
                    Product</a>
                <a href="/add-mesh-product" class="btn fw-bold btn-dark me-2">Add
                    Mesh
                    Product</a>
                <a href="/add-roof-product" class="btn fw-bold btn-dark me-2">Add
                    Roof
                    Product</a>
                <a href="/add-other-product" class="btn fw-bold btn-dark me-2">Add
                    Other
                    Product</a>
            </div>
            <!--end::Toolbar container-->
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card card-flush h-xl-100 mt-5">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Products</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6"></span>
                        </h3>
                        <div class="card-toolbar">
                            <div class="d-flex flex-stack flex-wrap gap-4">
                                <div class="position-relative my-1">
                                    <span class="svg-icon svg-icon-2 position-absolute top-50 translate-middle-y ms-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
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
                        <table class="table align-middle table-row-dashed fs-6 gy-3" id="productTable">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-30px pe-2">#</th>
                                    <th>Product Fields</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
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
@endsection

@section('scripts')
    <script src="{{ asset('console/assets/steelghar/product/index.js') }}"></script>
@endsection
