@extends('admin')

@section('content')

<div > 
	<div class="row">
		<form  method="POST" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token()}}">
			<?php foreach ($crop as $value): ?>
				<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-4">
				<input type="hidden" name="img_old" value="<?= $value['image'] ?>">
							<img style="width: 400px; height: 300px" src="{!!url('/')!!}/resources/upload/{!!$value['image']!!}" alt="">
						</br></br>
						<input type="file" name="image">
			</div>
			<div class="col-md-4">
				<h2 style="color: #0B610B; text-align: center;">Cập nhật thông tin về cây trồng</h2>
				<table class="table table-responsive table-inverse">
					<thead>
						<tr>
							<th>Tên cây trồng</th>
							<th>Mật độ cây trồng</th>
							<th>Tổng số giai đoạn phát triển của cây trồng</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input title="<?= $value['name'] ?>" style="width: 150px" type="text" class="form-control" name="name"  value="<?= $value['name'] ?>"></td>
							<td><input title="<?= $value['density'] ?>" type="text" class="form-control" name="density" value="<?= $value['density'] ?>"></td>
							<td><input title="<?= $value['quantity_max_stages_dev'] ?>" type="text" class="form-control" name="quanty_stages_dev" value="<?= $value['quantity_max_stages_dev'] ?>"></td>
						</tr>
					</tbody>
				</table>
			</div>	
			<div class="col-md-2"></div>
		</div> <!-- end row -->
</br></br></br>
		<div class="row">
			<div class="col-md-12">
				<h2 style="color: #0B610B; text-align: center;">Mô tả cây trồng</h2>
			</div>
		</br></br>
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<textarea type="text" class="form-control" id="description" name="description"><?= $value['description'] ?></textarea>
			</div>
			<div class="col-md-2"></div>
		</div> <!-- end row -->
		</br></br></br>
<?php endforeach ?>

<div class="row">
	<h2 style="color: #0B610B; text-align: center;">Các thông số môi trường phù hợp với mỗi giai đoạn</h2>
</br></br></br>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<table class="table table-responsive table-inverse">
			<thead>
				<tr>
					<th>Tên giai đoạn</th>
					<th>Độ sáng thích hợp</th>
					<th>Nhiệt độ thích hợp từ (độ C)</th>
					<th>Nhiệt độ thích hợp đến (độ C)</th>
					<th>Độ ẩm thích hợp từ (%)</th>
					<th>Độ ẩm thích hợp đến (%)</th>
					<th>Độ ph thích hợp từ </th>
					<th>Độ ph thích hợp đến </th>
					<th>Ngày bắt đầu giai đoạn</th>
					<th>Ngày kết thúc giai đoạn</th>
					<th>Loại phân cần bón</th>
					<th>Lượng phân cần bón</th>
				</tr>
			</thead>
			<?php foreach ($stages_dev as $key => $value_2): ?>
				<tbody>
					<tr>
	<td><input title="<?= $value_2['name'] ?>" style="width: 200px" type="text" class="form-control" name="stage[<?= $key ?>][nameStage]" value="<?= $value_2['name'] ?>" ></td>
	<td><input title="<?= $value_2['suitable_light'] ?>" style="width: 70px" type="text" class="form-control" name="stage[<?= $key ?>][suitable_light]" value="<?= $value_2['suitable_light'] ?>" ></td>
	<td><input title="<?= $value_2['suitable_temperature_from'] ?>" type="text" class="form-control" name="stage[<?= $key ?>][suitable_temperature_from]" value="<?= $value_2['suitable_temperature_from'] ?>" ></td>
	<td><input title="<?= $value_2['suitable_temperature_to'] ?>" type="text" class="form-control" name="stage[<?= $key ?>][suitable_temperature_to]" value="<?= $value_2['suitable_temperature_to'] ?>" ></td>
	<td><input title="<?= $value_2['suitable_temperature_from'] ?>" type="text" class="form-control" name="stage[<?= $key ?>][suitable_humidity_from]" value="<?= $value_2['suitable_temperature_from'] ?>" ></td>
	<td><input title="<?= $value_2['suitable_temperature_to'] ?>" type="text" class="form-control" name="stage[<?= $key ?>][suitable_humidity_to]" value="<?= $value_2['suitable_temperature_to'] ?>" ></td>
	<td><input title="<?= $value_2['suitable_ph_from'] ?>" type="text" class="form-control" name="stage[<?= $key ?>][suitable_ph_from]" value="<?= $value_2['suitable_ph_from'] ?>" ></td>
	<td><input title="<?= $value_2['suitable_ph_to'] ?>" type="text" class="form-control" name="stage[<?= $key ?>][suitable_ph_to]" value="<?= $value_2['suitable_ph_to'] ?>" ></td>
	<td><input title="<?= $value_2['start_day'] ?>" type="number" class="form-control" name="stage[<?= $key ?>][starday]" value="<?= $value_2['start_day'] ?>" ></td>
	<td><input title="<?= $value_2['end_day'] ?>" type="number" class="form-control" name="stage[<?= $key ?>][endday]" value="<?= $value_2['end_day'] ?>" ></td>
	<td><input title="<?= $value_2['fertilizer'] ?>" style="width: 200px" type="text" class="form-control" name="stage[<?= $key ?>][fertilizer_needed]" value="<?= $value_2['fertilizer'] ?>" ></td>
	<td><input title="<?= $value_2['fertilizer_mass'] ?>" style="width: 200px" type="text" class="form-control" name="stage[<?= $key ?>][mass_fertilizer_needed]" value="<?= $value_2['fertilizer_mass'] ?>" ></td>
	<input title="<?= $value_2['water_volume'] ?>" type="hidden" class="form-control" name="stage[<?= $key ?>][volume_water_needed]" value="<?= $value_2['water_volume'] ?>" >
	<input title="<?= $value_2['description'] ?>" type="hidden" class="form-control" name="stage[<?= $key ?>][description]" value="<?= $value_2['description'] ?>" >
					</tr>
				</tbody>
			<?php endforeach ?>
		</table>
	</div>
	<div class="col-md-1"></div>
</div>
</div> <!-- end row -->
<div class="row">
	<div class="col-md-5"></div>
	<div class="col-md-5">
		<fieldset>
			<a href="<?php echo url("/") ?>/admin/crops/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
			<br><br>
		</fieldset>
		<fieldset>
			<input type="submit" style="width: 200px" class="btn btn-primary" value="Lưu">
			<br><br>
		</fieldset>
	</div>
	<div class="col-md-2"></div>
</div>
</form>
<script> CKEDITOR.replace( 'description',
{
	filebrowserBrowseUrl: baseURL + '/public/ckeditor/ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl: baseURL + '/public/ckeditor/ckfinder/ckfinder.html?type=Images',
}); </script>
<style type="text/css">
	img {
		border-radius:2%;
		-moz-border-radius:2%;
		-webkit-border-radius:5%;
	}
</style>
@endsection()
