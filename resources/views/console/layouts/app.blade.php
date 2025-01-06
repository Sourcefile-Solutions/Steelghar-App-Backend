<!DOCTYPE html>
<html lang="en">


<head>
    <meta name="robots" content="noindex, nofollow">
    <title>Steel-Ghar | @yield('title')</title>
    <meta charset="utf-8" />
    <meta name="description" content="Steel Ghar" />
    <meta name="keywords" content="Steel Ghar" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset($settings->fav_icon) }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('') }}console/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('') }}console/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('') }}console/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}console/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <script>
        const BASE_URL = "{{ route('console.home') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>


    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div id="kt_app_header" class="app-header">

                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                            id="kt_app_sidebar_mobile_toggle">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="{{ route('console.home') }}" class="d-lg-none">
                            <img alt="Logo" src="{{ asset("/storage/$settings->logo") }}" class="h-30px" />
                        </a>
                    </div>

                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                            data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                        </div>

                        <div class="app-navbar flex-shrink-0">
                            <div class="app-navbar-item ms-1" id="kt_header_user_menu_toggle">
                                <div class="btn bg-gray-100 me-10 btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-40px h-40px position-relative"
                                    id="crm_notification_drawer_button">
                                    <i class="bi bi-bell-fill fs-2 text-danger"></i>
                                    <span
                                        class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink">
                                    </span>
                                </div>
                                <a href="{{ route('console.category-prices.index') }}"
                                    class="btn btn-linkedin text-end me-3">Category
                                    Price</a>

                                <div class="cursor-pointer symbol symbol-35px symbol-md-40px"
                                    data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <img src="https://ui-avatars.com/api/?background=random&name={{ auth()->user()->name }}"
                                        alt="user" />
                                </div>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-4 w-275px"
                                    data-kt-menu="true">
                                    <div class="menu-item">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <div class="symbol symbol-50px me-1">
                                                <img src="https://ui-avatars.com/api/?background=random&name={{ auth()->user()->name }}"
                                                    alt="user" />
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="fw-bold d-flex align-items-center fs-5">
                                                    {{ auth()->user()->name }}
                                                </div>
                                                <a href="#"
                                                    class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-2"></div>

                                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                        @csrf
                                        <div class="menu-item px-5">
                                            <a href="" class="menu-link px-5" id="logoutBtn">Sign Out</a>
                                        </div>
                                    </form>
                                </div>

                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('console.layouts.menu')
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    @yield('content')
                    <!--begin::Footer-->
                    <div id="kt_app_footer" class="app-footer">
                        <!--begin::Footer container-->
                        <div
                            class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">{{ now()->year }}&copy;</span>
                                <a href="#" target="_blank" class="text-gray-800 text-hover-primary">Steel
                                    Ghar</a>
                            </div>
                            <!--end::Copyright-->
                            <!--begin::Menu-->
                            <!--end::Menu-->
                        </div>
                        <!--end::Footer container-->
                    </div>
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>



    <div id="crm_notification_drawer" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-close="#crm_notification_drawer_close" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'300px', 'md': '500px'}">
        <div class="card rounded-0 w-100">
            <div class="card-header pe-5">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900  me-1 lh-1">Notifications</a>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_example_dismiss_close">
                        <i class="bi bi-x-circle-fill text-dark fs-2"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                </div>
            </div>
            <div class="card-body hover-scroll-overlay-y" id="crm-notification-body">

            </div>

            <div class="card-footer text-center pt-4 pb-4">

                <a href="#" class="btn btn-sm btn-light-dark">View All Notifications</a>


            </div>

        </div>

    </div>
    <!--end::View component-->


    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>





    @yield('modals')



    <script>
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault()
            document.getElementById('logoutForm').submit();
        })
    </script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="{{ asset('') }}console/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('') }}console/assets/js/scripts.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('') }}console/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ asset('') }}console/assets/js/widgets.bundle.js"></script>
    <script src="{{ asset('') }}console/assets/js/custom/widgets.js"></script>
    <script src="{{ asset('') }}console/assets/js/custom/apps/chat/chat.js"></script>
    <script src="{{ asset('') }}console/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="{{ asset('') }}console/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="{{ asset('') }}console/assets/js/custom/utilities/modals/new-target.js"></script>
    <script src="{{ asset('') }}console/assets/js/custom/utilities/modals/users-search.js"></script>
    <script>
        KTDrawer.createInstances();
        const notyDrawerElement = document.querySelector("#crm_notification_drawer");
        const NotyDrawer = KTDrawer.getInstance(notyDrawerElement);
        document.getElementById('crm_notification_drawer_button').addEventListener('click', function() {
            NotyDrawer.show();
            document.getElementById('crm-notification-body').innerHTML =
                '<div class="m-auto"><div class="text-center text-success-emphasis"><span class="spinner-grow"></span></div></div>';
            axios.get('#')
                .then(function(response) {
                    console.log(response)
                    if (response.data.status == 'success') document.getElementById('crm-notification-body')
                        .innerHTML = response.data.notifications;
                })
                .catch(function(error) {
                    console.log(error);
                })
                .then(function() {});
        })
        document.getElementById('kt_drawer_example_dismiss_close').addEventListener('click', function() {
            NotyDrawer.hide();
        })
    </script>
    @yield('scripts')
</body>

</html>
