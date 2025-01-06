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
                <a class="mobile-header__logo" href={{ route('public.home') }}>
                    <img src="{{ asset('') }}public/assets/images/logo.jpg" class="w-50" />
                </a>
                <div class="mobile-header__search mobile-search">
                    <form class="mobile-search__body m-0">
                        <input type="text" class="mobile-search__input" placeholder="Search Product"
                            id="mobilesearch" />

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

                </div>
            </div>
        </div>
    </div>
</header>
<header class="site__header">
    <div class="header">

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
                    <button class="departments__button" type="button"><span class="departments__button-icon"><svg
                                width="16px" height="12px">
                                <path d="M0,7L0,5L16,5L16,7L0,7ZM0,0L16,0L16,2L0,2L0,0ZM12,12L0,12L0,10L12,10L12,12Z" />
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
                        <li class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                            <a href="{{ route('public.home') }}" class="main-menu__link">Home </a>

                        </li>
                        <li class="main-menu__item main-menu__item--submenu--megamenu main-menu__item--has-submenu">
                            <a href="{{ route('public.about') }}" class="main-menu__link">About Us</a>

                        </li>
                        <li class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                            <a href="{{ route('public.products.index') }}" class="main-menu__link">Products</a>

                        </li>
                        <li class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                            <a href="{{ route('public.expert-advice') }}" class="main-menu__link">Expert
                                Advice</a>

                        </li>
                        <li class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
                            <a href="{{ route('public.calculator') }}" class="main-menu__link">Calculator</a>

                        </li>
                        <li class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
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
                    <button class="search__button search__button--end" type="submit" id="search-button"><span
                            class="search__button-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20">
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
                                                    class="input-radio__body"><input class="input-radio__input"
                                                        name="header-vehicle" type="radio"> <span
                                                        class="input-radio__circle"></span> </span></span><span
                                                class="vehicles-list__item-info"><span
                                                    class="vehicles-list__item-name">2011 Ford Focus S</span>
                                                <span class="vehicles-list__item-details">Engine 2.0L 1742DA L4
                                                    FI Turbo</span> </span><button type="button"
                                                class="vehicles-list__item-remove"><svg width="16"
                                                    height="16">
                                                    <path
                                                        d="M2,4V2h3V1h6v1h3v2H2z M13,13c0,1.1-0.9,2-2,2H5c-1.1,0-2-0.9-2-2V5h10V13z" />
                                                </svg></button></label> <label class="vehicles-list__item"><span
                                                class="vehicles-list__item-radio input-radio"><span
                                                    class="input-radio__body"><input class="input-radio__input"
                                                        name="header-vehicle" type="radio"> <span
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
                                    <div class="vehicle-form__item"><input type="text" class="form-control"
                                            placeholder="Enter VIN number" aria-label="VIN number"></div>
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
                            id="wishlistWebCound">{{ Auth::guard('customer')->check() && auth()->guard('customer')->user()?->wishlists ? count(json_decode(auth()->guard('customer')->user()->wishlists)) : 0 }}

                        </span></span></a>
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
                        <span class="indicator__counter cart_count" id="cartWebCount">{{ $cartCount }}</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>
