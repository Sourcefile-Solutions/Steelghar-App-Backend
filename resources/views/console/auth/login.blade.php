<!DOCTYPE html>

<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>Steel Ghar</title>
    <meta charset="utf-8" />
    <meta name="description" content="Steel Ghar" />
    <meta name="keywords" content="Steel Ghar" />
    <link rel="shortcut icon" href="{{ asset('') }}console/assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> <!--end::Fonts-->
    <link href="{{ asset('') }}console/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}console/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank">
    <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-2">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">

                        <form class="form w-100" novalidate="novalidate" action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">
                                    Sign In
                                </h1>
                            </div>
                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Email" name="email" autocomplete="off"
                                    class="form-control bg-transparent" value="{{ old('email') }}" />
                                @error('email')
                                    <div class="alert text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fv-row mb-3">
                                <input type="password" placeholder="Password" name="password" autocomplete="off"
                                    class="form-control bg-transparent" />
                                @error('password')
                                    <div class="alert text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid mb-10">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        Sign In</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-1"
                style="background-image: url({{ asset('') }}console/assets/media/misc/auth-bg.png)">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="#" class="mb-0 mb-lg-12">
                        <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Steel Ghar</h1>
                    </a>
                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                        src="{{ asset("public/storage/$settings->logo") }}" alt="" />

                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                        Admin Login
                    </h1>

                    <div class="d-none d-lg-block text-white fs-base text-center">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint molestiae maxime quaerat earum
                        harum, voluptatum minima! Quam corrupti accusantium officiis quia necessitatibus, id culpa
                        voluptatum expedita beatae sequi reprehenderit provident?
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('') }}console/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('') }}console/assets/js/scripts.bundle.js"></script>

    <script src="{{ asset('') }}console/assets/js/custom/authentication/sign-in/general.js"></script>


</body>

</html>
