@extends('public.layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">
                    <h1 class="block-header__title">Payment</h1>
                </div>
            </div>
        </div>
        <div class="checkout block">
            <div class="container container--max--xl">
                <div class="row">

                    <div class="col-12 col-lg-6 col-xl-6">
                        <div class="checkout__payment-methods payment-methods">
                            <ul class="payment-methods__list">
                                <li class="payment-methods__item payment-methods__item--active">
                                    <label class="payment-methods__item-header"><span
                                            class="payment-methods__item-radio input-radio"><span
                                                class="input-radio__body"><input class="input-radio__input"
                                                    name="checkout_payment_method" type="radio" checked="checked" />
                                                <span class="input-radio__circle"></span> </span></span><span
                                            class="payment-methods__item-title">Direct bank transfer</span></label>
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
                                                class="input-radio__body"><input class="input-radio__input"
                                                    name="checkout_payment_method" type="radio" />
                                                <span class="input-radio__circle"></span> </span></span><span
                                            class="payment-methods__item-title">Check payments</span></label>
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
                                                class="input-radio__body"><input class="input-radio__input"
                                                    name="checkout_payment_method" type="radio" />
                                                <span class="input-radio__circle"></span> </span></span><span
                                            class="payment-methods__item-title">PayPal</span></label>
                                    <div class="payment-methods__item-container">
                                        <div class="payment-methods__item-details text-muted">
                                            Pay via PayPal; you can pay with your credit card
                                            if you don’t have a PayPal account.
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-6 mt-4 mt-lg-0">
                        <div class="card mb-0">
                            <div class="card-body card-body--padding--2">
                                <table class="checkout__totals">
                                    <tfoot class="checkout__totals-footer">
                                        <tr>
                                            <th>Total</th>
                                            <td>₹{{ $payableAmount }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <form action="{{ route('public.checkout.payment.success') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <button type="button" class="btn btn-primary btn-xl btn-block" id="rzp-button1">
                                        Place Order
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection

@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ env('RAZORPAY_ID') }}",
            "amount": "{{ $razorpay['amount'] }}",
            "currency": "{{ $razorpay['currency'] }}",
            "name": "HAQ ENTERPRISES Pvt Ltd",
            "description": "Online Transaction",
            "image": "https://img.freepik.com/free-vector/bird-colorful-logo-gradient-vector_343694-1365.jpg",
            "order_id": "{{ $razorpay['order_id'] }}",
            "callback_url": "{{ route('public.razorpay-callback') }}",
            "prefill": {
                "name": "{{ $customer->name }}",
                "email": "{{ $customer->email }}",
                "contact": "{{ $customer->phone }}"
            },
            "theme": {
                "color": "#ef0800"
            }
        };
        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button1').onclick = function(e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>
@endsection
