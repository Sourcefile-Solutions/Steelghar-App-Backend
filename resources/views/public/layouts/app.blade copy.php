<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('') }}public/assets/images/logo.jpg"><!-- fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i"><!-- css -->
    <link rel="stylesheet" href="{{ asset('') }}public/assets/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/vendor/owl-carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/vendor/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/vendor/photoswipe/default-skin/default-skin.css">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/style.header-classic-variant-one.css"
        media="(min-width: 1200px)">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/style.mobile-header-variant-one.css"
        media="(max-width: 1199px)">
    <!-- font - fontawesome -->
    <link rel="stylesheet" href="{{ asset('') }}public/assets/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const BASE_URL = "{{ route('public.home') }}";

        const activeWishlist = `<svg width="16" height="16"
                                                                        viewBox="0 0 256 256">
                                                                        <path fill="none" d="M0 0h256v256H0z">
                                                                        </path>
                                                                        <path fill="#fc0505" stroke="#fff"
                                                                            d="M176 32a60 60 0 0 0-48 24A60 60 0 0 0 20 92c0 71.9 99.9 128.6 104.1 131a7.8 7.8 0 0 0 3.9 1 7.6 7.6 0 0 0 3.9-1 314.3 314.3 0 0 0 51.5-37.6C218.3 154 236 122.6 236 92a60 60 0 0 0-60-60Z">
                                                                        </path>
                                                                    </svg>`
        const deactiveWishlist =
            `<svg width="16" height="16"> <path d="M13.9,8.4l-5.4,5.4c-0.3,0.3-0.7,0.3-1,0L2.1,8.4c-1.5-1.5-1.5-3.8,0-5.3C2.8,2.4,3.8,2,4.8,2s1.9,0.4,2.6,1.1L8,3.7l0.6-0.6C9.3,2.4,10.3,2,11.3,2c1,0,1.9,0.4,2.6,1.1C15.4,4.6,15.4,6.9,13.9,8.4z" /></svg>`
        const smallLoader = `<span class="spinner-border spinner-border-sm text-danger"></span>`;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</head>

