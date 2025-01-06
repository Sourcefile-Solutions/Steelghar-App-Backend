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
                                {{-- <li class="account-nav__item account-nav__item--active">
                      <a href={{route('myaccount')}}>Dashboard</a>
                    </li> --}}

                                <li class="account-nav__item">
                                    <a href="{{ route('public.profile') }}">Edit Profile</a>
                                </li>
                                <li class="account-nav__item  ">
                                    <a href="{{ route('public.orders.index') }}">Order History</a>
                                </li>

                                <li class="account-nav__item account-nav__item--active">
                                    <a href="#">Addresses</a>
                                </li>

                                {{-- <li class="account-nav__item">
                      <a href="account-password.html">Password</a>
                    </li> --}}
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
                        <div class="addresses-list">
                            <a href="{{ route('public.profile.address.create') }}"
                                class="addresses-list__item addresses-list__item--new h-100">
                                <div class="addresses-list__plus"></div>
                                <div class="btn btn-secondary btn-sm">Add New</div>
                            </a>

                            @foreach ($addressess as $address)
                                <div class="addresses-list__divider"></div>
                                <div class="addresses-list__item card address-card mb-4">

                                    @if ($address->is_default)
                                        <div class="address-card__badge tag-badge tag-badge--theme">
                                            Default
                                        </div>
                                    @endif

                                    <div class="address-card__body">
                                        <div class="address-card__name">{{ $address->name }}</div>
                                        <div class="address-card__row">
                                            {{ $address->address }}, {{ $address->address_2 }}<br />
                                            {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                            <br>
                                            <small>{{ $address->landmark }}</small>

                                        </div>
                                        <div class="address-card__row">
                                            <div class="address-card__row-title">Phone Number</div>
                                            <div class="address-card__row-content">
                                                {{ $address->phone }}
                                            </div>
                                        </div>
                                        <div class="address-card__row">
                                            <div class="address-card__row-title">Email Address</div>
                                            <div class="address-card__row-content">
                                                {{ auth()->user()->email }}
                                            </div>
                                        </div>
                                        <div class="address-card__footer">

                                            <form
                                                action="{{ route('public.profile.address.delete', ['address' => $address->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <a
                                                    href="{{ route('public.profile.address.edit', ['address' => $address->id]) }}">Edit</a>&nbsp;&nbsp;
                                                <button type="submit" class=" btn">Remove</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <div class="addresses-list__divider"></div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
