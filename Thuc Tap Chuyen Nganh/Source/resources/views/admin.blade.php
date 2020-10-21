<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<title>Admin | Smart Manager</title>
	<link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ asset('css/font-awesome.min.css')}}" rel="stylesheet">
	<link href="{{ asset('css/prettyPhoto.css')}}" rel="stylesheet">
	<link href="{{ asset('css/price-range.css')}}" rel="stylesheet">
	<link href="{{ asset('css/animate.css')}}" rel="stylesheet">
	<link href="{{ asset('css/main.css')}}" rel="stylesheet">
	<link href="{{ asset('css/responsive.css')}}" rel="stylesheet">
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	<link rel="shortcut icon" href="images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
	<script src="{{ url('public/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ url('public/ckeditor/ckeditor.js') }}"></script>
	<script type="text/javascript">
		var baseURL = "{!!url('/')!!}";
	</script>
</head><!--/head-->

<body>
	<style type="text/css">
		img {
			border-radius:2%;
			-moz-border-radius:2%;
			-webkit-border-radius:5%;
		}
	</style>
	<header id="header"><!--header-->
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
							<li><a href="<?php echo url("/") ?>/homeindex" class="active">Trang chủ</a></li>
							<li><a href="<?php echo url("/") ?>/adminpage" class="active">Trang Admin</a></li>
							<li class="dropdown"><a href="">Cây trồng<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<li><a href="<?php echo url("/") ?>/admin/crops/list">Danh sách cây trồng</a></li>
									<li><a href="<?php echo url("/") ?>/admin/crops/add">Thêm cây trồng</a></li>
								</ul>
							</li>
							<li class="dropdown"><a href="#">Thửa ruộng<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<li><a href="<?php echo url("/") ?>/admin/lands/list">Danh sách tất cả lands</a></li>
									<!-- <?php foreach ($farms as $value): ?>
										<li><a href="{!! URL::route('admin.lands.getlistByFarm', $value['id'])!!}">Danh sách land của <?= $value['name'] ?></a></li>
									<?php endforeach ?> -->
									<li><a href="<?php echo url("/") ?>/admin/lands/add">Thêm thửa ruộng</a></li>
								</ul>
							</li>
							<li class="dropdown"><a href="#">Phân bón<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<li><a href="<?php echo url("/") ?>/admin/fertilizers/list">Danh sách tất cả phân bón</a></li>
									<!-- <?php foreach ($farms as $value): ?>
										<li><a href="{!! URL::route('admin.fertilizers.getlistByFarm', $value['id'])!!}">Danh sách phân bón của <?= $value['name'] ?></a></li>
									<?php endforeach ?> -->
									<li><a href="<?php echo url("/") ?>/admin/fertilizers/add">Thêm phân bón</a></li>
								</ul>
							</li>
							<li class="dropdown"><a href="#">Bồn nước<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<li><a href="<?php echo url("/") ?>/admin/sourceofwater/list">Danh sách tất cả bồn nước</a></li>
									<!-- <?php foreach ($farms as $value): ?>
										<li><a href="{!! URL::route('admin.sourceofwater.getlistByFarm', $value['id'])!!}">Danh sách bồn nước của <?= $value['name'] ?></a></li>
									<?php endforeach ?> -->
									<li><a href="<?php echo url("/") ?>/admin/sourceofwater/add">Thêm bồn nước</a></li>
								</ul>
							</li>
							<li class="dropdown"><a href="#">Thu hoạch<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<li><a href="<?php echo url("/") ?>/admin/lands/listHarvest">Danh sách các land đã thu hoạch</a></li>
								</ul>
							</li>
							<li class="dropdown"><a href="#">Trang trại<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<?php foreach ($farms as $value): ?>
										<li><a href="{!! URL::route('admin.farm.getDetail', $value['id'])!!}">Thông tin về trang trại (<?= $value['name'] ?>)</a></li>
										<li><a href="{!! URL::route('admin.farm.getEdit', $value['id'])!!}">Cập nhật trang trại (<?= $value['name'] ?>)</a></li>
									<?php endforeach ?>
								</ul>
							</li>
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
<!-- Modal -->
<script src="{{ asset('js/jquery.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/jquery.scrollUp.min.js')}}"></script>
<script src="{{ asset('js/price-range.js')}}"></script>
<script src="{{ asset('js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
<script src="{{ asset('js/ajax.js')}}"></script>
</body>
</html>