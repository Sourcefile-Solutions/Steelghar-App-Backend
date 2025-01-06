@extends('public.layouts.app')
@section('content')
    <div class="site__body">
        <div class="about">
            <div class="about__body">
                <div class="about__image">
                    <div class="about__image-bg" style="background-image: url('/public/assets/images/about-banner.jpg')">
                    </div>
                    <div class="decor about__image-decor decor--type--bottom">
                        <div class="decor__body">
                            <div class="decor__start"></div>
                            <div class="decor__end"></div>
                            <div class="decor__center"></div>
                        </div>
                    </div>
                </div>
                <div class="about__card">
                    <div class="about__card-title">About Us</div>
                    <div class="about__card-text">
                        Welcome to SteelGhar, your trusted destination for quality steel products. As Iron & Steel traders
                        in Bangalore, we offer a diverse range to meet your Construction and Fabrication needs.
                    </div>
                </div>
                <div class="about__indicators">
                    <div class="about__card-title">STEEL GHAR - PREMIER IRON & STEEL TRADERS IN BANGALORE</div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--divider-xl"></div>
        <div class="site__body">
            {{-- <div class="block-header block-header--has-breadcrumb block-header--has-title">
                <div class="container">
                    <div class="block-header__body">

                        <h1 class="block-header__title">Latest News</h1>
                    </div>
                </div>
            </div> --}}


            <div class="block blog-view blog-view--layout--list">
                <div class="container">
                    <div class="blog-view__body">

                        <div class="blog-view__item blog-view__item-posts">
                            <div class="block posts-view">
                                <div class="posts-view__list posts-list posts-list--layout--list">
                                    <div class="posts-list__body">
                                        <div class="posts-list__item">
                                            <div class="post-card post-card--layout--list bg-none">
                                                <div class="post-card__image">
                                                    <a href="#"><img
                                                            src="{{ asset('') }}public/assets/images/posts/about.jpg"
                                                            alt="" /></a>
                                                </div>


                                                <div class="post-card__content">
                                                    <div class="post-card__title">
                                                        <h2>
                                                            About Steel Ghar
                                                        </h2>
                                                    </div>

                                                    <div class="post-card__excerpt">
                                                        <div class="typography">
                                                            Welcome to Steelghar, your go-to destination for hassle-free
                                                            steel trading in the vibrant city of Bangalore. Proudly
                                                            operating under the esteemed umbrella of HAQ ENTERPRISES PRIVATE
                                                            LIMITED, Steelghar the Bangalore Iron & Steel distributors are
                                                            not just your typical steel trader – we're a dynamic platform
                                                            offering both online and offline solutions to meet your diverse
                                                            steel needs.
                                                        </div>
                                                    </div>
                                                    <div class="post-card__title">
                                                        <h2>
                                                            Steel Traders In Bangalore, Steelghar
                                                        </h2>
                                                    </div>

                                                    <div class="post-card__excerpt">
                                                        <div class="typography">
                                                            At Steelghar, we understand that convenience comes in different
                                                            forms for different people. That's why we provide you with the
                                                            flexibility of both online and offline trading options. Our
                                                            user-friendly online platform empowers you to explore a vast
                                                            catalog of steel products, featuring various brands,grades. For
                                                            those who prefer a hands-on experience, our physical location is
                                                            ready to offer personalized service and expert guidance.
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>

                                    <div class="posts-list__body mt-3">
                                        <div class="posts-list__item">
                                            <div class="post-card post-card--layout--list bg-none">



                                                <div class="post-card__content">
                                                    <div class="post-card__title">
                                                        <h2>
                                                            About HAQ ENTERPRISES PRIVATE LIMITED
                                                        </h2>
                                                    </div>

                                                    <div class="post-card__excerpt">
                                                        <div class="typography">
                                                            HAQ ENTERPRISES PRIVATE LIMITED stands tall as our parent
                                                            company, bringing with it a rich legacy of commitment and
                                                            expertise. With a strong foundation in the industry, HAQ
                                                            Enterprises ensures that every transaction with Steelghar is
                                                            backed by reliability, transparency and excellence.
                                                        </div>
                                                    </div>
                                                    <div class="post-card__title">
                                                        <h2>
                                                            Connecting the Steel Community:
                                                        </h2>
                                                    </div>

                                                    <div class="post-card__excerpt mb-0">
                                                        <div class="typography">
                                                            Steelghar is not just about transactions; it's about building a
                                                            thriving steel community. Our motto is to give fabricators,
                                                            engineers and our other customers transparency in the products
                                                            category and weighment of the material.Our platform is designed
                                                            to foster transparent and efficient connections, where trust and
                                                            reliability are at the forefront.We want to organize the
                                                            fabricators community by educating them about the product
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="post-card__image">
                                                    <a href="#"><img src="{{ asset('') }}public/assets/images/posts/about.jpg"
                                                            alt="" /></a>
                                                </div> --}}



                                            </div>
                                        </div>
                                    </div>




                                    <div class="posts-list__body mt-3">
                                        <div class="posts-list__item">
                                            <div class="post-card post-card--layout--list bg-none">
                                                {{-- <div class="post-card__image">
                                                    <a href="#"><img src="{{ asset('') }}public/assets/images/posts/about.jpg"
                                                            alt="" /></a>
                                                </div> --}}


                                                <div class="post-card__content">
                                                    <div class="post-card__title">
                                                        <h2>
                                                            Explore a World of Steel Choices:
                                                        </h2>
                                                    </div>

                                                    <div class="post-card__excerpt mb-0">
                                                        <div class="typography">
                                                            Dive into our extensive catalog and discover the diverse world
                                                            of steel possibilities. Whether you're involved in construction
                                                            projects, manufacturing, or any other application, Steelghar
                                                            offers a variety of brands and grades to meet your specific
                                                            requirements. We the steel traders in Bangalore believe in
                                                            providing choices that make us your preferred destination for
                                                            steel solutions in Bangalore.
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="posts-list__body mt-3">
                                        <div class="posts-list__item">
                                            <div class="post-card post-card--layout--list bg-none">



                                                <div class="post-card__content">
                                                    <div class="post-card__title">
                                                        <h2>
                                                            Why Choose Steelghar?
                                                        </h2>
                                                    </div>
                                                    <ol>
                                                        <li class="pt-2">
                                                            <strong>Dual Trading Options:</strong> — Enjoy the convenience
                                                            of both online and offline
                                                            trading methods, giving you the freedom to choose what suits you
                                                            best.
                                                        </li>
                                                        <li class="pt-2">
                                                            <strong>Diverse Steel Selection:</strong> — Explore a wide range
                                                            of steel products, featuring
                                                            multiple brands and grades, ensuring you find the perfect match
                                                            for your needs.
                                                        </li>
                                                        <li class="pt-2">
                                                            <strong>Community-Centric Approach:</strong> — Join a thriving
                                                            steel community where connections
                                                            go beyond transactions, fostering a sense of trust and
                                                            reliability.
                                                        </li>

                                                        <li class="pt-2">
                                                            <strong>Parent Company Assurance:</strong> — With HAQ
                                                            Enterprises as our parent company, every
                                                            transaction is underpinned by a legacy of excellence and trust.
                                                        </li>

                                                        <li class="pt-2">
                                                            <strong>Local Expertise:</strong> — As dedicated steel traders
                                                            in Bangalore, we understand the
                                                            unique needs of the local market, providing personalized service
                                                            and solutions.
                                                        </li>
                                                    </ol>
                                                    <p class="font-weight-bold">Join us, where the world of steel trading
                                                        unfolds both online and offline. Your reliable partner for quality
                                                        steel solutions in Bangalore – STEEL GHAR , a venture by HAQ
                                                        ENTERPRISES PRIVATE LIMITED.</p>

                                                </div>
                                                {{-- <div class="post-card__image">
                                                    <a href="#"><img src="{{ asset('') }}public/assets/images/posts/about.jpg"
                                                            alt="" /></a>
                                                </div> --}}



                                            </div>
                                        </div>
                                    </div>

                                    <div class="posts-list__body mt-3">
                                        <div class="posts-list__item">
                                            <div class="post-card post-card--layout--list bg-none">
                                                {{-- <div class="post-card__image">
                                                    <a href="#"><img src="{{ asset('') }}public/assets/images/posts/about.jpg"
                                                            alt="" /></a>
                                                </div> --}}


                                                <div class="post-card__content">
                                                    <div class="post-card__title">
                                                        <h2>OUR PRODUCTS</h2>
                                                        <h2 class="pt-3">
                                                            Explore our spectacular array of steel offerings in our catalog!
                                                        </h2>
                                                    </div>


                                                    <ol>
                                                        <li class="pt-2">
                                                            <strong>Construction Steel:</strong> — TMT bars, binding
                                                            wire.
                                                        </li>
                                                        <li class="pt-2">
                                                            <strong>Fabrication Steel:</strong> — YCR Pipes, HR Tubes,
                                                            MS Round Pipes , MS Angles, MS Square Pipes, MS channels, CR
                                                            sheets, MS Flats, MS Beams, MS Rods etc.
                                                        </li>
                                                        <li class="pt-2">
                                                            <strong>Special Steel:</strong> — Roofing sheets, Weld mesh,
                                                            Chain Link mesh and other hardware items.
                                                        </li>


                                                    </ol>


                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>

    <div class="site__body pt-5">
        <div class="block block-reviews">
            <div class="container">
                <div class="block-reviews__title">Testimonials</div>
                <div class="block-reviews__subtitle">
                    {{-- During our work we have accumulated<br />hundreds of positive
                    reviews. --}}
                </div>
                <div class="block-reviews__list">
                    <div class="owl-carousel">
                        @foreach ($testimonials as $testimonial)
                            <div class="block-reviews__item">
                                <div class="block-reviews__item-avatar">
                                    <img src="{{ asset('') }}public/assets/images/testimonials/t2.jpg" alt="" />
                                </div>
                                <div class="block-reviews__item-content">
                                    <div class="block-reviews__item-text">
                                        {{ $testimonial->testimonial }}
                                    </div>

                                    <div class="block-reviews__item-meta">

                                        <div class="block-reviews__item-author">
                                            {{ $testimonial->name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
