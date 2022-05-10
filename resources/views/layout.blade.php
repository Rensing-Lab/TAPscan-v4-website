<!DOCTYPE html>
    <html>
        {{-- <link rel="stylesheet" href="css/tapscan.css" type="text/css"> --}}
        {{-- <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" /> --}}
        <head>
            <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
            <title>TapScan - v4</title>
            {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> --}}
              {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
              {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}
              {{-- <script src="{{ asset('js/app.js') }}" defer></script>  --}}
              {{-- remove defer for jquery for jstree --}}
                <script src="{{ mix('js/app.js') }}"></script>
              <!-- Bootstrap Css -->
              <link href="{{ mix('css/app.css') }}" rel="stylesheet">
              {{-- <link rel="stylesheet" href="{{ asset('css/tapscan.css') }}"> --}}
              <link rel="stylesheet" type="text/css" href="{{ asset('css/tap_row.css') }}" >
              <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7/themes/algolia-min.css" />
              <link rel="icon" href="{{ asset('img/favicon.ico') }}">
              <meta name="csrf-token" content="{{ csrf_token() }}">
        </head>

        <div class="container">
          <div class="container-fluid">
            <img src="{{ asset('img/TAPscan_logo.png') }}" class="img-fluid" alt="Responsive image">
          </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="/">TAPscan</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item {{ (request()->is('taps*')) ? 'active' : '' }}">
                <a class="nav-link" href="/taps">TAPs <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item {{ (request()->is('species*')) ? 'active' : '' }}">
                <a class="nav-link" href="/species">Species</a>
              </li>
              @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Admin
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item {{ (request()->is('upload')) ? 'active' : '' }}" href="/taps/table">Data Upload</a>
                  <a class="dropdown-item {{ (request()->is('taps')) ? 'active' : '' }}" href="/taps/table">TAPs</a>
                  <a class="dropdown-item {{ (request()->is('rules')) ? 'active' : '' }}" href="/rules/table">TAP Rules</a>
                  <a class="dropdown-item {{ (request()->is('species/table')) ? 'active' : '' }}" href="/species/table">Species</a>
                  <a class="dropdown-item {{ (request()->is('news/table')) ? 'active' : '' }}" href="/news/table">News</a>
                </div>
              </li>
            @endauth
              {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/tools" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Tools
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">Compare</a>
                  <a class="dropdown-item {{ (request()->is('visualization*')) ? 'active' : '' }}" href="/visualization">Visualization</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Other</a>
                </div>
              </li> --}}
              {{-- <li class="nav-item">
                <a class="nav-link {{ (request()->is('trees*')) ? 'active' : '' }}" href="/visualization">Trees</a>
              </li> --}}
              <li class="nav-item {{ (request()->is('news*')) ? 'active' : '' }}">
                <a class="nav-link" href="/news">News</a>
              </li>
              {{-- <li class="nav-item {{ (request()->is('search*')) ? 'active' : '' }}">
                <a class="nav-link" href="/search">Search</a>
              </li> --}}
              <li class="nav-item">
                <a class="nav-link {{ (request()->is('contact*')) ? 'active' : '' }}" href="/contact">Contact</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (request()->is('about*')) ? 'active' : '' }}" href="/about">About</a>
              </li>
              {{-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="livesearch" name="livesearch" placeholder="Search" aria-label="Search">
                <select class="livesearch form-control" name="livesearch"></select>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form> --}}

              {{-- <select class="livesearch form-control" name="livesearch"></select> --}}

              {{-- Was soll das denn?!? wieso geht das nicht über npm von laravel --}}
              <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                @csrf
                <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>

              {{-- <form action="{{ route('search') }}" method="GET">
                @csrf
                <input type="text" name="query" class="form-control" />
                <input type="submit" class="btn btn-sm btn-primary" value="Search" style="margin-top: 10px;" />
              </form> --}}

            </ul>
        <div class="dropdown">

          <button class="btn btn-secondary" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
            Dropdown
          </button>


        @guest
        <div class="dropdown-menu dropdown-menu-right">
          {{-- <form class="px-4 py-3">
            <div class="form-group">
              <label for="exampleDropdownFormEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
            </div>
            <div class="form-group">
              <label for="exampleDropdownFormPassword1">Password</label>
              <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
            </div>
            <div class="form-group">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck">
                <label class="form-check-label" for="dropdownCheck">
                  Remember me
                </label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
          </form> --}}

          <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                  <div class="col-md-6">
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                  <div class="col-md-6">
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="form-group row">
                  <div class="col-md-6 offset-md-4">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                              {{ __('Remember Me') }}
                          </label>
                      </div>
                  </div>
              </div>

              <div class="form-group row mb-0">
                  <div class="col-md-8 offset-md-4">
                      <button type="submit" class="btn btn-primary">
                          {{ __('Login') }}
                      </button>

                      @if (Route::has('password.request'))
                          <a class="btn btn-link" href="{{ route('password.request') }}">
                              {{ __('Forgot Your Password?') }}
                          </a>
                      @endif
                  </div>
              </div>
          </form>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">New around here? Sign up</a>
          <a class="dropdown-item" href="#">Forgot password?</a>
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

        <body>

          <div class="container">
            @yield('content')
          </div>

        </body>
        </html>
                            {{-- <div>
                                <img alt="TAPscan logo" id="logo" src="img/TAPscan_logo.png">
                            </div>
                            <div id="overlay_logo">
                                <a href="http://www.plantco.de" target="_blank">
                                    <img alt="plantco.de logo" id="plogo" src="img/plantco_logo.png">
                                </a>
                            </div> --}}
