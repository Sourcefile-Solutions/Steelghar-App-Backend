@extends('layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Shopping Cart</h1>
                </div>
            </div>
        </div>


        <div class="block">
            <div class="container">
                <div class="cart">
                    <div class="cart__table cart-table">
                        <table class="cart-table__table">
                            <thead class="cart-table__head">
                                <tr class="cart-table__row">
                                    <th class="cart-table__column cart-table__column--image">
                                        Image
                                    </th>
                                    <th class="cart-table__column cart-table__column--product text-center">
                                        Product
                                    </th>
                                    <th class="cart-table__column cart-table__column--price text-center">
                                        Kgs/Ft
                                    </th>
                                    <th class="cart-table__column cart-table__column--quantity">
                                        Length
                                    </th>
                                    <th class="cart-table__column cart-table__column--total">
                                        Total
                                    </th>
                                    <th class="cart-table__column cart-table__column--remove"></th>
                                </tr>
                            </thead>

                            @foreach ($cartProducts as $cartProduct)
                                <tbody class="cart-table__body">
                                    <tr class="cart-table__row">
                                        <td class="cart-table__column cart-table__column--image">
                                            <div class="image image--type--product">
                                                <a href="#" class="image__body"><img class="image__tag"
                                                        src="{{ asset('') }}storage/{{ $cartProduct->product_image }}"
                                                        alt="" /></a>
                                            </div>
                                        </td>
                                        <td class="cart-table__column cart-table__column--product text-center">
                                            <span href="#"
                                                class="cart-table__product-name">{{ $cartProduct->product_name }}<br>
                                                @if ($cartProduct->category_id == 1)
                                                    <small>Brand : {{ $cartProduct->brand_name }}</small>
                                                @elseif ($cartProduct->category_id == 7)
                                                    <small>Feet : {{ $cartProduct->height }}</small>
                                                @elseif ($cartProduct->category_id == 9)
                                                    <small>Thickness : {{ $cartProduct->thickness }}</small>
                                                @else
                                                    <small>Thickness : {{ $cartProduct->thickness }}</small>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="cart-table__column cart-table__column--price" data-title="Price">
                                            <div class="cart-table__quantity input-number">
                                                <input class="form-control" type="text" placeholder="Kgs" disabled
                                                    data-tmtweight = "{{ $cartProduct->tmtweight }}"
                                                    data-category = "{{ $cartProduct->category_id }}"
                                                    data-brand_price = "{{ $cartProduct->brandprice }}"
                                                    @if ($cartProduct->category_id != 1 && $cartProduct->category_id != 7) @foreach ($cartProduct->attiribute as $abc)
                                                            data-price_kg = "{{ $abc->price_kg }}"
                                                            data-weight = "{{ $abc->attributeweight }}" 
                                                        @endforeach 
                                                    {{-- @endif --}}
                                                    value="{{ $cartProduct->weight }}" onkeyup="changeweight(this)"
                                                    id="weight" 
                                                    
                                                    @elseif ($cartProduct->category_id == 7)
                                                        @foreach ($cartProduct->attiribute as $abc1)
                                                        data-price_kg = "{{ $abc1->price_kg }}"
                                                        data-height = "{{ $abc1->attributeheight }}" 
                                                        @endforeach 
                                                        {{-- @endif --}}
                                                        value="{{ $cartProduct->height }}" onkeyup="changeheight(this)" id="height" @endif />

                                            </div>
                                        </td>
                                        <td class="cart-table__column cart-table__column--quantity" data-title="Quantity">
                                            <div class="cart-table__quantity input-number">
                                                <input class="form-control" type="text" placeholder="Length"
                                                    value="{{ $cartProduct->length }}"
                                                    @if ($cartProduct->category_id != 1 && $cartProduct->category_id != 7) onkeyup="changelength(this)"
                                                    @elseif ($cartProduct->category_id == 7)
                                                    onkeyup="changeMeshLength(this)" @endif
                                                    disabled id="length" />

                                            </div>
                                        </td>

                                        @php
                                            $thickness_price = 0;
                                            if ($cartProduct->category_id == 1) {
                                                $product_cost = $cartProduct->weight * $cartProduct->brandprice;
                                            } elseif ($cartProduct->category_id == 7) {
                                                foreach ($cartProduct->attiribute as $calcprice) {
                                                    $height_price = $calcprice->price_kg;
                                                }
                                                $product_cost =
                                                    $cartProduct->height * $cartProduct->length * $height_price;
                                            } else {
                                                foreach ($cartProduct->attiribute as $calcprice) {
                                                    $thickness_price = $calcprice->price_kg;
                                                }
                                                $product_cost = $cartProduct->weight * $thickness_price;
                                            }

                                        @endphp
                                        <td class="cart-table__column cart-table__column--total subtotal"
                                            data-title="Total">
                                            {{ number_format((float) $product_cost, 2, '.', '') }}
                                        </td>

                                        <td class="cart-table__column cart-table__column--remove">

                                            <button type="button" onclick="editproduct(this)"
                                                class="cart-table__remove btn btn-sm btn-icon btn-muted">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" onclick="updateproduct(this)"
                                                class="cart-table__remove btn btn-sm btn-icon btn-muted d-none"
                                                data-brand_id="{{ $cartProduct->brand_id }}"
                                                data-thickness_id ="{{ $cartProduct->thickness }}"
                                                data-cp_id = "{{ $cartProduct->id }}">
                                                <img class="image__tag" src="{{ asset('') }}assets/images/save.png"
                                                    alt="" />
                                            </button>
                                        </td>
                                        <td class="cart-table__column cart-table__column--remove">
                                            <button type="button"
                                                class="cart-table__remove btn btn-sm btn-icon btn-muted btnDelete"
                                                style="font-size: 20px" data-id="{{ $cartProduct->id }}">
                                                <i class="fa-solid fa-trash"></i>

                                            </button>
                                        </td>
                                    </tr>

                                </tbody>
                            @endforeach


                            <tfoot class="cart-table__foot">
                                <tr>
                                    <td colspan="6">



                                        <div class="cart-table__update-button text-lg-right d-none"
                                            id="updateButtonContainer">
                                            <a class="btn btn-primary" href="#" id="updateproduct">Update Cart</a>
                                        </div>

                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="cart__totals">
                        <div class="card">
                            <div class="card-body card-body--padding--2">
                                <!--<label for="form-name">Please Enter Your Pincode</label>-->
                                <!--<input type="tell" id="form-name" class="form-control bg-light" pattern="[0-9]*"-->
                                <!--    placeholder="pincode">-->


                                <!--<a class="btn btn-danger btn-sm mt-2 text-white">Check Pincode</a>-->

                                <table class="cart__totals-table">
                                    <tfoot>
                                        <tr>
                                            <th class="border-0">Total</th>
                                            <td id="totalprice" class="border-0">5,902.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a class="btn btn-primary btn-xl btn-block" href={{ route('checkout') }}>Proceed to
                                    checkout</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="csrf-token" content="YOUR_CSRF_TOKEN">
    <script>
        $(document).ready(function() {
            $('.btnDelete').click(function() {
                var product_id = $(this).data('id');
                var button = $(this);
                console.log(product_id);
                // Display SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms deletion, proceed with AJAX request
                        $.ajax({
                            url: BASE_URL + '/cart-delete/' + product_id,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Item removed from Cart successfully.',
                                    icon: 'success',
                                }).then((result) => {
                                    // Reload the page or perform any other action after success if needed
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                                // You might want to show an error message to the user
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function changeheight(e) {
            console.log(e);
            const length_parent = e.parentElement.parentElement.parentElement.childNodes[7].childNodes[1].childNodes[1]
            // const tmtweight = e.dataset.tmtweight
            // const steelweight = e.dataset.weight
            console.log('length_parent', length_parent.value)

            let price_parent = e.parentElement.parentElement.parentElement.childNodes[9]
            // console.log(price_parent);
            const height = e.dataset.height
            console.log('height', height)
            const steel_price = e.dataset.price_kg
            console.log('aaa', steel_price);

            // if (e.dataset.category == 1) {
            //     let length = Number(e.value) / Number(tmtweight)
            //     length_parent.value = length.toFixed(2)
            //     let changing_price = Number(tmt_price) * Number(e.value)
            //     // console.log(changing_price);
            //     price_parent.innerHTML = changing_price.toFixed(2);

            // } else {
            let length = Number(e.value) / Number(height)
            length_parent.value = length.toFixed(2)
            let changing_price = Number(steel_price) * Number(e.value);
            // console.log(changing_price);
            price_parent.innerHTML = changing_price.toFixed(2);
            // }
            subtotal()
        }

        function changeMeshLength(e) {
            console.log(e);
            const height_parent = e.parentElement.parentElement.parentElement.childNodes[5].childNodes[1].childNodes[1]
            console.log(height_parent)
            let price_parent = e.parentElement.parentElement.parentElement.childNodes[9]
            console.log('height', height_parent);
            // const tmtweight = height_parent.dataset.tmtweight
            const height = height_parent.dataset.height
            // const tmt_price = height_parent.dataset.brand_price
            const price = height_parent.dataset.price_kg
            console.log('price', price);
            console.log('height', height);
            // console.log('tmt_price', tmt_price);
            // if (height_parent.dataset.category == 7) {
            //     let weight = Number(e.value) * Number(tmtweight)
            //     height_parent.value = weight.toFixed(2)
            //     let changing_price = Number(tmt_price) * Number(height_parent.value)
            //     console.log('tmtprice', changing_price);
            //     price_parent.innerHTML = changing_price.toFixed(2);
            // } else {
            let length = Number(e.value) * Number(height)
            console.log('length', length)
            let final_height = length.toFixed(2);
            // height_parent.value = length.toFixed(2)
            let changing_price = Number(price) * Number(final_height)
            // console.log('steelprice', changing_price);
            price_parent.innerHTML = changing_price.toFixed(2);
            // }
            subtotal()
        }


        function changeweight(e) {
            console.log(e);
            const length_parent = e.parentElement.parentElement.parentElement.childNodes[7].childNodes[1].childNodes[1]
            const tmtweight = e.dataset.tmtweight
            const steelweight = e.dataset.weight

            let price_parent = e.parentElement.parentElement.parentElement.childNodes[9]
            // console.log(price_parent);
            const tmt_price = e.dataset.brand_price
            const steel_price = e.dataset.price_kg
            console.log('aaa', steel_price);

            if (e.dataset.category == 1) {
                let length = Number(e.value) / Number(tmtweight)
                length_parent.value = length.toFixed(2)
                let changing_price = Number(tmt_price) * Number(e.value)
                // console.log(changing_price);
                price_parent.innerHTML = changing_price.toFixed(2);

            } else {
                let length = Number(e.value) / Number(steelweight)
                length_parent.value = length.toFixed(2)
                let changing_price = Number(steel_price) * Number(e.value);
                // console.log(changing_price);
                price_parent.innerHTML = changing_price.toFixed(2);
            }
            subtotal()
        }

        function changelength(e) {
            console.log(e);
            const weight_parent = e.parentElement.parentElement.parentElement.childNodes[5].childNodes[1].childNodes[1]
            let price_parent = e.parentElement.parentElement.parentElement.childNodes[9]
            console.log('weight', weight_parent);
            const tmtweight = weight_parent.dataset.tmtweight
            const steelweight = weight_parent.dataset.weight
            const tmt_price = weight_parent.dataset.brand_price
            const steel_price = weight_parent.dataset.price_kg
            console.log('tmt', tmtweight);
            if (weight_parent.dataset.category == 1) {
                let weight = Number(e.value) * Number(tmtweight)
                weight_parent.value = weight.toFixed(2)
                let changing_price = Number(tmt_price) * Number(weight_parent.value)
                console.log('tmtprice', changing_price);
                price_parent.innerHTML = changing_price.toFixed(2);
            } else {
                let weight = Number(e.value) * Number(steelweight)
                weight_parent.value = weight.toFixed(2)
                let changing_price = Number(steel_price) * Number(weight_parent.value)
                console.log('steelprice', changing_price);
                price_parent.innerHTML = changing_price.toFixed(2);
            }
            subtotal()
        }

        function editproduct(e) {
            const updatebotton = e.parentElement.childNodes[3]
            const weightparent = e.parentElement.parentElement.childNodes[5].childNodes[1].childNodes[1]
            const lengthparent = e.parentElement.parentElement.childNodes[7].childNodes[1].childNodes[1]
            console.log(e.parentElement.parentElement.childNodes[7].childNodes[1].childNodes[1]);
            e.classList.add('d-none');
            updatebotton.classList.remove('d-none');
            weightparent.removeAttribute('disabled');
            lengthparent.removeAttribute('disabled');
        }

        function updateproduct(e) {
            console.log(e);
            const editbutton = e.parentElement.childNodes[1]
            const weightparent = e.parentElement.parentElement.childNodes[5].childNodes[1].childNodes[1]
            const lengthparent = e.parentElement.parentElement.childNodes[7].childNodes[1].childNodes[1]
            const weight = weightparent.value
            const length = lengthparent.value
            const cp_id = e.dataset.cp_id
            console.log('aaa', cp_id);
            let brand_id = '';
            let thickness = '';
            console.log(weightparent);
            if (weightparent.dataset.category == 1) {
                brand_id = e.dataset.brand_id
            } else {
                thickness = e.dataset.thickness
            }

            console.log('brand', brand_id);
            console.log('thickness', thickness);
            console.log('weight', weight);
            console.log('length', length);

            axios.post(BASE_URL + '/update-cart/' + cp_id, {
                    weight: weight,
                    length: length,
                    _token: '{{ csrf_token() }}'
                })
                .then(function(response) {
                    if (response.data.status === 'error') {
                        // Product is already added to cart
                        Swal.fire({
                            icon: 'info',
                            title: 'Oops!',
                            text: response.data.message
                        });
                    } else {
                        // Product added to cart successfully
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Cart Updated.'
                        });
                    }
                    console.log(response.data);
                })
                .then(function() {
                    e.classList.add('d-none');
                    editbutton.classList.remove('d-none');
                    weightparent.setAttribute('disabled', 'disabled');
                    lengthparent.setAttribute('disabled', 'disabled');
                })
                .catch(function(error) {
                    console.error(error);
                });
        }

        function subtotal(e) {
            let subtotal = 0;

            Array.from(document.getElementsByClassName("subtotal")).forEach(
                function(element, index, array) {
                    subtotal += Number(element.innerHTML)
                }
            );
            console.log('aa', subtotal);

            const total = document.getElementById('totalprice')
            console.log(total);
            total.innerHTML = subtotal.toFixed(2)
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            subtotal();
        });
    </script>
@endsection
