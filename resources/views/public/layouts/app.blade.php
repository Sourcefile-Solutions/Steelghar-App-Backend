<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Steel Ghar | {{ $settings->site_name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('') }}public/assets/images/logo.jpg">
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
    <div class="site">

        @include('public.layouts.header')

        @yield('content')
    </div>


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

                                    <li class="footer-links__item"><a href="#" class="footer-links__link">FAQs</a>
                                    </li>
                                    <li class="footer-links__item"><a href="{{ route('public.terms-and-conditions') }}"
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

    </div>


    @include('public.layouts.mobile-menu')





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
