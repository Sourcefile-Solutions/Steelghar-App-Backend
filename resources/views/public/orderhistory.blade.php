@extends('layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-space block-space--layout--after-header"></div>
        <div class="block">
            <div class="container container--max--xl">
                <div class="row">
                    <div class="col-12 col-lg-3 d-flex">
                        <div class="account-nav flex-grow-1">
                            <h4 class="account-nav__title">Navigation</h4>
                            <ul class="account-nav__list">


                                <li class="account-nav__item">
                                    <a href={{ route('my-profile') }}>Edit Profile</a>
                                </li>
                                <li class="account-nav__item account-nav__item--active">
                                    <a href={{ route('orderhistory') }}>Order History</a>
                                </li>

                                <li class="account-nav__item">
                                    <a href={{ route('address.index') }}>Addresses</a>
                                </li>

                                {{-- <li class="account-nav__item">
                      <a href="account-password.html">Password</a>
                    </li> --}}

                                <li class="account-nav__divider" role="presentation"></li>
                                <li class="account-nav__item">
                                    <form action={{ route('web-logout') }} method="post">
                                        @csrf

                                        <button type="submit" class="btn btn-block btn-danger">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                        <div class="card">
                            <div class="card-header">
                                <h5>Order History</h5>
                            </div>
                            <div class="card-divider"></div>
                            <div class="card-table">
                                <div class="table-responsive-sm">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Order</th>
                                            </tr>
                                        </thead>

                                        @foreach ($orderHistory as $orderHistory)
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="account-order-details.html">{{ $orderHistory->order_id }}</a>
                                                    </td>
                                                    <td>{{ $orderHistory->order_date }}</td>
                                                    <td>{{ $orderHistory->current_status }}</td>
                                                    <td>{{ number_format((float) $orderHistory->sub_total, 2, '.', '') }}
                                                    </td>
                                                    <td class="d-flex">
                                                        <a href={{ route('order-tracking', [$orderHistory->id]) }}
                                                            class="btn btn-sm btn-outline-danger">View Order</a>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="card-divider"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
