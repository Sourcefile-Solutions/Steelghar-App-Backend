@extends('public.layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Checkout</h1>
                </div>
            </div>
        </div>



        <div class="container-lg">
            <div class="row g-2">
                <div class="col-12 col-lg-6  mb-4">
                    <div class="card-body rounded-lg border shadow-sm bg-white">

                        <h5 class="">Delivery Address</h5>

                        <div>
                            <button class="btn btn-info rounded" id="use-current-location"><i
                                    class="fa fa-location-crosshairs"></i> Use My Current
                                Location</button>
                        </div>
                        <div style="text-align: center;">
                            <b>or</b>
                        </div>
                        <div class="mt-2 mb-4">
                            <input type="hidden" id="start" name="start"
                                value="Steel Ghar, Rampura main road, beside Bharat petrol bunk, Margondanahalli, Bengaluru, Karnataka, India"
                                autocomplete="off">

                            <div class="mb-2">
                                <input type="text" id="end" name="end"
                                    class="rounded-lg border px-3 w-100 bg-white " placeholder="Enter Delivery Location"
                                    value="" autocomplete="off" style="height: 50px">
                                <small class="text-danger font-weight-bold" id="km_error"></small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="rounded-lg border px-3 w-100 bg-white "
                                        style="height: 35px" name="name" id="delivery_name"
                                        placeholder="Enter Your Full Name" value="{{ auth()->user()->name }}">
                                    <small class="text-danger font-weight-bold" id="delivery_name_error"></small>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="tel" class="rounded-lg border px-3 w-100 bg-white " maxlength="10"
                                        style="height: 35px" name="phone" id="delivery_phone"
                                        placeholder="Enter Phone Number" value="{{ auth()->user()->phone }}">
                                    <small class="text-danger font-weight-bold" id="delivery_phone_error"></small>

                                </div>
                            </div>


                            <div class="mb-2">
                                <input type="text" class="rounded-lg border px-3 w-100 bg-white " style="height: 35px"
                                    name="address_line_1" id="address_line_1" placeholder="Address Line One"
                                    autocomplete="off">
                                <small class="text-danger font-weight-bold" id="address_line_1_error"></small>
                            </div>

                            <div class="mb-2">
                                <input type="text" class="rounded-lg border px-3 w-100 bg-white " style="height: 35px"
                                    name="address_line_2" id="address_line_2" placeholder="Address Line Two"
                                    autocomplete="off">
                                <small class="text-danger font-weight-bold" id="address_line_2_error"></small>
                            </div>



                            <div id="output" class="mb-2 text-muted">

                            </div>

                            <div id="map" class="border" style="height: 250px;"></div>
                        </div>

                        <h5 class="">Billing Address</h5>

                        <div class="mb-2">
                            @foreach ($addressess as $address)
                                <div class="bg-light shadow-sm p-3 rounded billig_address mb-2"
                                    data-id="{{ $address->id }}">
                                    <div class="form-check-inline font-weight-bold">
                                        <input class="form-check-input" type="radio" name="options" id="option2"
                                            value="Option 2">
                                        <label class="form-check-label" for="option2">
                                            {{ $address->name }}
                                        </label>


                                    </div>
                                    <div>
                                        <p>{{ $address->address }}
                                            {{ $address->address2 }},<br>{{ $address->city }},
                                            {{ $address->state }} -
                                            {{ $address->pincode }} </p>
                                    </div>
                                </div>
                            @endforeach
                            <small class="text-danger font-weight-bold" id="address_error"></small>
                        </div>

                        <div>
                            <button class="btn btn-danger rounded btn-sm" id="add_billing_btn">Add New Billing
                                Address</button>
                        </div>

                        <div id="billing_address_div" style="display:{{ $errors->any() ? 'block' : 'none' }} ">


                            <form action="addressess" method="post">
                                @csrf

                                <div class="row mt-4">

                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="rounded-lg border px-3 w-100 bg-white "
                                            style="height: 35px" name="name" placeholder="Enter Full Name"
                                            value="{{ old('name') ? old('name') : auth()->user()->name }}">
                                        @error('name')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror

                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <input type="tel" class="rounded-lg border px-3 w-100 bg-white "
                                            maxlength="10" style="height: 35px" name="phone"
                                            placeholder="Enter Phone Number"
                                            value="{{ old('phone') ? old('phone') : auth()->user()->phone }}">
                                        @error('phone')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-2 col-md-12">
                                        <input type="text" class="rounded-lg border px-3 w-100 bg-white "
                                            style="height: 35px" name="address" placeholder="Address Line Two"
                                            value="{{ old('address') }}">
                                        @error('address')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-2 col-md-12">
                                        <input type="text" class="rounded-lg border px-3 w-100 bg-white "
                                            style="height: 35px" name="address_2" placeholder="Address Line Two"
                                            value="{{ old('address_2') }}">
                                        @error('address_2')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="rounded-lg border px-3 w-100 bg-white "
                                            style="height: 35px" name="land_mark" id="land_mark"
                                            placeholder="Enter land mark" value="{{ old('land_mark') }}">
                                        @error('land_mark')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="rounded-lg border px-3 w-100 bg-white "
                                            style="height: 35px" name="city" placeholder="Enter city"
                                            value="{{ old('city') }}">
                                        @error('city')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="rounded-lg border px-3 w-100 bg-white "
                                            style="height: 35px" name="state" placeholder="Enter state"
                                            value="{{ old('state') }}">

                                        @error('state')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror

                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <input type="tel" class="rounded-lg border px-3 w-100 bg-white "
                                            maxlength="6" style="height: 35px" name="pincode" id="pincode"
                                            placeholder="Enter pincode" value="{{ old('pincode') }}">

                                        @error('pincode')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror

                                    </div>



                                </div>
                                <div style="text-align: end">
                                    <button class="btn btn-sm btn-dark rounded">Add Address</button>
                                </div>

                            </form>

                        </div>


                    </div>
                </div>
                <div class="col-6 col-12 col-lg-6 ">
                    <div class="card-body rounded-lg border shadow-sm">

                        <h5 class="">Product Details</h5>

                        <div class="table-responsive">
                            <table class="table  table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Details</th>
                                        <th style="text-align: end;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartProducts as $cartProduct)
                                        <tr>
                                            <td class="pb-1">{{ $cartProduct['product_name'] }}

                                                @if ($cartProduct['category_id'] == '1')
                                                    <br><small>Brand :
                                                        {{ $cartProduct['brand_name'] }}</small>
                                                @elseif ($cartProduct['category_id'] == '2')

                                                @elseif ($cartProduct['category_id'] == '3')
                                                    ({{ $cartProduct['color'] }})
                                                    <br><small>Thickness :
                                                        {{ $cartProduct['thickness'] }}mm</small>
                                                @else
                                                    <br><small>Thickness :
                                                        {{ $cartProduct['thickness'] }}mm</small>
                                                @endif

                                            </td>
                                            <td>
                                                @if ($cartProduct['category_id'] == '1')
                                                    <small>Weight:{{ $cartProduct['weight'] }}Kg
                                                        <br> Length :{{ $cartProduct['length'] }}</small>
                                                @elseif ($cartProduct['category_id'] == '2')
                                                    <small>Height:{{ $cartProduct['height'] }}ft
                                                        <br>Length : {{ $cartProduct['length'] }}
                                                        <br>Weight : {{ $cartProduct['weight'] }}Kg</small>
                                                @elseif ($cartProduct['category_id'] == '3')
                                                    <small>Size: {{ $cartProduct['size'] }}
                                                        <br> No.of Sheets:
                                                        {{ $cartProduct['no_of_sheet'] }}
                                                        <br>Weight : {{ $cartProduct['weight'] }}Kg</small>
                                                @else
                                                    <small>Weight:
                                                        {{ $cartProduct['weight'] }}kg
                                                        <br> Length: {{ $cartProduct['length'] }}</small>
                                                @endif
                                            </td>
                                            <td style="text-align: end;">
                                                {{ $cartProduct['sub_total'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                        <div class="row border-top pt-2  mb-2">
                            <div class="col-6 fw-bold">Total Weight</div>
                            <div class="col-6 text-end" style="text-align: end;">{{ $totalWeight }}Kg</div>
                        </div>

                        <div class="container mt-2">
                            <div class="row border-top pt-2  mb-2">
                                <div class="col-6 fw-bold">Subtotal</div>
                                <div class="col-6 text-end" style="text-align: end;" id="subtotal"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">Shipping Charges</div>
                                <div class="col-6 text-end" style="text-align: end;" id="shipping"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">Handling Charges</div>
                                <div class="col-6 text-end" style="text-align: end;" id="handling">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 fw-bold">GST <span id="gstPer"></span></div>
                                <div class="col-6 text-end" style="text-align: end;" id="gst"></div>
                            </div>
                            <div class="row border-top pt-2 mt-3 mb-2">
                                <div class="col-6 fw-bold">Grand Total</div>
                                <div class="col-6 text-end fw-bold" style="text-align: end;" id="grandTotal"></div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6 fw-bold">Pay Now (as Advance)</div>
                                <div class="col-6 text-end fw-bold" style="text-align: end;" id="payableAmount">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6 fw-bold">Pay Due on Delivery</div>
                                <div class="col-6 text-end fw-bold" style="text-align: end;" id="payLaterAmount">
                                </div>
                            </div>
                        </div>

                        <div class="row border-top pt-2  pt-3">
                            <div class="col-6">
                                <button class="btn btn-sm btn-danger rounded-lg payment-btn" data-payment="part">Part
                                    Payment</button>
                            </div>

                            <div class="col-6" style="text-align: end">
                                <button class="btn btn-sm btn-danger rounded-lg payment-btn" data-payment="full">Pay
                                    Full
                                    Amount</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFGN7LRr7JY-HOdBuB05aLXcLXgdTv_EQ&libraries=places">
    </script>

    <script>
        const add_billing_btn = document.getElementById('add_billing_btn');
        const billing_address_div = document.getElementById('billing_address_div');

        add_billing_btn.addEventListener("click", function() {

            if (billing_address_div.style.display === 'block') {
                billing_address_div.style.display = 'none';
            } else {
                billing_address_div.style.display = 'block';
            }
        });
    </script>

    <script>
        console.log(@json($cartProducts))
        const charges = @json($charges);
        const checkoutPayments = @json($checkoutPayments);
        const gstPercentage = {{ $gst_percentage }}
        const totalWeight = {{ $totalWeight }}
        const amountCalculation = @json($amountCalculation);
        let totalKm = 0;
        let delivery_address = null;
        //FOR SUBMITION
        let address_id_for_billing = null;
        const billig_addresses = document.querySelectorAll('.billig_address');

        function setActiveAddress(selectedAddress) {
            billig_addresses.forEach((a) => {
                a.classList.remove('bg-info');
                a.classList.add('bg-light');
            });
            selectedAddress.classList.remove('bg-light');
            selectedAddress.classList.add('bg-info');
        }

        billig_addresses.forEach((address) => {
            address.addEventListener("click", function() {
                address_id_for_billing = address.dataset.id
                setActiveAddress(address);
                address_error.innerText = "";
            });
        });

        const setBillingAddress = (id) => {
            address_id_for_billing = id
        }

        const formatAmount = (value) => {
            return value.toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        const calculateDeliveryCharge = (totalKm) => {
            let minimumCharge = 0;
            const weightFilteredCharges = charges.filter(charge =>
                totalWeight >= charge.from_kg && totalWeight <= charge.to_kg
            );
            if (weightFilteredCharges.length === 0) {
                throw new Error('No applicable charges found for the given weight.');
            }
            const firstCharge = weightFilteredCharges[0];

            if (firstCharge.id === 1) {
                if (totalKm <= firstCharge.to_km) {
                    minimumCharge = Number(firstCharge.minimum_charge);
                } else {
                    const additionalKm = totalKm - firstCharge.to_km;
                    const additionalCharge = additionalKm * firstCharge.additional_charge;
                    minimumCharge = Number(firstCharge.minimum_charge) + additionalCharge;
                }
            } else {
                const finalMatchingCharges = weightFilteredCharges.filter(charge =>
                    totalKm >= charge.from_km && totalKm <= charge.to_km
                );

                if (finalMatchingCharges.length === 0) {
                    throw new Error('No applicable charges found for the given distance.');
                }

                const last = finalMatchingCharges.find(element =>
                    element.to_km >= totalKm && element.from_km <= totalKm
                );

                if (last) {
                    minimumCharge = Number(last.minimum_charge);
                } else {
                    throw new Error('No valid charge found for the specified distance.');
                }
            }

            return Math.round(minimumCharge);
        };


        const calculateFinalAmount = (totalKm) => {
            const subTotalFromServer = parseFloat(amountCalculation.total.replace(/,/g, ''));

            console.log(subTotalFromServer)
            if (isNaN(subTotalFromServer)) {
                throw new Error('Invalid total amount received from server.');
            }

            const shippingCharge = calculateDeliveryCharge(totalKm);
            const finalAmounts = calculateFinalPayments(subTotalFromServer, shippingCharge);

            const {
                subTotal,
                gst,
                gstPercentage,
                grandTotal,
                payableAmount,
                payLaterAmount,
            } = finalAmounts;

            document.getElementById("subtotal").innerHTML = subTotal;
            document.getElementById("shipping").innerHTML = '₹' + formatAmount(shippingCharge);
            document.getElementById("gst").innerHTML = gst;
            document.getElementById("gstPer").innerHTML = gstPercentage;
            document.getElementById("grandTotal").innerHTML = grandTotal;
            document.getElementById("payableAmount").innerHTML = payableAmount;
            document.getElementById("payLaterAmount").innerHTML = payLaterAmount;
        };




        const calculateFinalPayments = (totalAmount, shippingCharge) => {

            console.log(totalAmount)

            console.log(checkoutPayments)

            if (typeof totalAmount !== 'number' || typeof shippingCharge !== 'number') {
                throw new Error('Invalid input: totalAmount and shippingCharge must be numbers.');
            }

            const paymentGroup = checkoutPayments.filter(charge =>
                totalAmount <= charge.max_range && totalAmount >= charge.min_range
            );

            if (paymentGroup.length === 0) {
                throw new Error('No valid payment slab found for the given totalAmount.');
            }

            const slab = paymentGroup[0];
            const gst = Math.ceil(gstPercentage ? ((totalAmount * gstPercentage) / 100) : 0);
            const grandTotal = Math.round(gst ? totalAmount + gst + shippingCharge : totalAmount + shippingCharge);
            const payableAmount = (grandTotal * (slab.payment_percentage)) / 100;
            const payLaterAmount = grandTotal - payableAmount;

            return {
                subTotal: '₹' + formatAmount(totalAmount),
                gst: '₹' + formatAmount(gst),
                gstPercentage: gstPercentage + '%',
                grandTotal: '₹' + formatAmount(grandTotal),
                payableAmount: '₹' + formatAmount(Math.round(payableAmount)),
                payLaterAmount: '₹' + formatAmount(Math.round(payLaterAmount)),
            };
        }



        const km_error = document.getElementById('km_error');

        const delivery_name = document.getElementById('delivery_name');
        const delivery_phone = document.getElementById('delivery_phone');
        const address_line_1 = document.getElementById('address_line_1');
        const address_line_2 = document.getElementById('address_line_2');


        const delivery_name_error = document.getElementById('delivery_name_error');
        const delivery_phone_error = document.getElementById('delivery_phone_error');
        const address_line_1_error = document.getElementById('address_line_1_error');
        const address_line_2_error = document.getElementById('address_line_2_error');






        const goToPayment = (e) => {
            km_error.innerText = "";

            const is_full_payment = e.target.dataset.payment === "full";
            let is_error = false;


            if (!totalKm) {
                is_error = true;
                km_error.innerText = "Please select Delivery Address";
            }

            if (!delivery_address) {
                is_error = true;
                km_error.innerText = "Please select Delivery Address";
            }

            if (!address_id_for_billing) {
                is_error = true;
                address_error.innerText = "Please select billing address";
            } else {
                address_error.innerText = ""; // Clear error message if no error
            }

            if (!delivery_name.value) {
                is_error = true;
                delivery_name_error.innerText = "Full name is required";
            } else {
                delivery_name_error.innerText = ""; // Clear error message if no error
            }

            if (!delivery_phone.value) {
                is_error = true;
                delivery_phone_error.innerText = "Phone number is required";
            } else if (delivery_phone.value.length !== 10) {
                is_error = true;
                delivery_phone_error.innerText = "Phone number must 10 digits long";
            } else if (!/^\d+$/.test(delivery_phone.value)) {
                is_error = true;
                delivery_phone_error.innerText = "Phone number must only contain digits";
            } else {
                delivery_phone_error.innerText = ""; // Clear error message if no error
            }

            if (!address_line_1.value) {
                is_error = true;
                address_line_1_error.innerText = "Address line one is required";
            } else {
                address_line_1_error.innerText = ""; // Clear error message if no error
            }

            if (is_error) return;
            const data = new FormData();
            data.append('total_km', totalKm);
            data.append('is_full_payment', is_full_payment ? 1 : 0);
            data.append('address_id_for_billing', address_id_for_billing);
            data.append('google_map_address', delivery_address);
            data.append('delivery_name', delivery_name.value);
            data.append('delivery_phone', delivery_phone.value);
            data.append('address_line_1', address_line_1.value);
            data.append('address_line_2', address_line_2.value);
            paymentAPI(data);

        };

        const paymentBtn = document.querySelectorAll('.payment-btn');

        paymentBtn.forEach((btn) => {
            btn.addEventListener("click", goToPayment)
        })




        calculateFinalAmount(totalKm)




        var autocompleteStart, autocompleteEnd, map, directionsService, directionsRenderer, placesService;

        function initAutocomplete() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 13.050822390891184,
                    lng: 77.68720708989858
                }, // Default center (New York)
                zoom: 12,
                disableDefaultUI: true,
                draggable: false,
                scrollwheel: false,
            });



            // Initialize the Directions service and renderer
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Apply autocomplete to the start and end input fields
            autocompleteStart = new google.maps.places.Autocomplete(
                document.getElementById('start'), {
                    types: ['establishment', 'geocode']
                }
            );



            autocompleteEnd = new google.maps.places.Autocomplete(document.getElementById('end'), {
                componentRestrictions: {
                    country: 'IN'
                }, // Restrict to Indian places
                types: ['establishment', 'geocode']
            });

            autocompleteEnd.addListener('place_changed', function() {
                var place = autocompleteEnd.getPlace();
                delivery_address = place.formatted_address;
                console.log(place.formatted_address); // This will give you the full details of the selected place.
                calculateDistance()
                km_error.innerText = ""
            });


            placesService = new google.maps.places.PlacesService(map);
            // Set a marker and InfoWindow for the start point (your company)
            var startLatLng = {
                lat: 13.050822390891184,
                lng: 77.68720708989858
            }; // Replace with your company's coordinates
            markerStart = new google.maps.Marker({
                position: startLatLng,
                map: map,
                title: "Steel Ghar"
            });

            var placeId = "ChIJh4ZOzlYRrjsRf6fuJOiVvHs"; // Replace with your company's Place ID
            getCompanyDetails(placeId, markerStart);

        }

        document.getElementById("use-current-location").addEventListener("click", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        const geocoder = new google.maps.Geocoder();
                        const latLng = new google.maps.LatLng(latitude, longitude);

                        geocoder.geocode({
                            location: latLng
                        }, (results, status) => {

                            console.log(results)
                            console.log(status)
                            if (status === "OK") {
                                if (results[0]) {
                                    km_error.innerText = ""
                                    document.getElementById("end").value = results[0].formatted_address;
                                    calculateDistance()
                                    delivery_address = results[0].formatted_address;
                                } else {
                                    alert("No address found for your location.");
                                }
                            } else {
                                alert("Geocoder failed: " + status);
                            }
                        });
                    },
                    () => {
                        alert("Unable to retrieve your location. Please allow location access.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

        function getCompanyDetails(placeId, marker) {
            // Request place details for your company
            placesService.getDetails({
                    placeId: placeId,
                    fields: ['name', 'formatted_address', 'photos']
                },
                function(place, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        var contentString = `<div>
                                <h4>${place.name}</h4>
                                <p>${place.formatted_address}</p>`;

                        if (place.photos && place.photos.length > 0) {
                            var photoUrl = place.photos[0].getUrl({
                                maxWidth: 100
                            });
                            contentString += `<img src="${photoUrl}" alt="Company Image" style="width:100px;">`;
                        }

                        contentString += `</div>`;

                        var infoWindowStart = new google.maps.InfoWindow({
                            content: contentString
                        });

                        marker.addListener('click', function() {
                            infoWindowStart.open(map, marker);
                        });
                    } else {
                        console.error("PlacesService failed: " + status);
                    }
                }
            );
        }

        // Function to calculate the distance and show the route on the map
        function calculateDistance() {
            var start = document.getElementById("start").value;
            var end = document.getElementById("end").value;

            if (!start || !end) {
                alert("Please enter both start and end locations.");
                return;
            }

            // Calculate distance using Distance Matrix Service
            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                    origins: [start],
                    destinations: [end],
                    travelMode: 'DRIVING',
                    unitSystem: google.maps.UnitSystem.METRIC,
                },
                function(response, status) {
                    if (status === 'OK') {
                        var distance = response.rows[0].elements[0].distance.text;
                        var duration = response.rows[0].elements[0].duration.text;

                        document.getElementById('output').innerHTML = "  <b>Distance:" + distance +
                            " </b> <b class='float-right'>Duration: " + duration + "</b>"
                        // Call the function to display the route
                        displayRoute(start, end);
                        totalKm = parseFloat(distance.replace(/,/g, ''));
                        calculateFinalAmount(totalKm)

                    } else {
                        alert("Error: " + status);
                    }
                }
            );
        }

        // Function to display the route on the map
        function displayRoute(start, end) {
            directionsService.route({
                    origin: start,
                    destination: end,
                    travelMode: 'DRIVING'
                },
                function(response, status) {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(response);
                    } else {
                        alert('Could not display route due to: ' + status);
                    }
                }
            );
        }

        // Initialize the autocomplete and map when the page loads
        google.maps.event.addDomListener(window, 'load', initAutocomplete);



        const paymentAPI = async (data) => {


            try {

                const response = await axios({
                    method: 'post',
                    url: "checkout/payments",
                    data,
                    headers: {
                        'Content-Type': 'application/json',
                        // Authorization: 'Bearer ' + crmToken,
                    },
                });

                console.log(response.data.status == "success")

                if (response.data.status == "success") {
                    location.href = "checkout/payments"

                }

            } catch (error) {

                if (error?.response?.status === 422) {
                    console.log(error.response.data.errors);
                    if (typeof error.response.data.errors === 'object') {
                        Object.keys(error.response.data.errors).forEach(key => {
                            error.response.data.errors[key].forEach(err => {

                                if (key == "address_id_for_billing") {
                                    address_error.innerText = err;
                                } else if (key == "delivery_name") {
                                    delivery_name_error.innerText = err
                                } else if (key == "delivery_phone") {
                                    delivery_phone_error.innerText = err
                                } else if (key == "address_line_1") {
                                    address_line_1_error.innerText = err
                                } else if (key == "address_line_2") {
                                    address_line_2_error.innerText = err
                                }
                                console.log(key)
                                console.log(err); // Log each error message
                            });
                        });
                    }
                }
            } finally {

            }
        }
    </script>
@endsection
