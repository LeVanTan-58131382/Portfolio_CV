@extends('admin')

@section('content')

<div> 
	<?php foreach ($crop as $value): ?>
	<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-4">
				<img style="width: 400px; height: 300px" src="{!!url('/')!!}/resources/upload/{!!$value['image']!!}" alt="">
			</div>
			<div class="col-md-4">
				<h2 style="color: #0B610B; text-align: center;">Thông tin cây trồng</h2>
				<table class="table table-responsive table-inverse">
					<thead>
						<tr>
							<th>Tên cây trồng</th>
							<th>Mật độ cây trồng</th>
							<th>Độ PH thích hợp</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $value['name'] ?></td>
							<td><?= $value['density'] ?></td>
							<td>Từ <?= $value['ph_from'] ?> đến <?= $value['ph_to'] ?></td>
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
				<?= $value['description'] ?>
			</div>
			<div class="col-md-2"></div>
		</div> <!-- end row -->
		</br></br></br>
		<div class="row">
			<h2 style="color: #0B610B; text-align: center;">Các giai đoạn phát triển</h2>
				<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<table class="table table-responsive table-inverse">
						<thead>
							<tr>
								<th>Tên giai đoạn</th>
								<th>Ngày bắt đầu</th>
								<th>Ngày kết thúc</th>
								<th>Mô tả</th>
								<th>Loại phân cần thiết</th>
							</tr>
						</thead>
						<?php foreach ($stages_dev as $value_2): ?>
						<tbody>
							<tr>
								<td><?= $value_2['name'] ?></td>
								<td>Ngày thứ <?= $value_2['start_day'] ?></td>
								<td>Ngày thứ <?= $value_2['end_day'] ?></td>
								<td><?= $value_2['description'] ?></td>
								<td><?= $value_2['fertilizer'] ?></td>
							</tr>
						</tbody>
						<?php endforeach ?>
					</table>
				</div>
				<div class="col-md-2"></div>
				</div>
		</div> <!-- end row -->
		<div class="row">
			<h2 style="color: #0B610B; text-align: center;">Các thông số môi trường phù hợp với mỗi giai đoạn</h2>
				<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<table class="table table-responsive table-inverse">
						<thead>
							<tr>
								<th>Tên giai đoạn</th>
								<th>Độ sáng thích hợp</th>
								<th>Nhiệt độ thích hợp (độ C)</th>
								<th>Độ ẩm thích hợp (%)</th>
								<th>Độ ph thích hợp</th>

							</tr>
						</thead>
						<?php foreach ($stages_dev as $value_2): ?>
						<tbody>
							<tr>
								<td><?= $value_2['name'] ?></td>
								<td><?= $value_2['suitable_light'] ?></td>
								<td><?= $value_2['suitable_temperature_from'] ?> độ C đến <?= $value_2['suitable_temperature_to'] ?> độ C</td>
								<td><?= $value_2['suitable_humidity_from'] ?> % đến <?= $value_2['suitable_humidity_to'] ?> %</td>
								<td><?= $value_2['suitable_ph_from'] ?> đến <?= $value_2['suitable_ph_to'] ?></td>
							</tr>
						</tbody>
						<?php endforeach ?>
					</table>
				</div>
				<div class="col-md-2"></div>
				</div>
		</div> <!-- end row -->
	<?php endforeach ?>
</div> <!-- end div chính -->
<div class="row">
	<div class="col-md-5"></div>
	<div class="col-md-4">
		<a href="<?php echo url("/") ?>/admin/crops/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Lại"></a>
	</div>
	<div class="col-md-3"></div>
</div>
<style type="text/css">
	img {
		border-radius:2%;
		-moz-border-radius:2%;
		-webkit-border-radius:5%;
	}
</style>
@endsection()
