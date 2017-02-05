<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    @yield('styles')
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>



                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <form class="navbar-form navbar-right" action="" method="POST">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" id="search-input" placeholder="Search..." class="form-control" onkeydown="down()" onkeyup="up()" autocomplete="off">
                                </div>
                                <div class="searchPanelBody table-bordered" style="display: none; background: #FFF; padding: 10px; position: absolute; width: 90%; z-index: 999;">
                                    <div id="search-result"></div>
                                </div>
                            </form>
                        </li>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            @if (Auth::user()->hasRole('buyer'))
                                <li><a href="{{ url('/buyer/home') }}">Home</a></li>
                            @elseif(Auth::user()->hasRole('seller'))
                                <li><a href="{{ url('/seller/home') }}">Home</a></li>
                            @else
                                <a href="{{ url('/admin/home') }}">Home</a>
                            @endif

                            @if (Auth::user()->hasRole('buyer'))
                                    <li><a href="">Credit balance: 100</a></li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (Auth::user()->hasRole('buyer'))
                                        <li><a href="{{ url('/buyer/profile') }}">Profile</a></li>
                                    @elseif(Auth::user()->hasRole('seller'))
                                        <li><a href="{{ url('/seller/profile') }}">Profile</a></li>
                                    @endif

                                        @if (Auth::user()->hasRole('seller'))
                                            <li><a href="{{ url('/seller/product/') }}">Products</a></li>
                                        @endif

                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var timer;
        function up(){
            timer = setTimeout(function(){
                var keywords = $("#search-input").val();

                if(keywords.length >0){
                    $.post("/livesearch", {keywords: keywords}, function(markup){
                        $(".searchPanelBody").show();
                        $('#search-input').removeClass('loading-icn');
                        $("#search-result").fadeIn("fast");
                        $("#search-result").html(markup);
                    });
                }
                if(keywords.length == 0){
                    $(".searchPanelBody").hide();
                    $('#search-input').removeClass('loading-icn');
                    $("#search-result").fadeOut("fast");
                }
            }, 500);
        }

        function down(){
            $('#search-input').addClass('loading-icn');
            clearTimeout(timer);
        }
    </script>
    @yield('scripts')
</body>
</html>
