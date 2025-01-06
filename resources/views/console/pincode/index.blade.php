@extends('console.layouts.app')
@section('title', 'Pincodes')
@section('styles')
@endsection
@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link"
                    href="http://localhost:8000/settings">
                    <!--begin::Page title-->
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Pincode</h1>
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
                        <li class="breadcrumb-item text-muted">Pincodes</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <button type="button" class="btn btn-primary text-end" data-bs-toggle="modal"
                    data-bs-target="#PincodeModal">Add New Pincode</button>
            </div>
            <!--end::Toolbar container-->
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container">
                <div class="card card-flush mt-6 mt-xl-12">
                    <div class="card-header mt-5">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Pincodes</h3>
                        </div>
                        <div class="card-toolbar my-1">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-3 position-absolute ms-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" data-table-search="search"
                                    class="form-control form-control-solid form-select-sm w-150px ps-9"
                                    placeholder="Search Pincode" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="pincodeTable"
                                class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-30px pe-2">#</th>
                                        <th>Pincode</th>
                                        <th>Post Office</th>
                                        <th>Delivery Details</th>
                                        <th>Divisions</th>
                                        <th>Head Office / Sub-Office / Phone</th>
                                        <th>State / District / Taluk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-6">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('modals')
    <div class="modal fade" tabindex="-1" id="PincodeModal">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Pincodes</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                        </svg>
                    </div>
                    <!--end::Close-->
                </div>

                <form class="form" method="POST" action="" enctype="multipart/form-data" id="pincodeForm">
                    @method('post')
                    @csrf
                    <div class="mb-5 text-center">
                        <h1 class="mb-3" id="pincode-modal-title">Pincodes</h1>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Office Name</label>
                                    <input type="text" name="office_name" class="form-control mb-2"
                                        placeholder="Office Name" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Office Type</label>
                                    <input type="text" name="office_type" class="form-control mb-2"
                                        placeholder="Office Type" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Pincode</label>
                                    <input type="text" name="pincode" class="form-control mb-2" placeholder="Pincode"
                                        value="" maxlength="6"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Division Name</label>
                                    <input type="text" name="division_name" class="form-control mb-2"
                                        placeholder="Division Name" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Region Name</label>
                                    <input type="text" name="region_name" class="form-control mb-2"
                                        placeholder="Region Name" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Circle Name</label>
                                    <input type="text" name="circle_name" class="form-control mb-2"
                                        placeholder="Circle Name" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Telephone</label>
                                    <input type="text" name="telephone" class="form-control mb-2"
                                        placeholder="Telephone" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Related Headoffice</label>
                                    <input type="text" name="related_headoffice" class="form-control mb-2"
                                        placeholder="Related Headoffice" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Related Suboffice</label>
                                    <input type="text" name="related_suboffice" class="form-control mb-2"
                                        placeholder="Related Suboffice" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">State</label>
                                    <input type="text" name="state" class="form-control mb-2" placeholder="State"
                                        value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">District</label>
                                    <input type="text" name="district" class="form-control mb-2"
                                        placeholder="District" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Taluk</label>
                                    <input type="text" name="taluk" class="form-control mb-2" placeholder="Taluk"
                                        value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Delivery Charge</label>
                                    <input type="text" name="delivery_charge" class="form-control mb-2"
                                        placeholder="Delivery Charge" value="" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Delivery Status</label>
                                    <select name="delivery_status" class="form-control mb-2">
                                        <option value="1">Deliverable</option>
                                        <option value="0">Not Deliverable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Duration</label>
                                    <input type="text" name="duration" class="form-control mb-2"
                                        placeholder="Duration" value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            id="pincode_cancel">Close</button>
                        <button type="submit" class="btn btn-primary" id="pincode_submit"><span class="indicator-label"
                                id="btn-text">
                                Submit
                            </span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('console/assets/steelghar/pincodes/index.js') }}"></script>
@endsection
