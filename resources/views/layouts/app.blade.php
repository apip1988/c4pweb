<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cawangan Perkhidmatan PPP</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; padding-top: 70px; }
        [id^="section-"] { scroll-margin-top: 100px; }
        
        #top-nav {
            background: #fff; 
            border-bottom: 3px solid #3051a0; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            width: 100%; 
            position: fixed; 
            top: 0; 
            z-index: 9999;
        }

        .nav-container {
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 10px 15px;
        }

        .nav-custom { 
            list-style: none; 
            margin: 0; 
            padding: 0; 
            display: flex; 
            align-items: center; 
        }

        .nav-custom > li > a { 
            display: block; 
            padding: 15px 12px; 
            text-decoration: none; 
            color: #444; 
            font-weight: bold; 
            font-size: 13px; 
            transition: 0.3s; 
        }

        .nav-custom > li > a:hover { color: #3051a0; }

        /* Dropdown Desktop */
        .dropdown-custom { position: relative; }
        .dropdown-custom:hover > .dropdown-content { display: block; }
        .dropdown-content {
            display: none; position: absolute; background-color: #fff;
            min-width: 250px; box-shadow: 0px 8px 16px rgba(0,0,0,0.15);
            z-index: 9999; list-style: none; padding: 10px 0;
            border-top: 3px solid #3051a0;
        }
        .dropdown-content li a { color: #555; padding: 10px 20px; display: block; text-decoration: none; font-size: 13px; font-weight: 500; }
        .dropdown-content li a:hover { background-color: #f8f9fa; color: #3051a0; }
        .dropdown-content .header { padding: 8px 20px; font-weight: bold; color: #3051a0; font-size: 12px; background: #f1f4f9; border-left: 4px solid #3051a0; }

        /* --- SUBMENU FLYOUT BOX --- */
        .has-submenu { position: relative; }
        .has-submenu:hover > .submenu-box { display: block; }
        .submenu-box {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            background: #fff;
            min-width: 220px;
            box-shadow: 5px 8px 16px rgba(0,0,0,0.1);
            border-left: 3px solid #3051a0;
            list-style: none;
            padding: 5px 0;
            z-index: 10000;
        }

        /* Warna Biru Khas untuk Menu e-Pusat */
        .menu-biru { color: #3051a0 !important; font-weight: bold !important; }

        .mobile-toggler {
            display: none;
            background: none;
            border: 2px solid #3051a0;
            color: #3051a0;
            font-size: 20px;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            body { padding-top: 60px; }
            .mobile-toggler { display: block; }

            .nav-custom {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #fff;
                border-bottom: 3px solid #3051a0;
                max-height: 80vh;
                overflow-y: auto;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }

            .nav-custom.active { display: flex; }

            .nav-custom > li { width: 100%; border-bottom: 1px solid #eee; }
            .nav-custom > li > a { padding: 15px 20px; width: 100%; }

            .dropdown-content, .submenu-box {
                position: static;
                display: none;
                width: 100%;
                box-shadow: none;
                border-top: none;
                background: #fdfdfd;
                padding-left: 20px;
            }
            .dropdown-custom.active > .dropdown-content,
            .has-submenu.active > .submenu-box { display: block; }
        }
    </style>
</head>
<body>
    <div id="app">
        <header id="top-nav">
            <div class="container nav-container">
                
                <div style="font-size: 20px; font-weight: bold; color: #3051a0;">
                    <a href="{{ url('/') }}" style="text-decoration: none; color: inherit;">PORTAL PPP</a>
                </div>

                <button class="mobile-toggler" id="mobile-btn">
                    <i class="fas fa-bars"></i>
                </button>

                <nav id="nav-menu">
                    <ul class="nav-custom">
                        @guest
                            <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> LOG MASUK</a></li>
                        @else
                            <li class="dropdown-custom">
                                <a href="javascript:void(0)" class="drop-trigger">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} <i class="fas fa-caret-down ml-1"></i>
                                </a>
                                <ul class="dropdown-content">
                                    @if(Auth::user()->role == 'ADMIN')
                                        <li class="header">PENTADBIRAN</li>
                                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fas fa-user-shield"></i> Dashboard Admin</a></li>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <li class="header">AKAUN</li>
                                    <li><a href="{{ url('/profile') }}"><i class="fas fa-id-card"></i> Profil Saya</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" style="color:red; font-weight:bold;" onclick="event.preventDefault(); document.getElementById('logout-form-fixed').submit();">
                                            <i class="fas fa-power-off"></i> LOGOUT
                                        </a>
                                        <form id="logout-form-fixed" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest

                        <li class="dropdown-custom">
                            <a href="javascript:void(0)" class="drop-trigger">UTAMA <i class="fas fa-caret-down ml-1"></i></a>
                            <ul class="dropdown-content">
                                <li><a href="{{ url('/#section-visi') }}">Visi, Misi, Objektif & Motto</a></li>
                                <li><a href="{{ url('/#section-organisasi') }}">Carta Organisasi</a></li>
                                <li><a href="{{ url('/#section-fungsi') }}">Carta Fungsi Utama</a></li>
                                <li><a href="{{ url('/#section-rakan') }}">Rakan Kolaborasi</a></li>
                                <li><a href="{{ url('/#section-kerjaya') }}">Laluan Kerjaya</a></li>
                            </ul>
                        </li>
                        
                        <li><a href="{{ url('/dashboard') }}">DASHBOARD</a></li>

                        <li class="dropdown-custom">
                            <a href="javascript:void(0)" class="drop-trigger">DIREKTORI <i class="fas fa-caret-down ml-1"></i></a>
                            <ul class="dropdown-content">
                                <li><a href="{{ url('/direktori/carian-ppp') }}">Carian PPP</a></li>
                                <li><a href="{{ route('direktori.carta-organisasi') }}">Carta Organisasi</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-custom">
                            <a href="javascript:void(0)" class="drop-trigger">e-PUSAT <i class="fas fa-caret-down ml-1"></i></a>
                            <ul class="dropdown-content">
                                <li><a href="#" class="menu-biru">e-CREDENTIAL</a></li>
                                <li><a href="#" class="menu-biru">e-PEPERIKSAAN</a></li>
                                
                                <li class="has-submenu">
                                    <a href="javascript:void(0)" class="sub-trigger menu-biru">e-KOMPETENSI <i class="fas fa-caret-right float-right mt-1"></i></a>
                                    <ul class="submenu-box">
                                        <li><a href="{{ url('/kompetensi/permohonan') }}" style="color: #dc3545; font-weight: bold;">Borang Permohonan Baru</a></li>
                                        <li><a href="{{ url('/kompetensi/tempat') }}">Semak Tempat</a></li>
                                        <li><a href="{{ url('/kompetensi/semak') }}">Semak Keputusan</a></li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="javascript:void(0)" class="sub-trigger menu-biru">e-KPI <i class="fas fa-caret-right float-right mt-1"></i></a>
                                    <ul class="submenu-box">
                                        <li><a href="#">Laporan</a></li>
                                        <li><a href="#">Pengisian</a></li>
                                    </ul>
                                </li>

                                <li><a href="{{ url('/ebook') }}" class="menu-biru">e-RUJUKAN</a></li>
                                
                                <li><a href="https://www.bless.gov.my/bless/action/login?show" target="_blank" class="menu-biru">BLESS</a></li>
                                <li><a href="https://www.mycpd2.moh.gov.my/" target="_blank" class="menu-biru">MyCPD</a></li>
                                <li><a href="https://p3s.moh.gov.my/login" target="_blank" class="menu-biru">P3S</a></li>
                                
                                <li class="has-submenu">
                                    <a href="javascript:void(0)" class="sub-trigger menu-biru">PRPA <i class="fas fa-caret-right float-right mt-1"></i></a>
                                    <ul class="submenu-box">
                                        <li><a href="https://phcmalaysia.com/phcals/" target="_blank">Dashboard</a></li>
                                        <li><a href="#">Kursus</a></li>
                                        <li><a href="#">Aktiviti</a></li>
                                        <li><a href="#">Rujukan</a></li>
                                        <li><a href="#">Hubungi</a></li>
                                    </ul>
                                </li>

                                <li><a href="https://sites.google.com/moh.gov.my/jkteknikaltriageemts/halaman-utama" target="_blank" class="menu-biru">TRIAGE</a></li>
                            </ul>
                        </li>

                        <li><a href="#">AMOTeX</a></li>
                        <li><a href="#">JURNAL</a></li>
                        <li><a href="{{ url('/hubungi') }}">HUBUNGI</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle Menu Utama di Mobile
            $('#mobile-btn').click(function() {
                $('.nav-custom').toggleClass('active');
                $(this).find('i').toggleClass('fa-bars fa-times');
            });

            // Toggle Dropdown di Mobile
            $('.drop-trigger').click(function(e) {
                if ($(window).width() <= 992) {
                    e.preventDefault();
                    $(this).parent('.dropdown-custom').toggleClass('active');
                }
            });

            // Toggle Sub-box di Mobile
            $('.sub-trigger').click(function(e) {
                if ($(window).width() <= 992) {
                    e.preventDefault();
                    $(this).parent('.has-submenu').toggleClass('active');
                }
            });

            // Tutup menu bila klik link
            $('.nav-custom a').not('.drop-trigger, .sub-trigger').click(function() {
                if ($(window).width() <= 992) {
                    $('.nav-custom').removeClass('active');
                    $('#mobile-btn').find('i').addClass('fa-bars').removeClass('fa-times');
                }
            });
        });
    </script>
</body>
</html>