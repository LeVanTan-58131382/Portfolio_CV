@extends('admin')

@section('content') 
<div class="row">	
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div id="list" class="table-responsive cart_info">
			<table class="table table-hover table-responsive table-striped">
				<thead>
					<tr class="cart_menu">
						<td class="description"><h3 style="color: #FF8000" >Id Cây trồng</h3></td>
						<td class="description"><h3 style="color: #FF8000">Tên cây trồng</h3></td>
						<!-- <td class="description"><h3 style="color: #FF8000">Mật độ cây trồng</h3></td> -->
						<td class="description"><h3 style="color: #FF8000">Ảnh</h3></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($data as $value): ?>
						<tr>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['id'] ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['name'] ?></h4></label>
							</td>
							<!-- <td >
								<label for=""><h4 style="color: #088A08"><?= $value['density'] ?> cây trên một mét vuông</h4></label>
							</td> -->
							<td >
								<img style="width: 150px; height: 150px" src="{!!url('/')!!}/resources/upload/{!!$value['image']!!}" alt="">
							</td>
							<td>
								<a href="{!! URL::route('admin.crops.getDetail', $value['id'])!!}"><i class="fa fa-search"></i></a>
							</td>
							<td>
								<a href="" style="cursor:pointer"><i class="fas fa-trash-alt" data-toggle="modal" data-target="#exampleModal<?= $value['id'] ?>"></i></a>
								<div class="modal fade" id="exampleModal<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Xác nhận</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Bạn có muốn xóa <?= $value['name'] ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
												<a href="{!! URL::route('admin.crops.getDelete', $value['id'])!!}"><button type="button" class="btn btn-secondary">Đồng ý</button></a>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td>
								<a href="{!! URL::route('admin.crops.getEdit', $value['id'])!!}"><i class="fa fa-edit"></i></a>
							</td>
						</tr>
					<?php endforeach ?>


				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-2"></div>
</div>

<style type="text/css">
	img {
		border-radius:2%;
		-moz-border-radius:2%;
		-webkit-border-radius:5%;
	}
	#list{
		margin: 3px;
		padding: 5px;
		color: #006899;
		border: solid 1px #006899;
		background: white;
		border-radius: 5px
	}
</style>
@endsection