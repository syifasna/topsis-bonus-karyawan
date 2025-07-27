<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon.png') }}" />
    <title>Delibra</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.1.0') }}" rel="stylesheet" />

    <style>
        .menu-hover {
            transition: all 0.3s ease;
        }

        .menu-hover:hover {
            transform: scale(1.05);
        }
    </style>

</head>

<body class="g-sidenav-show bg-gray-100">


    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="100px"
                    alt="main_logo" />
                <span class="ms-1 font-weight-bold">Sistem Penggajian Karyawan</span>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item dropdown d-flex align-items-center">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                                class="nav-link text-body font-weight-bold px-0">
                                <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                                <ion-icon name="caret-down"></ion-icon>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Selamat Datang, {{ Auth::user()->name }}</h6>
                        </div>
                        <div class="card-body px-0 pt-5 pb-5">
                            <div class="table-responsive p-0">
                                <div class="container d-flex justify-content-center gap-5 py-4">
                                    <a class="menu-hover nav-link text-center" href="{{ route('admin.home') }}"  target="_blank">
                                        <div class="icon icon-shape shadow border-radius-lg d-flex align-items-center justify-content-center mx-auto"
                                            style="font-size: 150px; width: 200px; height: 200px; background-color:#FCC737 ; color:#000">
                                            <ion-icon name="cash-outline"></ion-icon>
                                        </div>
                                        <span class=" nav-link-text mt-2 d-block fw-bold">Perhitungan Gaji</span>
                                    </a>

                                    <a class="menu-hover nav-link text-center" href="{{ route('spk.home') }}"  target="_blank">
                                        <div class="icon icon-shape shadow border-radius-lg d-flex align-items-center justify-content-center mx-auto"
                                            style="font-size: 150px; width: 200px; height: 200px; background-color:#FCC737 ; color:#000">
                                            <ion-icon name="ribbon-outline"></ion-icon>
                                        </div>
                                        <span class="nav-link-text mt-2 d-block fw-bold">Sistem Pendukung Keputusan<br> Penentuan Bonus Karyawan</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer pt-3">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                <a href="#" class="font-weight-bold" target="_blank">Delibra</a>
                                Kreasi Indonesia.
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-muted" target="_blank">Delibra</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-muted" target="_blank">Tentang Kami</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        var win = navigator.platform.indexOf("Win") > -1;
        if (win && document.querySelector("#sidenav-scrollbar")) {
            var options = {
                damping: "0.5",
            };
            Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js') }}"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.1.0') }}"></script>
</body>

</html>
