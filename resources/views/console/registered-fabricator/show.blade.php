@extends('console.layouts.app')
@section('title', 'Fabricators | ' . $fabricator->id)
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
                        <li class="breadcrumb-item text-muted">Fabricator {{ $fabricator->fab_id }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">


            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Fabricator Details</h3>
                        </div>
                        <div class="card-toolbar">
                            @if ($fabricator->approval_status == 'APPROVED')
                                <span class="badge badge-dark fs-4">{{ $fabricator->fab_id }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <label class="col-lg-4 fw-semibold text-muted">Customer Name</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->name }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Customer Phone</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->phone }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Customer Email</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->email }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Company Name</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->company_name }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Company Phone</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->fabircator_phone }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Company Email</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->fabircator_email }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">GST</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->gst }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">PAN</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->pan }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Aadhaar</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->aadhaar }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Attempt</label>
                                    <div class="col-lg-8 mb-2">
                                        @if ($fabricator->attempt == 1)
                                            <span class="badge badge-success">First Attempt</span>
                                        @else
                                            <span class="badge badge-primary">Re Attempt
                                                ({{ $fabricator->attempt }})</span>
                                        @endif
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted mb-2">Applied At</label>
                                    <div class="col-lg-8 mb-2">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $fabricator->applied_at }}</span>
                                    </div>

                                    <label class="col-lg-4 fw-semibold text-muted">Status</label>
                                    <div class="col-lg-8 mb-2">

                                        @if ($fabricator->approval_status == 'APPROVED')
                                            <span class="badge badge-success">{{ $fabricator->approval_status }}</span>
                                        @elseif($fabricator->approval_status == 'PENDING')
                                            <span class="badge badge-warning">{{ $fabricator->approval_status }}</span>
                                        @elseif($fabricator->approval_status == 'BLOCKED')
                                            <span class="badge badge-danger">{{ $fabricator->approval_status }}</span>
                                        @elseif($fabricator->approval_status == 'REJECTED')
                                            <span class="badge badge-primary">{{ $fabricator->approval_status }}</span>
                                        @endif




                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="symbol symbol-100px symbol-lg-100px symbol-fixed position-relative">
                                        <a href="{{ asset("/storage2/$fabricator->photo") }}" target="_blank">
                                            <img src="{{ asset("/storage2/$fabricator->photo") }}" alt="image">
                                        </a>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <a href="{{ asset("/storage2/$fabricator->business_agreement") }}"
                                        class="btn btn-sm btn-primary me-3" target="_blank">View Business Agreement</a>
                                </div>

                                <form class="form mt-5" method="POST"
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
                                                <label class="form-label">Status</label>
                                                <select name="approval_status" class="form-control mb-2"
                                                    id="approval_status">
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status }}">{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                                @error('approval_status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-none" id="reasonDiv">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light-danger">Reason</span>
                                                <textarea class="form-control" aria-label="With textarea" name="reason"></textarea>
                                            </div>
                                            @error('reason')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-12 text-end mt-5">
                                        <button type="submit" class="btn btn-sm btn-info" id="category_submit"><span
                                                class="indicator-label" id="btn-text">
                                                Update
                                            </span></button>
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
    <script>
        const approvalStatus = document.getElementById('approval_status');
        const reasonDiv = document.getElementById('reasonDiv');

        approvalStatus.addEventListener("change", function(e) {
            if (e.target.value == "REJECTED") reasonDiv.classList.remove("d-none");
            else reasonDiv.classList.add("d-none");
        });
        // console.log(approvalStatus)
    </script>
@endsection
