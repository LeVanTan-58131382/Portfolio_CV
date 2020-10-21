@extends('admin')

@section('content')
<div class="row">	
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="table-responsive cart_info">
			<table class="table table-hover table-responsive table-striped table-bordered">
				<thead>
					<tr class="cart_menu">
						<td class="description"><h3 style="color: #FF8000" >Id mùa vụ</h3></td>
						<td class="description"><h3 style="color: #FF8000">Tên mùa vụ</h3></td>
						<td class="description"><h3 style="color: #FF8000">Tên loại cây trồng</h3></td>
						<td class="description"><h3 style="color: #FF8000">Tháng bắt đầu gieo trồng</h3></td>
						<td class="description"><h3 style="color: #FF8000">Tháng kết thúc gieo trồng</h3></td>
						<td style="border-right: none;"></td>
						<td style="border-right: none; border-left: none;"></td>
						<td style="border-left: none;"></td>
					</tr>
				</thead>
				<tbody> 

					<?php foreach ($seasons as $value): ?>
						<tr>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['id'] ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['name'] ?></h4></label>
							</td>
							<td >
								<?php 
								foreach ($crop as $val) {
									if($val['id'] == $value["crop_id"]) 
										echo '<label><h4 style="color: #088A08">'.$val["name"].'</h4></label>';
								}
								?>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['start_month_planting'] ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['end_month_planting'] ?></h4></label>
							</td>
							<td style="border-right: none;">
								<a style="display: inline;" href="{!! URL::route('admin.seasons.getDetail', $value['id'])!!}"><i class="far fa-file-alt"></i></a>
							</td>
							<td style="border-right: none; border-left: none;">
								<a style="display: inline;" href="{!! URL::route('admin.seasons.getDelete', $value['id'])!!}"><i class="fas fa-trash-alt"></i></a>
							</td>
							<td style="border-left: none;">
								<a style="display: inline;" href="{!! URL::route('admin.seasons.getEdit', $value['id'])!!}"><i class="fa fa-edit"></i></a>
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
		{{ $seasons->links() }}
	</div>

	@endsection