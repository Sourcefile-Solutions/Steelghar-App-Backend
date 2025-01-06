@extends('layouts.app')
<style>
    #tracking {
        background: #fff
    }

    .tracking-detail {
        padding: 3rem 0;
    }

    #tracking {
        margin-bottom: 1rem;
    }

    [class*="tracking-status-"] p {
        margin: 0;
        font-size: 1.1rem;
        color: #fff;
        text-transform: uppercase;
        text-align: center;
    }

    [class*="tracking-status-"] {
        padding: 1.6rem 0;
    }

    .tracking-list {
        border: 1px solid #e5e5e5;
    }

    .tracking-item {
        border-left: 4px solid #00ba0d;
        position: relative;
        padding: 2rem 1.5rem 0.5rem 2.5rem;
        font-size: 0.9rem;
        margin-left: 3rem;
        min-height: 5rem;
    }

    .tracking-item:last-child {
        padding-bottom: 4rem;
    }

    .tracking-item .tracking-date {
        margin-bottom: 0.5rem;
    }

    .tracking-item .tracking-date span {
        color: #888;
        font-size: 85%;
        padding-left: 0.4rem;
    }

    .tracking-item .tracking-content {
        padding: 0.5rem 0.8rem;
        background-color: #f4f4f4;
        border-radius: 0.5rem;
    }

    .tracking-item .tracking-content span {
        display: block;
        color: #767676;
        font-size: 13px;
    }

    .tracking-item .tracking-icon {
        position: absolute;
        left: -0.7rem;
        width: 1.1rem;
        height: 1.1rem;
        text-align: center;
        border-radius: 50%;
        font-size: 1.1rem;
        background-color: #fff;
        color: #fff;
    }

    .tracking-item-pending {
        border-left: 4px solid #d6d6d6;
        position: relative;
        padding: 2rem 1.5rem 0.5rem 2.5rem;
        font-size: 0.9rem;
        margin-left: 3rem;
        min-height: 5rem;
    }

    .tracking-item-pending:last-child {
        padding-bottom: 4rem;
    }

    .tracking-item-pending .tracking-date {
        margin-bottom: 0.5rem;
    }

    .tracking-item-pending .tracking-date span {
        color: #888;
        font-size: 85%;
        padding-left: 0.4rem;
    }

    .tracking-item-pending .tracking-content {
        padding: 0.5rem 0.8rem;
        background-color: #f4f4f4;
        border-radius: 0.5rem;
    }

    .tracking-item-pending .tracking-content span {
        display: block;
        color: #767676;
        font-size: 13px;
    }

    .tracking-item-pending .tracking-icon {
        line-height: 2.6rem;
        position: absolute;
        left: -0.7rem;
        width: 1.1rem;
        height: 1.1rem;
        text-align: center;
        border-radius: 50%;
        font-size: 1.1rem;
        color: #d6d6d6;
    }

    .tracking-item-pending .tracking-content {
        font-weight: 600;
        font-size: 17px;
    }

    .tracking-item .tracking-icon.status-current {
        width: 1.9rem;
        height: 1.9rem;
        left: -1.1rem;
    }

    .tracking-item .tracking-icon.status-intransit {
        color: #00ba0d;
        font-size: 0.6rem;
    }

    .tracking-item .tracking-icon.status-current {
        color: #00ba0d;
        font-size: 0.6rem;
    }

    @media (min-width: 992px) {
        .tracking-item {
            margin-left: 10rem;
        }

        .tracking-item .tracking-date {
            position: absolute;
            left: -10rem;
            width: 7.5rem;
            text-align: right;
        }

        .tracking-item .tracking-date span {
            display: block;
        }

        .tracking-item .tracking-content {
            padding: 0;
            background-color: transparent;
        }

        .tracking-item-pending {
            margin-left: 10rem;
        }

        .tracking-item-pending .tracking-date {
            position: absolute;
            left: -10rem;
            width: 7.5rem;
            text-align: right;
        }

        .tracking-item-pending .tracking-date span {
            display: block;
        }

        .tracking-item-pending .tracking-content {
            padding: 0;
            background-color: transparent;
        }
    }

    .tracking-item .tracking-content {
        font-weight: 600;
        font-size: 17px;
    }

    .blinker {
        border: 7px solid #e9f8ea;
        animation: blink 1s;
        animation-iteration-count: infinite;
    }

    @keyframes blink {
        50% {
            border-color: #fff;
        }
    }
