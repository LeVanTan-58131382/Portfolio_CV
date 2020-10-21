@extends('admin')

@section('content')
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="table-responsive cart_info">
			<table class="table table-hover table-responsive table-striped table-bordered">
				<thead>
					<tr class="cart_menu">
						<td class="description"><h3 style="color: #FF8000" >Id phân bón</h3></td>
						<td class="description"><h3 style="color: #FF8000">Tên phân bón</h3></td>
						<td class="description"><h3 style="color: #FF8000">Tên loại phân bón</h3></td>
						<td class="description"><h3 style="color: #FF8000">Khối lượng phân bón (kg)</h3></td>
						<td style="border-right: none;"></td>
						<td style="border-right: none; border-left: none;"></td>
						<td style="border-left: none;"></td>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($fer as $value): ?>
						<tr>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['id'] ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['name'] ?></h4></label>
							</td>
							<td >
								<?php
								foreach ($type_fer as $val) {
									if($val['id'] == $value["type_fertilizer_id"])
										echo '<label><h4 style="color: #088A08">'.$val["name"].'</h4></label>';
								}
								?>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['mass'] ?></h4></label>
							</td>
							<td style="border-right: none;">
								<a style="display: inline;" href="{!! URL::route('admin.fertilizers.getDetail', $value['id'])!!}"><i class="far fa-file-alt"></i></a>
							</td>
							<td style="border-right: none; border-left: none;">
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
												<a href="{!! URL::route('admin.fertilizers.getDelete', $value['id'])!!}"><button type="button" class="btn btn-secondary">Đồng ý</button></a>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td style="border-left: none;">
								<a style="display: inline;" href="{!! URL::route('admin.fertilizers.getEdit', $value['id'])!!}"><i class="fa fa-edit"></i></a>
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
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-4" >
		{{ $fer->links() }}
	</div>

	@endsection