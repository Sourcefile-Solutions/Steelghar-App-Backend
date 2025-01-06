@extends('public.layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-space block-space--layout--spaceship-ledge-height"></div>
        <div class="block order-success">
            <div class="container">
                <div class="order-success__body">
                    <div class="order-success__header">
                        <div class="order-success__icon">
                            <svg width="100" height="100">
                                <path
                                    d="M50,100C22.4,100,0,77.6,0,50S22.4,0,50,0s50,22.4,50,50S77.6,100,50,100z M50,2C23.5,2,2,23.5,2,50
                                                                                                                                                                                                                                    s21.5,48,48,48s48-21.5,48-48S76.5,2,50,2z M44.2,71L22.3,49.1l1.4-1.4l21.2,21.2l34.4-34.4l1.4,1.4L45.6,71
                                                                                                                                                                                                                                    C45.2,71.4,44.6,71.4,44.2,71z" />
                            </svg>
                        </div>
                        <h1 class="order-success__title">Thank you</h1>
                        <div class="order-success__subtitle">
                            Your order has been received
                        </div>
                        <div class="order-success__actions">
                            <a href={{ route('public.home') }} class="btn btn-sm btn-secondary">Go To Homepage</a>

                            <a href={{ route('public.orders.show', ['id' => $order->order_id]) }}
                                class="btn btn-sm btn-secondary">Track
                                Order</a>
                        </div>
                    </div>
                    <div class="card order-success__meta">
                        <ul class="order-success__meta-list">
                            <li class="order-success__meta-item">
                                <span class="order-success__meta-title">Order number:</span>
                                <span class="order-success__meta-value">#{{ $order->order_id }}</span>
                            </li>
                            <li class="order-success__meta-item">
                                <span class="order-success__meta-title">Total:</span>
                                <span class="order-success__meta-value">{{ $order->payable_amount }}</span>
                            </li>
                            <li class="order-success__meta-item">
                                <span class="order-success__meta-title">Payment Method:</span>
                                <span class="order-success__meta-value">Online</span>
                            </li>
                        </ul>
                    </div>




                    <div class="order-success__addresses">
                        <div class="order-success__address card address-card">
                            <div class="address-card__badge tag-badge tag-badge--theme">
                                Delivery Address
                            </div>
                            <div class="address-card__body">
                                <div class="address-card__name">{{ $shippingAddress->name }}</div>
                                <div class="address-card__row">
                                    {{ $shippingAddress->address }}<br />{{ $shippingAddress->address_2 }}<br />
                                    {{-- {{ $shippingAddress->state }},
                                    {{ $shippingAddress->city }} <br />
                                    {{ $shippingAddress->pincode }}<br />
                                    @if ($shippingAddress->land_mark)
                                        <span>Landmark : {{ $shippingAddress->land_mark }}</span>
                                    @endif --}}
                                </div>
                                <div class="address-card__row">
                                    <div class="address-card__row-title">Phone Number</div>
                                    <div class="address-card__row-content">
                                        {{ $shippingAddress->phone }}
                                    </div>
                                </div>
                                @if (auth()->user()->email)
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Email Address</div>
                                        <div class="address-card__row-content">
                                            {{ auth()->user()->email }}
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-2">
                                    <i> Map Location</i>:
                                    <small>{{ $shippingAddress->google_map_address }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="order-success__address card address-card">
                            <div class="address-card__badge tag-badge tag-badge--theme">
                                Billing Address
                            </div>
                            <div class="address-card__body">
                                <div class="address-card__name">{{ $billingAddress->name }}</div>
                                <div class="address-card__row">
                                    {{ $billingAddress->address }}<br />{{ $billingAddress->address_2 }}<br />{{ $billingAddress->state }},
                                    {{ $billingAddress->city }} <br />
                                    {{ $billingAddress->pincode }}<br />
                                    @if ($billingAddress->land_mark)
                                        <span>Landmark : {{ $billingAddress->land_mark }}</span>
                                    @endif
                                </div>
                                <div class="address-card__row">
                                    <div class="address-card__row-title">Phone Number</div>
                                    <div class="address-card__row-content">
                                        {{ $billingAddress->phone }}
                                    </div>
                                </div>
                                @if (auth()->user()->email)
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Email Address</div>
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
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
