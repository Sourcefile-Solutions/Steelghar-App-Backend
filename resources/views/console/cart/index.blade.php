@extends('console.layouts.app')
@section('title', 'Carts')
@section('styles')
@endsection
@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link" href="#">
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Active Carts</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Carts</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container">



                <div class="card card-flush">

                    <div class="card-body pt-6">
                        <div class="table-responsive mt-4">
                            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                <thead>
                                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                        <th class="p-0 pb-3  text-start">#</th>
                                        <th class="p-0 pb-3  text-end">Name</th>
                                        <th class="p-0 pb-3  text-end">Phone</th>
                                        <th class="p-0 pb-3 text-end">Cart Items</th>
                                        <th class="p-0 pb-3  text-end pe-12">View</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($carts->where('count', '>=', 1) as $cart)
                                        <tr>
                                            <td class="text-start pe-0">
                                                <span class="text-gray-600 fw-bold fs-6">{{ $loop->iteration }}</span>
                                            </td>

                                            <td class="text-end pe-0">
                                                <span class="text-gray-600 fw-bold fs-6">{{ $cart->name }}</span>
                                            </td>

                                            <td class="text-end pe-0">
                                                <span class="text-gray-600 fw-bold fs-6">{{ $cart->phone }}</span>
                                            </td>

                                            <td class="text-end pe-0">
                                                <span class="text-gray-600 fw-bold fs-6">{{ $cart->count }}</span>
                                            </td>
                                            <td class="text-end  pe-12">
                                                <a href="{{ route('carts.show', ['id' => $cart->id]) }}"
                                                    class="btn btn-sm btn-icon btn-bg-info  w-30px h-30px">
                                                    <i class="bi bi-eye fs-2 text-white"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end: Card Body-->
                </div>


            </div>
        </div>

    </div>

@endsection

@section('modals')


@endsection

@section('scripts')
    {{-- <script src="{{ asset('console/assets/steelghar/payment/index.js') }}"></script> --}}
@endsection
