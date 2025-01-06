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
                        <div class="card">
                            <div class="card-header">
                                <h5>Edit Address</h5>
                            </div>
                            <div class="card-divider"></div>
                            <div class="card-body card-body--padding--2">

                                <form action="{{ route('public.profile.address.update', ['address' => $address->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row no-gutters">
                                        <div class="col-12 ">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="address-first-name">Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $address->name }}" placeholder="Your Name" />
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="address-last-name">Mobile Number</label>
                                                    <input type="tel" class="form-control" name="phone"
                                                        value="{{ $address->phone }}" placeholder="Your Mobile" />
                                                    @error('phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="address-address1">Street Address</label>
                                                <input type="text" class="form-control" name="address"
                                                    value="{{ $address->address }}"
                                                    placeholder="House number and street name" />
                                                @error('address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <label for="address-address2" class="sr-only">Street Address</label>
                                                <input type="text" class="form-control mt-2" name="address_2"
                                                    value="{{ $address->address_2 }}"
                                                    placeholder="Apartment, suite, unit etc." />
                                                @error('address_2')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- <div class="form-group">
                                                <label for="address-country">Country</label>
                                                <select name="country" class="form-control">
                                                    <option value="">Select a country...</option>
                                                    <option value="AU">India</option>
                                                    <option value="DE">Germany</option>
                                                    <option value="FR">France</option>
                                                    <option value="IT">Italy</option>
                                                    <option value="RU">Russia</option>
                                                    <option value="UA">Ukraine</option>
                                                    <option value="US">United States</option>
                                                </select>
                                            </div> --}}

                                            <div class="form-group">
                                                <label for="address-city">City</label>
                                                <input type="text" class="form-control" name="city"
                                                    value="{{ $address->city }}" placeholder="Enter City" />
                                                @error('city')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="address-state">State</label>
                                                <input type="text" class="form-control" name="state"
                                                    value="{{ $address->state }}" placeholder="Enter State" />
                                                @error('state')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="address-postcode">Pincode</label>
                                                <input type="text" class="form-control" name="pincode"
                                                    value="{{ $address->pincode }}" placeholder="Enter Pincode" />
                                                @error('pincode')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6 mb-0">
                                                    <label for="address-email">Landmark(optional)</label>
                                                    <input type="text" class="form-control" name="land_mark"
                                                        value="{{ $address->land_mark }}" placeholder="Enter Landmark" />
                                                    @error('land_mark')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6 mb-0">
                                                    <label for="address-email">Alternate Phone(optional)</label>
                                                    <input type="text" class="form-control" name="alternate_phone"
                                                        value="{{ $address->alternate_phone }}"
                                                        placeholder="Alternate Phone" />
                                                    @error('alternate_phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6 mb-0">
                                                    <label for="address-email">Email address</label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ $address->email }}" placeholder="user@example.com" />
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="form-group mt-3">
                                                <div class="form-check">
                                                    <span class="input-check form-check-input"><span
                                                            class="input-check__body"><input class="input-check__input"
                                                                type="checkbox" name="is_default" value="1" />
                                                            <span class="input-check__box"></span>
                                                            <span class="input-check__icon"><svg width="9px"
                                                                    height="7px">
                                                                    <path
                                                                        d="M9,1.395L3.46,7L0,3.5L1.383,2.095L3.46,4.2L7.617,0L9,1.395Z" />
                                                                </svg> </span></span></span><label class="form-check-label"
                                                        for="default-address">Set as my default address</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0 pt-3 mt-3">
                                                <button class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
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
