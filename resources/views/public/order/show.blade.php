@extends('public.layouts.app')
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






    .timeline-container {
        font-family: "Roboto", sans-serif;
        width: 50%;
        margin: auto;
        display: block;
        position: relative;
    }

    .timeline-container ul.tl {
        margin: 20px 0;
        padding: 0;
        display: inline-block;

    }

    .timeline-container ul.tl li {
        list-style: none;
        margin: auto;
        min-height: 50px;
        border-left: 3px solid #36ad02;
        padding: 0 0 50px 30px;
        position: relative;
        display: flex;
        flex-direction: row;
    }



    .timeline-container ul.tl li.dashed {
        border-left: 1px dashed #2d2e2e;
    }

    .timeline-container ul.tl li:last-child {
        border-left: 0;
    }

    .timeline-container ul.tl li .item-icon {
        position: absolute;
        left: -10px;
        top: -5px;
        content: " ";
        border: 8px solid rgba(255, 255, 255, 0.74);
        border-radius: 500%;
        background: #28a102;
        height: 20px;
        width: 20px;
    }

    .timeline-container ul.tl li:hover::before {
        border-color: #28a102;
        transition: all 1000ms ease-in-out;
    }

    ul.tl li .item-text {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    ul.tl li .item-title {}

    ul.tl li .item-detail {
        color: rgba(0, 0, 0, 0.5);
        font-size: 12px;
    }

    ul.tl li .item-timestamp {
        color: #8D8D8D;
        font-size: 12px;
        text-align: right;
        padding-left: 20px;
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
                            <a href="{{ route('public.orders.index') }}" class="btn btn-xs btn-secondary">Back to list</a>
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
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td style="text-align: right;">{{ $item->sub_total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody class="card-table__body card-table__body--merge-rows">
                                    <tr>
                                        <th>Subtotal</th>
                                        <td style="text-align: right;">{{ $order->sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping Charge</th>
                                        <td style="text-align: right;">{{ $order->shipping_charge }}</td>
                                    </tr>
                                    <tr>
                                        <th>Handling Charge</th>
                                        <td style="text-align: right;">{{ $order->handling_charge }}</td>
                                    </tr>
                                    <tr>
                                        <th>GST</th>
                                        <td style="text-align: right;">{{ $order->gst_charge }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <td style="text-align: right;">{{ $order->payable_amount }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 no-gutters mx-n2 mb-3">
                    <div class="col-sm-6 col-12 px-2">
                        <div class="card address-card address-card--featured">
                            <div class="address-card__badge tag-badge tag-badge--theme">
                                Delivery Address
                            </div>
                            <div class="address-card__body">

                                <div class="address-card__name">{{ $shippingAddress->name }}</div>
                                <div class="address-card__row">
                                    {{ $shippingAddress->address }}<br />{{ $shippingAddress->address_2 }}
                                </div>

                                <div class="address-card__row">
                                    <div class="address-card__row-title">
                                        Phone Number
                                    </div>
                                    <div class="address-card__row-content">
                                        {{ $shippingAddress->phone }}
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <small> <i>Map Address:</i> {{ $shippingAddress->google_map_address }}</small>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12 px-2">
                        <div class="card address-card address-card--featured">
                            <div class="address-card__badge tag-badge tag-badge--theme">
                                Billing Address
                            </div>
                            <div class="address-card__body">

                                <div class="address-card__name">{{ $billingAddress->name }}</div>
                                <div class="address-card__row">
                                    {{ $billingAddress->address }}<br />{{ $billingAddress->address_2 }}<br />{{ $billingAddress->city }},
                                    {{ $billingAddress->state }} - {{ $billingAddress->pincode }}
                                </div>
                                @if ($billingAddress->land_mark)
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">
                                            Landmark
                                        </div>
                                        <div class="address-card__row-content">
                                            {{ $billingAddress->land_mark }}
                                        </div>
                                    </div>
                                @endif
                                <div class="address-card__row">
                                    <div class="address-card__row-title">
                                        Phone Number
                                    </div>
                                    <div class="address-card__row-content">
                                        {{ $billingAddress->phone }}
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

                </div>
            </div>
            @if (count($orderStatus))
                <div class="col-md-12 col-lg-6 card">


                    <div class="timeline-container">
                        <ul class="tl">
                            <li>
                                <div class="item-icon"></div>
                                <div class="item-text">
                                    <div
                                        class="item-title font-weight-bold  {{ $orderStatus->where('status', 'ORDER CONFIRMED')->count() ? 'text-success' : 'text-muted' }}">
                                        ORDER CONFIRMED
                                    </div>
                                    @if ($orderStatus->where('status', 'ORDER CONFIRMED')->first())
                                        <div class="item-detail">
                                            {{ $orderStatus->where('status', 'ORDER CONFIRMED')->pluck('created_at')->first() }}
                                        </div>
                                    @endif
                                </div>
                            </li>
                            <li class="tl-item">
                                <div class="item-icon"></div>
                                <div class="item-text">
                                    <div
                                        class="item-title font-weight-bold {{ $orderStatus->where('status', 'MATERIAL LOADED')->count() ? 'text-success' : 'text-muted' }}">
                                        MATERIAL LOADED</div>
                                    @if ($orderStatus->where('status', 'MATERIAL LOADED')->first())
                                        <div class="item-detail">
                                            {{ $orderStatus->where('status', 'MATERIAL LOADED')->pluck('created_at')->first() }}
                                        </div>
                                    @endif
                                </div>
                            </li>

                            <li class="tl-item">
                                <div class="item-icon"></div>
                                <div class="item-text">
                                    <div
                                        class="item-title font-weight-bold {{ $orderStatus->where('status', 'INVOICE GENERATED')->count() ? 'text-success' : 'text-muted' }}">
                                        INVOICE GENERATED</div>
                                    @if ($orderStatus->where('status', 'INVOICE GENERATED')->first())
                                        <div class="item-detail">
                                            {{ $orderStatus->where('status', 'INVOICE GENERATED')->pluck('created_at')->first() }}
                                        </div>
                                    @endif
                                </div>
                            </li>

                            <li class="tl-item">
                                <div class="item-icon"></div>
                                <div class="item-text">
                                    <div
                                        class="item-title font-weight-bold {{ $orderStatus->where('status', 'PAYMENT RECIVED')->count() ? 'text-success' : 'text-muted' }}">
                                        PAYMENT RECIVED</div>
                                    @if ($orderStatus->where('status', 'PAYMENT RECIVED')->first())
                                        <div class="item-detail">
                                            {{ $orderStatus->where('status', 'PAYMENT RECIVED')->pluck('created_at')->first() }}
                                        </div>
                                    @endif
                                </div>
                            </li>

                            <li class="tl-item">
                                <div class="item-icon"></div>
                                <div class="item-text">
                                    <div
                                        class="item-title font-weight-bold {{ $orderStatus->where('status', 'ORDER SHIPPED')->count() ? 'text-success' : 'text-muted' }}">
                                        ORDER SHIPPED</div>
                                    @if ($orderStatus->where('status', 'ORDER SHIPPED')->first())
                                        <div class="item-detail">
                                            {{ $orderStatus->where('status', 'ORDER SHIPPED')->pluck('created_at')->first() }}
                                        </div>
                                    @endif
                                </div>
                            </li>

                            <li class="tl-item">
                                <div class="item-icon"></div>
                                <div class="item-text">
                                    <div
                                        class="item-title font-weight-bold {{ $orderStatus->where('status', 'GOODS-IN-TRANSIT')->count() ? 'text-success' : 'text-muted' }}">
                                        GOODS-IN-TRANSIT</div>
                                    @if ($orderStatus->where('status', 'GOODS-IN-TRANSIT')->first())
                                        <div class="item-detail">
                                            {{ $orderStatus->where('status', 'GOODS-IN-TRANSIT')->pluck('created_at')->first() }}
                                        </div>
                                    @endif
                                </div>
                            </li>

                            <li class="tl-item ">
                                <div class="item-icon"></div>
                                <div class="item-text">
                                    <div
                                        class="item-title font-weight-bold {{ $orderStatus->where('status', 'MATERIAL DELIVERED')->count() ? 'text-success' : 'text-muted' }}">
                                        MATERIAL DELIVERED</div>
                                    @if ($orderStatus->where('status', 'MATERIAL DELIVERED')->first())
                                        <div class="item-detail">
                                            {{ $orderStatus->where('status', 'MATERIAL DELIVERED')->pluck('created_at')->first() }}
                                        </div>
                                    @endif
                                </div>
                            </li>






                        </ul>

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
