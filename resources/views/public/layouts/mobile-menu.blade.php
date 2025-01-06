<div class="mobile-menu">
    <div class="mobile-menu__backdrop"></div>
    <div class="mobile-menu__body"><button class="mobile-menu__close" type="button"><svg width="12" height="12">
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
                                <path
                                    d="M14,3c2.2,0,4,1.8,4,4c0,4-5.2,10-8,10S2,11,2,7c0-2.2,1.8-4,4-4c1,0,1.9,0.4,2.7,1L10,5.2L11.3,4C12.1,3.4,13,3,14,3 M14,1
                                  c-1.5,0-2.9,0.6-4,1.5C8.9,1.6,7.5,1,6,1C2.7,1,0,3.7,0,7c0,5,6,12,10,12s10-7,10-12C20,3.7,17.3,1,14,1L14,1z" />
                            </svg> <span class="mobile-menu__indicator-counter"
                                id="wishlistMobCound">{{ Auth::guard('customer')->check() && auth()->guard('customer')->user()?->wishlists ? count(json_decode(auth()->guard('customer')->user()->wishlists)) : 0 }}
                            </span></span><span class="mobile-menu__indicator-title">Wishlist</span>
                    </a><a class="mobile-menu__indicator" href="{{ route('public.profile') }}"><span
                            class="mobile-menu__indicator-icon"><svg width="20" height="20">
                                <path
                                    d="M20,20h-2c0-4.4-3.6-8-8-8s-8,3.6-8,8H0c0-4.2,2.6-7.8,6.3-9.3C4.9,9.6,4,7.9,4,6c0-3.3,2.7-6,6-6s6,2.7,6,6
                         c0,1.9-0.9,3.6-2.3,4.7C17.4,12.2,20,15.8,20,20z M14,6c0-2.2-1.8-4-4-4S6,3.8,6,6s1.8,4,4,4S14,8.2,14,6z" />
                            </svg> </span><span class="mobile-menu__indicator-title">Account</span>
                    </a><a class="mobile-menu__indicator" href="{{ route('public.cart.index') }}"><span
                            class="mobile-menu__indicator-icon"><svg width="20" height="20">
                                <circle cx="7" cy="17" r="2" />
                                <circle cx="15" cy="17" r="2" />
                                <path
                                    d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6
                                    V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4
                                  C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z" />
                            </svg> <span class="mobile-menu__indicator-counter cart_count"
                                id="cartMobCount">{{ $cartCount }}</span>
                        </span><span class="mobile-menu__indicator-title">Cart</span> </a><a
                        class="mobile-menu__indicator" href="#"><span class="mobile-menu__indicator-icon"></a>
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
                                                    <button type="button" class="" data-mobile-menu-trigger>
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
                                                                <button class="mobile-menu__panel-back" type="button">
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
                                                                                class="" data-mobile-menu-trigger>
                                                                                {{ $subcategory->subcategory_name }}
                                                                                @if ($subcategory->divisions && count($subcategory->divisions))
                                                                                    <svg width="7" height="11">
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
</div>
