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
		<input type="button" id="btn3" class="btn btn-info" value="Thông tin về phân bón"/>
		<div id="phanbon" style="display: none">
			<table class="table table-responsive table-inverse">
				<thead>
					<tr>
						<th>Loại phân bón</th>
						<th>Lượng phân bón cần thiết (kg)</th>
						<th>Lượng phân bón còn trong kho (kg)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($fers as $value): ?>
						<tr>
							<td><?= $value['name'] ?></td>
							<td><?=(int)($square * $value['mass_suiable_30_m']/30).' kg'; ?></td>
							<td><?= $value['mass'] ?> kg</td>
						</tr>
					<?php endforeach ?>
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
					<h2>Chi Tiết Bón Phân</h2>
				</div>
				<div class="col-md-1"></div>
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
								<th>Tên loại phân cần bón</th>
								<td><select class="custom-select" name="sltType">
									<option value="-1" selected>Chọn một loại phân cần bón</option>
									<?php foreach ($fers as $val): ?>
										<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
									<?php endforeach ?>
								</select></td>
							</tr>
							<tr>
								<th>Lượng Phân cần bón (kg)</th>
								<td><input type="number" min="1" name="mass" class="form-control" ></td>
							</tr>
							<tr>
								<th>Bỏ qua cảnh báo lượng phân</th>
								<td><input style="width: 20px" type="checkbox" name="checkbox" class="form-control" ></td>
							</tr>
						</table>
					<?php endforeach ?>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<fieldset>
								<input type="submit" style="width: 200px" class="btn btn-primary" value="Bón phân" >
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