<body><!-- site -->
    <div class="site"><!-- site__mobile-header -->
        <header class="site__mobile-header">
            <div class="mobile-header">
                <div class="container">
                    <div class="mobile-header__body">
                        <button class="mobile-header__menu-button" type="button">
                            <svg width="18px" height="14px">
                                <path
                                    d="M-0,8L-0,6L18,6L18,8L-0,8ZM-0,-0L18,-0L18,2L-0,2L-0,-0ZM14,14L-0,14L-0,12L14,12L14,14Z" />
                            </svg>
                        </button>
                        <a class="mobile-header__logo" href={{ route('public.home') }}><!-- mobile-logo -->
                            <img src="{{ asset('') }}public/assets/images/logo.jpg" class="w-50" />
                            <!-- mobile-logo / end --></a>
                        <div class="mobile-header__search mobile-search">
                            <form class="mobile-search__body m-0">
                                <input type="text" class="mobile-search__input" placeholder="Search Product"
                                    id="mobilesearch" />
                                <!--                              <button type="button" class="mobile-search__vehicle-picker"-->
                                <!--                                  aria-label="Select Vehicle">-->
                                <!--                                  <svg width="20" height="20">-->
                                <!--                                      <path d="M6.6,2c2,0,4.8,0,6.8,0c1,0,2.9,0.8,3.6,2.2C17.7,5.7,17.9,7,18.4,7C20,7,20,8,20,8v1h-1v7.5c0,0.8-0.7,1.5-1.5,1.5h-1-->
                                <!--c-0.8,0-1.5-0.7-1.5-1.5V16H5v0.5C5,17.3,4.3,18,3.5,18h-1C1.7,18,1,17.3,1,16.5V16V9H0V8c0,0,0.1-1,1.6-1C2.1,7,2.3,5.7,3,4.2-->
                                <!--C3.7,2.8,5.6,2,6.6,2z M13.3,4H6.7c-0.8,0-1.4,0-2,0.7c-0.5,0.6-0.8,1.5-1,2C3.6,7.1,3.5,7.9,3.7,8C4.5,8.4,6.1,9,10,9-->
                                <!--c4,0,5.4-0.6,6.3-1c0.2-0.1,0.2-0.8,0-1.2c-0.2-0.4-0.5-1.5-1-2C14.7,4,14.1,4,13.3,4z M4,10c-0.4-0.3-1.5-0.5-2,0-->
                                <!--c-0.4,0.4-0.4,1.6,0,2c0.5,0.5,4,0.4,4,0C6,11.2,4.5,10.3,4,10z M14,12c0,0.4,3.5,0.5,4,0c0.4-0.4,0.4-1.6,0-2c-0.5-0.5-1.3-0.3-2,0-->
                                <!--C15.5,10.2,14,11.3,14,12z" />-->
                                <!--                                  </svg>-->

                                <!--                              </button>-->
                                <button type="submit" class="mobile-search__button mobile-search__button--search"
                                    id="mobile-search-button">
                                    <svg width="20" height="20">
                                        <path
                                            d="M19.2,17.8c0,0-0.2,0.5-0.5,0.8c-0.4,0.4-0.9,0.6-0.9,0.6s-0.9,0.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9C10.9,14.5,9.5,15,8,15c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7c0,1.5-0.5,2.9-1.3,4c1.1,0.8,2.5,2,4,3.1C20,16.8,19.2,17.8,19.2,17.8z M8,3C5.2,3,3,5.2,3,8c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5C13,5.2,10.8,3,8,3z" />
                                    </svg>
                                </button>
                                <button type="button" class="mobile-search__button mobile-search__button--close">
                                    <svg width="20" height="20">
                                        <path
                                            d="M16.7,16.7L16.7,16.7c-0.4,0.4-1,0.4-1.4,0L10,11.4l-5.3,5.3c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L8.6,10L3.3,4.7c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L10,8.6l5.3-5.3c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L11.4,10l5.3,5.3C17.1,15.7,17.1,16.3,16.7,16.7z" />
                                    </svg>
                                </button>
                                <div class="mobile-search__field"></div>
                            </form>
                        </div>
                        <div class="mobile-header__indicators">
                            <div class="mobile-indicator mobile-indicator--search d-md-none">
                                <button type="button" class="mobile-indicator__button">
                                    <span class="mobile-indicator__icon"><svg width="20" height="20">
                                            <path d="M19.2,17.8c0,0-0.2,0.5-0.5,0.8c-0.4,0.4-0.9,0.6-0.9,0.6s-0.9,0.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9C10.9,14.5,9.5,15,8,15
  c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7c0,1.5-0.5,2.9-1.3,4c1.1,0.8,2.5,2,4,3.1C20,16.8,19.2,17.8,19.2,17.8z M8,3C5.2,3,3,5.2,3,8
  c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5C13,5.2,10.8,3,8,3z" />
                                        </svg></span>
                                </button>
                            </div>
                            {{-- <div class="mobile-indicator d-none d-lg-block">
                                <a href="#" class="mobile-indicator__button"><span
                                        class="mobile-indicator__icon"><svg width="20" height="20">
                                            <path d="M20,20h-2c0-4.4-3.6-8-8-8s-8,3.6-8,8H0c0-4.2,2.6-7.8,6.3-9.3C4.9,9.6,4,7.9,4,6c0-3.3,2.7-6,6-6s6,2.7,6,6
  c0,1.9-0.9,3.6-2.3,4.7C17.4,12.2,20,15.8,20,20z M14,6c0-2.2-1.8-4-4-4S6,3.8,6,6s1.8,4,4,4S14,8.2,14,6z" />
                                        </svg></span></a>
                            </div>
                            <div class="mobile-indicator d-none d-lg-block">
                                <a href="#" class="mobile-indicator__button"><span
                                        class="mobile-indicator__icon"><svg width="20" height="20">
                                            <path d="M14,3c2.2,0,4,1.8,4,4c0,4-5.2,10-8,10S2,11,2,7c0-2.2,1.8-4,4-4c1,0,1.9,0.4,2.7,1L10,5.2L11.3,4C12.1,3.4,13,3,14,3 M14,1
  c-1.5,0-2.9,0.6-4,1.5C8.9,1.6,7.5,1,6,1C2.7,1,0,3.7,0,7c0,5,6,12,10,12s10-7,10-12C20,3.7,17.3,1,14,1L14,1z" />
                                        </svg></span></a>
                            </div> --}}
                            <!--                          <div class="mobile-indicator">-->
                            <!--                              <a href="#" class="mobile-indicator__button"><span-->
                            <!--                                      class="mobile-indicator__icon"><svg width="20" height="20">-->
                            <!--                                          <circle cx="7" cy="17" r="2" />-->
                            <!--                                          <circle cx="15" cy="17" r="2" />-->
                            <!--                                          <path d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6-->
                            <!--V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4-->
                            <!--C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z" />-->
                            <!--                                      </svg>-->
                            <!--                                      <span class="mobile-indicator__counter">3</span></span></a>-->
                            <!--                          </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </header><!-- site__mobile-header / end --><!-- site__header -->
        <header class="site__header">
            <div class="header">
                <!-- <div class="header__megamenu-area megamenu-area"></div>
    <div class="header__topbar-classic-bg"></div -->
                <div class="header__topbar-classic">
                    <div class="topbar topbar--classic pt-3">
                        <marquee direction="left">
                            <p class="text-danger font-weight-bold">* All prices shown on the site are on real time
                                basis. The
                                prices displayed on the
                                website are firm for the order only when the payment is made successfully.</p>
                        </marquee>
                    </div>
                </div>
                <div class="header__navbar">
                    <div class="header__navbar-departments">
                        <div class="departments">
                            <button class="departments__button" type="button"><span
                                    class="departments__button-icon"><svg width="16px" height="12px">
                                        <path
                                            d="M0,7L0,5L16,5L16,7L0,7ZM0,0L16,0L16,2L0,2L0,0ZM12,12L0,12L0,10L12,10L12,12Z" />
                                    </svg> </span><span class="departments__button-title">Shop By Category</span> <span
                                    class="departments__button-arrow"><svg width="9px" height="6px">
                                        <path
                                            d="M0.2,0.4c0.4-0.4,1-0.5,1.4-0.1l2.9,3l2.9-3c0.4-0.4,1.1-0.4,1.4,0.1c0.3,0.4,0.3,0.9-0.1,1.3L4.5,6L0.3,1.6C-0.1,1.3-0.1,0.7,0.2,0.4z" />
                                    </svg></span></button>
                            <div class="departments__menu">
                                <div class="departments__arrow"></div>
                                <div class="departments__body">
                                    <ul class="departments__list">
                                        <li class="departments__list-padding" role="presentation"></li>
                                        @foreach ($menues as $category)
                                            @if (count($category->subcategories))
                                                <li class="menu__item menu__item--has-submenu">
                                                    <a href="{{ route('public.products.index', ['category' => $category->slug]) }}"
                                                        class="menu__link">{{ $category->category_name }}
                                                        <span class="menu__arrow"><svg width="6px" height="9px">
                                                                <path
                                                                    d="M0.3,7.4l3-2.9l-3-2.9c-0.4-0.3-0.4-0.9,0-1.3l0,0c0.4-0.3,0.9-0.4,1.3,0L6,4.5L1.6,8.7c-0.4,0.4-0.9,0.4-1.3,0l0,0C-0.1,8.4-0.1,7.8,0.3,7.4z" />
                                                            </svg></span></a>
                                                    <div class="menu__submenu">
                                                        <ul class="menu">
                                                            @foreach ($category->subcategories as $subcategory)
                                                                <li class="menu__item">
                                                                    <a href="{{ route('public.products.index', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}"
                                                                        class="menu__link">
                                                                        {{ $subcategory->subcategory_name }}
                                                                        {{-- @if ($subcategory->is_divison)
                                                                            <span class="menu__arrow"><svg
                                                                                    width="6px" height="9px">
                                                                                    <path
                                                                                        d="M0.3,7.4l3-2.9l-3-2.9c-0.4-0.3-0.4-0.9,0-1.3l0,0c0.4-0.3,0.9-0.4,1.3,0L6,4.5L1.6,8.7c-0.4,0.4-0.9,0.4-1.3,0l0,0C-0.1,8.4-0.1,7.8,0.3,7.4z" />
                                                                                </svg>
                                                                            </span>
                                                                        @endif --}}
                                                                    </a>
                                                                    {{-- @if ($subcategory->is_divison)
                                                                        <div class="menu__submenu pt-2">
                                                                            <ul class="menu">
                                                                                @foreach ($subcategory->divisions as $division)
                                                                                    <li class="menu__item">
                                                                                        <a href="#"
                                                                                            class="menu__link">{{ $division->division_name }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endif --}}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @else
                                                <li class="menu__item menu__item--has-submenu">
                                                    <a href="{{ route('public.products.index', ['category' => $category->slug]) }}"
                                                        class="departments__item-link">

                                                        {{ $category->category_name }}

                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach

                                        <li class="departments__list-padding" role="presentation"></li>
                                    </ul>
                                    <div class="departments__menu-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header__navbar-menu">
                        <div class="main-menu">
                            <ul class="main-menu__list">
                                <li
                                    class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                                    <a href="{{ route('public.home') }}" class="main-menu__link">Home </a>

                                </li>
                                <li
                                    class="main-menu__item main-menu__item--submenu--megamenu main-menu__item--has-submenu">
                                    <a href="{{ route('public.about') }}" class="main-menu__link">About Us</a>

                                </li>
                                <li
                                    class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                                    <a href="{{ route('public.products.index') }}"
                                        class="main-menu__link">Products</a>

                                </li>
                                <li
                                    class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                                    <a href="{{ route('public.expert-advice') }}" class="main-menu__link">Expert
                                        Advice</a>

                                </li>
                                <li
                                    class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                                    <a href="{{ route('public.calculator') }}" class="main-menu__link">Calculator</a>

                                </li>
                                <li
                                    class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                                    <a href="{{ route('public.contact') }}" class="main-menu__link">Contact Us</a>

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header__navbar-phone phone"><a href="#" class="phone__body">
                            <div class="phone__title">Call Us:</div>
                            <div class="phone__number">{{ $settings->phone }}</div>
                        </a></div>
                </div>
                <div class="header__logo"><a href={{ route('public.home') }} class="logo">
                        <div class="logo__slogan"></div>
                        <div class="logo__image"><!-- logo -->
                            <img src="{{ asset('') }}public/assets/images/logo.jpg"></img>
                            <!-- logo / end -->
                        </div>
                    </a></div>
                <div class="header__search">
                    <div class="search">
                        <form action="#" class="search__body">
                            <div class="search__shadow"></div><input class="search__input" type="text"
                                placeholder="Search products" id="webSearch">
                            <button class="search__button search__button--end" type="submit"
                                id="search-button"><span class="search__button-icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                        <path
                                            d="M19.2 17.8s-.2.5-.5.8c-.4.4-.9.6-.9.6s-.9.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9-1 .8-2.4 1.3-3.9 1.3-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7c0 1.5-.5 2.9-1.3 4 1.1.8 2.5 2 4 3.1 2.3 1.7 1.5 2.7 1.5 2.7zM8 3C5.2 3 3 5.2 3 8s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                            <div class="search__box"></div>
                            <div class="search__decor">
                                <div class="search__decor-start"></div>
                                <div class="search__decor-end"></div>
                            </div>
                            <div class="search__dropdown search__dropdown--suggestions suggestions">
                                <div class="suggestions__group">

                                    <div class="suggestions__group-content" id="webSearchBody">


                                    </div>
                                </div>

                            </div>
                            <div class="search__dropdown search__dropdown--vehicle-picker vehicle-picker">
                                <div class="search__dropdown-arrow"></div>
                                <div class="vehicle-picker__panel vehicle-picker__panel--list vehicle-picker__panel--active"
                                    data-panel="list">
                                    <div class="vehicle-picker__panel-body">
                                        <div class="vehicle-picker__text">Select a vehicle to find exact fit parts
                                        </div>
                                        <div class="vehicles-list">
                                            <div class="vehicles-list__body"><label class="vehicles-list__item"><span
                                                        class="vehicles-list__item-radio input-radio"><span
                                                            class="input-radio__body"><input
                                                                class="input-radio__input" name="header-vehicle"
                                                                type="radio"> <span
                                                                class="input-radio__circle"></span> </span></span><span
                                                        class="vehicles-list__item-info"><span
                                                            class="vehicles-list__item-name">2011 Ford Focus S</span>
                                                        <span class="vehicles-list__item-details">Engine 2.0L 1742DA L4
                                                            FI Turbo</span> </span><button type="button"
                                                        class="vehicles-list__item-remove"><svg width="16"
                                                            height="16">
                                                            <path
                                                                d="M2,4V2h3V1h6v1h3v2H2z M13,13c0,1.1-0.9,2-2,2H5c-1.1,0-2-0.9-2-2V5h10V13z" />
                                                        </svg></button></label> <label
                                                    class="vehicles-list__item"><span
                                                        class="vehicles-list__item-radio input-radio"><span
                                                            class="input-radio__body"><input
                                                                class="input-radio__input" name="header-vehicle"
                                                                type="radio"> <span
                                                                class="input-radio__circle"></span> </span></span><span
                                                        class="vehicles-list__item-info"><span
                                                            class="vehicles-list__item-name">2019 Audi Q7
                                                            Premium</span>
                                                        <span class="vehicles-list__item-details">Engine 3.0L 5626CC L6
                                                            QK</span> </span><button type="button"
                                                        class="vehicles-list__item-remove"><svg width="16"
                                                            height="16">
                                                            <path
                                                                d="M2,4V2h3V1h6v1h3v2H2z M13,13c0,1.1-0.9,2-2,2H5c-1.1,0-2-0.9-2-2V5h10V13z" />
                                                        </svg></button></label></div>
                                        </div>
                                        <div class="vehicle-picker__actions"><button type="button"
                                                class="btn btn-primary btn-sm" data-to-panel="form">Add A
                                                Vehicle</button></div>
                                    </div>
                                </div>
                                <div class="vehicle-picker__panel vehicle-picker__panel--form" data-panel="form">
                                    <div class="vehicle-picker__panel-body">
                                        <div class="vehicle-form vehicle-form--layout--search">
                                            <div class="vehicle-form__item vehicle-form__item--select"><select
                                                    class="form-control form-control-select2" aria-label="Year">
                                                    <option value="none">Select Year</option>
                                                    <option>2010</option>
                                                    <option>2011</option>
                                                    <option>2012</option>
                                                    <option>2013</option>
                                                    <option>2014</option>
                                                    <option>2015</option>
                                                    <option>2016</option>
                                                    <option>2017</option>
                                                    <option>2018</option>
                                                    <option>2019</option>
                                                    <option>2020</option>
                                                </select></div>
                                            <div class="vehicle-form__item vehicle-form__item--select"><select
                                                    class="form-control form-control-select2" aria-label="Brand"
                                                    disabled="disabled">
                                                    <option value="none">Select Brand</option>
                                                    <option>Audi</option>
                                                    <option>BMW</option>
                                                    <option>Ferrari</option>
                                                    <option>Ford</option>
                                                    <option>KIA</option>
                                                    <option>Nissan</option>
                                                    <option>Tesla</option>
                                                    <option>Toyota</option>
                                                </select></div>
                                            <div class="vehicle-form__item vehicle-form__item--select"><select
                                                    class="form-control form-control-select2" aria-label="Model"
                                                    disabled="disabled">
                                                    <option value="none">Select Model</option>
                                                    <option>Explorer</option>
                                                    <option>Focus S</option>
                                                    <option>Fusion SE</option>
                                                    <option>Mustang</option>
                                                </select></div>
                                            <div class="vehicle-form__item vehicle-form__item--select"><select
                                                    class="form-control form-control-select2" aria-label="Engine"
                                                    disabled="disabled">
                                                    <option value="none">Select Engine</option>
                                                    <option>Gas 1.6L 125 hp AT/L4</option>
                                                    <option>Diesel 2.5L 200 hp AT/L5</option>
                                                    <option>Diesel 3.0L 250 hp MT/L5</option>
                                                </select></div>
                                            <div class="vehicle-form__divider">Or</div>
                                            <div class="vehicle-form__item"><input type="text"
                                                    class="form-control" placeholder="Enter VIN number"
                                                    aria-label="VIN number"></div>
                                        </div>
                                        <div class="vehicle-picker__actions">
                                            <div class="search__car-selector-link"><a href="#"
                                                    data-to-panel="list">Back
                                                    to vehicles list</a></div><button type="button"
                                                class="btn btn-primary btn-sm" disabled="disabled">Add A
                                                Vehicle</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="header__indicators">
                    <div class="indicator"><a href="{{ route('public.wishlist') }}" class="indicator__button">
                            <span class="indicator__icon"><svg width="32" height="32">
                                    <path
                                        d="M23,4c3.9,0,7,3.1,7,7c0,6.3-11.4,15.9-14,16.9C13.4,26.9,2,17.3,2,11c0-3.9,3.1-7,7-7c2.1,0,4.1,1,5.4,2.6l1.6,2l1.6-2C18.9,5,20.9,4,23,4 M23,2c-2.8,0-5.4,1.3-7,3.4C14.4,3.3,11.8,2,9,2c-5,0-9,4-9,9c0,8,14,19,16,19s16-11,16-19C32,6,28,2,23,2L23,2z" />
                                </svg><span class="indicator__counter"
                                    id="wishlistWebCound">{{ $wishlistCount }}</span></span></a>
                    </div>
                    <div class="indicator {{ Auth::guard('customer')->check() ? 'indicator--trigger--click' : '' }}">
                        <a href="/login" class="indicator__button">
                            <span class="indicator__icon">
                                <svg width="32" height="32">
                                    <path
                                        d="M16,18C9.4,18,4,23.4,4,30H2c0-6.2,4-11.5,9.6-13.3C9.4,15.3,8,12.8,8,10c0-4.4,3.6-8,8-8s8,3.6,8,8c0,2.8-1.5,5.3-3.6,6.7C26,18.5,30,23.8,30,30h-2C28,23.4,22.6,18,16,18z M22,10c0-3.3-2.7-6-6-6s-6,2.7-6,6s2.7,6,6,6S22,13.3,22,10z" />
                                </svg>
                            </span>
                            <span class="indicator__value mt-2">
                                @guestGuard('customer')
                                Login
                                @endguestGuard

                                @authGuard('customer')
                                {{ Auth::guard('customer')->user()->name }}
                                @endauthGuard


                            </span>
                        </a>
                        @authGuard('customer')
                        <div class="indicator__content">

                            <div class="account-menu">
                                <div class="account-menu__divider"></div>

                                <ul class="account-menu__links">

                                    <li><a href="{{ route('public.profile') }}">My Profile</a></li>

                                    <li><a href="{{ route('public.orders.index') }}">Order History</a></li>

                                    <li><a href="{{ route('public.profile.address') }}">Addresses</a></li>

                                    <li class="p-2">
                                        {{-- @if ($fab != null)
                                            @if ($fab->approval_status == 'PENDING')
                                                <span>Fabricator Status : </span><span class="text-info">Pending</span>
                                            @elseif ($fab->approval_status == 'APPROVED')
                                                <span>Fabricator ID : </span><span
                                                    class="text-success"><b>{{ $fab->fab_id }}</b></span>
                                            @elseif ($fab->approval_status == 'REJECTED')
                                                <span>Reject Reason : </span><span
                                                    class="text-success">{{ $fab->reason }}</span>
                                                <a href="#">
                                                    <button class="btn btn-info rounded-lg">Re-apply For Fabricators
                                                        Id</button>
                                                </a>
                                            @elseif($fab->approval_status == 'BLOCKED')
                                                <span>Fabricator Status : </span><span
                                                    class="text-danger">Blocked</span>
                                            @endif
                                        @else
                                            <a href="#">
                                                <button class="btn btn-info rounded-lg">Apply For Fabricators
                                                    Id</button>
                                            </a>
                                        @endif --}}
                                    </li>

                                </ul>
                                <div class="account-menu__divider"></div>
                                <div class="form-group account-menu__form-button mt-3">

                                    <form action="{{ route('public.logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            Logout
                                        </button>
                                    </form>

                                </div>

                                <div class="account-menu__divider"></div>
                            </div>
                        </div>
                        @endauthGuard

                    </div>

                    <div>
                        <a href="{{ route('public.cart.index') }}" class="indicator__button">
                            <span class="indicator__icon">
                                <svg width="32" height="32">
                                    <circle cx="10.5" cy="27.5" r="2.5" />
                                    <circle cx="23.5" cy="27.5" r="2.5" />
                                    <path
                                        d="M26.4,21H11.2C10,21,9,20.2,8.8,19.1L5.4,4.8C5.3,4.3,4.9,4,4.4,4H1C0.4,4,0,3.6,0,3s0.4-1,1-1h3.4C5.8,2,7,3,7.3,4.3l3.4,14.3c0.1,0.2,0.3,0.4,0.5,0.4h15.2c0.2,0,0.4-0.1,0.5-0.4l3.1-10c0.1-0.2,0-0.4-0.1-0.4C29.8,8.1,29.7,8,29.5,8H14c-0.6,0-1-0.4-1-1s0.4-1,1-1h15.5c0.8,0,1.5,0.4,2,1c0.5,0.6,0.6,1.5,0.4,2.2l-3.1,10C28.5,20.3,27.5,21,26.4,21z" />
                                </svg>
                                <span class="indicator__counter cart_count"
                                    id="cartWebCount">{{ $cartCount }}</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')
    </div><!-- site__body / end --><!-- site__footer -->
    <footer class="site__footer">
        <div class="site-footer">
            <div class="decor site-footer__decor decor--type--bottom">
                <div class="decor__body">
                    <div class="decor__start"></div>
                    <div class="decor__end"></div>
                    <div class="decor__center"></div>
                </div>
            </div>


            <div class="site-footer__widgets">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-xl-4">
                            <div class="site-footer__widget footer-contacts">
                                <h5 class="footer-contacts__title">Steel Ghar</h5>
                                <div class="footer-contacts__text">Your one-stop shop for steel products, offering a
                                    seamless online experience for purchasing steel materials.</div>
                                <address class="footer-contacts__contacts">
                                    <dl>
                                        <dt>Phone Number</dt>
                                        <dd>{{ $settings->phone }}</dd>
                                    </dl>
                                    <dl>
                                        <dt>Email Address</dt>
                                        <dd>{{ $settings->email }}</dd>
                                    </dl>
                                    <dl>
                                        <dt>Our Location</dt>
                                        <dd>Bengaluru, Karntaka</dd>
                                    </dl>
                                    <dl>
                                        <dt>Working Hours</dt>
                                        <dd>Sun-Sat 09:00am - 9:00pm</dd>
                                    </dl>
                                </address>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-xl-2">
                            <div class="site-footer__widget footer-links">
                                <h5 class="footer-links__title">Information</h5>
                                <ul class="footer-links__list">
                                    <li class="footer-links__item"><a href="{{ route('public.about') }}"
                                            class="footer-links__link">About
                                            Us</a></li>
                                    <li class="footer-links__item"><a href="{{ route('public.contact') }}"
                                            class="footer-links__link">Contact Us</a></li>
                                    <li class="footer-links__item"><a href="{{ route('public.brands') }}"
                                            class="footer-links__link">All
                                            Brands</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-xl-2">
                            <div class="site-footer__widget footer-links">
                                <h5 class="footer-links__title">Policies</h5>
                                <ul class="footer-links__list">

                                    <li class="footer-links__item"><a href="#"
                                            class="footer-links__link">FAQs</a></li>
                                    <li class="footer-links__item"><a
                                            href="{{ route('public.terms-and-conditions') }}"
                                            class="footer-links__link">Terms
                                            & Conditions</a></li>
                                    <li class="footer-links__item"><a href="{{ route('public.return-policy') }}"
                                            class="footer-links__link">Return Policy</a></li>

                                    <li class="footer-links__item"><a href="{{ route('public.privacy-policy') }}"
                                            class="footer-links__link">Privacy Policy</a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="site-footer__widget footer-newsletter">
                                <h5 class="footer-newsletter__title">Social Media</h5>
                                {{-- <div class="footer-newsletter__text">Enter your email address below to
                                    subscribe to
                                    our newsletter and keep up to date with discounts and special
                                    offers.</div>
                                <form action="#" class="footer-newsletter__form"><label class="sr-only"
                                        for="footer-newsletter-address">Email
                                        Address</label> <input type="text" class="footer-newsletter__form-input"
                                        id="footer-newsletter-address" placeholder="Email Address..."> <button
                                        class="footer-newsletter__form-button">Subscribe</button>
                                </form> --}}
                                <div class="footer-newsletter__text footer-newsletter__text--social">
                                    Follow us on
                                    social networks</div>
                                <div class="footer-newsletter__social-links social-links">
                                    <ul class="social-links__list">
                                        <li class="social-links__item social-links__item--facebook"><a
                                                href="{{ $settings->facebook }}" target="_blank"><i
                                                    class="fab fa-facebook-f"></i></a></li>

                                        <li class="social-links__item social-links__item--instagram">
                                            <a href="{{ $settings->instagram }}" target="_blank"><i
                                                    class="fab fa-instagram"></i></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--<div class="site-footer__bottom">-->
            <!--	<div class="container">-->
            <!--		<div class="site-footer__bottom-row">-->
            <!--<div class="site-footer__copyright">  Designed by <a-->
            <!--		href="#"-->
            <!--		target="_blank">SFS</a>-->
            <!--</div>-->
            <!--<div class="site-footer__payments"><img src="images/payments.png" alt=""></div>-->
            <!--		</div>-->
            <!--	</div>-->
            <!--</div>-->
        </div>
    </footer>
    <!-- site__footer / end -->
    </div><!-- site / end --><!-- mobile-menu -->
    <div class="mobile-menu">
        <div class="mobile-menu__backdrop"></div>
        <div class="mobile-menu__body"><button class="mobile-menu__close" type="button"><svg width="12"
                    height="12">
                    <path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6
c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4
C11.2,9.8,11.2,10.4,10.8,10.8z" />
                </svg></button>
            <div class="mobile-menu__panel">
                <div class="mobile-menu__panel-header">
                    <div class="mobile-menu__panel-title">Steel Ghar</div>
                </div>
                <div class="mobile-menu__panel-body">


                    <div class="mobile-menu__divider"></div>
                    <div class="mobile-menu__indicators"><a class="mobile-menu__indicator"
                            href="{{ route('public.wishlist') }}"><span class="mobile-menu__indicator-icon"><svg
                                    width="20" height="20">
                                    <path d="M14,3c2.2,0,4,1.8,4,4c0,4-5.2,10-8,10S2,11,2,7c0-2.2,1.8-4,4-4c1,0,1.9,0.4,2.7,1L10,5.2L11.3,4C12.1,3.4,13,3,14,3 M14,1
c-1.5,0-2.9,0.6-4,1.5C8.9,1.6,7.5,1,6,1C2.7,1,0,3.7,0,7c0,5,6,12,10,12s10-7,10-12C20,3.7,17.3,1,14,1L14,1z" />
                                </svg> <span class="mobile-menu__indicator-counter"
                                    id="wishlistMobCound">{{ $wishlistCount }}</span></span><span
                                class="mobile-menu__indicator-title">Wishlist</span>
                        </a><a class="mobile-menu__indicator" href="{{ route('public.profile') }}"><span
                                class="mobile-menu__indicator-icon"><svg width="20" height="20">
                                    <path d="M20,20h-2c0-4.4-3.6-8-8-8s-8,3.6-8,8H0c0-4.2,2.6-7.8,6.3-9.3C4.9,9.6,4,7.9,4,6c0-3.3,2.7-6,6-6s6,2.7,6,6
c0,1.9-0.9,3.6-2.3,4.7C17.4,12.2,20,15.8,20,20z M14,6c0-2.2-1.8-4-4-4S6,3.8,6,6s1.8,4,4,4S14,8.2,14,6z" />
                                </svg> </span><span class="mobile-menu__indicator-title">Account</span>
                        </a><a class="mobile-menu__indicator" href="{{ route('public.cart.index') }}"><span
                                class="mobile-menu__indicator-icon"><svg width="20" height="20">
                                    <circle cx="7" cy="17" r="2" />
                                    <circle cx="15" cy="17" r="2" />
                                    <path d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6
V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4
C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z" />
                                </svg> <span class="mobile-menu__indicator-counter cart_count"
                                    id="cartMobCount">{{ $cartCount }}</span>
                            </span><span class="mobile-menu__indicator-title">Cart</span> </a><a
                            class="mobile-menu__indicator" href="#"><span
                                class="mobile-menu__indicator-icon"></a>
                    </div>


                    <div class="mobile-menu__settings-list">
                        <div class="mobile-menu__setting" data-mobile-menu-item>
                            <button class="mobile-menu__setting-button p-2" title="Language" data-mobile-menu-trigger>
                                <span class="bg-danger mobile-menu__setting-button text-white">Shop By Category <span
                                        class="mobile-menu__setting-arrow"><svg width="6px" height="9px">
                                            <path
                                                d="M0.3,7.4l3-2.9l-3-2.9c-0.4-0.3-0.4-0.9,0-1.3l0,0c0.4-0.3,0.9-0.4,1.3,0L6,4.5L1.6,8.7c-0.4,0.4-0.9,0.4-1.3,0l0,0C-0.1,8.4-0.1,7.8,0.3,7.4z" />
                                        </svg></span></span>

                            </button>
                            <div class="mobile-menu__setting-panel" data-mobile-menu-panel>
                                <div class="mobile-menu__panel mobile-menu__panel--hidden">
                                    <div class="mobile-menu__panel-header">
                                        <button class="mobile-menu__panel-back" type="button">
                                            <svg width="7" height="11">
                                                <path
                                                    d="M6.7,0.3L6.7,0.3c-0.4-0.4-0.9-0.4-1.3,0L0,5.5l5.4,5.2c0.4,0.4,0.9,0.3,1.3,0l0,0c0.4-0.4,0.4-1,0-1.3l-4-3.9l4-3.9C7.1,1.2,7.1,0.6,6.7,0.3z" />
                                            </svg>
                                        </button>
                                        <div class="mobile-menu__panel-title">Categories</div>
                                    </div>
                                    <div class="mobile-menu__panel-body">
                                        <ul class="mobile-menu__links">
                                            @foreach ($menues as $category)
                                                <li data-mobile-menu-item>
                                                    <!-- For categories with subcategories -->
                                                    @if ($category->subcategories && count($category->subcategories))
                                                        <button type="button" class=""
                                                            data-mobile-menu-trigger>
                                                            {{ $category->category_name }}
                                                            <svg width="7" height="11">
                                                                <path
                                                                    d="M0.3,10.7L0.3,10.7c0.4,0.4,0.9,0.4,1.3,0L7,5.5L1.6,0.3C1.2-0.1,0.7,0,0.3,0.3l0,0c-0.4,0.4-0.4,1,0,1.3l4,3.9l-4,3.9C-0.1,9.8-0.1,10.4,0.3,10.7z" />
                                                            </svg>
                                                        </button>

                                                        <!-- Submenu for categories with subcategories -->
                                                        <div class="mobile-menu__links-panel" data-mobile-menu-panel>
                                                            <div class="mobile-menu__panel mobile-menu__panel--hidden">
                                                                <div class="mobile-menu__panel-header">
                                                                    <button class="mobile-menu__panel-back"
                                                                        type="button">
                                                                        <svg width="7" height="11">
                                                                            <path
                                                                                d="M6.7,0.3L6.7,0.3c-0.4-0.4-0.9-0.4-1.3,0L0,5.5l5.4,5.2c0.4,0.4,0.9,0.3,1.3,0l0,0c0.4-0.4,0.4-1,0-1.3l-4-3.9l4-3.9C7.1,1.2,7.1,0.6,6.7,0.3z" />
                                                                        </svg>
                                                                    </button>
                                                                    <div class="mobile-menu__panel-title">
                                                                        {{ $category->category_name }}
                                                                    </div>
                                                                </div>
                                                                <div class="mobile-menu__panel-body">
                                                                    <ul class="mobile-menu__links">
                                                                        @foreach ($category->subcategories as $subcategory)
                                                                            <li data-mobile-menu-item>
                                                                                <a href="{{ route('public.products.index', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}"
                                                                                    class=""
                                                                                    data-mobile-menu-trigger>
                                                                                    {{ $subcategory->subcategory_name }}
                                                                                    @if ($subcategory->divisions && count($subcategory->divisions))
                                                                                        <svg width="7"
                                                                                            height="11">
                                                                                            <path
                                                                                                d="M0.3,10.7L0.3,10.7c0.4,0.4,0.9,0.4,1.3,0L7,5.5L1.6,0.3C1.2-0.1,0.7,0,0.3,0.3l0,0c-0.4,0.4-0.4,1,0,1.3l4,3.9l-4,3.9C-0.1,9.8-0.1,10.4,0.3,10.7z" />
                                                                                        </svg>
                                                                                    @endif
                                                                                </a>
                                                                                @if ($subcategory->divisions && count($subcategory->divisions))
                                                                                    <div class="mobile-menu__links-panel"
                                                                                        data-mobile-menu-panel>
                                                                                        <div
                                                                                            class="mobile-menu__panel mobile-menu__panel--hidden">
                                                                                            <div
                                                                                                class="mobile-menu__panel-header">
                                                                                                <button
                                                                                                    class="mobile-menu__panel-back"
                                                                                                    type="button">
                                                                                                    <svg width="7"
                                                                                                        height="11">
                                                                                                        <path
                                                                                                            d="M6.7,0.3L6.7,0.3c-0.4-0.4-0.9-0.4-1.3,0L0,5.5l5.4,5.2c0.4,0.4,0.9,0.3,1.3,0l0,0c0.4-0.4,0.4-1,0-1.3l-4-3.9l4-3.9C7.1,1.2,7.1,0.6,6.7,0.3z" />
                                                                                                    </svg>
                                                                                                </button>
                                                                                                <div
                                                                                                    class="mobile-menu__panel-title">
                                                                                                    {{ $subcategory->subcategory_name }}
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="mobile-menu__panel-body">
                                                                                                <ul
                                                                                                    class="mobile-menu__links">
                                                                                                    @foreach ($subcategory->divisions as $division)
                                                                                                        <li
                                                                                                            data-mobile-menu-item>
                                                                                                            <a href="#"
                                                                                                                class=""
                                                                                                                data-mobile-menu-trigger>
                                                                                                                {{ $division->division_name }}
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- For categories without subcategories, just display as link -->
                                                        <a href="{{ route('public.products.index', ['category' => $category->slug]) }}"
                                                            class="" data-mobile-menu-trigger>
                                                            {{ $category->category_name }}
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>



                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mobile-menu__divider"></div>

                    <ul class="mobile-menu__links">
                        <li data-mobile-menu-item><a href="{{ route('public.home') }}" class=""
                                data-mobile-menu-trigger>Home </a>

                        </li>
                        <li data-mobile-menu-item><a href="{{ route('public.about') }}" class=""
                                data-mobile-menu-trigger>About Us
                            </a>

                        </li>
                        <li data-mobile-menu-item><a href="{{ route('public.products.index') }}" class=""
                                data-mobile-menu-trigger>Products
                            </a>

                        </li>
                        <li data-mobile-menu-item><a href="{{ route('public.expert-advice') }}" class=""
                                data-mobile-menu-trigger>Expert
                                Advice
                            </a>

                        </li>
                        <li data-mobile-menu-item><a href="{{ route('public.calculator') }}" class=""
                                data-mobile-menu-trigger>Calculator
                            </a>

                        </li>
                        <li data-mobile-menu-item><a href="{{ route('public.contact') }}" class=""
                                data-mobile-menu-trigger>Contact
                                Us
                            </a>

                        </li>

                    </ul>
                    <div class="mobile-menu__spring"></div>
                    <div class="mobile-menu__divider"></div><a class="mobile-menu__contacts" href="#">
                        <div class="mobile-menu__contacts-subtitle">Free call 24/7</div>
                        <div class="mobile-menu__contacts-title">+91 8756453423</div>
                    </a>
                </div>
            </div>
        </div>
    </div><!-- mobile-menu / end --><!-- quickview-modal -->
    <div id="quickview-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
    <!-- quickview-modal / end --><!-- add-vehicle-modal -->


    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div><button class="pswp__button pswp__button--close"
                        title="Close (Esc)"></button><!--<button class="pswp__button pswp__button&#45;&#45;share" title="Share"></button>-->
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div><button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div><!-- photoswipe / end --><!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('') }}public/assets/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('') }}public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}public/assets/vendor/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ asset('') }}public/assets/vendor/nouislider/nouislider.min.js"></script>
    <script src="{{ asset('') }}public/assets/vendor/photoswipe/photoswipe.min.js"></script>
    <script src="{{ asset('') }}public/assets/vendor/photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('') }}public/assets/vendor/select2/js/select2.min.js"></script>
    <script src="{{ asset('') }}public/assets/js/number.js"></script>
    <script src="{{ asset('') }}public/assets/js/main.js"></script>




    <script>
        const xxx = @json($searchData);

        document.getElementById('webSearch').addEventListener('keyup', (e) => {
            if (e.target.value.length < 3) {
                document.getElementById('webSearchBody').innerHTML = `<div class='text-center p-2'>
              <span class='spinner-grow spinner-grow-sm'></span>
              </div>`;
                return false
            };
            const searchData = xxx?.filter((zzz) => zzz.product_name.toLowerCase().includes(e.target.value
                .toLowerCase()));
            let qqq = '';
            if (searchData.length) {
                searchData.forEach(rrr => {
                    qqq += ` <a class="suggestions__item suggestions__product" href="/search?search=${rrr.product_name}">
                       <div class="suggestions__product-image image image--type--product">
                        <div class="image__body"><img class="image__tag" src="/storage/${rrr.product_image}" alt="">
                           </div>
                          </div>
                          <div class="suggestions__product-info">
                         <div class="suggestions__product-name">${rrr.product_name}
                        </div>
                        </div>
                        </a>`;
                });
                document.getElementById('webSearchBody').innerHTML = qqq;
            } else {
                document.getElementById('webSearchBody').innerHTML = `<div class="text-center">
              <span>No Data Found!</span>
              </div>`;
            }
        })
    </script>
    <script>
        const searchButton = document.getElementById('search-button');

        searchButton.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent the default form submission behavior

            const webSearch = document.getElementById('webSearch');
            let searchElement = webSearch.value.trim(); // Trim leading and trailing spaces

            if (searchElement !== '') {
                let url = BASE_URL + "/search?search=" + encodeURIComponent(searchElement);
                window.location.assign(url); // Redirect to the search URL
            } else {
                alert('Please enter a search term.');
            }
        });

        const mobilesearchButton = document.getElementById('mobile-search-button');
        mobilesearchButton.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent the default form submission behavior

            const mobilesearch = document.getElementById('mobilesearch');
            let searchElementmobile = mobilesearch.value.trim(); // Trim leading and trailing spaces

            if (searchElementmobile !== '') {
                let url = BASE_URL + "/search?search=" + encodeURIComponent(searchElementmobile);
                window.location.assign(url); // Redirect to the search URL
            } else {
                alert('Please enter a search term.');
            }
        });
    </script>
    <script></script>
    @yield('scripts')
</body>

</html>
