@extends('master')

@section('content')

<div > 
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<h2>Thông tin cần tìm kiếm</h2>
			<div class="list-group">
				<?php 
				if($crops){
					foreach ($crops as $value)
						{?>
							<a title="<?= $value['name'] ?>" href="{!! URL::route('admin.crops.getDetail', $value['id'])!!}" class="list-group-item list-group-item-action flex-column align-items-start">
								<div class="d-flex w-100 justify-content-between">
									<h4 style="color: blue;"><?= $value['name'] ?></h4>
									<small>3 days ago</small>
								</div>
								<img style="width: 200px; height: 100px" src="{!!url('/')!!}/resources/upload/{!!$value['image']!!}" alt="">
								<!-- <small>Donec id elit non mi porta.</small> -->
							</a>
						</br>
					<?php }

				}
				if($lands){
					foreach ($lands as $value)
						{?>
							<a title="<?= $value['name'] ?>" href="{!! URL::route('admin.lands.getDetail', $value['id'])!!}" class="list-group-item list-group-item-action flex-column align-items-start">
								<div class="d-flex w-100 justify-content-between">
									<h4 style="color: blue;"><?= $value['name'] ?></h4>
									<small>3 days ago</small>
								</div>
								<p>Ngày phát triển: <?= $value['dev_days'] ?></p>
							</a>
						</br>
					<?php }
					
				}
				?>

			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
<style type="text/css">
	img {
		border-radius:2%;
		-moz-border-radius:2%;
		-webkit-border-radius:5%;
	}
</style>
@endsection()
