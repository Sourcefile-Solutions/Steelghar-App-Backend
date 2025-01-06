@extends('layouts.app')
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

                                            @if ($is_full_payment)
                                                <td>₹{{ $order->payable_amount }}</td>
                                            @else
                                                <td>₹{{ $order->advance_payment }}</td>
                                            @endif

                                        </tr>
                                    </tfoot>
                                </table>

                                <button type="submit" class="btn btn-primary btn-xl btn-block" data-toggle="modal"
                                    data-target="#exampleModal">
                                    Place Order
                                </button>





                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <a href="{{ route('checkout') }}"><button
                                                        class="btn btn-secondary">Failed</button></a>
                                                <form action="{{ route('payment.success') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{ $is_full_payment }}"
                                                        name="is_full_payment">
                                                    <button class="btn btn-primary" type="submit">Success</button>
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
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
