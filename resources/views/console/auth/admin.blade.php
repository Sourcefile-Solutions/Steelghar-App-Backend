<!DOCTYPE html>

<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="/console/assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="/console/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/console/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>


<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
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
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                background-image: url('console/assets/media/auth/bg9.jpg');
            }

            [data-bs-theme="dark"] body {
                background-image: url('console/assets/media/auth/bg9-dark.jpg');
            }
        </style>

        <div class="d-flex flex-column flex-center flex-column-fluid bg-black">
            <div class="d-flex flex-column flex-center text-center p-10">
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <div class="d-flex flex-center flex-column-fluid pb-15 pb-lg-20">
                            <form class="form w-100 " action="{{ route('console.admin') }}" method="POST">
                                @csrf
                                <div class="text-center mb-11">
                                    <h1 class="text-dark fw-bolder mb-3">Setup Admin</h1>
                                </div>


                                <div class=" mb-8 fv-plugins-icon-container">
                                    <input type="text" placeholder="Enter Full Name" name="name"
                                        autocomplete="off" class="form-control bg-transparent">
                                </div>

                                <div class=" mb-8 fv-plugins-icon-container">
                                    <input type="text" placeholder="Enter Email Address" name="email"
                                        autocomplete="off" class="form-control bg-transparent">
                                </div>

                                <div class=" mb-8 fv-plugins-icon-container">
                                    <input type="text" placeholder="Enter Password" name="password"
                                        autocomplete="off" class="form-control bg-transparent">
                                </div>

                                <div class=" mb-8 fv-plugins-icon-container">
                                    <input type="text" placeholder="Re Enter Password" name="password_confirmation"
                                        autocomplete="off" class="form-control bg-transparent">
                                </div>



                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                        <span class="indicator-label">Craete</span>
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script></script>

    <script src="/console/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/console/assets/js/scripts.bundle.js"></script>
    <script src="/console/assets/js/custom/authentication/sign-up/coming-soon.js"></script>

</body>
