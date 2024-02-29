<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <title>TapScan - v4</title>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <!-- Bootstrap Css -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/tap_row.css') }}" >
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7/themes/algolia-min.css" />
        <link rel="icon" href="{{ asset('img/favicon.ico') }}">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script defer data-domain="tapscan.plantcode.cup.uni-freiburg.de" src="http://tapscan.plantcode.cup.uni-freiburg.de:8001/js/plausible.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="col-md-10 offset-md-1">
                <img src="{{ asset('img/TAPscan_logo_v4.png') }}" class="img-fluid" alt="Responsive image">
            </div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="/families">TAPscan</a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ (request()->is('species*')) ? 'active' : '' }}">
                            <a class="nav-link" href="/species">Species</a>
                        </li>
                        @auth
                        <!--
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                           </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                               <a class="dropdown-item {{ (request()->is('upload')) ? 'active' : '' }}" href="/data-upload">Data Upload</a>
                               <hr>
                               <a class="dropdown-item {{ (request()->is('species/table')) ? 'active' : '' }}" href="/species/table">Species</a>
                               <a class="dropdown-item {{ (request()->is('rules')) ? 'active' : '' }}" href="/rules/table">TAP Rules</a>
                               <a class="dropdown-item {{ (request()->is('taps')) ? 'active' : '' }}" href="/taps/table">TAPs</a>
                               <a class="dropdown-item {{ (request()->is('tapinfo/table')) ? 'active' : '' }}" href="/tapinfo/table">Tap Info</a>
                               <a class="dropdown-item {{ (request()->is('domain/table')) ? 'active' : '' }}" href="/domain/table">Domains</a>
                               <a class="dropdown-item {{ (request()->is('news/table')) ? 'active' : '' }}" href="/news/table">News</a>
                               <hr>
                               <a class="dropdown-item" target="_blank"  href="http://tapscan.plantcode.cup.uni-freiburg.de:8001/tapscan.plantcode.cup.uni-freiburg.de">Website Metrics</a>
                            </div>
                        </li>
                        -->
                        @endauth
                        <li class="nav-item {{ (request()->is('news*')) ? 'active' : '' }}">
                            <a class="nav-link" href="/news">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('data*')) ? 'active' : '' }}" href="/data">Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('about*')) ? 'active' : '' }}" href="/about">About</a>
                        </li>

                        <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                            @csrf
                            <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </ul>
                    <div class="dropdown">
                        <button class="btn btn-secondary" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                        Login
                        </button>
                        @guest
                       <div class="dropdown-menu dropdown-menu-right">
                           <form method="POST" action="{{ route('login') }}">
                           @csrf
                           <div class="container">
                               <div class="form-group row">
                                   <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                   <div class="col-md-8">
                                       <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error ('email')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    <div class="col-md-8">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                         @error ('password')
                                         <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                         </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                       <div class="col-md-4"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endguest

                        @auth
                        <div class="dropdown-menu dropdown-menu-right">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Logout') }}
                                        </button>
                                    </div>
                                </div>
                           </form>
                        </div>
                        @endauth
                    </div>
                </nav>
            </div>
            <div class="container">
                @yield('content')
             </div>
             <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center">
                        <a href="https://plantcode.cup.uni-freiburg.de/tapscan/impressum-plain.php">Impressum & Datenschutzerklärung</a>
                        <!--<a href="https://www.plantco.de/Datenschutz.php">Datenschutzerklärung</a>-->
                    </div>
                </div>
                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    All data and services offered on this site are © copyrighted. Distribution via internet or other media is prohibited.<br/>
                    TAPscan logo created by Debbie Maizels
                    <br><br>
                </div>
            </div>
        </div>
    </body>
</html>
