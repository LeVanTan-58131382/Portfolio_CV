@extends('admin')

@section('content')
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="table-responsive cart_info">
			<table class="table table-hover table-responsive table-striped">
				<thead>
					<tr class="cart_menu">
						<td class="description"><h4 style="color: #FF8000" >Id Thửa ruộng</h4></td>
						<td class="description"><h4 style="color: #FF8000">Tên thửa ruộng</h4></td>
						<td class="description"><h4 style="color: #FF8000">Số lần tưới nước</h4></td>
						<td class="description"><h4 style="color: #FF8000">Tổng lượng nước đã tưới</h4></td>
						<td class="description"><h4 style="color: #FF8000">Số lần bón phân</h4></td>
						<td class="description"><h4 style="color: #FF8000">Tổng lượng phân đã bón</h4></td>
						<td class="description"><h4 style="color: #FF8000">Ngày thu hoạch</h4></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($harvest as $value): ?>
						<tr>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['id_land'] ?></h4></label>
							</td>
							<td >
								<?php
								foreach ($lands as $val) {
									if($val['id'] == $value["id_land"])
										echo '<label><h4 style="color: #088A08">'.$val["name"].'</h4></label>';
								}
								?>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= '' ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['total_water'] ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= '' ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['total_fer'] ?></h4></label>
							</td>
							<td >
								<label for=""><h4 style="color: #088A08"><?= $value['day_harvest'] ?></h4></label>
							</td>
							<td>
								<a href=""><i class="fa fa-search"></i></a>
							</td>
							<td >
								<a href=""><i class="fas fa-trash-alt"></i></a>
							</td>
							<td>
								<a href=""><i class="fa fa-edit"></i></a>
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
</style>
@endsection