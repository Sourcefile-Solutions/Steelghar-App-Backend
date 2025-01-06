@extends('public.layouts.app')
<style>
    .customer-logos {
        background-color: #ffffff;
    }

    /* Slider */
    .slick-slide {
        margin: 0px 20px;
    }

    .slick-slide img {
        width: 100%;
    }

    .slick-slider {
        position: relative;
        display: white;
        box-sizing: border-box;

        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;

        -webkit-touch-callout: none;
        -khtml-user-select: none;
        -ms-touch-action: pan-y;
        touch-action: pan-y;
        -webkit-tap-highlight-color: transparent;
    }

    .slick-list {
        position: relative;
        display: white;
        overflow: hidden;

        margin: 0;
        padding: 0;
    }

    .slick-list:focus {
        outline: none;
    }

    .slick-list.dragging {
        cursor: pointer;
        cursor: hand;
    }

    .slick-slider .slick-track,
    .slick-slider .slick-list {
        -webkit-transform: translate3d(0, 0, 0);
        -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        -o-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
    }

    .slick-track {
        position: relative;
        top: 0;
        left: 0;

        display: white;
    }

    .slick-track:before,
    .slick-track:after {
        display: table;

        content: '';
    }

    .slick-track:after {
        clear: both;
    }

    .slick-loading .slick-track {
        visibility: hidden;
    }

    .slick-slide {
        display: none;
        float: left;

        height: 100%;
        min-height: 1px;
    }

    [dir='rtl'] .slick-slide {
        float: right;
    }

    .slick-slide img {
        display: white;
    }

    .slick-slide.slick-loading img {
        display: none;
    }

    .slick-slide.dragging img {
        pointer-events: none;
    }

    .slick-initialized .slick-slide {
        display: white;
    }

    .slick-loading .slick-slide {
        visibility: hidden;
    }

    .slick-vertical .slick-slide {
        display: white;

        height: auto;

        border: 1px solid transparent;
    }

    .slick-arrow.slick-hidden {
        display: none;
    }

    logo-slider {
        overflow: hidden;
        max-width: 1920px;
        min-width: 320px;
        width: 100% !important;
        height: 40%;
        display: inline;
        padding-white: 5px;
    }

    @keyframes marquee {
        0% {
            transform: translateX(0%);
        }

        100% {
            transform: translateX(calc(-50% - (var(--slider-gap, max(16px, max(16px, 2vw))) * 2)));
        }
    }

    logo-slider>div {
        display: flex;
        align-items: center;
        animation: marquee calc(var(--slider-duration, 10s) + (var(--variable-duration, 0s) * 30)) linear infinite;
        justify-content: space-between;
        gap: var(--slider-gap, max(16px, max(16px, 2vw)));
    }

    logo-slider>div img {
        height: clamp(50%, 10vw, 100%);
        /* max-width: 150px; */
        max-height: 100px;
        object-fit: contain;
        display: white;
    }

    logo-slider>div:hover {
        animation-play-state: paused;
    }

    @media (min-width: 1920px) {
        logo-slider {
            -webkit-mask-image: linear-gradient(to right, transparent, white 10vw, white calc(100% - 10vw), transparent);
        }
    }