</style>
@section('content')
    <div class="container">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Order Details</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                <div class="card">


                    <div class="order-header">
                        <div class="order-header__actions">
                            <a href="{{ route('orderhistory') }}" class="btn btn-xs btn-secondary">Back to list</a>
                        </div>
                        <h5 class="order-header__title">Order Id #{{ $order->order_id }}</h5>
                        <div class="order-header__subtitle">
                            Was placed on <mark>{{ $order->created_at }}</mark>
                        </div>
                    </div>


                    <div class="card-divider"></div>
                    <div class="card-table">
                        <div class="table-responsive-sm">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th style="text-align: right;">Total <small>(rupees)</small></th>
                                    </tr>
                                </thead>
                                <tbody class="card-table__body card-table__body--merge-rows">
                                    @php
                                        $totalPrice = 0;
                                    @endphp

                                    @foreach ($orderitems as $orderitem)
                                        <tr>
                                            <td>{{ $orderitem->product_name }}</td>
                                            <td style="text-align: right;">{{ $orderitem->price }}</td>
                                        </tr>
                                        @php
                                            $totalPrice += $orderitem->price;
                                        @endphp
                                    @endforeach

                                </tbody>
                                <tbody class="card-table__body card-table__body--merge-rows">
                                    {{-- <tr>
                                        <th>Subtotal</th>
                                        <td>$1309.00</td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Shipping</th>
                                        <td>$25.00</td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th>
                                        <td>$262.00</td>
                                    </tr> --}}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <td style="text-align: right;">{{ number_format($totalPrice, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 no-gutters mx-n2">
                    <div class="col-sm-6 col-12 px-2">
                        <div class="card address-card address-card--featured">
                            <div class="address-card__badge tag-badge tag-badge--theme">
                                Delivery Address
                            </div>
                            <div class="address-card__body">
                                <div class="address-card__name">{{ $address->name }}</div>
                                <div class="address-card__row">
                                    {{ $address->address }}<br />{{ $address->address2 }}<br />{{ $address->city }},
                                    {{ $address->state }} - {{ $address->pincode }}
                                </div>
                                @if ($address->landmark)
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">
                                            Landmark
                                        </div>
                                        <div class="address-card__row-content">
                                            {{ $address->landmark }}
                                        </div>
                                    </div>
                                @endif
                                <div class="address-card__row">
                                    <div class="address-card__row-title">
                                        Phone Number
                                    </div>
                                    <div class="address-card__row-content">
                                        {{ $address->phone }}
                                    </div>
                                </div>
                                @if (auth()->user()->email)
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">
                                            Email Address
                                        </div>
                                        <div class="address-card__row-content">
                                            {{ auth()->user()->email }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 px-2 mt-sm-0 mt-3">
                        <div class="card address-card address-card--featured">

                            <div class="address-card__body">
                                <div class="address-card__name">Paid By Credit Card</div>
                                @if ($orderstatus != null)
                                    @if (
                                        $orderstatus->status == 'INVOICE GENERATED' ||
                                            $orderstatus->status == 'PAYMENT RECIVED' ||
                                            $orderstatus->status == 'ORDER SHIPPED' ||
                                            $orderstatus->status == 'GOODS-IN-TRANSIT' ||
                                            $orderstatus->status == 'MATERIAL DELIVERED')
                                        <a href="{{ route('invoice.download', ['order' => $order->id]) }}"
                                            class="btn btn-danger">Get Invoice</a>
                                    @endif
                                @endif
                                <div class="address-card__row pt-5">
                                    <div class="address-card__row-title">
                                        For queries contact :
                                    </div>
                                    <div class="address-card__row-content">
                                        {{ $settings->email }}
                                    </div>
                                    <div class="address-card__row-content">
                                        {{ $settings->phone }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($orderstatus != null)
                <div class="col-md-12 col-lg-6 ">

                    <div id="tracking-pre"></div>
                    <div id="tracking">
                        <div class="tracking-list">

                            @if (
                                $orderstatus->status == 'ORDER CONFIRMED' ||
                                    $orderstatus->status == 'MATERIAL LOADED' ||
                                    $orderstatus->status == 'INVOICE GENERATED' ||
                                    $orderstatus->status == 'PAYMENT RECIVED' ||
                                    $orderstatus->status == 'ORDER SHIPPED' ||
                                    $orderstatus->status == 'GOODS-IN-TRANSIT' ||
                                    $orderstatus->status == 'MATERIAL DELIVERED')
                                <div class="tracking-item" id="order_confirm"
                                    style="{{ $orderstatus->status == 'ORDER CONFIRMED' || $orderstatus->status == 'MATERIAL LOADED' || $orderstatus->status == 'INVOICE GENERATED' || $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'ORDER CONFIRMED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas"
                                            data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" data-fa-i2svg="" id="confirm"
                                            style="{{ $orderstatus->status == 'ORDER CONFIRMED' || $orderstatus->status == 'MATERIAL LOADED' || $orderstatus->status == 'INVOICE GENERATED' || $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date">
                                        <img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" />
                                    </div>
                                    <div class="tracking-content">Order
                                        Confirmed<span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'ORDER CONFIRMED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>

                                <div class="tracking-item" id="material_loaded"
                                    style="{{ $orderstatus->status == 'MATERIAL LOADED' || $orderstatus->status == 'INVOICE GENERATED' || $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'MATERIAL LOADED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas"
                                            data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" data-fa-i2svg="" id="loaded"
                                            style="{{ $orderstatus->status == 'MATERIAL LOADED' || $orderstatus->status == 'INVOICE GENERATED' || $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date">
                                        <img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" />
                                    </div>
                                    <div class="tracking-content">Material
                                        Loaded<span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'MATERIAL LOADED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>

                                <div class="tracking-item" id="invoice_generated"
                                    style="{{ $orderstatus->status == 'INVOICE GENERATED' || $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'INVOICE GENERATED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas"
                                            data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" data-fa-i2svg="" id="invoice"
                                            style="{{ $orderstatus->status == 'INVOICE GENERATED' || $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date">
                                        <img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" />
                                    </div>
                                    <div class="tracking-content">Invoice
                                        Generated<span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'ORDER SHIPPED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>

                                <div class="tracking-item" id="payment_received"
                                    style="{{ $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'PAYMENT RECIVED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                            data-prefix="fas" data-icon="circle" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            id="payment"
                                            style="{{ $orderstatus->status == 'PAYMENT RECIVED' || $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date">
                                        <img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" />
                                    </div>
                                    <div class="tracking-content">Payment Received
                                        <span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'PAYMENT RECIVED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>

                                <div class="tracking-item" id="order_shipped"
                                    style="{{ $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'ORDER SHIPPED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                            data-prefix="fas" data-icon="circle" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            id="shipped"
                                            style="{{ $orderstatus->status == 'ORDER SHIPPED' || $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date"><img
                                            src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" /></div>
                                    <div class="tracking-content">Order
                                        Shipped<span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'ORDER SHIPPED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>


                                <div class="tracking-item" id="goods_in_transit"
                                    style="{{ $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'GOODS-IN-TRANSIT' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                            data-prefix="fas" data-icon="circle" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            id="transit"
                                            style="{{ $orderstatus->status == 'GOODS-IN-TRANSIT' || $orderstatus->status == 'MATERIAL DELIVERED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date"><img
                                            src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" /></div>
                                    <div class="tracking-content">Goods
                                        IN-Transit<span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'GOODS-IN-TRANSIT' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>

                                <div class="tracking-item" id="material_delivered"
                                    style="{{ $orderstatus->status == 'MATERIAL DELIVERED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'MATERIAL DELIVERED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                            data-prefix="fas" data-icon="circle" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            style="{{ $orderstatus->status == 'MATERIAL DELIVERED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date"><img
                                            src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" /></div>
                                    <div class="tracking-content">Material
                                        Delivered<span>

                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'MATERIAL DELIVERED' ? $time->updated_at : '' }}
                                            @endforeach

                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="tracking-item" id="order_rejected"
                                    style="{{ $orderstatus->status == 'ORDER REJECTED' || $orderstatus->status == 'REFUND INITIATED' || $orderstatus->status == 'REFUND COMPLETED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'ORDER REJECTED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                            data-prefix="fas" data-icon="circle" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            id="reject"
                                            style="{{ $orderstatus->status == 'ORDER REJECTED' || $orderstatus->status == 'REFUND INITIATED' || $orderstatus->status == 'REFUND COMPLETED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date">
                                        <img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" />
                                    </div>
                                    <div class="tracking-content">Order Rejected
                                        <span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'ORDER REJECTED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>

                                <div class="tracking-item" id="refund_initiated"
                                    style="{{ $orderstatus->status == 'REFUND INITIATED' || $orderstatus->status == 'REFUND COMPLETED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'REFUND INITIATED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                            data-prefix="fas" data-icon="circle" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            id="refund"
                                            style="{{ $orderstatus->status == 'REFUND INITIATED' || $orderstatus->status == 'REFUND COMPLETED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date">
                                        <img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" />
                                    </div>
                                    <div class="tracking-content">Refund
                                        Initiated<span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'REFUND INITIATED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>

                                <div class="tracking-item" id="invoice_generated"
                                    style="{{ $orderstatus->status == 'REFUND COMPLETED' ? 'border-left: 4px solid #00ba0d;' : 'border-left: 4px solid #d6d6d6;' }}">
                                    <div
                                        class="tracking-icon {{ $orderstatus->status == 'REFUND COMPLETED' ? 'status-current blinker' : 'status-intransit' }}">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                            data-prefix="fas" data-icon="circle" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            id="invoice"
                                            style="{{ $orderstatus->status == 'REFUND COMPLETED' ? 'color: #00ba0d;' : 'color: #d6d6d6;' }}">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="tracking-date">
                                        <img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg"
                                            class="img-responsive" alt="order-placed" />
                                    </div>
                                    <div class="tracking-content">Refund
                                        Completed<span>
                                            @foreach ($statustime as $time)
                                                {{ $time->status == 'REFUND COMPLETED' ? $time->updated_at : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            @else
                <div class="col-md-12 col-lg-6 align-content-center text-center">

                    <h2>Waiting For Order Confirmation</h2>

                </div>
            @endif
        </div>
    </div>
@endsection
