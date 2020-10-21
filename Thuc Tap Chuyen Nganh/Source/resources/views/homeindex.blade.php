@extends('master')

@section('content')
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>E</span>Manager Crops</h1>
                                <h2>WIDOSOFT</h2>
                                <p>Quản Lý Vườn Rau Thông Minh.</p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <!-- <img style="width: 400px; height: 400px" src="{!!url('/')!!}/resources/upload/2.png" class="girl img-responsive" alt="" /> -->
                                <img style="width: 500px; height: 400px" src="{!!url('/')!!}/resources/images/nhodo.jpg"  class="pricing" alt="" />
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>Manager Crops</h1>
                                <h2>WIDOSOFT</h2>
                                <p>Quản Lý Vườn Rau Thông Minh.</p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <!-- <img style="width: 300px; height: 300px" src="{!!url('/')!!}/resources/upload/3.png" class="girl img-responsive" alt="" /> -->
                                <img style="width: 500px; height: 400px" src="{!!url('/')!!}/resources/images/nhoden.jpg"  class="pricing" alt="" />
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>Manager Crops</h1>
                                <h2>WIDOSOFT</h2>
                                <p>Quản Lý Vườn Rau Thông Minh.</p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img style="width: 500px; height: 400px" src="{!!url('/')!!}/resources/images/nhoxanh.jpg" class="pricing" alt="" />
                            </div>
                        </div>
                    </div>
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section><!--/slider-->
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
            </div>
        </div>
    </div>
</div><!--/header-bottom-->
</header><!--/header-->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                  <div class="brands_products"><!--brands_products-->
                    <h2>Các land hiện canh tác</h2>
                    <div class="brands-name">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="<?php echo url("/") ?>/admin/lands/list">Danh sách tất cả lands</a></li>
                            <?php foreach ($lands as $value): ?>
                                <li><a href="{!! URL::route('admin.lands.getDetail', $value['id'])!!}"><span class="pull-left"><?= $value['name'] ?></span></a></li></br>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <h2>Các loại cây trồng</h2>
                    <div class="brands-name">
                        <ul class="nav nav-pills nav-stacked">
                            <?php foreach ($crops as $value): ?>
                                <li><a href="#"><span class="pull-left"><?= $value['name'] ?></span></a></li></br>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div><!--/brands_products-->
            </div>
        </div>
        <div class="col-sm-9 padding-right">
            <div class="features_items"><!--features_items-->
                <h3 style="color: orange" class="title text-center">Thông tin về các loại cây trồng</h3>
            </br>
            <?php foreach ($crops as $value): ?>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{!!url('/')!!}/resources/upload/{!!$value['image']!!}" alt="" />
                                <h2><?= $value['name'] ?></h2>
                                <p><?= $value['id'] ?></p>
                                <a href="{!! URL::route('admin.crops.getDetail', $value['id'])!!}" class="btn btn-default add-to-cart"><i class="fa fa-search"></i>Xem chi tiết</a>
                            </div>
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h2><?= $value['name'] ?></h2>
                                    <a href="{!! URL::route('admin.crops.getDetail', $value['id'])!!}" class="btn btn-default add-to-cart"><i class="fa fa-search"></i>Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="#"><i class="fa fa-plus-square"></i>Like</a></li>
                                <li><a href="#"><i class="fa fa-plus-square"></i>...</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div><!--features_items-->
    </div>
</div>
</div>
</section>
@endsection
