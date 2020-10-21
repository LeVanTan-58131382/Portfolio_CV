<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Home | Smart Manager</title>
	<link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ asset('css/font-awesome.min.css')}}" rel="stylesheet">
	<link href="{{ asset('css/prettyPhoto.css')}}" rel="stylesheet">
	<link href="{{ asset('css/price-range.css')}}" rel="stylesheet">
	<link href="{{ asset('css/animate.css')}}" rel="stylesheet">
	<link href="{{ asset('css/main.css')}}" rel="stylesheet">
	<link href="{{ asset('css/responsive.css')}}" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="images/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
<script src="{{ url('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
	var baseURL = "{!!url('/')!!}";
</script>
</head><!--/head-->
<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> agriculturalSolutions.com.vn</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.html"><img src="images/home/logo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-user"></i> Account</a></li>
							</ul>
							<!-- Right Side Of Navbar -->
							<ul class="navbar-nav ml-auto">
								<!-- Authentication Links -->
								@guest
								<li class="nav-item">
									<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
								</li>
								@if (Route::has('register'))
								<li class="nav-item">
									<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
								</li>
								<a href="{{ route('login') }}"><i title="Manager" class="fa fa-book" style="font-size:40px;color:green"></i></a>
								@endif
								@else
								<li class="nav-item dropdown">
									<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
										Chào <b style="color: green">{{ Auth::user()->name }}</b> <span class="caret"></span>
									</a>
									<a href="{{ route('adminpage') }}"><i title="Admin" class="fa fa-user-circle-o" style="font-size:35px;color:green"></i></a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>

								</div>
							</li>
							@endguest
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div><!--/header-middle-->

	<div class="header-bottom"><!--header-bottom-->
		<div class="container">
			<div class="row">
				<div class="col-sm-9">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="mainmenu pull-left">
						<ul class="nav navbar-nav collapse navbar-collapse">
							<li><a href="index.html" class="active">Home</a></li>

						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<form action="{{ route('admin.crops.postSearch')}}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token()}}">
						<div class="row">
							<div class="col-md-8">
								<div class="search_box">
									<input style="width: 180px" type="text" name="keyword" placeholder="Nhập vào từ khóa"/>
								</div>
							</div>
							<div class="col-md-4">
								<input style="float: right;"  class="btn btn-secondary pull-right" type="submit" value="Search">
							</div>
						</div>
						<div class="list-inline">
						</div>
					</form>

				</div>
			</div>
		</div>
	</div><!--/header-bottom-->
</header><!--/header-->
<!-- Hiện thông báo khi thao tác thành công -->
<div class="col-lg-12">
	@if(Session::has('flash_message'))
	<div class="alert alert-success">
		{!!Session::get('flash_message')!!}
	</div>
	@endif
</div>
<div>
	@yield('content')
</div>

<footer id="footer"><!--Footer-->
	<div class="footer-top">

	</div>

	<div class="footer-widget">
		<div class="container">
			<div class="row">

			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
				<p class="pull-right">Designed by Me<span><a target="_blank" href="http://www.themeum.com"></a></span></p>
			</div>
		</div>
	</div>
</footer><!--/Footer-->



<script src="{{ asset('js/jquery.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/jquery.scrollUp.min.js')}}"></script>
<script src="{{ asset('js/price-range.js')}}"></script>
<script src="{{ asset('js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
<script src="{{ asset('js/ajax.js')}}"></script>

    <!-- <script src="../../resources/views/js/jquery.js"></script>
	<script src="../../resources/views/js/bootstrap.min.js"></script>
	<script src="../../resources/views/js/jquery.scrollUp.min.js"></script>
	<script src="../../resources/views/js/price-range.js"></script>
    <script src="../../resources/views/js/jquery.prettyPhoto.js"></script>
    <script src="../../resources/views/js/main.js"></script> -->
</body>
</html>