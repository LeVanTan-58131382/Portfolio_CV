@extends('admin')

@section('content')
@if(count($errors)>0)
<div class="alert alert-danger">
	<ul>
		@foreach($errors->all() as $error)
		<li>{!! $error!!}</li>
		@endforeach
	</ul>
</div>
@endif
<div >
	<?php foreach ($land as $value): ?>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			<input type="button" id="btn2" class="btn btn-info" value="Thông tin về giai đoạn phát triển"/>
			<div id="giaidoan" style="display: none">
				<h2>Thông tin về giai đoạn phát triển</h2>
				<?php foreach ($stages as $val){
						if($value['virtual_dev_days'] != 0) {
							if(($val['crop_id'] == $value["crop_id"]) && ($val['start_day'] <= $value["virtual_dev_days"]) && ($val['end_day'] >= $value["virtual_dev_days"])){
								{?>
									<label for="">Cây trồng đang trong giai đoạn phát triển thứ: <?= $val['numerical_order'] ?></label></br>
									<label for="">Tên giai đoạn: <?= $val['name']?></label></br>
									<label for="">Loại phân thích hợp: <?= $val['fertilizer']?></label></br>
									<!-- <label for="">Lượng phân thích hợp cho toàn bộ giai đoạn: <?= $val['fertilizer_mass']?></label></br> -->
									<label for="">Độ sáng thích hợp: <?= $val['suitable_light']?></label></br>
									<label for="">Nhiệt độ thích hợp từ <?= $val['suitable_temperature_from']?> đến <?= $val['suitable_temperature_to'] ?></label></br>
									<label for="">Độ ph thích hợp từ <?= $val['suitable_ph_from']?> đến <?= $val['suitable_ph_to'] ?></label></br>
									<label for="">Độ ẩm thích hợp từ <?= $val['suitable_humidity_from']?> đến <?= $val['suitable_humidity_to'] ?></label></br>
									<input class="btn btn-warning" type="button" id="btn1" value="Ẩn"/>
								</br>
							<?php }
						}
					}
				}
					if($value['virtual_dev_days'] == 0) {
						foreach ($stage as $val){
							{?>
								<label for="">Cây trồng đang trong giai đoạn phát triển thứ: <?= $val['numerical_order'] ?></label></br>
								<label for="">Tên giai đoạn: <?= $val['name']?></label></br>
								<label for="">Loại phân thích hợp: <?= $val['fertilizer']?></label></br>
								<!-- <label for="">Lượng phân thích hợp cho toàn bộ giai đoạn: <?= $val['fertilizer_mass']?></label></br> -->
								<label for="">Độ sáng thích hợp: <?= $val['suitable_light']?></label></br>
								<label for="">Nhiệt độ thích hợp từ <?= $val['suitable_temperature_from']?> đến <?= $val['suitable_temperature_to'] ?></label></br>
								<label for="">Độ ph thích hợp từ <?= $val['suitable_ph_from']?> đến <?= $val['suitable_ph_to'] ?></label></br>
								<label for="">Độ ẩm thích hợp từ <?= $val['suitable_humidity_from']?> đến <?= $val['suitable_humidity_to'] ?></label></br>
								<input class="btn btn-warning" type="button" id="btn1" value="Ẩn"/>
							</br>
						<?php }
					}
				}
				?>
			<?php endforeach ?>
		</div>
		<input type="button" id="btn3" class="btn btn-info" value="Thông tin về nguồn nước"/>
		<div id="phanbon" style="display: none">
			<table class="table table-responsive table-inverse">
				<thead>
					<tr>
						<th>Tên bồn nước</th>
						<th>Lượng nước cần tưới (mét khối)</th>
						<th>Lượng nước còn trong bồn (mét khối)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($water_tank as $value): ?>
						<tr>
							<td><?= $value['name'] ?></td>
							<td><?= (int)($square/30) ?></td>
							<td><?= $value['volume'] ?></td>
						</tr>
					<?php endforeach ?>
					<tr>
						<p>Với cây trồng hiện tại, lượng nước cần cho mỗi lần tưới là 1 mét khối/ 30 mét vuông</p>
					</tr>
				</tbody>
			</table>
			<input class="btn btn-warning" type="button" id="btn4" value="Ẩn"/>
		</div>
	</div>
	<div class="col-md-4">
		<div class="bonphan">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-8">
					<h2>Chi Tiết Tưới Nước</h2>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row">
				<?php
				foreach ($weather as $value) {

					if(($value['temperature_from'] + $value['temperature_to'])/2 > $suitable_temperature_to){
						{?>
							<label class="thongbaodo" style="color: red" for="">Nhiệt độ môi trường đang cao hơn mức thích hợp của cây trồng (Phương thức tưới thích hợp : "Tưới phun sương") !!!</label>
						<?php }
					}

					if(($value['humidity_from'] + $value['humidity_to'])/2 < $suitable_humidity_from){
						{?>
							<label class="thongbaodo" style="color: red" for="">Độ ẩm của đất đang thấp hơn mức thích hợp của cây trồng (Phương thức tưới thích hợp: "Tưới nhỏ giọt hoặc tưới theo kênh") !!!</label>
						<?php }
					}
					if(($value['humidity_from'] + $value['humidity_to'])/2 >= $suitable_humidity_from && ($value['humidity_from'] + $value['humidity_to'])/2 <= $suitable_humidity_to){
						{?>
							<label class="thongbaoxanh" style="color: green" for="">Độ ẩm của đất đang ở mức thích hợp của cây trồng (Bạn không cần phải tưới nước cho cây) !!!</label>
						<?php }
					}
					if(($value['humidity_from'] + $value['humidity_to'])/2 > $suitable_humidity_to){
						{?>
							<label class="thongbaoxanh" style="color: green" for="">Độ ẩm của đất đang cao hơn mức thích hợp của cây trồng (Bạn không cần phải tưới nước cho cây) !!!</label>
						<?php }
					}
				}
				?>
			</div>
			<form method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<?php foreach ($land as $value): ?>
					<table class="table table-responsive table-inverse">
						<tr>
							<th>Tên Land</th>
							<td><?= $value['name'] ?></td>
						</tr>
						<tr>
							<th>Tên loại cây trồng</th>
							<td><?php
							foreach ($crops as $val) {
								if($val['id'] == $value["crop_id"])
									{?>
										<p><?= $val['name'] ?></p>
									<?php }
								}
								?></td>
							</tr>
							<tr>
								<th>Giai đoạn sinh trưởng của cây</th>
								<td>
									<?php foreach ($stage as $val): ?>
										<p><?= $val['name']?></p>
									<?php endforeach ?>
								</td>
							</tr>
							<tr>
								<th>Chọn bồn nước bạn muốn sử dụng</th>
								<td><select class="custom-select" name="sltType">
									<option value="-1" selected>Chộn một bồn nước</option>
									<?php foreach ($water_tank as $val): ?>
										<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
									<?php endforeach ?>
								</select></td>
							</tr>
							<tr>
								<th>Lượng nước cần tưới (mét khối)</th>
								<td><input type="number" min="1" class="form-control" name="water_volume" ></td>
							</tr>
							<tr>
								<th>Chọn cách thức bạn muốn tưới</th>
								<td><select class="custom-select" name="sltTypeMethod">
									<option value="-1" selected>Chọn cách thức bạn muốn tưới</option>
									<?php foreach ($method as $val): ?>
										<option value="<?= $val['id'] ?>"><?= $val['method'] ?></option>
									<?php endforeach ?>
								</select></td>
							</tr>
							<tr>
								<th>Bỏ qua cảnh báo lượng nước</th>
								<td><input style="width: 20px" type="checkbox" name="checkbox" class="form-control" ></td>
							</tr>

						</table>
					<?php endforeach ?>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<fieldset>
								<input type="submit" style="width: 200px" class="btn btn-primary" value="Tưới nước"
								<?php
								foreach ($land as $value) {
									foreach ($watering_detail_need as $valu) {
										if($value['dev_days'] == $valu['day_water'])
										{
											echo "onclick='return confirm(".'"Bạn đã tưới '.$valu['water_volume'].' khối nước cho lần tưới trước trong ngày hôm nay.'.'Bạn vẫn muốn tiếp tục tưới nước cho land này?");'."'";
											break;
										}
									}
								}
								?>
								>

								<br><br>
							</fieldset>
						</div>
						<div class="col-md-2"></div>
					</div>

				</form>
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<fieldset>
							<a href="<?php echo url("/") ?>/admin/lands/list"><input type="button" style="width: 200px" class="btn btn-primary"  value="Quay Về"></a>
							<br><br>
						</fieldset>
					</div>
					<div class="col-md-2"></div>


				</div>
			</div>


			<div class="col-md-2"></div>
		</div>
	</div><!--/Repaly Box-->
	<style type="text/css">
		#phanbon{
			margin: 3px;
			padding: 5px;
			color: #006899;
			border: solid 1px #006899;
			background: white;
			border-radius: 5px
		}
		#giaidoan{
			margin: 3px;
			padding: 5px;
			color: #006899;
			border: solid 1px #006899;
			background: white;
			border-radius: 5px
		}
		.thongbaoxanh{
			margin: 3px;
			padding: 5px;
			color: green;
			border: solid 1px green;
			background: white;
			border-radius: 5px
		}
		.thongbaodo{
			margin: 3px;
			padding: 5px;
			color: red;
			border: solid 1px red;
			background: white;
			border-radius: 5px
		}
	</style>
	<script language="javascript">

		document.getElementById("btn1").onclick = function () {
			document.getElementById("giaidoan").style.display = 'none';
		};

		document.getElementById("btn2").onclick = function () {
			document.getElementById("giaidoan").style.display = 'block';
		};
		document.getElementById("btn4").onclick = function () {
			document.getElementById("phanbon").style.display = 'none';
		};

		document.getElementById("btn3").onclick = function () {
			document.getElementById("phanbon").style.display = 'block';
		};

	</script>
	@endsection()