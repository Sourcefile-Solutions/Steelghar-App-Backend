@extends('public.layouts.app')
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

                    <h1 class="block-header__title">Products</h1>
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
                                            @if ($product->category_id == 1)
                                                @include('public.products.tmt-product')
                                            @elseif ($product->category_id == 2)
                                                @include('public.products.mesh-product')
                                            @elseif ($product->category_id == 3)
                                                @include('public.products.roofing-product')
                                            @else
                                                @include('public.products.other-product')
                                            @endif
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
    <script>
        const roofThickness = document.querySelectorAll('.roofThickness');


        function roofCalculation(e) {
            // 
            const productCard = e.target.closest('.product-card');
            const thickness = productCard.querySelector(
                '[name="product_attribute_id"]');
            let thicknessPrice = thickness.options[thickness.selectedIndex].dataset.price;
            let formula_value = thickness.options[thickness.selectedIndex].dataset.formula_value;

            if (e.target.name == "size") {
                productCard.querySelector('.price-value').innerText =
                    (formula_value * (Number(productCard.dataset.categoryprice) + Number(thicknessPrice)) * Number(
                        productCard
                        .querySelector('[name="no_of_sheet"]').value) * e.target.value).toFixed(2);
            } else if (e.target.name == "no_of_sheet") {
                productCard.querySelector('.price-value').innerText =
                    (formula_value * (Number(productCard.dataset.categoryprice) + Number(thicknessPrice)) * Number(
                        productCard
                        .querySelector('[name="size"]').value) * e.target.value).toFixed(2);
            }
        }

        roofThickness.forEach(element => {
            element.addEventListener('change', function(e) {
                const so = e.target.options[e.target.selectedIndex];
                const productCard = e.target.closest('.product-card');
                productCard.querySelector('.price-value').innerText =
                    1.3 * (Number(productCard.dataset.categoryprice) + Number(so.dataset.price)).toFixed(2)
                const sizeInput = productCard.querySelector('[name="size"]');
                sizeInput.value = 1;
                sizeInput.disabled = false;
                sizeInput.addEventListener('keyup', roofCalculation);
                const sheetInput = productCard.querySelector('[name="no_of_sheet"]');
                sheetInput.value = 1;
                sheetInput.disabled = false;
                sheetInput.addEventListener('keyup', roofCalculation);
            });
        });
    </script>
    <script>
        const meshHeight = document.querySelectorAll('.meshHeight');

        function meshCalculation(e) {
            const productCard = e.target.closest('.product-card');
            const categoryPrice = Number(productCard.dataset.categoryprice)
            const product_attribute = productCard.querySelector('[name="product_attribute_id"]');


            const height = product_attribute.options[product_attribute.selectedIndex].dataset.height;
            const heightPrice = product_attribute.options[product_attribute.selectedIndex].dataset.price;

            productCard.querySelector('.price-value').innerText =
                ((categoryPrice + Number(heightPrice)) * height * e.target.value).toFixed(2);
        }

        meshHeight.forEach(element => {
            element.addEventListener('change', function(e) {
                const so = e.target.options[e.target.selectedIndex];
                const productCard = e.target.closest('.product-card');
                productCard.querySelector('.price-value').innerText =
                    ((Number(productCard.dataset.categoryprice) + Number(so.dataset.price)) * Number(so
                        .dataset.height)).toFixed(2)
                const lengthInput = productCard.querySelector('[name="length"]');
                lengthInput.value = 1;
                lengthInput.disabled = false;
                lengthInput.addEventListener('keyup', meshCalculation);
            });
        });
    </script>
    <script>
        const crThickness = document.querySelectorAll('.crThickness');

        function crCalculation(e) {
            const productCard = e.target.closest('.product-card');
            const categoryPrice = Number(productCard.dataset.categoryprice)
            const thickness = productCard.querySelector('[name="thickness"]');
            const thicknessWeight = thickness.options[thickness.selectedIndex].dataset.weight;
            const thicknessPrice = thickness.options[thickness.selectedIndex].dataset.price;
            if (e.target.name == "weight") {
                console.log("weight")
                const length = e.target.value / thicknessWeight;
                productCard.querySelector('.price-value').innerText =
                    (e.target.value * (categoryPrice + Number(thicknessPrice))).toFixed(2);
                productCard.querySelector('[name="length"]').value = length.toFixed(2);
            } else if (e.target.name == "length") {
                const weight = e.target.value * thicknessWeight;
                productCard.querySelector('.price-value').innerText =
                    (weight * (categoryPrice + Number(thicknessPrice))).toFixed(2);
                productCard.querySelector('[name="weight"]').value = weight.toFixed(2);
            }
        }

        crThickness.forEach(element => {
            element.addEventListener('change', function(e) {
                const so = e.target.options[e.target.selectedIndex];
                const productCard = e.target.closest('.product-card');

                productCard.querySelector('.price-value').innerText = ((Number(productCard.dataset
                    .categoryprice) + Number(so.dataset.price)) * Number(
                    so.dataset.weight)).toFixed(2)

                const weightInput = productCard.querySelector('[name="weight"]');
                weightInput.value = so.dataset.weight;
                weightInput.disabled = false;
                weightInput.addEventListener('keyup', crCalculation);

                const lengthInput = productCard.querySelector('[name="length"]');
                lengthInput.disabled = false;
                lengthInput.addEventListener('keyup', crCalculation);

            });
        });
    </script>
    <script>
        const tmtBrand = document.querySelectorAll('.tmtBrand');

        function tmtCalculation(e) {
            const productCard = e.target.closest('.product-card');
            const tmtWeight = productCard.dataset.weight;
            const brand = productCard.querySelector('[name="brand"]');
            const brandPrice = brand.options[brand.selectedIndex].dataset.price;
            if (e.target.name == "weight") {
                const length = e.target.value / tmtWeight;
                productCard.querySelector('.price-value').innerText = (e.target.value * brandPrice).toFixed(2);
                productCard.querySelector('[name="length"]').value = length.toFixed(2);
            } else if (e.target.name == "length") {
                const weight = e.target.value * tmtWeight;
                productCard.querySelector('.price-value').innerText = (weight * brandPrice).toFixed(2);
                productCard.querySelector('[name="weight"]').value = weight.toFixed(2);
            }
        }

        tmtBrand.forEach(element => {
            element.addEventListener('change', function(e) {
                const so = e.target.options[e.target.selectedIndex];
                const productCard = e.target.closest('.product-card');
                productCard.querySelector('.price-value').innerText =
                    (so.dataset.price * so.dataset.tmtweight).toFixed(2);
                const weightInput = productCard.querySelector('[name="weight"]');
                weightInput.value = so.dataset.tmtweight;
                weightInput.disabled = false;
                weightInput.addEventListener('keyup', tmtCalculation);
                const lengthInput = productCard.querySelector('[name="length"]');
                lengthInput.disabled = false;
                lengthInput.addEventListener('keyup', tmtCalculation);
            })
        })
        const cartWebCount = document.getElementById('cartWebCount');
        const cartMobCount = document.getElementById('cartMobCount');
        async function addtocart(e, data) {
            console.log(data)
            const productCard = e.closest('.product-card');
            if (data.category_id == 1) {
                const brand = productCard.querySelector('[name="brand"]');
                if (!brand.value) alert("Please Select Brand");
                const weight = productCard.querySelector('[name="weight"]').value;
                const length = productCard.querySelector('[name="length"]').value;
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
                const height = productCard.querySelector('[name="product_attribute_id"]');
                if (!height.value) alert("Please Select Height");
                const length = productCard.querySelector('[name="length"]').value;
                if (!length) alert("Please Select weight");
                formData = {
                    product_id: data.id,
                    length: length,
                    product_attribute_id: height.value
                };
                // console.log(formData)
            } else if (data.category_id == 3) {
                const thickness = productCard.querySelector('[name="product_attribute_id"]').value;
                if (!thickness) alert("Please Select thickness");
                const size = productCard.querySelector('[name="size"]').value;
                if (!size) alert("Please Select size");
                const no_of_sheet = productCard.querySelector('[name="no_of_sheet"]').value;
                if (!no_of_sheet) alert("Please Select size");
                const color = productCard.querySelector('[name="color"]').value;
                if (!color) alert("Please Select size");
                formData = {
                    product_id: data.id,
                    size: size,
                    no_of_sheet: no_of_sheet,
                    product_attribute_id: thickness,
                    color: color
                };
            } else {
                const thickness = productCard.querySelector('[name="thickness"]');
                if (!thickness.value) alert("Please Select thickness");
                const weight = productCard.querySelector('[name="weight"]').value;
                const length = productCard.querySelector('[name="length"]').value;
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
            const response = await axios({
                method: 'post',
                url: "http://localhost:8000/add-to-cart",
                // url:'http://192.168.1.15:8000/add-to-cart'
                data: formData,
                headers: {
                    "Content-Type": "multipart/form-data",
                    "X-CSRF-TOKEN": csrfToken
                },
            });
            if (response.data.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Item Added to Cart',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                })
                const count = Number(cartWebCount.innerText) + 1;
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




    <script>
        function addToWishlist(event, productId) {
            event.preventDefault();
            const btn = event.target.closest('button');
            $(btn).html(smallLoader)
            $.ajax({
                url: BASE_URL + "/add-to-wishlist", // Update the URL to match your route
                method: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status == "success") {

                        if (response.action == 'added') {
                            $(btn).html(activeWishlist)
                            const a = Number($('#wishlistWebCound').text()) + 1;
                            $('#wishlistWebCound').text(a)
                            $('#wishlistMobCound').text(a)
                        } else if (response.action == 'removed') {
                            $(btn).html(deactiveWishlist)
                            const a = Number($('#wishlistWebCound').text()) - 1;
                            $('#wishlistWebCound').text(a)
                            $('#wishlistMobCound').text(a)
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors
                },
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection
