@extends('console.layouts.app')
@section('title', 'Carts | ' . $cart->id)
@section('styles')
@endsection
@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link" href="#">
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Cart View</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $customer->name }}'s Cart</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container">

                <div class="row gy-5 g-xl-10">
                    <div class="col-xl-4 mb-xl-10">
                        <div class="card h-md-100" dir="ltr">
                            <div class="card-body  flex-column flex-center">
                                <h6 class="mb-5 fs-4">Customer Details</h6>

                                <div class="d-flex flex-stack mb-3">
                                    <span class="text-gray-500 fw-bold fs-6">Name</span>
                                    <div class="text-gray-700 fw-semibold fs-6 me-2">{{ $customer->name }}</div>
                                </div>

                                <div class="d-flex flex-stack mb-3">
                                    <span class="text-gray-500 fw-bold fs-6">Phone</span>
                                    <div class="text-gray-700 fw-semibold fs-6 me-2">{{ $customer->phone }}</div>
                                </div>

                                <div class="d-flex flex-stack mb-3">
                                    <span class="text-gray-500 fw-bold fs-6">Email</span>
                                    @if ($customer->email)
                                        <div class="text-gray-700 fw-semibold fs-6 me-2">{{ $customer->email }}</div>
                                    @else
                                        <div class="text-gray-700 fw-semibold fs-6 me-2">-</div>
                                    @endif
                                </div>

                                <div class="d-flex flex-stack mb-3">
                                    <span class="text-gray-500 fw-bold fs-6">Joined At</span>
                                    <div class="text-gray-700 fw-semibold fs-6 me-2">{{ $customer->created_at }}</div>
                                </div>

                                <div class="text-center mt-4 ">
                                    <a href="{{ route('customers.show', ['customer' => $cart->user_id]) }}"
                                        class="btn btn-info btn-sm">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-8 mb-5 mb-xl-10">
                        <div class="card h-md-100">
                            <div class="card-body  flex-column flex-center">
                                <h6 class="mb-5 fs-4">Cart Items</h6>
                                <div class="table-responsive mt-4">
                                    <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                        <thead>
                                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                <th class="p-0 pb-3  text-start">#</th>
                                                <th class="p-0 pb-3  text-end">Product</th>
                                                <th class="p-0 pb-3  text-end">Brand/Thickness</th>
                                                <th class="p-0 pb-3 text-end">Weight</th>
                                                <th class="p-0 pb-3  text-end pe-12">Length</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($cartProducts as $product)
                                                <tr>
                                                    <td class="text-start pe-0">
                                                        <span
                                                            class="text-gray-600 fw-bold fs-6">{{ $loop->iteration }}</span>
                                                    </td>

                                                    <td class="text-end pe-0">
                                                        <span
                                                            class="text-gray-600 fw-bold fs-6">{{ $product->product_name }}</span>
                                                    </td>

                                                    <td class="text-end pe-0">
                                                        <span
                                                            class="text-gray-600 fw-bold fs-6">{{ $product->category_id == 2 ? $product->brand : $product->thickness . 'MM' }}</span>
                                                    </td>

                                                    <td class="text-end pe-0">
                                                        <span
                                                            class="text-gray-600 fw-bold fs-6">{{ $product->weight }}</span>
                                                    </td>
                                                    <td class="text-end  pe-12">
                                                        <span
                                                            class="text-gray-600 fw-bold fs-6">{{ $product->length }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                        <!--end::Table body-->
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
    {{-- <script src="{{ asset('console/assets/steelghar/payment/index.js') }}"></script> --}}
@endsection
