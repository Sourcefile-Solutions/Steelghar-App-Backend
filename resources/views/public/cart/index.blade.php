@extends('public.layouts.app')
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
                @if (count($cartProducts))
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
                                            Details
                                        </th>

                                        <th class="cart-table__column cart-table__column--total">
                                            Total
                                        </th>
                                        <th class="cart-table__column cart-table__column--remove">


                                        </th>
                                    </tr>
                                </thead>


                                @foreach ($cartProducts as $cartProduct)
                                    @if ($cartProduct['category_id'] == '1')
                                        <tbody>
                                            <td class="cart-table__column cart-table__column--image">
                                                <div class="image image--type--product">
                                                    <a href="#" class="image__body">
                                                        <img src="{{ $cartProduct['product_image'] }}" alt=""
                                                            class="image__tag rounded">
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="cart-table__column cart-table__column--product text-center">
                                                <span href="#"
                                                    class="cart-table__product-name">{{ $cartProduct['product_name'] }}<br>
                                                    <small>Brand : {{ $cartProduct['brand_name'] }}</small>
                                                </span>
                                            </td>

                                            <td class="cart-table__column cart-table__column--quantity">
                                                <small>
                                                    Weight:
                                                    {{ $cartProduct['weight'] }}
                                                    <br>
                                                    Length: {{ $cartProduct['length'] }}
                                                </small>
                                            </td>


                                            <td class="cart-table__column cart-table__column--total subTotal">
                                                {{ $cartProduct['sub_total'] }}
                                            </td>

                                            <td class="cart-table__column cart-table__column--remove">

                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted m-2"
                                                    style="font-size: 20px" data-id="{{ $cartProduct['cart_product_id'] }}"
                                                    onclick="updateProduct(this)">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>

                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted btnDelete"
                                                    style="font-size: 20px" data-id="{{ $cartProduct['cart_product_id'] }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tbody>
                                    @elseif ($cartProduct['category_id'] == '2')
                                        <tbody>
                                            <td class="cart-table__column cart-table__column--image">
                                                <div class="image image--type--product">
                                                    <a href="#" class="image__body">
                                                        <img src="{{ $cartProduct['product_image'] }}" alt=""
                                                            class="image__tag rounded">
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="cart-table__column cart-table__column--product text-center">
                                                <span href="#"
                                                    class="cart-table__product-name">{{ $cartProduct['product_name'] }}



                                                </span>
                                            </td>

                                            <td class="cart-table__column cart-table__column--quantity">
                                                <small>Height: {{ $cartProduct['height'] }} ft
                                                    <br>
                                                    Length: {{ $cartProduct['length'] }}</small>
                                            </td>



                                            <td class="cart-table__column cart-table__column--total subTotal">
                                                {{ $cartProduct['sub_total'] }}
                                            </td>

                                            <td class="cart-table__column cart-table__column--remove">
                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted m-2"
                                                    style="font-size: 20px" data-id="{{ $cartProduct['cart_product_id'] }}"
                                                    onclick="updateProduct(this)">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted btnDelete"
                                                    style="font-size: 20px"
                                                    data-id="{{ $cartProduct['cart_product_id'] }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tbody>
                                    @elseif ($cartProduct['category_id'] == '3')
                                        <tbody>
                                            <td class="cart-table__column cart-table__column--image">
                                                <div class="image image--type--product">
                                                    <a href="#" class="image__body">
                                                        <img src="{{ $cartProduct['product_image'] }}" alt=""
                                                            class="image__tag rounded">
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="cart-table__column cart-table__column--product text-center">
                                                <span href="#"
                                                    class="cart-table__product-name">{{ $cartProduct['product_name'] }}
                                                    ({{ $cartProduct['color'] }})
                                                    <br>
                                                    <small>Thickness {{ $cartProduct['thickness'] }} mm</small>
                                                </span>
                                            </td>

                                            <td class="cart-table__column cart-table__column--quantity">
                                                <small> size:{{ $cartProduct['size'] }}
                                                    <br>
                                                    No.of sheets: {{ $cartProduct['no_of_sheet'] }}</small>
                                            </td>




                                            <td class="cart-table__column cart-table__column--total subTotal">
                                                {{ $cartProduct['sub_total'] }}
                                            </td>

                                            <td class="cart-table__column cart-table__column--remove">
                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted m-2"
                                                    style="font-size: 20px" data-id="{{ $cartProduct['cart_product_id'] }}"
                                                    onclick="updateProduct(this)">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted btnDelete"
                                                    style="font-size: 20px"
                                                    data-id="{{ $cartProduct['cart_product_id'] }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>

                                        </tbody>
                                    @else
                                        <tbody>
                                            <td class="cart-table__column cart-table__column--image">
                                                <div class="image image--type--product">
                                                    <a href="#" class="image__body">
                                                        <img src="{{ $cartProduct['product_image'] }}" alt=""
                                                            class="image__tag rounded">
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="cart-table__column cart-table__column--product text-center">
                                                <span href="#"
                                                    class="cart-table__product-name">{{ $cartProduct['product_name'] }}
                                                    {{-- ({{ $cartProduct->subcategory }}) --}}
                                                    <br>
                                                    <small>Thickness {{ $cartProduct['thickness'] }} mm</small>
                                                </span>
                                            </td>

                                            <td class="cart-table__column cart-table__column--quantity">
                                                <small>
                                                    Weight:
                                                    {{ $cartProduct['weight'] }}
                                                    <br>
                                                    Length: {{ $cartProduct['length'] }}
                                                </small>
                                            </td>


                                            <td class="cart-table__column cart-table__column--total subTotal">
                                                {{ $cartProduct['sub_total'] }}
                                            </td>

                                            <td class="cart-table__column cart-table__column--remove">

                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted m-2"
                                                    style="font-size: 20px"
                                                    data-id="{{ $cartProduct['cart_product_id'] }}"
                                                    onclick="updateProduct(this)">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>

                                                <button type="button"
                                                    class="cart-table__remove btn btn-sm btn-icon btn-muted btnDelete"
                                                    style="font-size: 20px"
                                                    data-id="{{ $cartProduct['cart_product_id'] }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tbody>
                                    @endif
                                @endforeach


                                <tfoot class="cart-table__foot">
                                    <tr>
                                        <td colspan="6">
                                            <div class="cart-table__update-button text-lg-right d-none"
                                                id="updateButtonContainer">
                                                <a class="btn btn-primary" href="#" id="updateproduct">Update
                                                    Cart</a>
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
                                                <td id="totalprice" class="border-0">{{ $amountCalculation['total'] }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <a class="btn btn-primary btn-xl btn-block"
                                        href="{{ route('public.checkout.index') }}">Proceed to
                                        checkout</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="cart-empty">
                        <div class="cart-empty__content text-center py-5">
                            <div class="cart-empty__icon mb-3">
                                <i class="fa fa-shopping-cart fa-4x text-muted"></i>
                            </div>
                            <h4 class="cart-empty__title mb-2">Your Cart is Empty</h4>
                            <p class="cart-empty__text mb-4">Looks like you haven't added anything to your cart yet.</p>
                            <a href="/products" class="btn btn-primary btn-lg">
                                <i class="fa fa-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>


    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Update Cart Product</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="modalLoder">
                        <span class="spinner-border spinner-grow my-5"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const updateModal = document.querySelector('#updateModal');
        const modalBody = updateModal.querySelector('.modal-body');

        function updateProduct(e) {
            $('#updateModal').modal('show');

            $.ajax({
                url: BASE_URL + '/get-cart-update-view',
                data: {
                    "id": e.dataset.id
                },
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success") {
                        let tempDiv = document.createElement('div');
                        tempDiv.innerHTML = response.edit;
                        console.log(tempDiv.querySelector('div'))
                        let scriptContent = tempDiv.querySelector('script')?.textContent;
                        modalBody.innerHTML = "";
                        modalBody.appendChild(tempDiv.querySelector('div'));
                        if (scriptContent) {
                            const script = document.createElement("script");
                            script.textContent = scriptContent;
                            document.body.appendChild(script);
                        }
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    // You might want to show an error message to the user
                }
            });
        }
    </script>
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
                            url: BASE_URL + '/remove-from-cart',
                            data: {
                                "id": product_id
                            },
                            type: 'POST',
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
@endsection
