<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>I M S</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/spacelab.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    {{--DataTables--}}
    <link rel="stylesheet" type="text/css" href="{{asset('datatables/datatables.min.css')}}"/>
    <script type="text/javascript" src="{{asset('datatables/datatables.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('fa/css/all.css')}}">

</head>
<body style="padding-bottom: 50px">
<div id="app">
    <div class="container" style="margin-top: 8px">
    <nav class="navbar navbar-default navbar-static-top" style="border-radius: 5px">
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
                <a class="navbar-brand" href="{{ url('/') }}">
                    <p style="color: black"><img src="{{asset("img/logo.png")}}" height="40px" style="margin-top: -10px"></p>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav pull-right" style="margin-right: 20px">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><a href="/home"><strong>Dashboard</strong></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="badge">{{\App\Item::where('deleted',false)->count()}}</span><strong> Items</strong><span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/items/all">View All</a></li>
                                <li><a href="/item/add">Add Item</a></li>
                            </ul>
                        </li>
                        <li><a href="/categories/all"><span class="badge">{{\App\Category::count()}}</span><strong> Categories</strong></a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <strong>History</strong><span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="/ledger?month={{date('m')}}&year={{date('Y')}}">{{date('F')}}</a>
                                </li>
                                <li>
                                    <a href="/ledger">All Records</a>
                                </li>
                                <li>
                                    <a href="/deleted-items">Deleted Items</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="far fa-user-alt"></span> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
    </div>

    @yield('content')
    <div class="container">
        <nav class="nav navbar-fixed-bottom" style="background-color: white; border-top: black">
            <div class="container" align="center" style="margin-bottom: 5px;">
                <p><span class="label label-default">amodsachintha&reg; &copy;{{date('Y')}}</span></p>
            </div>
        </nav>
    </div>

</div>

</body>
</html>
