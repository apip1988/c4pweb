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
        :root { --ppp-blue: #3051a0; --ppp-bg: #f4f7f6; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--ppp-bg); padding-top: 90px; }
        #top-nav { background: #fff; border-bottom: 4px solid var(--ppp-blue); box-shadow: 0 4px 12px rgba(0,0,0,0.08); width: 100%; position: fixed; top: 0; z-index: 9999; }
        .nav-container { display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; }
        .logo-text { font-size: 20px; font-weight: 700; color: var(--ppp-blue); }
        .nav-custom { list-style: none; margin: 0; padding: 0; display: flex; align-items: center; }
        .nav-custom > li > a { padding: 12px 15px; text-decoration: none !important; color: #444; font-weight: 600; font-size: 13px; text-transform: uppercase; }
        .dropdown-custom { position: relative; }
        .dropdown-custom:hover > .dropdown-content { display: block; opacity: 1; visibility: visible; }
        .dropdown-content { display: none; position: absolute; background-color: #fff; min-width: 260px; box-shadow: 0px 10px 25px rgba(0,0,0,0.15); border-top: 4px solid var(--ppp-blue); right: 0; }
        .dropdown-content li a { color: #555; padding: 10px 20px; display: block; font-size: 13px; }
        .dropdown-content .header { padding: 8px 20px; font-weight: 700; color: var(--ppp-blue); font-size: 11px; background: #f8f9fa; border-left: 4px solid var(--ppp-blue); }
        .has-submenu:hover > .submenu-box { display: block; }
        .submenu-box { display: none; position: absolute; left: 100%; top: -10px; background: #fff; min-width: 230px; border-left: 4px solid var(--ppp-blue); box-shadow: 5px 8px 20px rgba(0,0,0,0.12); }
    </style>
</head>
<body>
    <div id="app">
        <header id="top-nav">
            <div class="container nav-container">
                <div class="logo-text"><a href="{{ url('/') }}" style="text-decoration:none; color:inherit;">PORTAL PPP</a></div>
                <nav>
                    <ul class="nav-custom">
                        <li><a href="{{ url('/') }}">UTAMA</a></li>
                        <li><a href="{{ url('/dashboard') }}">DASHBOARD</a></li>
                        <li class="dropdown-custom">
                            <a href="#">e-PUSAT <i class="fas fa-caret-down"></i></a>
                            <ul class="dropdown-content">
                                <li class="has-submenu">
                                    <a href="#">e-KOMPETENSI <i class="fas fa-caret-right float-right"></i></a>
                                    <ul class="submenu-box">
                                        @auth <li><a href="{{ url('/kompetensi/permohonan') }}">Borang Permohonan</a></li> @endauth
                                        <li><a href="{{ url('/kompetensi/tempat') }}">Semak Tempat</a></li>
                                        <li><a href="{{ url('/kompetensi/semak') }}">Semak Keputusan</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        @guest
                            <li><a href="{{ route('login') }}" class="btn btn-primary btn-sm text-white px-4">LOG MASUK</a></li>
                        @else
                            <li class="dropdown-custom ml-3">
                                <a href="javascript:void(0)" class="btn btn-light btn-sm px-3" style="border-radius:20px; border:1px solid #ddd;">
                                    {{ strtoupper(explode(' ', Auth::user()->name)[0]) }} <i class="fas fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-content">
                                    @if(Auth::user()->role == 'ADMIN' || Auth::user()->role == 'SUPER ADMIN')
                                        <li class="header">PENTADBIRAN</li>
                                        <li><a href="{{ url('/admin/dashboard') }}">Dashboard Admin</a></li>
                                        <li><a href="{{ url('/admin/kompetensi/pengurusan-calon') }}" class="text-danger font-weight-bold font-italic"><i class="fas fa-users-cog"></i> PENGURUSAN CALON</a></li>
                                    @endif
                                    <li class="header">AKAUN</li>
                                    <li><a href="{{ url('/profile') }}">Profil Saya</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" class="text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">KELUAR</a>
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
</body>
</html>