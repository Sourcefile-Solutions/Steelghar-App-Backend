@extends('console.layouts.app')
@section('title', 'Fabricator-Detail')
@section('styles')
@endsection

@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link" href="#">
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Fabricator Details</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Fabricator Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">


            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <!--end::Navbar-->
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Fabricator Details</h3>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Action-->
                        <!--end::Action-->
                    </div>
                    <!--begin::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-8">
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 fw-semibold text-muted">User Name</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 fw-semibold text-muted">Company Name</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->company_name }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->

                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 fw-semibold text-muted">Phone Number</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <span class="fw-semibold text-gray-800 fs-6">{{ $fabricator->phone }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 fw-semibold text-muted">Email</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <span class="fw-semibold text-gray-800 fs-6">{{ $fabricator->email }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 fw-semibold text-muted">GST</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <span class="fw-semibold fs-6 text-gray-800">{{ $fabricator->gst }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 fw-semibold text-muted">PAN</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->pan }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->


                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Aadhaar</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->aadhaar }}</span>
                                    </div>
                                </div>



                                <div class="row mb-10">
                                    <label class="col-lg-4 fw-semibold text-muted">Approval Status</label>
                                    <div class="col-lg-8">
                                        @if ($fabricator->approval_status == 'PENDING')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif ($fabricator->approval_status == 'APPROVED')
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-4">
                                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                        <img src="{{ asset('storage/fabricators/jnc-1707890625657.jpeg') }}" alt="image">
                                    </div>
                                </div>

                                <div class="mt-15">
                                    <a href="{{ asset('storage/fabricators/jnc-1707890625657.jpeg') }}"
                                        class="btn btn-sm btn-primary me-3" target="_blank">View Business Agreement</a>
                                </div>

                                <form class="form mt-11" method="POST"
                                    action="{{ route('fabricators.update', [$fabricator->id]) }}">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-5 fv-row">
                                                <label class="required form-label">Status</label>
                                                <select name="approval_status" class="form-control mb-2">
                                                    <option value="APPROVED">Approve</option>
                                                    <option value="REJECTED">Reject</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-10">
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" class="btn btn-primary" id="category_submit"><span
                                                    class="indicator-label" id="btn-text">
                                                    Update
                                                </span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('drawers')
@endsection

@section('modals')
@endsection

@section('scripts')
@endsection
