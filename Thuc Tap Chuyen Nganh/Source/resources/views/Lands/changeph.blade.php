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
	<div class="row">
		<?php foreach ($land as $value): ?>
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
		<input type="button" id="btn3" class="btn btn-info" value="Thông tin về các loại phụ gia"/>
		<div id="phanbon" style="display: none">
			<table class="table table-responsive table-inverse">
				<thead>
					<tr>
						<th>Tên phụ gia</th>
						<th>Lượng phụ gia cần dùng để giảm (tăng) 1 đơn vị ph cho 30 mét vuông (kg)</th>
						<th>Lượng phụ gia cần dùng cho diện tích hiện tại (kg)</th>
						<th>Lượng phụ gia còn trong kho (kg)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($fer_increase_ph as $value): ?>
						<tr>
							<td><?= $value['name'] ?></td>
							<td><?= $value['mass_increase_1_pH_above_30_m'] ?></td>
							<td><?= (int)($square*$value['mass_increase_1_pH_above_30_m']/30)*$deviation_ph ?></td>
							<td><?= $value['mass'] ?></td>
						</tr>
					<?php endforeach ?>
					<?php foreach ($fer_decrease_ph as $value): ?>
						<tr>
							<td><?= $value['name'] ?></td>
							<td><?= $value['mass_reduces_1_pH_above_30_m'] ?></td>
							<td><?= (int)($square*$value['mass_reduces_1_pH_above_30_m']/30)*$deviation_ph ?></td>
							<td><?= $value['mass'] ?></td>
						</tr>
					<?php endforeach ?>
					<tr>
						<p>Với cây trồng hiện tại, lượng phụ gia dưới đây là phù hợp với diện tích thửa ruộng của bạn.</p>
					</tr>
				</tbody>
			</table>
			<input class="btn btn-warning" type="button" id="btn4" value="Ẩn"/>
		</div>
	</div>
	<div class="col-md-4">
		<div class="bonphan">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-9">
					<h2>Điều chỉnh độ PH của đất</h2>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row">
				<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token()}}">
					<?php
					if($suitable_ph_from > $ph){
						{?>
							<input type="hidden" name="ph" value="1">
							<table class="table table-responsive table-inverse">
						<tr>
							<th><div class="thongbaodo">Độ PH của đất đang thấp hơn mức thích hợp của cây trồng !!!</div></th>
						</tr>
						<tr>
							<th>Tên loại phụ gia cần bón</th>
							<td><select class="custom-select" name="sltTypeIncreasePH">
									<option value="-1" selected>Chọn một loại phụ gia cần bón</option>
									<?php foreach ($fer_increase_ph as $val): ?>
										<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
									<?php endforeach ?>
								</select>
							</td>
						</tr>
						<tr>
							<th style="color: green">Gợi ý lượng phụ gia cần bón</th>
							<td><?php foreach ($fer_increase_ph as $value): ?>
									<label for="">Loại phụ gia: <?= $value['name'] ?> </br> Lượng phụ gia cần: <?= (int)($value['mass_increase_1_pH_above_30_m']*$square/30)*$deviation_ph ?> kg</label></br>
								<?php endforeach ?></td>
						</tr>
						<tr>
							<th>Lượng phụ gia cần bón</th>
							<td>
								<input type="number" min="1" name="mass_increase_ph" class="form-control" >
							</td>
						</tr>
							<tr>
								<th>Bỏ qua cảnh báo lượng phụ gia</th>
								<td><input style="width: 20px" type="checkbox" name="checkbox" class="form-control" ></td>
							</tr>

						</table>
						<?php }
					}
					if($suitable_ph_to < $ph){
						{?>
							<input type="hidden" name="ph" value="0">
							<table class="table table-responsive table-inverse">
						<tr>
							<th><div class="thongbaodo">Độ PH của đất đang cao hơn mức thích hợp của cây trồng !!!</div></th>
						</tr>
						<tr>
							<th>Tên loại phụ gia cần bón</th>
							<td><select class="custom-select" name="sltTypeDecreasePH">
									<option value="-1" selected>Chọn một loại phụ gia cần bón</option>
									<?php foreach ($fer_decrease_ph as $val): ?>
										<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
									<?php endforeach ?>
								</select>
							</td>
						</tr>
						<tr>
							<th style="color: green">Gợi ý lượng phụ gia cần bón</th>
							<td><?php foreach ($fer_decrease_ph as $value): ?>
									<label for="">Loại phụ gia: <?= $value['name'] ?> </br> Lượng phụ gia cần: <?= $value['mass_reduces_1_pH_above_30_m']*$square/30 ?> kg</label></br>
								<?php endforeach ?></td>
						</tr>
						<tr>
							<th>Lượng phụ gia cần bón</th>
							<td>
								<input type="number" min="1" name="mass_decrease_ph" class="form-control" >
							</td>
						</tr>
							<tr>
								<th>Bỏ qua cảnh báo lượng phụ gia</th>
								<td><input style="width: 20px" type="checkbox" name="checkbox" class="form-control" ></td>
							</tr>

						</table>
						<?php }
					}
					if($suitable_ph_to >= $ph && $suitable_ph_from <= $ph){
						{?>
							<div class="thongbaoxanh">Độ PH của đất đang ở mức thích hợp của cây trồng !!!</div></br>
						<?php }
					}

					?>
					</div>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
								<input type="submit" style="width: 200px" class="btn btn-primary" value="Bón phân"
								<?php
				if($suitable_ph_to < $ph) // bón phân giảm độ ph
				{
					foreach ($land as $value) {
						foreach ($fer_decrease_ph_Detail_need as $valu) {
							foreach ($fers as $val) {
								if($val['id'] == $valu['fertilizer_id'] ){
									if(($value['dev_days'] - $valu['day_fer']) <= $val['effective_time']){
										$time_day = ($value['dev_days'] - $valu['day_fer']);
										echo "onclick='return confirm(".'"Bạn đã sử dụng '.$val['name'].' có tính năng giảm độ ph của đất cách đây '.$time_day.' ngày.'.'Bạn vẫn muốn sử dụng phụ gia giảm độ ph ?");'."'";
										break;
									}
									break;
								}
							}

						}
					}
					//echo "onclick='return confirm(".'"Bạn muốn quay về hã?");'."'";
				}
				if($suitable_ph_from > $ph) // bón phân tăng độ ph
				{
					foreach ($land as $value) {
						foreach ($fer_increase_ph_Detail_need as $valu) {
							foreach ($fers as $val) {
								if($val['id'] == $valu['fertilizer_id'] ){
									if(($value['dev_days'] - $valu['day_fer']) <= $val['effective_time']){
										$time_day = ($value['dev_days'] - $valu['day_fer']);
										echo "onclick='return confirm(".'"Bạn đã sử dụng '.$val['name'].' có tính năng tăng độ ph của đất cách đây '.$time_day.' ngày.'.'Bạn vẫn muốn sử dụng phụ gia tăng độ ph ?");'."'";
										break;
									}
									break;
								}
							}

						}
					}
				}
				?>
				>
				<br><br>

		</div>
		<div class="col-md-2"></div>
	</div>
</form>
</div>
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<a href="<?php echo url("/") ?>/admin/lands/list"><input type="button" style="width: 200px" class="btn btn-primary"  value="Quay Về"></a>
			<br><br>

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