</style>
@section('content')
    <!-- site__header / end --><!-- site__body -->
    <div class="site__body">

        <div class="block block-slideshow">

            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    @foreach ($banner as $banner)
                        <div class="block-slideshow__item"><span
                                class="block-slideshow__item-image block-slideshow__item-image--desktop"
                                style="background-image: url('{{ asset("/storage/$banner->banner_image") }}')"></span>
                            <span class="block-slideshow__item-image block-slideshow__item-image--mobile"
                                style="background-image: url('{{ asset("/storage/$banner->mobile_banner") }}')"></span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="block-features block block-features--layout--bottom-strip pt-6">
            <div class="container">
                <ul class="block-features__list">
                    <li class="block-features__item">
                        <div class="block-features__item-icon">

                            <i class="fa-solid fa-truck fa-3x text-danger"></i>

                        </div>
                        <div class="block-features__item-info">
                            <div class="block-features__item-title">Seamless Delivery</div>

                        </div>
                    </li>
                    <li class="block-features__item">
                        <div class="block-features__item-icon">
                            <i class="fa-solid fa-phone fa-3x text-danger"></i>
                        </div>
                        <div class="block-features__item-info">
                            <div class="block-features__item-title">Support 24/7</div>

                        </div>
                    </li>
                    <li class="block-features__item">
                        <div class="block-features__item-icon"><i class="fa-solid fa-money-bill fa-3x text-danger"></i>
                        </div>
                        <div class="block-features__item-info">
                            <div class="block-features__item-title">Easy Refund Policy</div>

                        </div>
                    </li>
                    <li class="block-features__item">
                        <div class="block-features__item-icon"><i class="fa-solid fa-square-check fa-3x text-danger"></i>
                        </div>
                        <div class="block-features__item-info">
                            <div class="block-features__item-title">Verified Suppliers</div>

                        </div>
                    </li>
                </ul>
            </div>
            <div class="block-space block-space--layout--divider-nl"></div>
            <div class="block block-categories">
                <div class="container">
                    <div class="block-categories__header">
                        <div class="block-categories__title">Popular Categories<div
                                class="decor block-categories__title-decor decor--type--center">
                                <div class="decor__body">
                                    <div class="decor__start"></div>
                                    <div class="decor__end"></div>
                                    <div class="decor__center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-categories__body">
                    <div class="decor block-categories__body-decor decor--type--bottom">
                        <div class="decor__body">
                            <div class="decor__start"></div>
                            <div class="decor__end"></div>
                            <div class="decor__center"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="block-categories__list">


                            @foreach ($popularCategories as $product)
                                <div class="block-categories__item category-card category-card--layout--classic">


                                    <div class="category-card__body rounded shadow-sm"
                                        style="background-image: linear-gradient(to right, #dc3545, #dc354573);padding: 20px;color: white;">
                                        <a href="products/{{ $product->slug }}">
                                            <div class="category-card__content">
                                                <div class="category-card__image image image--type--category">
                                                    <div class="image__body">
                                                        <img class="image__tag rounded-lg"
                                                            src="{{ asset('/storage/' . $product->category_image) }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="category-card__info text-center m-auto">
                                                    <div class="category-card__name">
                                                        <h5 class="text-white">{{ $product->category_name }}</h5>
                                                    </div>
                                                    <!--<ul class="category-card__children">-->
                                                    <!--    <li>-->
                                                    <!--        <span>{{ $product->product_name }}</span>-->
                                                    <!--    </li>-->
                                                    <!-- Add more <li> elements for other product details if needed -->
                                                    <!--</ul>-->

                                                </div>
                                            </div>
                                        </a>
                                    </div>


                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            @if (count($latestProducts))
                <div class="block-space block-space--layout--divider-nl"></div>
                <div class="block block-products-carousel" data-layout="grid-5">
                    <div class="container">
                        <div class="section-header">
                            <div class="section-header__body">
                                <h2 class="section-header__title">Latest Products</h2>
                                <div class="section-header__spring"></div>
                                <ul class="section-header__groups">
                                    <li class="section-header__groups-item"><a href="#"><button type="button"
                                                class="section-header__groups-button section-header__groups-button--active">View
                                                All</button></a>
                                    </li>
                                    <!-- <li class="section-header__groups-item"><button type="button"
                                                                                                                                                                                                                                                          class="section-header__groups-button">Power Tools</button></li>
                                                                                                                                                                                                                                                        <li class="section-header__groups-item"><button type="button"
                                                                                                                                                                                                                                                          class="section-header__groups-button">Hand Tools</button></li>
                                                                                                                                                                                                                                                        <li class="section-header__groups-item"><button type="button"
                                                                                                                                                                                                                                                          class="section-header__groups-button">Plumbing</button></li> -->
                                </ul>
                                <div class="section-header__arrows">
                                    <div class="arrow section-header__arrow section-header__arrow--prev arrow--prev">
                                        <button class="arrow__button" type="button"><svg width="7" height="11">
                                                <path
                                                    d="M6.7,0.3L6.7,0.3c-0.4-0.4-0.9-0.4-1.3,0L0,5.5l5.4,5.2c0.4,0.4,0.9,0.3,1.3,0l0,0c0.4-0.4,0.4-1,0-1.3l-4-3.9l4-3.9C7.1,1.2,7.1,0.6,6.7,0.3z" />
                                            </svg></button>
                                    </div>
                                    <div class="arrow section-header__arrow section-header__arrow--next arrow--next">
                                        <button class="arrow__button" type="button"><svg width="7" height="11">
                                                <path
                                                    d="M0.3,10.7L0.3,10.7c0.4,0.4,0.9,0.4,1.3,0L7,5.5L1.6,0.3C1.2-0.1,0.7,0,0.3,0.3l0,0c-0.4,0.4-0.4,1,0,1.3l4,3.9l-4,3.9C-0.1,9.8-0.1,10.4,0.3,10.7z" />
                                            </svg></button>
                                    </div>
                                </div>
                                <div class="section-header__divider"></div>
                            </div>
                        </div>



                        <div class="block-products-carousel__carousel">
                            <div class="block-products-carousel__carousel-loader"></div>
                            <div class="owl-carousel">
                                @foreach ($latestProducts as $product)
                                    <div class="block-products-carousel__column">
                                        <div class="block-products-carousel__cell">
                                            <div class="product-card product-card--layout--grid">
                                                <div class="product-card__actions-list">

                                                    <!--<button class="product-card__action product-card__action--wishlist"-->
                                                    <!--    type="button" aria-label="Add to wish list"><svg width="16"-->
                                                    <!--        height="16">-->
                                                    <!--        <path-->
                                                    <!--            d="M13.9,8.4l-5.4,5.4c-0.3,0.3-0.7,0.3-1,0L2.1,8.4c-1.5-1.5-1.5-3.8,0-5.3C2.8,2.4,3.8,2,4.8,2s1.9,0.4,2.6,1.1L8,3.7l0.6-0.6C9.3,2.4,10.3,2,11.3,2c1,0,1.9,0.4,2.6,1.1C15.4,4.6,15.4,6.9,13.9,8.4z" />-->
                                                    <!--    </svg></button>-->

                                                </div>
                                                <div class="product-card__image">
                                                    <div class="image image--type--product">
                                                        <div class="image__body"><img class="image__tag"
                                                                src="{{ $product['product_image'] }}" alt="">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="product-card__info">

                                                    <div class="product-card__name py-2">
                                                        <div class="font-weight-bold">
                                                            <span>{{ $product['product_name'] }}</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="product-card__footer">
                                                    <div class="product-card__prices">
                                                        <div
                                                            class="product-card__price product-card__price--current text-success">
                                                            Starts
                                                            From

                                                        </div>
                                                    </div>
                                                    <span class="font-weight-bold">₹{{ $product['price_start'] }}</span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach




                            </div>
                        </div>


                    </div>
                </div>
            @endif
        </div>


        @if (count($brands))
            <section class="py-5 bg-white">
                <div class="container-fluid aos-init aos-animate customer-logos" data-aos="fade-up"
                    data-aos-duration="1000">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 class="fw-medium pb-3 mt-0 fs-1">Brands</h4>
                            <logo-slider>

                                <div class="customer-logos">
                                    @foreach ($brands as $brand)
                                        <div class="slide">
                                            <img src="storage/{{ $brand->logo }}" height="70" width="170"
                                                alt="" />
                                        </div>
                                    @endforeach
                                </div>

                            </logo-slider>

                        </div>
                    </div>
                </div>
            </section>

            <div class="block-space block-space--layout--divider-nl"></div>
        @endif

    @endsection


    @section('scripts')
        <script>
            class LogoSlider extends HTMLElement {

                connectedCallback() {
                    this.boundUpdateVariableDuration = this.updateVariableDuration.bind(this);
                    window.addEventListener('resize', this.boundUpdateVariableDuration);
                    this.boundUpdateVariableDuration()

                    Array.from(this.firstElementChild.children).forEach(child => this.firstElementChild.append(child
                        .cloneNode(true)))
                }

                disconnectedCallback() {
                    window.removeEventListener('resize', this.boundUpdateVariableDuration);
                }

                updateVariableDuration() {
                    this.firstElementChild.style.animation = 'initial'
                    const computedStyle = getComputedStyle(this);
                    const minWidth = parseInt(computedStyle.minWidth || 320, 10);
                    const maxWidth = parseInt(computedStyle.maxWidth || 1920, 10);
                    const windowWidth = window.innerWidth
                    const normalized = Math.min(1, Math.max(0, parseFloat(((windowWidth - minWidth) / (maxWidth - minWidth))
                        .toFixed(2))));
                    this.style.setProperty('--variable-duration', `${normalized}s`);
                    setTimeout(() => {
                        this.firstElementChild.style.animation = ''
                    }, 500)
                }

            }

            if (!customElements.get('logo-slider')) {
                customElements.define('logo-slider', LogoSlider)
            }

            $(document).ready(function() {
                $('.customer-logos').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    arrows: false,
                    dots: false,
                    pauseOnHover: false,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3
                        }
                    }, {
                        breakpoint: 520,
                        settings: {
                            slidesToShow: 2
                        }
                    }]
                });
            });
        </script>
    @endsection
