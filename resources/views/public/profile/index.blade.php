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

                                <li class="account-nav__item account-nav__item--active">
                                    <a href="#">Edit Profile</a>
                                </li>
                                <li class="account-nav__item">
                                    <a href="{{ route('public.orders.index') }}">Order History</a>
                                </li>

                                <li class="account-nav__item">
                                    <a href="{{ route('public.profile.address') }}">Addresses</a>
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
                                <h5>Edit Profile</h5>
                            </div>

                            <div class="card-divider"></div>
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            <div class="card-body card-body--padding--2">

                                <form method="post" action="{{ route('public.profile.update') }}">
                                    @csrf
                                    @method('put')
                                    <div class="justify-content-center no-gutters row">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="profile-first-name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="First Name" value="{{ auth()->user()->name }}" />
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="profile-email">Email Address</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Email Address" value="{{ auth()->user()->email }}" />
                                                @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="profile-phone">Phone Number</label>
                                                <input type="text" class="form-control" name="phone"
                                                    placeholder="Phone Number" value="{{ auth()->user()->phone }}"
                                                    maxlength="10" />
                                                @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-0">
                                                <button class="btn btn-primary mt-3" type="submit">Update</button>
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
