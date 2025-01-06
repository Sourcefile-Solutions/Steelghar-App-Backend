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
                                    <div>
                                        <a href="#">{{ $wp->product_name }}</a>
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


                <!-- Modal -->
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
</script>

<script>
    $(document).ready(function() {
        let attribute = document.getElementById('attribute')
        attribute_parent = attribute.parentElement.parentElement
        const weight_child = attribute_parent.childNodes[5].childNodes[1].childNodes[1].childNodes[1]
        const length_child = attribute_parent.childNodes[5].childNodes[1].childNodes[3].childNodes[1]
        attribute.addEventListener("change", function(e) {
            // console.log(e.target.childNodes[1]);
            e.preventDefault();
            // console.log('selectedattribute', this.options[this.selectedIndex].dataset.weight);

            if (this.options[this.selectedIndex].dataset.tmtweight) {
                tmtweight = this.options[this.selectedIndex].dataset.tmtweight;
                weight_child.value = tmtweight
                length_child.value = 1
            } else if (this.options[this.selectedIndex].dataset.weight) {
                steelweight = this.options[this.selectedIndex].dataset.weight
                weight_child.value = steelweight
                length_child.value = 1
            }
        })

    });

    function cartmodal(e) {
        axios
            .get(
                BASE_URL + "/brandthickness/" + e.id
            )
            .then(function(response) {
                const product_id = response.data.product.id;
                const producttmt = response.data.product.tmtweight;
                // console.log(response.data.dropdowns);
                let options =
                    ` <option selected disabled>Choose ${e.category_id == 2 ? 'a Brand': 'thickness'}</option>`
                response.data.dropdowns.forEach(element => {
                    // console.log(element);
                    if (e.category_id == 2) {
                        options +=
                            `<option value="${element.id}" data-price="${element.price}" data-tmtweight="${producttmt}" data-product_id="${product_id}">${element.brand_name}</option>`
                    } else {
                        options +=
                            `<option value="${element.thickness}" data-weight="${element.weight}" data-product_id="${product_id}">${element.thickness}mm</option>`
                    }

                });
                // console.log(options);
                const addattribute = document.getElementById('addattribute')

                $(addattribute).on('show.bs.modal', function(event) {
                    document.getElementsByName('weight')[0].value = ''; // Clear weight field
                    document.getElementsByName('length')[0].value = ''; // Clear length field
                });
                $(addattribute).modal('show');

                document.getElementById('attribute').innerHTML = options



            });


    }
</script>
<script>
    function changeweight(e) {
        const weightparent = e.parentElement.parentElement
        const lengthchild = weightparent.childNodes[3].childNodes[1]

        const selectbox = e.parentElement.parentElement.parentElement.parentElement
        const selectattribute = selectbox.childNodes[3].childNodes[1]
        const selectedattribute = selectattribute.options[selectattribute.selectedIndex]
        const tmt_weight = selectedattribute.dataset.tmtweight
        const steel_weight = selectedattribute.dataset.weight

        if (selectedattribute.dataset.tmtweight) {
            let length = Number(e.value) / Number(tmt_weight);
            lengthchild.value = length.toFixed(2)
        } else {
            let length = Number(e.value) / Number(steelweight);
            lengthchild.value = length.toFixed(2)
        }
    }


    function changelength(e) {
        lengthparent = e.parentElement.parentElement
        console.log(lengthparent.childNodes[1].childNodes[1]);
        weightchild = lengthparent.childNodes[1].childNodes[1]
        const selectbox = e.parentElement.parentElement.parentElement.parentElement
        const selectattribute = selectbox.childNodes[3].childNodes[1]
        const selectedattribute = selectattribute.options[selectattribute.selectedIndex]
        const tmt_weight = selectedattribute.dataset.tmtweight
        const steel_weight = selectedattribute.dataset.weight

        if (selectedattribute.dataset.tmtweight) {
            let length = Number(e.value) * Number(tmt_weight);
            weightchild.value = length.toFixed(2)
        } else {
            let length = Number(e.value) * Number(steelweight);
            weightchild.value = length.toFixed(2)
        }

    }


    function addtocart(e) {
        const productid_parent = e.parentElement.parentElement.childNodes[3].childNodes[1]
        const product_id = productid_parent.options[productid_parent.selectedIndex].dataset.product_id
        const attribute_id = productid_parent.options[productid_parent.selectedIndex].value

        let weight = e.parentElement.parentElement.childNodes[5].childNodes[1].childNodes[1].childNodes[1].value
        let length = e.parentElement.parentElement.childNodes[5].childNodes[1].childNodes[3].childNodes[1].value

        axios.post('/add-to-cart/' + product_id, {
                product_id: product_id,
                brand_id: attribute_id,
                thickness: attribute_id,
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
                        text: 'Product added to cart successfully.'
                    }).then((result) => {
                        updateCartCount();
                    });
                }
                $(addattribute).modal('hide');
                console.log(response.data);
            })
            .catch(function(error) {
                console.error(error);
            });
    }
</script>
@endsection