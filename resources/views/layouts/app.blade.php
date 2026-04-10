<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cawangan Perkhidmatan PPP</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --ppp-blue: #3051a0;
            --ppp-green: #2d5a27;
            --ppp-bg: #f4f7f6;
        }

        html { scroll-behavior: smooth; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--ppp-bg); 
            padding-top: 90px; /* Jarak untuk Fixed Navbar */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #app { flex: 1; }

        /* --- NAVBAR RE-DESIGN --- */
        #top-nav {
            background: #fff; 
            border-bottom: 4px solid var(--ppp-blue); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
            width: 100%; 
            position: fixed; 
            top: 0; 
            z-index: 9999;
        }

        .nav-container { display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; }
        
        .logo-text { font-size: 20px; font-weight: 700; color: var(--ppp-blue); letter-spacing: 1px; }

        .nav-custom { list-style: none; margin: 0; padding: 0; display: flex; align-items: center; }
        
        .nav-custom > li > a { 
            display: block; 
            padding: 12px 15px; 
            text-decoration: none !important; 
            color: #444; 
            font-weight: 600; 
            font-size: 13px; 
            transition: 0.3s; 
            text-transform: uppercase;
        }

        .nav-custom > li > a:hover { color: var(--ppp-blue); transform: translateY(-1px); }

        /* Dropdown Desktop */
        .dropdown-custom { position: relative; }
        .dropdown-custom:hover > .dropdown-content { display: block; opacity: 1; visibility: visible; }
        
        .dropdown-content {
            display: none; position: absolute; background-color: #fff;
            min-width: 260px; box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
            z-index: 9999; list-style: none; padding: 10px 0;
            border-top: 4px solid var(--ppp-blue);
            border-radius: 0 0 8px 8px;
            right: 0; opacity: 0; transition: 0.3s;
        }

        .dropdown-content li a { color: #555; padding: 10px 20px; display: block; text-decoration: none !important; font-size: 13px; font-weight: 500; }
        .dropdown-content li a:hover { background-color: #f1f4f9; color: var(--ppp-blue); padding-left: 25px; }
        
        .dropdown-content .header { 
            padding: 8px 20px; font-weight: 700; color: var(--ppp-blue); 
            font-size: 11px; background: #f8f9fa; border-left: 4px solid var(--ppp-blue); 
            text-transform: uppercase; margin-bottom: 5px;
        }

        /* Flyout Submenu */
        .has-submenu { position: relative; }
        .has-submenu:hover > .submenu-box { display: block; }
        .submenu-box {
            display: none; position: absolute; left: 100%; top: -10px;
            background: #fff; min-width: 230px; box-shadow: 5px 8px 20px rgba(0,0,0,0.12);
            border-left: 4px solid var(--ppp-blue); list-style: none; padding: 10px 0; z-index: 10000;
            border-radius: 0 8px 8px 0;
        }

        .mobile-toggler { display: none; background: none; border: 2px solid var(--ppp-blue); color: var(--ppp-blue); font-size: 20px; padding: 5px 12px; border-radius: 6px; cursor: pointer; outline: none !important; }

        /* --- RESPONSIVE MOBILE --- */
        @media (max-width: 992px) {
            .mobile-toggler { display: block; }
            .nav-custom {
                display: none; flex-direction: column; position: absolute;
                top: 100%; left: 0; width: 100%; background: #fff;
                border-bottom: 4px solid var(--ppp-blue); max-height: 85vh; overflow-y: auto;
                box-shadow: 0 10px 15px rgba(0,0,0,0.1);
            }
            .nav-custom.active { display: flex; }
            .nav-custom > li { width: 100%; border-bottom: 1px solid #f0f0f0; }
            .dropdown-content, .submenu-box { 
                position: static; display: none; width: 100%; box-shadow: none; 
                background: #fafafa; padding-left: 15px; border: none; opacity: 1; visibility: visible;
            }
            .dropdown-custom.active > .dropdown-content, .has-submenu.active > .submenu-box { display: block; }
            .has-submenu > a .fa-caret-right { transform: rotate(90deg); }
        }

        /* Helpers */
        .section-title { font-weight: 700; color: var(--ppp-blue); border-left: 5px solid var(--ppp-blue); padding-left: 15px; text-transform: uppercase; margin-bottom: 20px; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div id="app">
        <header id="top-nav">
            <div class="container nav-container">
                <div class="logo-text">
                    <a href="{{ url('/') }}" style="text-decoration: none; color: inherit;">
                        <i class="fas fa- clinic-medical mr-1"></i> PORTAL PPP
                    </a>
                </div>

                <button class="mobile-toggler" id="mobile-btn">
                    <i class="fas fa-bars"></i>
                </button>

                <nav id="nav-menu">
                    <ul class="nav-custom">
                        <li><a href="{{ url('/') }}"><i class="fas fa-home mr-1"></i> UTAMA</a></li>
                        <li><a href="{{ url('/dashboard') }}">DASHBOARD</a></li>
                        
                        <li class="dropdown-custom">
                            <a href="javascript:void(0)">DIREKTORI <i class="fas fa-caret-down ml-1"></i></a>
                            <ul class="dropdown-content">
                                <li><a href="{{ url('/direktori/carian-ppp') }}">Carian PPP</a></li>
                                <li><a href="{{ route('direktori.carta-organisasi') }}">Carta Organisasi</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-custom">
                            <a href="javascript:void(0)">e-PUSAT <i class="fas fa-caret-down ml-1"></i></a>
                            <ul class="dropdown-content">
                                <li><a href="{{ route('credentialing.index') }}">e-Credentialing</a></li>
                                <li><a href="#" class="text-muted">e-PEPERIKSAAN (Akan Datang)</a></li>
                                
                                <li class="has-submenu border-top mt-2 pt-2">
                                    <a href="javascript:void(0)">e-KOMPETENSI <i class="fas fa-caret-right float-right mt-1"></i></a>
                                    <ul class="submenu-box">
                                        @auth
                                            <li><a href="{{ url('/kompetensi/permohonan') }}" class="text-danger font-weight-bold">Borang Permohonan Baru</a></li>
                                        @endauth
                                        <li><a href="{{ url('/kompetensi/tempat') }}">Semak Tempat</a></li>
                                        <li><a href="{{ url('/kompetensi/semak') }}">Semak Keputusan</a></li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="javascript:void(0)">PRPA <i class="fas fa-caret-right float-right mt-1"></i></a>
                                    <ul class="submenu-box">
                                        <li><a href="{{ url('/prpa/semak-keputusan') }}">Semak Keputusan</a></li>
                                        <li><a href="{{ url('/prpa#dashboard') }}">Dashboard</a></li>
                                    </ul>
                                </li>

                                <li class="header mt-2">Pautan Luar</li>
                                <li><a href="{{ route('rujukan.index') }}">e-RUJUKAN</a></li>
                                <li><a href="https://www.bless.gov.my/" target="_blank">BLESS</a></li>
                                <li><a href="https://www.mycpd2.moh.gov.my/" target="_blank">MyCPD</a></li>
                            </ul>
                        </li>

                        <li><a href="#">AMOTeX</a></li>
                        <li><a href="{{ url('/hubungi') }}">HUBUNGI</a></li>

                        @guest
                            <li class="ml-lg-3 mt-3 mt-lg-0">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm text-white px-4" style="border-radius:20px; font-weight:700;">LOG MASUK</a>
                            </li>
                        @else
                            <li class="dropdown-custom ml-lg-3">
                                <a href="javascript:void(0)" class="btn btn-light btn-sm px-3" style="border-radius:20px; border:1px solid #ddd;">
                                    <i class="fas fa-user-circle mr-1"></i> {{ strtoupper(explode(' ', Auth::user()->name)[0]) }} <i class="fas fa-caret-down ml-1"></i>
                                </a>
                                <ul class="dropdown-content">
                                    @if(in_array(strtoupper(Auth::user()->role), ['ADMIN', 'SUPER ADMIN']))
                                        <li class="header">PENTADBIRAN</li>
                                        <li><a href="{{ url('/admin/dashboard') }}"><i class="fas fa-user-shield mr-2 text-primary"></i> Dashboard Admin</a></li>
                                        @if(strtoupper(Auth::user()->role) == 'SUPER ADMIN')
                                            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-users-cog mr-2 text-danger"></i> Pengurusan Pengguna</a></li>
                                        @endif
                                        <li><a href="{{ route('credentialing.create') }}"><i class="fas fa-file-upload mr-2 text-primary"></i> Pengurusan Dokumen</a></li>
                                        <hr class="my-1">
                                    @endif

                                    <li class="header">AKAUN SAYA</li>
                                    <li><a href="{{ url('/profile') }}"><i class="fas fa-id-card mr-2 text-secondary"></i> Profil Saya</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" class="text-danger font-weight-bold" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-power-off mr-2"></i> KELUAR SISTEM
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </nav>
            </div>
        </header>

        <main class="container">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Mobile Menu Toggler
            $('#mobile-btn').click(function() {
                $('.nav-custom').toggleClass('active');
                $(this).find('i').toggleClass('fa-bars fa-times');
            });

            // Dropdown & Submenu for Mobile
            if ($(window).width() <= 992) {
                $('.dropdown-custom > a, .has-submenu > a').click(function(e) {
                    e.preventDefault();
                    var $parent = $(this).parent();
                    $parent.toggleClass('active');
                    $parent.siblings().removeClass('active').find('.active').removeClass('active');
                });
            }

            // Close mobile menu when clicking outside
            $(document).click(function(event) {
                if (!$(event.target).closest('#top-nav').length) {
                    $('.nav-custom').removeClass('active');
                    $('#mobile-btn').find('i').addClass('fa-bars').removeClass('fa-times');
                }
            });
        });
    </script>
</body>
</html>