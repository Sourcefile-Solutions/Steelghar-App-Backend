@extends('layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Checkout</h1>
                </div>
            </div>
        </div>


        <div class="checkout block">
            <div class="container container--max--xl">
                <div class="row">

                    <div class="checkout block">
                        <div class="container container--max--xl">
                            <div class="row">

                                <div class="col-12 col-lg-6 col-xl-6">

                                    <div class="row">
                                        <div class="col">
                                            <div class="card mb-lg-0">
                                                <div class="card-body card-body--padding--2">
                                                    <h3 class="card-title">Shipping Address </h3>

                                                    <div class="widget-filters__item">
                                                        <div class="filter filter--opened" data-collapse-item>
                                                            <div class="filter__body" data-collapse-content>
                                                                <div class="filter__container">
                                                                    <div class="filter-list">
                                                                        <div class="filter-list__list">

                                                                            @foreach ($addressess as $address)
                                                                                <label class="filter-list__item">
                                                                                    <span
                                                                                        class="filter-list__input input-radio">
                                                                                        <span class="input-radio__body">
                                                                                            <input
                                                                                                class="input-radio__input"
                                                                                                name="address"
                                                                                                type="radio"
                                                                                                value="{{ $address->id }}" />
                                                                                            <span
                                                                                                class="input-radio__circle"></span>
                                                                                        </span>
                                                                                    </span>
                                                                                    <div class="address-card__name mb-0">
                                                                                        {{ $address->name }}
                                                                                    </div>
                                                                                </label>
                                                                                <div class="address-card__row pl-4">
                                                                                    {{ $address->address }}
                                                                                    {{ $address->address2 }},<br>{{ $address->city }},
                                                                                    {{ $address->state }} -
                                                                                    {{ $address->pincode }}
                                                                                </div>
                                                                                <div
                                                                                    class="address-card__row pl-4 mt-0 font-italic">Phone : 
                                                                                    {{ $address->phone }}</div>
                                                                            @endforeach


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card widget widget-categories pt-3">

                                                        <ul class="widget-categories__list widget-categories__list--root"
                                                            data-collapse=""
                                                            data-collapse-opened-class="widget-categories__item--open">

                                                            <li class="widget-categories__item" data-collapse-item=""><a
                                                                    href="" class="widget-categories__link">
                                                                    <h4>Add Shipping Address</h4>
                                                                </a><button class="widget-categories__expander"
                                                                    type="button" data-collapse-trigger=""></button>
                                                                <div class="widget-categories__container"
                                                                    data-collapse-content="">

                                                                    <form action="{{ route('store-address') }}"
                                                                        method="POST" id="address-form">
                                                                        @csrf
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ auth()->user()->id }}">
                                                                        <div class="col-12 col-lg-12 col-xl-12">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label
                                                                                        for="address-first-name">Name</label>
                                                                                    <input type="text"
                                                                                        class="form-control" name="name"
                                                                                        placeholder="Your Name" />
                                                                                    @error('name')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="address-last-name">Mobile
                                                                                        Number</label>
                                                                                    <input type="text"
                                                                                        class="form-control" name="phone"
                                                                                        placeholder="Your Mobile" />
                                                                                    @error('phone')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="address-address1">Street
                                                                                    Address</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="address"
                                                                                    placeholder="House number and street name" />
                                                                                @error('address')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                                <label for="address-address2"
                                                                                    class="sr-only">Street
                                                                                    Address</label>
                                                                                <input type="text"
                                                                                    class="form-control mt-2"
                                                                                    name="address2"
                                                                                    placeholder="Apartment, suite, unit etc." />
                                                                                @error('address2')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="address-city">City</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="city"
                                                                                    placeholder="Enter City" />
                                                                                @error('city')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="address-state">State</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="state"
                                                                                    placeholder="Enter State" />
                                                                                @error('state')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label
                                                                                        for="address-postcode">Pincode</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="pincode"
                                                                                        placeholder="Enter Pincode" />
                                                                                    @error('pincode')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="form-group  col-md-6">
                                                                                    <label
                                                                                        for="address-email">Landmark(optional)</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="landmark"
                                                                                        placeholder="Enter Landmark" />
                                                                                    @error('landmark')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group mb-0 pt-3 mt-3">
                                                                                <button class="btn btn-primary"
                                                                                    type="submit" id="submit-address">Add
                                                                                    Address</button>
                                                                            </div>

                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </li>

                                                        </ul>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <div class="col-12 col-lg-6 col-xl-6 mt-4 mt-lg-0">
                                    <div class="card mb-0">
                                        <div class="card-body card-body--padding--2">
                                            <h3 class="card-title">Your Order</h3>
                                            <table class="checkout__totals">
                                                <thead class="checkout__totals-header">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th class="w-25">Kgs</th>
                                                        <th>Length</th>
                                                        <th>Total</th>


                                                    </tr>
                                                </thead>
                                                @foreach ($products as $cartProduct)
                                                    <tbody class="checkout__totals-products">
                                                        <tr>
                                                            <td class="pb-1">{{ $cartProduct->product_name }}
                                                                <!--<br><small>abc</small>-->
                                                            </td>
                                                            <td class="pb-1">{{ $cartProduct->weight }}</td>
                                                            <td class="pb-1">{{ $cartProduct->length }}</td>
                                                            <td class="pb-1 subtotal">{{ $cartProduct->price }}</td>

                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                                <tbody class="checkout__totals-subtotals">
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="subtotal">{{ $subTotal }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Shipping Charges</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="shipping">{{ $shippingCharge }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Handling Charges</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="handling">{{ $handlingCharge }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>GST</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="gst">{{ $gst }}</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="checkout__totals-footer" style="font-size: 18px">
                                                    <tr>
                                                        <th>Total Amount</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="total">{{ $totalAmount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pt-3"><span>Pay Now (as Advance)</span></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="pt-3" id="paynow">{{ $payNow }}</td>
                                                    </tr>
                                                    <tr class="pt-3">
                                                        <th class="pt-3">Pay Due on Delivery</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="pt-3" id="paydue">{{ $PayOnDelivery }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            {{-- <div class="checkout__payment-methods payment-methods">
                                                <ul class="payment-methods__list">
                                                    <li class="payment-methods__item payment-methods__item--active">
                                                        <label class="payment-methods__item-header"><span
                                                                class="payment-methods__item-radio input-radio"><span
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio"
                                                                        checked="checked" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">Direct
                                                                bank transfer</span></label>
                                                        <div class="payment-methods__item-container">
                                                            <div class="payment-methods__item-details text-muted">
                                                                Make your payment directly into our bank account.
                                                                Please use your Order ID as the payment reference.
                                                                Your order will not be shipped until the funds
                                                                have cleared in our account.
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="payment-methods__item">
                                                        <label class="payment-methods__item-header"><span
                                                                class="payment-methods__item-radio input-radio"><span
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">Check
                                                                payments</span></label>
                                                        <div class="payment-methods__item-container">
                                                            <div class="payment-methods__item-details text-muted">
                                                                Please send a check to Store Name, Store Street,
                                                                Store Town, Store State / County, Store Postcode.
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="payment-methods__item">
                                                        <label class="payment-methods__item-header"><span
                                                                class="payment-methods__item-radio input-radio"><span
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">Cash
                                                                on
                                                                delivery</span></label>
                                                        <div class="payment-methods__item-container">
                                                            <div class="payment-methods__item-details text-muted">
                                                                Pay with cash upon delivery.
                                                            </div>
                                                        </div>


                                                    </li>
                                                    <li class="payment-methods__item">
                                                        <label class="payment-methods__item-header"><span
                                                                class="payment-methods__item-radio input-radio"><span
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">PayPal</span></label>
                                                        <div class="payment-methods__item-container">
                                                            <div class="payment-methods__item-details text-muted">
                                                                Pay via PayPal; you can pay with your credit card
                                                                if you don’t have a PayPal account.
                                                            </div>
                                                        </div>



                                                    </li>
                                                </ul>
                                            </div> --}}


                                            <div class="d-flex justify-content-between">



                                                <form action="{{ route('payment') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="address_id" id="address_id">
                                                    <input type="hidden" name="is_full_payment" value="0">
                                                    <button type="submit" class="btn btn-danger">
                                                        Part Payment
                                                    </button>
                                                </form>


                                                <form action="{{ route('payment') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="address_id" id="address_id2">
                                                    <input type="hidden" name="is_full_payment" value="1">
                                                    @error('address_id')
                                                        <small class="alert text-danger">Choose Address</small>
                                                    @enderror
                                                    <button type="submit" class="btn btn-danger">
                                                        Pay Full Amount
                                                    </button>
                                                </form>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer">
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script>
        function subtotal(e) {
            let subtotal = 0;

            Array.from(document.getElementsByClassName("subtotal")).forEach(
                function(element, index, array) {
                    subtotal += Number(element.innerHTML)
                }
            );
            // console.log('aa', subtotal);

            const sub_total = document.getElementById('subtotal')
            const shipping = document.getElementById('shipping')
            const handling = document.getElementById('handling')
            const gst = document.getElementById('gst')
            const total = document.getElementById('total')
            const paynow = document.getElementById('paynow')
            const paydue = document.getElementById('paydue')
            // console.log(total);

            shipping_charges = (subtotal * 2) / 100;
            console.log(shipping_charges);

            handling_charges = (subtotal * 2) / 100;
            console.log(handling_charges);

            gst_amount = (subtotal * 18) / 100;
            console.log(gst);


            shipping.innerHTML = shipping_charges.toFixed(2)
            handling.innerHTML = handling_charges.toFixed(2)
            gst.innerHTML = gst_amount.toFixed(2)
            sub_total.innerHTML = subtotal.toFixed(2)

            total_price = Number(subtotal) + Number(shipping_charges) + Number(handling_charges) + Number(gst_amount)
            console.log(total_price);

            total.innerHTML = Math.round(total_price)

            const paymentElements = document.querySelectorAll('.payment');
            let pay_now = 0;
            paymentElements.forEach(payment => {
                const min_range = payment.dataset.min_range;
                const max_range = payment.dataset.max_range;
                const payment_percentage = payment.dataset.payment_percentage;

                if (min_range <= total_price && max_range >= total_price) {
                    pay_now = Number(total_price * payment_percentage) / 100

                    console.log('ss', pay_now.toFixed(2));
                }

                paynow.innerHTML = Math.round(pay_now)

                pay_due = total_price - pay_now;

                console.log(pay_due);

                paydue.innerHTML = Math.round(pay_due)

                // Do something with the payment data
                console.log(
                    `min_range: ${min_range}, max_range: ${max_range}, payment_percentage:${payment_percentage}`
                );
            });

        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            subtotal();
        });
    </script> --}}
    <script>
        var radioButtons = document.querySelectorAll('.input-radio__input');
        let address_id = 0;
        radioButtons.forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {
                if (this.checked) {
                    address_id = this.value;
                    console.log('Selected value:', address_id);
                    document.getElementById('address_id').value = address_id
                    document.getElementById('address_id2').value = address_id
                }
            });
        });
    </script>
@endsection
