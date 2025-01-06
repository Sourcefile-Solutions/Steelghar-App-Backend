@extends('public.layouts.app')


@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Wishlist</h1>
                </div>
            </div>
        </div>
        <div class="block-split">
            <div class="container">

                <div class="products-view__list products-list products-list--grid--4" data-layout="grid"
                    data-with-features="false">
                    <div class="products-list__head">
                        <div class="products-list__column products-list__column--image">
                            Image
                        </div>
                        <div class="products-list__column products-list__column--meta">
                            SKU
                        </div>
                        <div class="products-list__column products-list__column--product">
                            Product
                        </div>
                        <div class="products-list__column products-list__column--rating">
                            Rating
                        </div>
                        <div class="products-list__column products-list__column--price">
                            Price
                        </div>
                    </div>

                    <div id="message-container"></div>

                    @if (count($wishlistproducts) > 0)
                        <div class="products-list__content ">
                            @foreach ($wishlistproducts as $wp)
                                <div class="products-list__item">
                                    <div class="product-card">
                                        <div class="product-card__actions-list">
                                            <a class="product-card__action btnDelete" type="button"
                                                data-id="{{ $wp->id }}" aria-label="Remove from Wishlist">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                        <div class="product-card__image">
                                            <div class="image image--type--product">
                                                <a href="#" class="image__body"><img class="image__tag"
                                                        src="{{ $wp->product_image ? asset('storage/' . $wp->product_image) : asset('no-image.png') }}"
                                                        alt="" /></a>
                                            </div>
                                        </div>
                                        <div class="product-card__info" data-product_id="{{ $wp->id }}">
                                            <div class="product-card__name">
                                                <div class="mt-3">
                                                    <b>{{ $wp->product_name }}</b>
                                                </div>
                                            </div>

                                            <div class="product-card__name pt-3 pb-3">
                                                <button type="submit"
                                                    class="border-bottom border-danger btn btn-block btn-outline-danger shadow-sm border"
                                                    onclick="cartmodal({{ $wp }})">
                                                    Add To Cart
                                                </button>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="modal fade" id="addattribute" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" id="add-to-cart-content">







                                </div>
                            </div>
                        </div>
                    @else
                        <h1 class="block-header__title text-center">No Item In The Wishlist</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"
        integrity="sha512-NQfB/bDaB8kaSXF8E77JjhHG5PM6XVRxvHzkZiwl3ddWCEPBa23T76MuWSwAJdMGJnmQqM0VeY9kFszsrBEFrQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {



            $('.btnDelete').click(function() {
                var productId = $(this).data('id');
                var button = $(this); // Reference to the clicked button

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
                            url: BASE_URL + "/add-to-wishlist",
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                product_id: productId,
                            },
                            success: function(response) {

                                // if (response.status == "success") {

                                //     if (response.action == 'added') {
                                //         const a = Number($('#wishlistWebCound')
                                //             .text()) + 1;
                                //         $('#wishlistWebCound').text(a)
                                //         $('#wishlistMobCound').text(a)
                                //     } else if (response.action == 'removed') {
                                //         const a = Number($('#wishlistWebCound')
                                //             .text()) - 1;
                                //         $('#wishlistWebCound').text(a)
                                //         $('#wishlistMobCound').text(a)
                                //     }
                                // }
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Item removed from wishlist successfully.',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
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


        function cartmodal(data) {
            console.log("data", data)

            axios
                .get(BASE_URL + "/add-to-card-from-wishlist/" + data.id)
                .then(function(response) {

                    // Show modal
                    $(addattribute).modal("show");

                    // Insert HTML content into the target element
                    const contentDiv = document.getElementById("add-to-cart-content");
                    contentDiv.innerHTML = response.data;

                    // Remove previously added scripts tagged for dynamic loading
                    document.querySelectorAll('script[data-dynamic="true"]').forEach(script => script.remove());

                    // Extract and execute new scripts
                    const tempDiv = document.createElement("div");
                    tempDiv.innerHTML = response.data;
                    const newScripts = tempDiv.querySelectorAll("script");

                    newScripts.forEach(script => {
                        const newScript = document.createElement("script");
                        newScript.setAttribute("data-dynamic", "true"); // Tag to identify dynamic scripts
                        if (script.src) {
                            newScript.src = script.src; // For external scripts
                            newScript.async = true;
                        } else {
                            newScript.textContent = script.textContent; // For inline scripts
                        }
                        document.body.appendChild(newScript); // Append and execute the script
                    });
                })
                .catch(function(error) {
                    console.error("Error fetching data:", error);
                });

        }


        async function addtocart(e, data) {
            console.log(data)
            var productCard = e.closest('.product-card');
            if (data.category_id == 1) {
                var brand = productCard.querySelector('[name="brand"]');
                if (!brand.value) alert("Please Select Brand");
                var weight = productCard.querySelector('[name="weight"]').value;
                var length = productCard.querySelector('[name="length"]').value;
                if (!weight) alert("Please Select weight");
                if (!length) alert("Please Select weight");
                console.log("weight", weight)
                console.log("length", length)
                formData = {
                    product_id: data.id,
                    weight: weight,
                    length: length,
                    brand_id: brand.value
                };
            } else if (data.category_id == 2) {
                var height = productCard.querySelector('[name="product_attribute_id"]');
                if (!height.value) alert("Please Select Height");
                var length = productCard.querySelector('[name="length"]').value;
                if (!length) alert("Please Select weight");
                formData = {
                    product_id: data.id,
                    length: length,
                    product_attribute_id: height.value
                };
                // console.log(formData)
            } else if (data.category_id == 3) {
                var thickness = productCard.querySelector('[name="product_attribute_id"]').value;
                if (!thickness) alert("Please Select thickness");
                var size = productCard.querySelector('[name="size"]').value;
                if (!size) alert("Please Select size");
                var no_of_sheet = productCard.querySelector('[name="no_of_sheet"]').value;
                if (!no_of_sheet) alert("Please Select size");
                var color = productCard.querySelector('[name="color"]').value;
                if (!color) alert("Please Select size");
                formData = {
                    product_id: data.id,
                    size: size,
                    no_of_sheet: no_of_sheet,
                    product_attribute_id: thickness,
                    color: color
                };
            } else {
                var thickness = productCard.querySelector('[name="thickness"]');
                if (!thickness.value) alert("Please Select thickness");
                var weight = productCard.querySelector('[name="weight"]').value;
                var length = productCard.querySelector('[name="length"]').value;
                if (!weight) alert("Please Select weight");
                if (!length) alert("Please Select weight");
                console.log("weight", weight)
                console.log("length", length)
                formData = {
                    product_id: data.id,
                    weight: weight,
                    length: length,
                    product_attribute_id: thickness.value
                };
            }
            var response = await axios({
                method: 'post',
                url: "add-to-cart",
                data: formData,
                headers: {
                    "Content-Type": "multipart/form-data",
                    "X-CSRF-TOKEN": csrfToken
                },
            });
            if (response.data.status == "success") {

                $(addattribute).modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Item Added to Cart',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                })
                var count = Number(cartWebCount.innerText) + 1;
                cartWebCount.innerText = count;
                cartMobCount.innerText = count;
            } else if (response.data.status == "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Item Already added in cart',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                })
            }
        }
    </script>
@endsection
