@extends('console.layouts.app')
@section('title', 'Customers | ' . $customer->name)
@section('styles')
@endsection

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Customer
                        View</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $customer->name }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
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
                                    <div class="text-gray-700 fw-semibold fs-6 me-2">{{ $customer->email }}</div>
                                </div>

                                <div class="d-flex flex-stack mb-3">
                                    <span class="text-gray-500 fw-bold fs-6">Joined At</span>
                                    <div class="text-gray-700 fw-semibold fs-6 me-2">{{ $customer->created_at }}</div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-8 mb-5 mb-xl-10">
                        <div class=" h-md-100">
                            <div class=" flex-column flex-center">
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="card overflow-hidden  mb-5 " style="background: darkblue;">
                                            <div class="d-flex justify-content-between flex-column">
                                                <div class="mb-4 px-9">
                                                    <div class="d-flex align-items-center mb-2 mt-4">

                                                        <span class="fs-2x fw-bold text-white me-2 lh-1"
                                                            data-kt-countup="true"
                                                            data-kt-countup-value="{{ number_format((float) $orders->sum('pa'), 2, '.', '') }}"
                                                            data-kt-countup-prefix="₹"
                                                            data-kt-countup-suffix=".00">{{ number_format((float) $orders->sum('pa'), 2, '.', '') }}
                                                        </span>
                                                    </div>
                                                    <span class="fs-6 fw-semibold text-white">Total Sales</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card overflow-hidden  mb-5 " style="background:darkgreen">
                                            <div class="d-flex justify-content-between flex-column">
                                                <div class="mb-4 px-9">
                                                    <div class="d-flex align-items-center mb-2 mt-4">

                                                        <span class="fs-2x fw-bold text-white me-2 lh-1"
                                                            data-kt-countup="true"
                                                            data-kt-countup-value="{{ number_format((float) $orders->sum('pa'), 2, '.', '') }}"
                                                            data-kt-countup-prefix="₹" data-kt-countup-suffix=".00">
                                                            {{ number_format((float) $orders->sum('pa'), 2, '.', '') }}
                                                        </span>
                                                    </div>
                                                    <span class="fs-6 fw-semibold text-white">Paid Amount</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-4">
                                        <div class="card overflow-hidden  mb-5 " style="background: tomato;">
                                            <div class="d-flex justify-content-between flex-column">
                                                <div class="mb-4 px-9">
                                                    <div class="d-flex align-items-center mb-2 mt-4">

                                                        <span class="fs-2x fw-bold text-white me-2 lh-1"
                                                            data-kt-countup="true"
                                                            data-kt-countup-value="{{ number_format((float) $orders->sum('balance_payment'), 2, '.', '') }}"
                                                            data-kt-countup-prefix="₹"
                                                            data-kt-countup-suffix=".00">{{ number_format((float) $orders->sum('balance_payment'), 2, '.', '') }}
                                                        </span>
                                                    </div>
                                                    <span class="fs-6 fw-semibold text-white">Balance Amount</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-4">
                                        <div class="card overflow-hidden  mb-5 " style="background: yellowgreen;">
                                            <div class="d-flex justify-content-between flex-column">
                                                <div class="mb-4 px-9">
                                                    <div class="d-flex align-items-center mb-2 mt-4">
                                                        <span class="fs-2x fw-bold text-white me-2 lh-1"
                                                            data-kt-countup="true"
                                                            data-kt-countup-value="{{ $orders->count() }}">{{ $orders->count() }}</span>
                                                    </div>
                                                    <span class="fs-6 fw-semibold text-white">Total Orders</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="card overflow-hidden  mb-5 " style="background: teal;">
                                            <div class="d-flex justify-content-between flex-column">
                                                <div class="mb-4 px-9">
                                                    <div class="d-flex align-items-center mb-2 mt-4">
                                                        <span class="fs-2x fw-bold text-white me-2 lh-1"
                                                            data-kt-countup="true"
                                                            data-kt-countup-value="{{ count($cartProducts) }}">{{ count($cartProducts) }}</span>
                                                    </div>
                                                    <span class="fs-6 fw-semibold text-white">Items in Cart</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="card overflow-hidden  mb-5 " style="background: slateblue;">
                                            <div class="d-flex justify-content-between flex-column">
                                                <div class="mb-4 px-9">
                                                    <div class="d-flex align-items-center mb-2 mt-4">

                                                        <span class="fs-2x fw-bold text-white me-2 lh-1"
                                                            data-kt-countup="true"
                                                            data-kt-countup-value="{{ count($wishlists) }}">{{ count($wishlists) }}</span>
                                                    </div>
                                                    <span class="fs-6 fw-semibold text-white">Items in Wishlist</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                @if (count($orders))
                    <div class="card h-md-100">
                        <div class="card-body  flex-column flex-center">
                            <h6 class="mb-5 fs-4">Order History</h6>
                            <div class="table-responsive mt-4">
                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                    <thead>
                                        <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                            <th class="p-0 pb-3  text-start">#</th>
                                            <th class="p-0 pb-3  text-end">Order Id</th>
                                            <th class="p-0 pb-3  text-end">Date</th>
                                            <th class="p-0 pb-3 text-end">Subtotal</th>
                                            <th class="p-0 pb-3 text-end">Shipping Charge</th>
                                            <th class="p-0 pb-3 text-end">Handling Charge</th>
                                            <th class="p-0 pb-3 text-end">GST</th>
                                            <th class="p-0 pb-3 text-end">Grand Total</th>
                                            <th class="p-0 pb-3 text-end">Balance Amount</th>
                                            <th class="p-0 pb-3 text-end pe-12">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="text-start pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">{{ $loop->iteration }}</span>
                                                </td>

                                                <td class="text-end pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">{{ $order->order_id }}</span>
                                                </td>

                                                <td class="text-end pe-0">
                                                    <span
                                                        class="text-gray-600 fw-bold fs-6">{{ substr($order->order_date, 0, 10) }}</span>
                                                </td>

                                                <td class="text-end pe-0">
                                                    <span
                                                        class="text-gray-600 fw-bold fs-6">{{ $order->sub_total }}</span>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span
                                                        class="text-info fw-bold fs-6">{{ $order->shipping_charge }}</span>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span
                                                        class="text-primary fw-bold fs-6">{{ $order->handling_charge }}</span>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="text-danger fw-bold fs-6">{{ $order->gst }}</span>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class=" fw-bold fs-6">{{ $order->payable_amount }}</span>
                                                </td>
                                                <td class="text-end pe-0">
                                                    @if ($order->balance_payment)
                                                        <span
                                                            class="text-gray-600 fw-bold fs-6">{{ $order->balance_payment }}</span>
                                                    @else
                                                        <span class="badge badge-success">Fully Paid</span>
                                                    @endif
                                                </td>

                                                <td class="text-end  pe-12">
                                                    <a href="{{ route('console.orders.show', ['order' => $order->id]) }}"
                                                        class="btn btn-sm btn-icon btn-bg-dark  w-30px h-30px">
                                                        <i class="bi bi-eye fs-4 text-white"></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="shadow-xs alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10">
                        <i class="bi bi-info fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <h4 class="fw-semibold">No orders found!</h4>
                            <span>The customer has not placed any orders yet.</span>
                        </div>
                    </div>
                @endif


                <div class="row  mt-2">
                    <div class="col-xl-8 mb-xl-10">

                        @if (count($cartProducts))
                            <div class="card h-md-100 mt-5">
                                <div class="card-body  flex-column flex-center">
                                    <h6 class="mb-5 fs-4">Cart Items</h6>
                                    <div class="table-responsive mt-4">
                                        <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                            <thead>
                                                <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                    <th class="p-0 pb-3 text-start">#</th>
                                                    <th class="p-0 pb-3 text-end">Product</th>
                                                    <th class="p-0 pb-3 text-end">Brand/Thickness</th>
                                                    <th class="p-0 pb-3 text-end">Weight</th>
                                                    <th class="p-0 pb-3 text-end pe-12">Length</th>
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
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="shadow-xs alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10 mt-5">
                                <i class="bi bi-info fs-2hx text-danger me-4 mb-5 mb-sm-0"><span
                                        class="path1"></span><span class="path2"></span><span
                                        class="path3"></span></i>
                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <h4 class="fw-semibold">Cart is empty</h4>
                                    <span>Customer has not yet added any items to their cart</span>
                                </div>
                            </div>
                        @endif

                    </div>


                    <div class="col-xl-4">
                        @if (count($wishlists))
                            <div class="card h-md-100 mt-5">
                                <div class="card-body  flex-column flex-center">
                                    <h6 class="mb-5 fs-4">Wishlist</h6>
                                    <div class="table-responsive mt-4">
                                        <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                            <thead>
                                                <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                    <th class="p-0 pb-3  text-start">#</th>
                                                    <th class="p-0 pb-3  text-end pe-5">Product</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($wishlists as $wish)
                                                    <tr>
                                                        <td class="text-start pe-0">
                                                            <span
                                                                class="text-gray-600 fw-bold fs-6">{{ $loop->iteration }}</span>
                                                        </td>

                                                        <td class="text-end pe-5">
                                                            <span
                                                                class="text-gray-600 fw-bold fs-6">{{ $wish->product_name }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="shadow-xs alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10 mt-5">
                                <i class="bi bi-info fs-2hx text-danger me-4 mb-5 mb-sm-0"><span
                                        class="path1"></span><span class="path2"></span><span
                                        class="path3"></span></i>
                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <h4 class="fw-semibold">Wishlist is empty</h4>
                                    <span>Customer has not added any items to their wishlist yet</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if (count($addressess))
                    <h6 class=" mt-4 mb-3">Saved Addresses
                    </h6>
                    <div class="row ">

                        @foreach ($addressess as $address)
                            <div class="col-xl-4 mb-xl-5">
                                <div class="card {{ $address->is_default ? 'bg-light-success' : '' }} shadow-xs">
                                    <div class="p-3">
                                        <p class="fw-bold text-gray-700">Name: {{ $address->name }}</p>
                                        <p class="fw-bold text-gray-700">Phone: {{ $address->phone }}</p>
                                        <p class="fw-bold">{{ $address->address }}, {{ $address->address2 }},
                                            {{ $address->landmark }},
                                            {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @else
                    <div
                        class="shadow-xs alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10">
                        <i class="bi bi-info fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <h4 class="fw-semibold">Addresses have not been added</h4>
                            <span>Customer has not yet added any address to their profile</span>
                        </div>
                    </div>
                @endif


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
