@extends('console.layouts.app')
@section('title', "Orders | $order->order_id ")
@section('styles')
@endsection
@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex"><a class="menu-link" href="#">
                </a>
                <div class="flex-column-fluid page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Orders</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Orders</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container">

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class=" mb-6 mb-xl-9">

                            <div class="card p-3 bg-light-danger shadow-xs mb-4">
                                <h6 class="text-center mt-4 mb-3">Order Details</h6>
                                <div>
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p class="fw-bold text-gray-700">Order Id</p>
                                            <p class="fw-bold">{{ $order->order_id }}</p>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p class="fw-bold text-gray-700">GST</p>
                                            <p class="fw-bold">₹{{ $order->gst_charge }}</p>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p class="fw-bold text-gray-700">Current Status</p>
                                            <p class="fw-bold">{{ $order->current_status }}</p>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p class="fw-bold text-gray-700">Shipping Charge</p>
                                            <p class="fw-bold">₹{{ $order->shipping_charge }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">

                                            <p class="fw-bold text-gray-700">Order Date</p>
                                            <p class="fw-bold">{{ $order->order_date }}</p>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p class="fw-bold  fs-5 text-danger ">Grand Total</p>
                                            <p class="fw-bold fs-5 text-danger ">₹{{ $order->payable_amount }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p class="fw-bold text-info fs-6">Subtotal</p>
                                            <p class="fw-bold text-info fs-6">₹{{ $order->sub_total }}</p>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p
                                                class="fw-bold text-primary {{ $order->is_full_payment ? 'text-decoration-line-through' : '' }} ">
                                                Advance Payment</p>
                                            <p
                                                class="fw-bold text-primary {{ $order->is_full_payment ? 'text-decoration-line-through' : '' }}">
                                                ₹{{ $order->advance_amount }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p class="fw-bold text-gray-700">Handling Charge</p>
                                            <p class="fw-bold">₹{{ $order->handling_charge }}</p>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <p
                                                class="fw-bold text-primary {{ $order->is_full_payment ? 'text-decoration-line-through' : '' }}">
                                                Balance Payment</p>
                                            <p
                                                class="fw-bold text-primary {{ $order->is_full_payment ? 'text-decoration-line-through' : '' }}">
                                                ₹{{ $order->balance_amount }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-flush h-xl-100 shadow-xs bg-light-primary">
                                <div class="pt-4 px-4">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">Order Items</span>
                                    </h3>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed align-middle gs-0 gy-4">
                                            <thead>
                                                <tr class="fs-7 fw-bold border-0 text-gray-500">
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Details</th>
                                                    <th class="text-end min-w-150px">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td class="">
                                                            <span
                                                                class="text-gray-800 fw-bold  fs-6">{{ $loop->iteration }}</span>
                                                        </td>
                                                        <td class="">
                                                            <span
                                                                class="text-gray-800 fw-bold  mb-1 fs-6">{{ $item->product_name }}
                                                                @if ($item->category_id == 3)
                                                                    ({{ $item->color }})
                                                                @endif
                                                                @if ($item->category_id == 1)
                                                                    <br>
                                                                    <small>Brand: {{ $item->brand_name }}</small>
                                                                @elseif ($item->category_id == 2)

                                                                @elseif ($item->category_id == 3)
                                                                    <br>
                                                                    <small>Thickness: {{ $item->thickness }}</small>
                                                                @else
                                                                    <br>
                                                                    <small>Thickness: {{ $item->thickness }}</small>
                                                                @endif


                                                            </span>
                                                        </td>
                                                        <td class="">
                                                            <span class="text-gray-800 fw-bold  mb-1 fs-6">

                                                                @if ($item->category_id == 1)
                                                                    <span>Weight: {{ $item->weight }}
                                                                        <br>
                                                                        Length: {{ $item->length }}
                                                                    </span>
                                                                @elseif ($item->category_id == 2)
                                                                    <span>Height: {{ $item->height }} ft
                                                                        <br>
                                                                        Length: {{ $item->length }}
                                                                    </span>
                                                                @elseif ($item->category_id == 3)
                                                                    <span>Size: {{ $item->size }}
                                                                        <br>
                                                                        No.of Sheets: {{ $item->no_of_sheet }}
                                                                    </span>
                                                                @else
                                                                    <span>Weight: {{ $item->weight }}
                                                                        <br>
                                                                        Length: {{ $item->length }}
                                                                    </span>
                                                                @endif

                                                            </span>
                                                        </td>


                                                        <td class="">
                                                            <div class="d-flex justify-content-end">
                                                                <span
                                                                    class="text-gray-800  d-block text-end fw-bold fs-6">₹{{ $item->sub_total }}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="bg-light-info card p-3 shadow-xs mb-4">
                            <h6 class="text-center mt-4 mb-3">Customer</h6>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold text-gray-700">Name:</p>
                                    <p class="fw-bold">{{ $customer->name }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold text-gray-700">Phone:</p>
                                    <p class="fw-bold">{{ $customer->phone }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold text-gray-700">Email:</p>
                                    <p class="fw-bold text-t">{{ $customer->email }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold text-gray-700">Joined at:</p>
                                    <p class="fw-bold">{{ $customer->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light-success shadow-xs">
                            <h6 class="text-center mt-4 mb-3">Delivery Address</h6>
                            <div class="p-3">
                                <p class="fw-bold text-gray-700">Name: {{ $shippingAddress->name }}</p>
                                <p class="fw-bold text-gray-700">Phone: {{ $shippingAddress->phone }}</p>
                                <p class="fw-bold">
                                    {{ $shippingAddress->address }},{{ $shippingAddress->address2 }}<br />
                                </p>

                                <p><i>Map Address</i> : <small>{{ $shippingAddress->google_map_address }}</small></p>

                                <div class="mt-4 mb-4">
                                    <input type="hidden" id="start" name="start"
                                        value="Steel Ghar, Rampura main road, beside Bharat petrol bunk, Margondanahalli, Bengaluru, Karnataka, India"
                                        autocomplete="off">

                                    <div class="mb-2">
                                        <input type="hidden" id="end" name="end"
                                            class="rounded-lg border px-3 w-100 bg-white "
                                            placeholder="Enter Delivery Location"
                                            value="{{ $shippingAddress->google_map_address }}" autocomplete="off"
                                            style="height: 50px">
                                        <span class="text-danger font-weight-bold" id="km_error"></span>
                                    </div>



                                    <div id="output" class="mb-2 text-muted">

                                    </div>

                                    <div id="map" class="border" style="height: 250px;"></div>
                                </div>
                            </div>


                            <h6 class="text-center mt-4 mb-3">Billing Address</h6>
                            <div class="p-3">
                                <p class="fw-bold text-gray-700">Name: {{ $billingAddress->name }}</p>
                                <p class="fw-bold text-gray-700">Phone: {{ $billingAddress->phone }}</p>
                                <p class="fw-bold">{{ $billingAddress->address }}, {{ $billingAddress->address_2 }},
                                    <br> {{ $billingAddress->land_mark }},<br>
                                    {{ $billingAddress->city }}, {{ $billingAddress->state }} -
                                    {{ $billingAddress->pincode }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card card-flush h-xl-100 shadow-xs bg-light-warning mt-5">
                    <div class="pt-4 px-4 card-header">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Payment Details</span>
                        </h3>

                        @if ($order->balance_payment)
                            <div class="card-toolbar">
                                <button class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_1">Add
                                    Payment</button>
                            </div>
                        @endif

                    </div>
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fs-7 fw-bold border-0 text-gray-500">
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Payment Id</th>
                                        <th>Payment Mode</th>
                                        <th class="text-end min-w-150px">Remarks</th>
                                        {{-- <th class="">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td class="">
                                                <span class="text-gray-800 fw-bold  fs-6">{{ $loop->iteration }}</span>
                                            </td>
                                            <td class="">
                                                <span
                                                    class="text-gray-800 fw-bold  mb-1 fs-6">{{ $payment->created_at->format('d M Y H:i:s') }}</span>
                                            </td>
                                            <td class="">
                                                <span
                                                    class="text-gray-800 fw-bold  mb-1 fs-6">₹{{ $payment->paid }}</span>
                                            </td>
                                            <td class="">
                                                @if ($payment->balance)
                                                    <span
                                                        class="text-gray-800 fw-bold  mb-1 fs-6">₹{{ $payment->balance }}</span>
                                                @else
                                                    <span class="badge badge-danger">No Balance</span>
                                                @endif
                                            </td>
                                            <td class="">
                                                <span
                                                    class="text-gray-800 fw-bold  mb-1 fs-6">{{ $payment->payment_id }}</span>
                                            </td>
                                            <td class="">
                                                <span
                                                    class="text-gray-800 fw-bold  mb-1 fs-6">{{ $payment->payment_mode }}</span>
                                            </td>
                                            <td class="text-end min-w-150px">
                                                <span
                                                    class="text-gray-800 fw-bold  mb-1 fs-6">{{ $payment->payment_remarks }}</span>
                                            </td>
                                            {{-- <td class="">
                                                <div class="d-flex justify-content-end">
                                                    @if ($payment->is_editable)
                                                        <span class="text-gray-800  d-block text-end fw-bold fs-6">E
                                                            D</span>
                                                    @else
                                                        <span class="badge badge-danger">No Action</span>
                                                    @endif
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <div class="card mb-5 mb-xxl-8 mt-5">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bold mb-2 text-gray-900">Timeline</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="timeline-label">

                            @foreach ($statuses as $status)
                                <div class="timeline-item">
                                    <div class="timeline-label fw-bold text-gray-800 fs-6"></div>
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-success fs-1"></i>
                                    </div>
                                    <div class="fw-bold timeline-content  ps-3">
                                        {{ $status->status }}
                                        <p class="fw-bold text-muted">{{ $status->created_at }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        @if (count($statuses))

                            @if (count($dropdowns))
                                <form action="#" method="POST" class="mt-10 mw-400px">
                                    @csrf
                                    <div class="input-group mb-5">
                                        <select class="form-select" aria-label="Select example" name="status">
                                            <option value="" disabled selected>Select Action</option>
                                            @foreach ($dropdowns as $item)
                                                <option value="{{ $item }}"
                                                    {{ $loop->first ? '' : 'disabled ' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <button class="input-group-text" id="basic-addon2">Update Status</button>
                                    </div>

                                    @error('status')
                                        <span class="error text-danger fw-bold">{{ $message }}</span>
                                    @enderror
                                </form>
                            @endif
                        @else
                            <div class="mw-300px text-center m-auto">
                                <div>
                                    <button class="btn btn-success me-5" id="acceptOrder">Accept Order</button>
                                    <button class="btn btn-youtube" id="rejectOrder">Reject Order</button>
                                </div>
                            </div>
                        @endif

                        @if (count($statuses->where('status', 'INVOICE GENERATED')))
                            <div class="mw-300px text-center m-auto">
                                <div>
                                    <a href="#" class="btn btn-dark me-5">Download Invoice</a>

                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Payment</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="paymentForm">
                        @csrf

                        <div>
                            <b>Balance : ₹{{ $order->balance_payment }}</b>

                        </div>
                        <p id="paymentError"></p>

                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <input type="text" class="form-control" placeholder="Enter Amount" value=""
                            name="paid" />
                        <select class="form-select mt-5" aria-label="Select example" name="payment_mode">
                            <option disabled selected>Select Payment Mode</option>
                            <option value="Cash">Cash</option>
                            <option value="Online">Online</option>
                            <option value="Check">Check</option>
                            <option value="Card">Card</option>
                        </select>
                        <input type="text" class="form-control mt-5" name="payment_remarks"
                            placeholder="Enter Remarks" />

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addPaymentBtn">Add Now</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        const orderId = {{ $order->id }}

        @if (!count($statuses))
            document.getElementById('acceptOrder').addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure to accept this Order",
                    icon: "question",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Accept Now",
                    cancelButtonText: 'Later',
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: 'btn btn-outline'
                    },
                    preConfirm: () => {
                        return axios
                            .post(BASE_URL + "/order-accept/" + orderId)
                            .then(function(response) {
                                if (response.data.status == "success") {
                                    Swal.fire({
                                        icon: response.data.status,
                                        title: response.data.title,
                                        text: response.data.message,
                                    });
                                    location.reload()
                                } else if (response.status == "error") {
                                    Swal.fire({
                                        icon: response.data.status,
                                        title: response.data.title,
                                        text: response.data.message,
                                    });
                                }
                            })
                            .catch(function(error) {})
                            .finally(function() {});
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                })
            });

            document.getElementById('rejectOrder').addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure to reject this order",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Reject Now",
                    cancelButtonText: 'Later',
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: 'btn btn-outline'
                    },
                    preConfirm: () => {
                        return axios
                            .post(BASE_URL + "/order-reject/" + orderId)
                            .then(function(response) {
                                if (response.data.status == "success") {
                                    Swal.fire({
                                        icon: response.data.status,
                                        title: response.data.title,
                                        text: response.data.message,
                                    });
                                    location.reload()
                                } else if (response.status == "error") {
                                    Swal.fire({
                                        icon: response.data.status,
                                        title: response.data.title,
                                        text: response.data.message,
                                    });
                                }
                            })
                            .catch(function(error) {})
                            .finally(function() {});
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                })
            });
        @endif

        document.getElementById('addPaymentBtn').addEventListener('click', e => {
            document.getElementById('paymentError').innerHTML = '';
            const form = document.getElementById('paymentForm');

            axios
                .post(BASE_URL + "/order-payment", new FormData(form))
                .then(function(response) {
                    console.log(response.data.status)
                    if (response.data.status == "success") {
                        location.reload()
                    } else if (response.data.status == "error") {
                        document.getElementById('paymentError').innerHTML = response.data.message;
                    }
                })
                .catch(function(error) {})
                .finally(function() {});
        })
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFGN7LRr7JY-HOdBuB05aLXcLXgdTv_EQ&libraries=places">
    </script>
    <script>
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


            // autocompleteEnd = new google.maps.places.Autocomplete(
            //     document.getElementById('end'), {
            //         types: ['establishment', 'geocode']
            //     }
            // );


            calculateDistance()


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
                        // totalKm = parseFloat(distance.replace(/,/g, ''));
                        // calculateFinalAmount(totalKm)


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

        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>
    {{-- <script src="{{ asset('console/assets/steelghar/order/index.js') }}"></script> --}}
@endsection
