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
                                {{-- <li class="account-nav__item account-nav__item--active">
                      <a href={{route('myaccount')}}>Dashboard</a>
                    </li> --}}

                                <li class="account-nav__item">
                                    <a href={{ route('editprofile') }}>Edit Profile</a>
                                </li>
                                <li class="account-nav__item">
                                    <a href={{ route('orderhistory') }}>Order History</a>
                                </li>

                                <li class="account-nav__item account-nav__item--active">
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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="addresses-list">

                            <a href={{ route('add-address') }} class="addresses-list__item addresses-list__item--new">
                                <div class="addresses-list__plus"></div>
                                <div class="btn btn-secondary btn-sm">Add New</div>
                            </a>
                            <div class="addresses-list__divider"></div>

                            @foreach ($address as $address)
                                <div class="addresses-list__item card address-card">

                                    <div class="address-card__body">
                                        <div class="address-card__name">{{ $address->name }}</div>
                                        <div class="address-card__row">
                                            {{ $address->address }}<br />{{ $address->address2 }}<br />{{ $address->city }},
                                            {{ $address->state }} - {{ $address->pincode }}
                                        </div>
                                        <div class="address-card__row">
                                            <div class="address-card__row-title">Landmark</div>
                                            <div class="address-card__row-content">
                                                {{ $address->landmark }}
                                            </div>
                                        </div>
                                        <div class="address-card__row">
                                            <div class="address-card__row-title">Phone Number</div>
                                            <div class="address-card__row-content">
                                                {{ $address->phone }}
                                            </div>
                                        </div>

                                        <div class="address-card__footer">
                                            <a
                                                href="{{ route('edit-address', ['id' => $address->id]) }}">Edit</a>&nbsp;&nbsp;
                                            <a href="{{ route('destroy-address', ['id' => $address->id]) }}">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="addresses-list__divider"></div>
                            @endforeach
                            <div class="addresses-list__divider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
