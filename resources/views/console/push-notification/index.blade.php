@extends('console.layouts.app')
@section('title', 'Push Notifications')
@section('styles')
@endsection
@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link" href="#">
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Push Notifications</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Push Notification</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container">
                <div class=" mt-6 mt-xl-12">

                    <div class="row">
                        <div class="col-lg-4 col-md-12 card h-450px bg-light-primary shadow-xs">
                            <div class="card-header mt-5">
                                <div class="card-title flex-column">
                                    <h3 class="fw-bold mb-1">Send Notification</h3>
                                </div>

                            </div>

                            <form action="{{ route('console.push-notifications.store') }}" method="POST">
                                @csrf
                                <select class="form-select mt-5" aria-label="Select example" name="user_type">
                                    <option disabled>Select User Type</option>
                                    <option value="ALL" {{ old('user_type') == 'ALL' ? 'selected' : '' }}>ALL</option>
                                    <option value="CUSTOMERS" {{ old('user_type') == 'CUSTOMERS' ? 'selected' : '' }}>
                                        CUSTOMERS</option>
                                    <option value="FABRICATORS" {{ old('user_type') == 'FABRICATORS' ? 'selected' : '' }}>
                                        FABRICATORS</option>
                                </select>
                                @error('user_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control mt-5"
                                    placeholder="Enter Title" />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <textarea type="text" name="message" class="form-control mt-5"> {{ old('message') }}</textarea>
                                @error('message')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-sm btn-dark">Send Now</button>
                                </div>

                            </form>

                        </div>
                        <div class="col-lg-8 col-md-12 card card-flush">

                            <div class="card-header mt-5">
                                <div class="card-title flex-column">
                                    <h3 class="fw-bold mb-1">Push Notifications</h3>
                                </div>
                                <div class="card-toolbar my-1">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <span class="svg-icon svg-icon-3 position-absolute ms-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                    rx="1" transform="rotate(45 17.0365 15.1223)"
                                                    fill="currentColor" />
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text" data-table-search="search"
                                            class="form-control form-control-solid form-select-sm w-150px ps-9"
                                            placeholder="Search Notifications" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table id="brandTable"
                                        class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="w-30px pe-2">#</th>
                                                <th>Title</th>
                                                <th>Message</th>
                                                <th>Count</th>
                                                <th>Date</th>
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
        </div>

    </div>

@endsection

@section('modals')


@endsection

@section('scripts')
    <script src="{{ asset('console/assets/steelghar/push-notification/index.js') }}"></script>
@endsection
