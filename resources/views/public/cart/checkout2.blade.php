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

        <div class="checkout block">
            <div class="container container--max--xl">
                <div class="row">

                    <div class="checkout block">
                        <div class="container container--max--xl">
                            <div class="row">

                                <div class="col-12 col-lg-6 col-xl-6">

                                    <div class="row">
                                        <div class="col">
                                            <div class="card mb-lg-0">
                                                <div class="card-body card-body--padding--2">
                                                    <h3 class="card-title">Shipping Address </h3>

                                                    <div class="mt-4 mb-4">
                                                        <input type="hidden" id="start" name="start"
                                                            value="Steel Ghar, Rampura main road, beside Bharat petrol bunk, Margondanahalli, Bengaluru, Karnataka, India"
                                                            autocomplete="off">

                                                        <input type="text" id="end" name="end"
                                                            class="rounded-lg border px-3 w-100 bg-white mb-4"
                                                            placeholder="Enter Delivery Location" value=""
                                                            autocomplete="off" style="height: 50px">



                                                        <div id="output" class="mb-2">

                                                        </div>

                                                        <div id="map" style="height: 250px;"></div>
                                                    </div>

                                                    <h3 class="card-title">Billing Address </h3>

                                                    <div class="widget-filters__item">
                                                        <div class="filter filter--opened" data-collapse-item>
                                                            <div class="filter__body" data-collapse-content>
                                                                <div class="filter__container">
                                                                    <div class="filter-list">
                                                                        <div class="filter-list__list">

                                                                            @foreach ($addressess as $address)
                                                                                <label class="filter-list__item">
                                                                                    <span
                                                                                        class="filter-list__input input-radio">
                                                                                        <span class="input-radio__body">
                                                                                            <input
                                                                                                class="input-radio__input"
                                                                                                name="address"
                                                                                                type="radio"
                                                                                                value="{{ $address->id }}" />
                                                                                            <span
                                                                                                class="input-radio__circle"></span>
                                                                                        </span>
                                                                                    </span>
                                                                                    <div class="address-card__name mb-0">
                                                                                        {{ $address->name }}
                                                                                    </div>
                                                                                </label>
                                                                                <div class="address-card__row pl-4">
                                                                                    {{ $address->address }}
                                                                                    {{ $address->address2 }},<br>{{ $address->city }},
                                                                                    {{ $address->state }} -
                                                                                    {{ $address->pincode }}
                                                                                </div>
                                                                                <div
                                                                                    class="address-card__row pl-4 mt-0 font-italic">
                                                                                    Phone :
                                                                                    {{ $address->phone }}</div>
                                                                            @endforeach


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card widget widget-categories pt-3">

                                                        <ul class="widget-categories__list widget-categories__list--root"
                                                            data-collapse=""
                                                            data-collapse-opened-class="widget-categories__item--open">

                                                            <li class="widget-categories__item  widget-categories__item--open"
                                                                data-collapse-item=""><a href=""
                                                                    class="widget-categories__link">
                                                                    <h4>Add Shipping Address</h4>
                                                                </a><button class="widget-categories__expander"
                                                                    type="button" data-collapse-trigger=""></button>
                                                                <div class="widget-categories__container"
                                                                    data-collapse-content="">

                                                                    <form action="{{ route('public.addressess.store') }}"
                                                                        method="POST" id="address-form">
                                                                        @csrf
                                                                        <input type="hidden">
                                                                        <div class="col-12 col-lg-12 col-xl-12">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label
                                                                                        for="address-first-name">Name</label>
                                                                                    <input type="text"
                                                                                        class="form-control" name="name"
                                                                                        placeholder="Your Name" />
                                                                                    @error('name')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="address-last-name">Mobile
                                                                                        Number</label>
                                                                                    <input type="text"
                                                                                        class="form-control" name="phone"
                                                                                        placeholder="Your Mobile" />
                                                                                    @error('phone')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="address-address1">Street
                                                                                    Address</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="address"
                                                                                    placeholder="House number and street name" />
                                                                                @error('address')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                                <label for="address-address2"
                                                                                    class="sr-only">Street
                                                                                    Address</label>
                                                                                <input type="text"
                                                                                    class="form-control mt-2"
                                                                                    name="address_2"
                                                                                    placeholder="Apartment, suite, unit etc." />
                                                                                @error('address2')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="address-city">City</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="city"
                                                                                    placeholder="Enter City" />
                                                                                @error('city')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label
                                                                                        for="address-state">State</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="state"
                                                                                        placeholder="Enter State" />
                                                                                    @error('state')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="form-group col-md-6">
                                                                                    <label
                                                                                        for="address-postcode">Pincode</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="pincode"
                                                                                        placeholder="Enter Pincode" />
                                                                                    @error('pincode')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group  ">
                                                                                <label
                                                                                    for="address-email">Landmark(optional)</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="land_mark"
                                                                                    placeholder="Enter Landmark" />
                                                                                @error('landmark')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group mb-0 pt-3 mt-3">
                                                                                <button class="btn btn-primary"
                                                                                    type="submit" id="submit-address">Add
                                                                                    Address</button>
                                                                            </div>



                                                                        </div>
                                                                    </form>



                                                                </div>
                                                            </li>

                                                        </ul>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <div class="col-12 col-lg-6 col-xl-6 mt-4 mt-lg-0">
                                    <div class="card mb-0">
                                        <div class="card-body card-body--padding--2">
                                            <h3 class="card-title">Your Order</h3>
                                            <table class="checkout__totals">
                                                <thead class="checkout__totals-header">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Details</th>
                                                        <th>Total</th>


                                                    </tr>
                                                </thead>
                                                @foreach ($cartProducts as $cartProduct)
                                                    <tbody class="checkout__totals-products">
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
                                                                        <br>Length : {{ $cartProduct['length'] }}</small>
                                                                @elseif ($cartProduct['category_id'] == '3')
                                                                    <small>Size: {{ $cartProduct['size'] }}
                                                                        <br> No.of Sheets:
                                                                        {{ $cartProduct['no_of_sheet'] }}</small>
                                                                @else
                                                                    <small>Weight:
                                                                        {{ $cartProduct['weight'] * $cartProduct['length'] }}kg
                                                                        <br> Length: {{ $cartProduct['length'] }}</small>
                                                                @endif
                                                            </td>

                                                            <td class="pb-1 subtotal">
                                                                {{ $cartProduct['sub_total'] }}
                                                            </td>



                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                                <tbody class="checkout__totals-subtotals">

                                                    <tr>
                                                        <th>Total Weight:</th>
                                                        <td> {{ $totalWeight }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="subtotal">{{ $amountCalculation['total'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Shipping Charges</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="shipping">{{ $amountCalculation['shippingCharge'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Handling Charges</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="handling">{{ $amountCalculation['handlingCharge'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>GST <span id="gstPer"></span></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="gst">{{ $amountCalculation['gst'] }}</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="checkout__totals-footer" style="font-size: 18px">
                                                    <tr>
                                                        <th>Grand Total</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="grandTotal">{{ $amountCalculation['grandTotal'] }}</td>
                                                    </tr>


                                                    <tr>
                                                        <th class="pt-3"><span>Pay Now (as Advance)</span></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="pt-3" id="payableAmount">
                                                            {{ $amountCalculation['payAdvance'] }}</td>
                                                    </tr>
                                                    <tr class="pt-3">
                                                        <th class="pt-3">Pay Due on Delivery</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="pt-3" id="payLaterAmount">
                                                            {{ $amountCalculation['payLater'] }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            {{-- <div class="checkout__payment-methods payment-methods">
                                                <ul class="payment-methods__list">
                                                    <li class="payment-methods__item payment-methods__item--active">
                                                        <label class="payment-methods__item-header"><span
                                                                class="payment-methods__item-radio input-radio"><span
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio"
                                                                        checked="checked" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">Direct
                                                                bank transfer</span></label>
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
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">Check
                                                                payments</span></label>
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
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">Cash
                                                                on
                                                                delivery</span></label>
                                                        <div class="payment-methods__item-container">
                                                            <div class="payment-methods__item-details text-muted">
                                                                Pay with cash upon delivery.
                                                            </div>
                                                        </div>


                                                    </li>
                                                    <li class="payment-methods__item">
                                                        <label class="payment-methods__item-header"><span
                                                                class="payment-methods__item-radio input-radio"><span
                                                                    class="input-radio__body"><input
                                                                        class="input-radio__input"
                                                                        name="checkout_payment_method" type="radio" />
                                                                    <span class="input-radio__circle"></span>
                                                                </span></span><span
                                                                class="payment-methods__item-title">PayPal</span></label>
                                                        <div class="payment-methods__item-container">
                                                            <div class="payment-methods__item-details text-muted">
                                                                Pay via PayPal; you can pay with your credit card
                                                                if you don’t have a PayPal account.
                                                            </div>
                                                        </div>



                                                    </li>
                                                </ul>
                                            </div> --}}


                                            <div class="d-flex justify-content-between">



                                                <form action="{{ route('public.checkout.payment.index') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="address_id" id="address_id">
                                                    <input type="hidden" name="is_full_payment" value="0">
                                                    <button type="submit" class="btn btn-danger">
                                                        Part Payment
                                                    </button>
                                                </form>


                                                <form action="{{ route('public.checkout.payment.index') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="address_id" id="address_id2">
                                                    <input type="hidden" name="is_full_payment" value="1">
                                                    @error('address_id')
                                                        <small class="alert text-danger">Choose Address</small>
                                                    @enderror
                                                    <button type="submit" class="btn btn-danger">
                                                        Pay Full Amount
                                                    </button>
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
        <div class="block-space block-space--layout--before-footer">
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFGN7LRr7JY-HOdBuB05aLXcLXgdTv_EQ&libraries=places">
    </script>

    <script>
        const charges = @json($charges);
        const checkoutPayments = @json($checkoutPayments);
        const gstPercentage = {{ $gst_percentage }}
        const totalWeight = {{ $totalWeight }}
        const amountCalculation = @json($amountCalculation)

        const totalKm = 0;

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
                console.log(place); // This will give you the full details of the selected place.
                calculateDistance()
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
                        calculateFinalAmount(parseFloat(distance.replace(/,/g, '')))


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
    </script>

    <script>
        var radioButtons = document.querySelectorAll('.input-radio__input');
        let address_id = 0;
        radioButtons.forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {
                if (this.checked) {
                    address_id = this.value;
                    console.log('Selected value:', address_id);
                    document.getElementById('address_id').value = address_id
                    document.getElementById('address_id2').value = address_id
                }
            });
        });
    </script>
@endsection
