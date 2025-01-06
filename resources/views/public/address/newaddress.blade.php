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
                                    <a href={{ route('editprofile') }}>Edit Profile</a>
                                </li>
                                <li class="account-nav__item">
                                    <a href={{ route('orderhistory') }}>Order History</a>
                                </li>

                                <li class="account-nav__item">
                                    <a href={{ route('address.index') }}>Addresses</a>
                                </li>


                                <li class="account-nav__divider" role="presentation"></li>
                                <li class="account-nav__item">
                                    <a href="account-login.html">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                        <div class="card">
                            <div class="card-header">
                                <h5>New Address</h5>
                            </div>
                           
                            <div class="card-divider"></div>
                            <div class="card-body card-body--padding--2">
                                <form action="{{ route('store-address') }}" method="POST" id="address-form">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <div class="col-12 col-lg-12 col-xl-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="address-first-name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Your Name" value="{{ old('name') }}"/>
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address-last-name">Mobile Number</label>
                                                <input type="text" class="form-control" name="phone"
                                                    placeholder="Your Mobile" value="{{ old('phone') }}" maxlength="10"/>
                                                @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address-address1">Street Address</label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="House number and street name" value="{{ old('address') }}"/>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <label for="address-address2" class="sr-only">Street Address</label>
                                            <input type="text" class="form-control mt-2" name="address2"
                                                placeholder="Apartment, suite, unit etc." value="{{ old('address2') }}"/>
                                            @error('address2')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address-city">City</label>
                                            <input type="text" class="form-control" name="city"
                                                placeholder="Enter City" value="{{ old('city') }}"/>
                                            @error('city')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="address-state">State</label>
                                            <input type="text" class="form-control" name="state"
                                                placeholder="Enter State" value="{{ old('state') }}"/>
                                            @error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="address-postcode">Pincode</label>
                                                <input type="text" class="form-control" name="pincode"
                                                    placeholder="Enter Pincode" value="{{ old('pincode') }}"/>
                                                @error('pincode')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group  col-md-6">
                                                <label for="address-email">Landmark(optional)</label>
                                                <input type="text" class="form-control" name="landmark"
                                                    placeholder="Enter Landmark" value="{{ old('landmark') }}"/>
                                                @error('landmark')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 pt-3 mt-3">
                                            <button class="btn btn-primary" type="submit" id="submit-address">Add
                                                Address</button>
                                        </div>

                                    </div>
                                </form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#submit-address', function(e) {

            e.preventDefault();
            var formData = new FormData($('#address-form')[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('store-address') }}",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data)

                    Swal.fire(
                            'Success!', data.message, 'success'
                        )
                        .then((result) => {
                            location.reload();
                        })

                    $('#address-form')[0].reset();
                },
                error: function(g) {
                    console.log(g)
                }
            });
        });
    });
</script>
