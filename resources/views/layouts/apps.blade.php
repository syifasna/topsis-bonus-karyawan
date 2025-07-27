<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon.png') }}" />
    <title>SPK by Delibra</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.1.0') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html "
                target="_blank">
                <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo" />
                <span class="ms-1 font-weight-bold">SPK</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0" />

        {{-- navbar tidak collapse --}}
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'spk.home' ? 'active' : '' }}" href="{{ route('spk.home') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <ion-icon name="home"></ion-icon>
                        </div>
                        <span class="nav-link-text ms-1">Beranda</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'alternatif.index' ? 'active' : '' }}" href="{{ route('alternatif.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <ion-icon name="briefcase"></ion-icon>
                        </div>
                        <span class="nav-link-text ms-1">Alternatif</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'kriteria.index' ? 'active' : '' }}" href="{{ route('kriteria.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <ion-icon name="pencil-outline"></ion-icon>
                        </div>
                        <span class="nav-link-text ms-1">Bobot Kritria</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <ion-icon name="wallet"></ion-icon>
                        </div>
                        <span class="nav-link-text ms-1">Perhitungan Bonus</span>
                    </a>
                    <ul class="dropdown-menu bg-gray-100" aria-labelledby="navbarDropdown" style="margin-top: 0;">
                        <li class="dropdown-item" style="padding: 0px 15px;">
                            <a class="nav-link {{ Route::currentRouteName() == 'perhitungan.index' ? 'active' : '' }}" href="{{ route('perhitungan.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow text-center d-flex align-items-center justify-content-center">
                                    <ion-icon name="keypad-outline"></ion-icon>
                                </div>
                                <span class="nav-link-text ms-1">Input Alternatif</span>
                            </a>
                        </li>
                        <li class="dropdown-item" style="padding: 0px 15px;">
                            <a class="nav-link {{ Route::currentRouteName() == 'perhitungan.hasil' ? 'active' : '' }}" href="{{ route('perhitungan.hasil') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow text-center d-flex align-items-center justify-content-center">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <span class="nav-link-text ms-1">Hasil Perhitungan</span>
                            </a>
                        </li>
                        <li class="dropdown-item" style="padding: 0px 15px;">
                            <a class="nav-link {{ Route::currentRouteName() == 'perhitungan.keputusan' ? 'active' : '' }}" href="{{ route('perhitungan.keputusan') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow text-center d-flex align-items-center justify-content-center">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <span class="nav-link-text ms-1">Keputusan</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        {{-- navbar tidak collapse --}}
    </aside>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-dark" href="javascript:;">Hal</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                            @if(Route::currentRouteName() == 'alternatif.index')
                                Alternatif
                            @elseif(Route::currentRouteName() == 'kriteria.index')
                                Bobot Kriteria
                            @elseif(Route::currentRouteName() == 'perhitungan.index')
                                Input Alternatif
                            @elseif(Route::currentRouteName() == 'perhitungan.hasil')
                                Hasil Perhitungan
                            @elseif(Route::currentRouteName() == 'perhitungan.keputusan')
                                Hasil Keputusan
                            @else
                                Beranda
                            @endif
                        </li>
                    </ol>
                </nav>                
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search"
                                    aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here..." />
                        </div>
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
                                <a class="dropdown-item" href="{{ route('gate') }}">
                                    Gate
                                </a>
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
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                @yield('content')
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
