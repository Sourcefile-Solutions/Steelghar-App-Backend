@extends('public.layouts.app')
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
                                    <a href="{{ route('public.profile') }}">Edit Profile</a>
                                </li>
                                <li class="account-nav__item  account-nav__item--active">
                                    <a href="#">Order History</a>
                                </li>

                                <li class="account-nav__item">
                                    <a href="{{ route('public.profile.address') }}">Addresses</a>
                                </li>


                                <li class="account-nav__divider" role="presentation"></li>
                                <li class="account-nav__item">
                                    <form action="{{ route('public.logout') }}" method="post">
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

                                        @foreach ($orders as $order)
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="{{ route('public.orders.show', [$order->order_id]) }}">{{ $order->order_id }}</a>
                                                    </td>
                                                    <td>{{ $order->order_date }}</td>
                                                    <td>{{ $order->current_status }}</td>
                                                    <td>{{ $order->payable_amount }}
                                                    </td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('public.orders.show', [$order->order_id]) }}"
                                                            class="btn btn-sm btn-outline-success">View Order</a>

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
