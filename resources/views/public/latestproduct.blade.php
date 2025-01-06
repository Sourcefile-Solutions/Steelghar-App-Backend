@extends('layouts.app')
<style>
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        appearance: none;
        outline: 0;
        box-shadow: none;
        border: 1 !important;
        /* background: gray;
        background-image: none; */
        flex: 1;
        padding: 0 .5em;
        /* color: #fff; */
        cursor: pointer;
        font-size: 1em;
        font-family: 'Open Sans', sans-serif;
    }

    select::-ms-expand {
        display: none;
    }

    .select {
        position: relative;
        display: flex;
        width: 20em;
        height: 45px;
        line-height: 3;
        background: #5c6664;
        overflow: hidden;
        border-radius: .25em;
    }

    .select::after {
        content: '\25BC';
        position: absolute;
        top: 0;
        right: 0;
        padding: 0 1em;
        /* background: gray; */
        cursor: pointer;
        pointer-events: none;
        transition: .25s all ease;
    }

    .select:hover::after {
        color: #23b499;
    }
</style>
@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Latest Products</h1>
                </div>
            </div>
        </div>



        <div class="block-split">
            <div class="container">
                <div class="block-split__row no-gutters">
                    <div class="block-split__item block-split__item-content col-auto">
                        <div class="block">
                            <div class="products-view">
                                <div class="products-view__options view-options view-options--offcanvas--mobile">
                                    <div class="view-options__body">
                                        <button type="button" class="view-options__filters-button filters-button">
                                            <span class="filters-button__icon">
                                                <svg width="16" height="16">
                                                    <path
                                                        d="M7,14v-2h9v2H7z M14,7h2v2h-2V7z M12.5,6C12.8,6,13,6.2,13,6.5v3c0,0.3-0.2,0.5-0.5,0.5h-2C10.2,10,10,9.8,10,9.5v-3C10,6.2,10.2,6,10.5,6H12.5z M7,2h9v2H7V2z M5.5,5h-2C3.2,5,3,4.8,3,4.5v-3C3,1.2,3.2,1,3.5,1h2C5.8,1,6,1.2,6,1.5v3C6,4.8,5.8,5,5.5,5z M0,2h2v2H0V2z M9,9H0V7h9V9z M2,14H0v-2h2V14z M3.5,11h2C5.8,11,6,11.2,6,11.5v3C6,14.8,5.8,15,5.5,15h-2C3.2,15,3,14.8,3,14.5v-3C3,11.2,3.2,11,3.5,11z" />
                                                </svg>
                                            </span>
                                            <span class="filters-button__title">Filters</span>
                                            <span class="filters-button__counter">3</span>
                                        </button>
                                        <div class="view-options__layout layout-switcher">
                                            <div class="layout-switcher__list">
                                                {{-- <button type="button" class="layout-switcher__button"
                                                    data-layout="table" data-with-features="false">
                                                    <svg width="16" height="16">
                                                        <path
                                                            d="M15.2,16H0.8C0.4,16,0,15.6,0,15.2v-2.4C0,12.4,0.4,12,0.8,12h14.4c0.4,0,0.8,0.4,0.8,0.8v2.4C16,15.6,15.6,16,15.2,16zM15.2,10H0.8C0.4,10,0,9.6,0,9.2V6.8C0,6.4,0.4,6,0.8,6h14.4C15.6,6,16,6.4,16,6.8v2.4C16,9.6,15.6,10,15.2,10z M15.2,4H0.8C0.4,4,0,3.6,0,3.2V0.8C0,0.4,0.4,0,0.8,0h14.4C15.6,0,16,0.4,16,0.8v2.4C16,3.6,15.6,4,15.2,4z" />
                                                    </svg>
                                                </button> --}}
                                            </div>
                                        </div>
                                        <div class="view-options__legend">
                                            Showing {{ $products->count() }} products
                                        </div>
                                        <div class="view-options__spring"></div>
                                        <!--<div class="view-options__select">-->
                                        <!--    <label for="view-option-sort">Sort:</label>-->
                                        <!--    <select id="view-option-sort" class="form-control form-control-sm"-->
                                        <!--        name="">-->
                                        <!--        <option value="">Price</option>-->
                                        <!--    </select>-->
                                        <!--</div>-->
                                        <!--<div class="view-options__select">-->
                                        <!--    <label for="view-option-limit">Show:</label>-->
                                        <!--    <select id="view-option-limit" class="form-control form-control-sm"-->
                                        <!--        name="">-->
                                        <!--        <option value="">16</option>-->
                                        <!--    </select>-->
                                        <!--</div>-->
                                    </div>

                                    {{-- <div class="view-options__body view-options__body--filters">
                                        <div class="view-options__label">Active Filters</div>
                                        <div class="applied-filters">
                                            <ul class="applied-filters__list">
                                                <li class="applied-filters__item">
                                                    <a href="#"
                                                        class="applied-filters__button applied-filters__button--filter">Sales:
                                                        Top Sellers
                                                        <svg width="9" height="9">
                                                            <path
                                                                d="M9,8.5L8.5,9l-4-4l-4,4L0,8.5l4-4l-4-4L0.5,0l4,4l4-4L9,0.5l-4,4L9,8.5z" />
                                                        </svg></a>
                                                </li>
                                                <li class="applied-filters__item">
                                                    <a href="#"
                                                        class="applied-filters__button applied-filters__button--filter">Color:
                                                        True Red
                                                        <svg width="9" height="9">
                                                            <path
                                                                d="M9,8.5L8.5,9l-4-4l-4,4L0,8.5l4-4l-4-4L0.5,0l4,4l4-4L9,0.5l-4,4L9,8.5z" />
                                                        </svg></a>
                                                </li>
                                                <li class="applied-filters__item">
                                                    <button type="button"
                                                        class="applied-filters__button applied-filters__button--clear">
                                                        Clear All
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> --}}


                                </div>
                                <div class="products-view__list products-list products-list--grid--4" data-layout="grid"
                                    data-with-features="false">

                                    <div class="products-list__content">

                                        @foreach ($products as $product)
                                            <div class="products-list__item">
                                                <div class="product-card">
                                                    <div class="product-card__actions-list" data-id={{ $product->id }}>

                                                        <a href="add-to-wishlist/{{ $product->id }}"><button
                                                                class="product-card__action " type="button"
                                                                aria-label="Add to wish list"
                                                                onclick="addToWishlist(event, {{ $product->id }})">
                                                                @if ($product->isWishlist)
                                                                    <svg width="16" height="16"
                                                                        viewBox="0 0 256 256">
                                                                        <path fill="none" d="M0 0h256v256H0z">
                                                                        </path>
                                                                        <path fill="#fc0505" stroke="#fff"
                                                                            d="M176 32a60 60 0 0 0-48 24A60 60 0 0 0 20 92c0 71.9 99.9 128.6 104.1 131a7.8 7.8 0 0 0 3.9 1 7.6 7.6 0 0 0 3.9-1 314.3 314.3 0 0 0 51.5-37.6C218.3 154 236 122.6 236 92a60 60 0 0 0-60-60Z">
                                                                        </path>
                                                                    </svg>
                                                                @else
                                                                    <svg width="16" height="16">
                                                                        <path
                                                                            d="M13.9,8.4l-5.4,5.4c-0.3,0.3-0.7,0.3-1,0L2.1,8.4c-1.5-1.5-1.5-3.8,0-5.3C2.8,2.4,3.8,2,4.8,2s1.9,0.4,2.6,1.1L8,3.7l0.6-0.6C9.3,2.4,10.3,2,11.3,2c1,0,1.9,0.4,2.6,1.1C15.4,4.6,15.4,6.9,13.9,8.4z" />
                                                                    </svg>
                                                                @endif
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="product-card__image">

                                                        <div class="image image--type--product">
                                                            <a class="image__body"><img class="image__tag"
                                                                    src="{{ asset('') }}public/storage/{{ $product->product_image }}"
                                                                    alt="" /></a>
                                                        </div>


                                                        {{-- <div
                                                        class="status-badge status-badge--style--success product-card__fit status-badge--has-icon status-badge--has-text">
                                                        <div class="status-badge__body">
                                                            <div class="status-badge__icon">
                                                                <svg width="13" height="13">
                                                                    <path
                                                                        d="M12,4.4L5.5,11L1,6.5l1.4-1.4l3.1,3.1L10.6,3L12,4.4z" />
                                                                </svg>
                                                            </div>
                                                            <div class="status-badge__text">
                                                                Part Fit for 2011 Ford Focus S
                                                            </div>
                                                            <div class="status-badge__tooltip" tabindex="0"
                                                                data-toggle="tooltip"
                                                                title="Part&#x20;Fit&#x20;for&#x20;2011&#x20;Ford&#x20;Focus&#x20;S">
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>
                                                    <div class="product-card__info">
                                                        {{-- <div class="product-card__meta">
                                                            <span class="product-card__meta-title">SKU:</span>
                                                            140-10440-B
                                                        </div> --}}
                                                        <div class="product-card__name py-2">
                                                            <div class="font-weight-bold">
                                                                <span>{{ $product->product_name }}</span>
                                                            </div>
                                                        </div>
                                                        @if ($product->category_id == 2)
                                                            <div class="d-flex pr-2 pt-3 pl-2">
                                                                <div class="select">
                                                                    <select name="format" class="brand">
                                                                        <option selected disabled class="text-white">Choose
                                                                            a Brand</option>
                                                                        @foreach ($product->brands as $brand)
                                                                            <option value="{{ $brand->id }}"
                                                                                data-price="{{ $brand->price }}"
                                                                                data-tmtweight="{{ $product->tmtweight }}">
                                                                                {{ $brand->brand_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        @else
                                                            <div class="d-flex pr-2 pt-3 pl-2">
                                                                <div class="select">
                                                                    <select name="format" class="thickness">
                                                                        <option selected disabled class="text-white">Choose
                                                                            a
                                                                            Thickness
                                                                        </option>
                                                                        @foreach ($product->thick as $thickness)
                                                                            <option value="{{ $thickness->id }}"
                                                                                data-price_kg="{{ $thickness->price_kg }}"
                                                                                data-weight="{{ $thickness->weight }}"
                                                                                data-thickness="{{ $thickness->thickness }}">
                                                                                {{ $thickness->thickness }} mm</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        @endif

                                                        @if ($product->category_id == 2)
                                                            <div class="form-row pt-3 pl-1 pr-1">
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" name="weight"
                                                                        class="form-control" placeholder="Kgs"
                                                                        value="" onkeyup="tmtweight(this)" disabled
                                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" name="length" value=""
                                                                        class="form-control" placeholder="Length"
                                                                        onkeyup="tmtlength(this)" disabled
                                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="form-row pt-3 pl-1 pr-1">
                                                                <div class="form-group col-md-6">

                                                                    <input type="text" name="weight"
                                                                        class="form-control" placeholder="Kgs"
                                                                        value="" onkeyup="weight(this)" disabled>
                                                                </div>
                                                                <div class="form-group col-md-6">

                                                                    <input type="text" name="length" value=""
                                                                        class="form-control" placeholder="Length"
                                                                        onkeyup="length(this)" disabled>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>


                                                    <div class="product-card__footer">

                                                        @if ($product->category_id == 2)
                                                            <div class="product-card__prices">
                                                                <small class="text-danger price-tag">Starts
                                                                    From</small><br>
                                                                <div
                                                                    class="product-card__price product-card__price--current tmt_price ml-3">
                                                                    ₹ <span
                                                                        class="price-value">{{ $product->low_price }}</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="product-card__prices">
                                                                <small class="text-danger price-tag">Starts
                                                                    From</small><br>
                                                                <div
                                                                    class="product-card__price product-card__price--current steel_price ml-3">
                                                                    ₹ <span
                                                                        class="price-value">{{ $product->basePrice }}</span>
                                                                </div>
                                                            </div>
                                                        @endif


                                                        <button class="product-card__addtocart-icon" type="button"
                                                            aria-label="Add to cart" onclick="addtocart(this)"
                                                            data-product_id={{ $product->id }}
                                                            data-category_id={{ $product->category_id }}>
                                                            <svg width="20" height="20">
                                                                <circle cx="7" cy="17" r="2" />
                                                                <circle cx="15" cy="17" r="2" />
                                                                <path
                                                                    d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z" />
                                                            </svg>
                                                        </button>
                                                        <button class="product-card__addtocart-full" type="button">
                                                            Add to cart
                                                        </button>




                                                        <button class="product-card__wishlist" type="button">
                                                            <svg width="16" height="16">
                                                                <path
                                                                    d="M13.9,8.4l-5.4,5.4c-0.3,0.3-0.7,0.3-1,0L2.1,8.4c-1.5-1.5-1.5-3.8,0-5.3C2.8,2.4,3.8,2,4.8,2s1.9,0.4,2.6,1.1L8,3.7l0.6-0.6C9.3,2.4,10.3,2,11.3,2c1,0,1.9,0.4,2.6,1.1C15.4,4.6,15.4,6.9,13.9,8.4z" />
                                                            </svg>
                                                            <span>Add to wishlist</span>
                                                        </button>
                                                        <button class="product-card__compare" type="button">
                                                            <svg width="16" height="16">
                                                                <path
                                                                    d="M9,15H7c-0.6,0-1-0.4-1-1V2c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v12C10,14.6,9.6,15,9,15z" />
                                                                <path
                                                                    d="M1,9h2c0.6,0,1,0.4,1,1v4c0,0.6-0.4,1-1,1H1c-0.6,0-1-0.4-1-1v-4C0,9.4,0.4,9,1,9z" />
                                                                <path
                                                                    d="M15,5h-2c-0.6,0-1,0.4-1,1v8c0,0.6,0.4,1,1,1h2c0.6,0,1-0.4,1-1V6C16,5.4,15.6,5,15,5z" />
                                                            </svg>
                                                            <span>Add to compare</span>
                                                        </button>
                                                    </div>


                                                    {{-- <div class="product-card__footer">
                                                   
                                                </div> --}}


                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="products-view__pagination">
                                <!--<nav aria-label="Page navigation example">-->
                                <!--    <ul class="pagination">-->
                                <!--        <li class="page-item disabled">-->
                                <!--            <a class="page-link page-link--with-arrow" href="#"-->
                                <!--                aria-label="Previous"><span-->
                                <!--                    class="page-link__arrow page-link__arrow--left"-->
                                <!--                    aria-hidden="true"><svg width="7" height="11">-->
                                <!--                        <path-->
                                <!--                            d="M6.7,0.3L6.7,0.3c-0.4-0.4-0.9-0.4-1.3,0L0,5.5l5.4,5.2c0.4,0.4,0.9,0.3,1.3,0l0,0c0.4-0.4,0.4-1,0-1.3l-4-3.9l4-3.9C7.1,1.2,7.1,0.6,6.7,0.3z" />-->
                                <!--                    </svg></span></a>-->
                                <!--        </li>-->
                                <!--        <li class="page-item">-->
                                <!--            <a class="page-link" href="#">1</a>-->
                                <!--        </li>-->
                                <!--        <li class="page-item active" aria-current="page">-->
                                <!--            <span class="page-link">2<span class="sr-only">(current)</span></span>-->
                                <!--        </li>-->
                                <!--        <li class="page-item">-->
                                <!--            <a class="page-link" href="#">3</a>-->
                                <!--        </li>-->
                                <!--        <li class="page-item">-->
                                <!--            <a class="page-link" href="#">4</a>-->
                                <!--        </li>-->
                                <!--        <li class="page-item page-item--dots">-->
                                <!--            <div class="pagination__dots"></div>-->
                                <!--        </li>-->
                                <!--        <li class="page-item">-->
                                <!--            <a class="page-link" href="#">9</a>-->
                                <!--        </li>-->
                                <!--        <li class="page-item">-->
                                <!--            <a class="page-link page-link--with-arrow" href="#"-->
                                <!--                aria-label="Next"><span class="page-link__arrow page-link__arrow--right"-->
                                <!--                    aria-hidden="true"><svg width="7" height="11">-->
                                <!--                        <path-->
                                <!--                            d="M0.3,10.7L0.3,10.7c0.4,0.4,0.9,0.4,1.3,0L7,5.5L1.6,0.3C1.2-0.1,0.7,0,0.3,0.3l0,0c-0.4,0.4-0.4,1,0,1.3l4,3.9l-4,3.9-->
                                <!--                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                C-0.1,9.8-0.1,10.4,0.3,10.7z" />-->
                                <!--                    </svg></span></a>-->
                                <!--        </li>-->
                                <!--    </ul>-->
                                <!--</nav>-->
                                <div class="products-view__pagination-legend">
                                    Showing {{ $products->count() }} products
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="block-space block-space--layout--before-footer"></div>
        </div>

    </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/product/tmtproduct.js') }}"></script>
    <script src="{{ asset('assets/js/product/product.js') }}"></script>
    <script>
        function addToWishlist(event, productId) {
            event.preventDefault();
            const btn = event.target.closest('button');
            $(btn).html(smallLoader)
            $.ajax({
                url: BASE_URL + "/add-to-wishlist/" + productId, // Update the URL to match your route
                method: "GET",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status == "success") {
                        setTimeout(() => {
                            if (response.action == 'added') {
                                $(btn).html(activeWishlist)
                                $('#wishlistWebCound').text(Number($('#wishlistWebCound').text()) + 1)
                            } else if (response.action == 'removed') {
                                $(btn).html(deactiveWishlist)
                                $('#wishlistWebCound').text(Number($('#wishlistWebCound').text()) - 1)
                            }
                        }, 500)
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors
                },
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function addtocart(e) {
            console.log('product_id', e.dataset.product_id);
            const category_id = e.dataset.category_id;
            let product_id = e.dataset.product_id
            const product_parent = e.parentElement.parentElement
            let attribute_id = '';
            let thickness = 1;

            const selectBox = product_parent.childNodes[5].childNodes[3].childNodes[1].childNodes[1]
            console.log(selectBox);
            const brand_select = selectBox.options[selectBox.selectedIndex];
            console.log('brand_id', brand_select.value);
            if (category_id == 2) {
                attribute_id = brand_select.value;
                console.log('attribute', attribute_id);
            } else {
                thickness = brand_select.dataset.thickness;
            }

            const weight_child = product_parent.childNodes[5].childNodes[5].childNodes[1].childNodes[1]
            console.log('weight', weight_child.value);

            let weight = weight_child.value

            const length_child = product_parent.childNodes[5].childNodes[5].childNodes[3].childNodes[1]

            console.log('length', length_child.value);

            let length = length_child.value

            if (!weight) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Choose a weight'
                });
                return;
            }

            if (!length) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Choose a length'
                });
                return;
            }


            axios.post('/add-to-cart/' + product_id, {
                    product_id: product_id,
                    brand_id: attribute_id,
                    thickness: thickness,
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
                        });
                        updateCartCount()
                    }
                    console.log(response.data);
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    </script>
@endsection
