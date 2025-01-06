@extends('console.layouts.app')
@section('title', 'Delivery Charge')
@section('styles')
@endsection
@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link"
                    href="http://localhost:8000/settings">
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Delivery Charge</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Delivery Charge</li>
                    </ul>
                </div>
                <!--end::Page title-->
                {{-- <button type="button" class="btn btn-primary text-end" id="category-modal-button">Add </button> --}}
            </div>
            <!--end::Toolbar container-->
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container">
                <div class="card card-flush mt-6 mt-xl-12">

                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table table-hover table-rounded table-striped border gy-7 gs-7">
                                <thead>

                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>KG</th>
                                        <th>KM</th>
                                        <th>Minimum Charge</th>
                                        <th>Additional KM</th>
                                        <th>Additional Charge</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($charges as $charge)
                                        <tr>
                                            <td>{{ $charge->from_kg }} to {{ $charge->to_kg }} Kg</td>
                                            <td>{{ $charge->from_km }} to {{ $charge->to_km }} Km</td>
                                            <td> ₹{{ $charge->minimum_charge }}</td>
                                            <td>{{ $charge->additional_km }}</td>
                                            <td> ₹{{ $charge->additional_charge }}</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-info btn-sm editBtn"
                                                        data-data="{{ json_encode($charge) }}">Edit</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


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
    <div class="modal fade" tabindex="-1" id="CategoryModal">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="category-modal-title">Update Delivery Charge</h1>

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




                <form class="form" method="POST" action="" enctype="multipart/form-data" id="categoryForm">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">From Km</label>
                                    <input type="text" name="from_km" class="form-control mb-2"
                                        placeholder="Enter From Km" value="" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">To Km</label>
                                    <input type="text" name="to_km" class="form-control mb-2" placeholder="Enter To Km"
                                        value="" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">From Kg</label>
                                    <input type="text" name="from_kg" class="form-control mb-2"
                                        placeholder="Enter from kg" value="" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">To Kg</label>
                                    <input type="text" name="to_kg" class="form-control mb-2" placeholder="Enter To kg"
                                        value="" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Minimum Charge</label>
                                    <input type="text" name="minimum_charge" class="form-control mb-2"
                                        placeholder="Enter minimum charge" value="" />
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Additional Km</label>
                                    <input type="text" name="additional_km" class="form-control mb-2"
                                        placeholder="Enter additional km" value="" />
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-5 fv-row">
                                    <label class="required form-label">Additional Charge</label>
                                    <input type="text" name="additional_charge" class="form-control mb-2"
                                        placeholder="Enter Additional charge" value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            id="category_cancel">Close</button>
                        <button type="submit" class="btn btn-primary" id="category_submit"><span
                                class="indicator-label" id="btn-text">
                                Submit
                            </span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('console/assets/steelghar/delivery/index.js') }}"></script>
@endsection
