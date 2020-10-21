@extends('admin')

@section('content')
<div >
	<div class="row">
		<div class="col-md-2"></div>
		<?php foreach ($land as $value): ?>
			<div class="col-md-4">
				<?php
				foreach ($crops as $val) {
					if($val['id'] == $value["crop_id"])
						{?>
							<img style="width: 400px; height: 300px" src="{!!url('/')!!}/resources/upload/{!!$val['image']!!}" alt="">
						<?php }
					}
					?>
				</div> <!-- end col-md-6 -->
				<div class="col-md-4">
					<div class="row">
						<input style="width: 250px" type="button" id="btn3" class="btn btn-info" value="Thông tin về giai đoạn phát triển"/></br></br>
						<div style="display: none" id="giaidoan" class="col-md-12">
							<?php
					$vitri = 0;
					foreach ($stages as $val) {
						if($value['virtual_dev_days'] != 0) {
							if(($val['crop_id'] == $value["crop_id"]) && ($val['start_day'] <= $value["virtual_dev_days"]) && ($val['end_day'] >= $value["virtual_dev_days"])){
								$vitri = $val['numerical_order'];
										{?>
											<h2 style="color: #0B610B; text-align: center;">Thông tin về giai đoạn phát triển</h2>
												<label for="">Cây trồng đang trong giai đoạn phát triển thứ: <?= $val['numerical_order'] ?></label></br>
												<label for="">Tên giai đoạn: <?= $val['name']?></label></br>
												<label for="">Loại phân thích hợp: <?= $val['fertilizer']?></label></br>
												<label for="">Lượng phân thích hợp cho toàn bộ giai đoạn: <?= $val['fertilizer_mass']?></label></br>
												<label for="">Độ sáng thích hợp: <?= $val['suitable_light']?></label></br>
												<label for="">Nhiệt độ thích hợp từ <?= $val['suitable_temperature_from']?> đến <?= $val['suitable_temperature_to'] ?></label></br>
												<label for="">Độ ph thích hợp từ <?= $val['suitable_ph_from']?> đến <?= $val['suitable_ph_to'] ?></label></br>
												<label for="">Độ ẩm thích hợp từ <?= $val['suitable_humidity_from']?> đến <?= $val['suitable_humidity_to'] ?></label></br>
											</br>
									<?php }
								}
							}
						}
					if($value['virtual_dev_days'] == 0) {
						{?>
							<h2 style="color: #0B610B; text-align: center;">Thông tin về giai đoạn phát triển</h2>
							<?php foreach ($stage as $val): ?>
								<label for="">Cây trồng đang trong giai đoạn phát triển thứ: <?= $val['numerical_order'] ?></label></br>
								<label for="">Tên giai đoạn: <?= $val['name']?></label></br>
								<label for="">Loại phân thích hợp: <?= $val['fertilizer']?></label></br>
								<label for="">Lượng phân thích hợp cho toàn bộ giai đoạn: <?= $val['fertilizer_mass']?></label></br>
								<label for="">Độ sáng thích hợp: <?= $val['suitable_light']?></label></br>
								<label for="">Nhiệt độ thích hợp từ <?= $val['suitable_temperature_from']?> đến <?= $val['suitable_temperature_to'] ?></label></br>
								<label for="">Độ ph thích hợp từ <?= $val['suitable_ph_from']?> đến <?= $val['suitable_ph_to'] ?></label></br>
								<label for="">Độ ẩm thích hợp từ <?= $val['suitable_humidity_from']?> đến <?= $val['suitable_humidity_to'] ?></label></br>
							</br>
						<?php endforeach ?>
					<?php }
				}
			?>
			<input class="btn btn-warning" type="button" id="btn4" value="Ẩn"/>
						</div>
					</div>
		<div class="row">
			<input style="width: 250px" type="button" id="btn2" class="btn btn-info" value="Thông tin về sâu bệnh hại"/>
			<div style="display: none" id="saubenh" class="col-md-12">
				<h2 style="color: #0B610B; text-align: center;">Thông tin về sâu bệnh hại</h2>
				<?php
				foreach ($crops as $val) {
					if($val['id'] == $value["crop_id"])
						{?>
							<p><?= $val['pests_and_diseases'] ?></p>
						<?php }
					}
					?>
					<input class="btn btn-warning" type="button" id="btn1" value="Ẩn"/>
			</div>
		</div>
		</div> <!-- end col-md-6 -->
	</div> <!-- end row -->
</br></br></br></br>
<div class="row">
	<div class="col-md-12">
		<h2 style="color: #0B610B; text-align: center;">Chi Tiết Thửa ruộng</h2>
	</div>
	<div class="col-md-2"></div>
	<div class="col-md-8">

		<table class="table table-responsive table-inverse">
			<thead>
				<tr>
					<th>Land ID</th>
					<th>Tên thửa ruộng</th>
					<th>Loại cây trồng</th>
					<th>Số lượng cây trồng</th>
					<th>Diện tích thửa ruộng</th>
					<th>Số ngày phát triển</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $value['id'] ?></td>
					<td><?= $value['name'] ?></td>
					<td><?php
					foreach ($crops as $val) {
						if($val['id'] == $value["crop_id"])
							{?>
								<p><?= $val['name'] ?></p>
							<?php }
						}
						?></td>
						<td><?= $value['quanty_crops'] ?> cây</td>
						<td><?= $value['square']?> mét vuông</td>
						<td><?= $value['dev_days'] ?> ngày</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-2"></div>
	</div> <!-- end row -->
<?php endforeach ?>
</div> <!-- end col-md-6 -->
</br></br></br></br>
<div class="row">
	<div class="col-md-12">
		<h2 style="color: #0B610B; text-align: center;">Lịch sử chăm sóc thửa ruộng</h2>
	</div>
</br>
</br></br></br></br>
<div class="col-md-2"></div>
<div class="col-md-4">
	<h4 style="color: #0B610B; size: 20px">Lịch sử bón phân</h4>
	<?php foreach ($fer_detali as $value): ?>
		<fieldset class="form-group">
			<label>Ngày bón phân: </label><p>Ngày thứ <?= $value['day_fer'] ?></p>
			<label>Lượng phân đã bón: </label><p><?= $value['mass'] ?> kg</p>
			<label>Loại phân đã bón: </label>
			<?php
			foreach ($fers as $val) {
				if($val['id'] == $value["fertilizer_id"])
					{?>
						<p><?= $val['name'] ?></p>
					<?php }
				}
				?>
				<label>Người thực hiện: </label><p><?= $value['implementer'] ?></p>
				<label>--------------------------------</label>
			</fieldset>
		</br>
	<?php endforeach ?>
</div>
<div class="col-md-1"></div>
<div class="col-md-4">
	<h4 style="color: #0B610B; ; size: 20px">Lịch sử tưới nước</h4>
	<?php foreach ($water_detali as $value): ?>
		<fieldset class="form-group">
			<label>Ngày tưới nước: </label><p>Ngày thứ <?= $value['day_water'] ?></p>
			<label>Lượng nước đã tưới: </label><p><?= $value['water_volume'] ?> mét khối</p>
			<label>Bồn nước đã sử dụng: </label>
			<?php
			foreach ($water_tank as $val) {
				if($val['id'] == $value["water_tank_id"])
					{?>
						<p><?= $val['name'] ?></p>
					<?php }
				}
				?>
				<label for="">Phương thức tưới: </label><?php foreach ($method_watering as $valu) {
					if($value['method_id'] == $valu['id']){
						echo '</br>';
						echo $valu['method'];
						echo '</br>';echo '</br>';
					}
				} ?>
				<label>Người thực hiện: </label><p><?= $value['implementer'] ?></p>
				<label>--------------------------------</label>
			</fieldset>
		</br>
	<?php endforeach ?>
</div>
<div class="col-md-1"></div>
</div> <!-- end row -->
<div class="row">
	<div class="col-md-5"></div>
	<div class="col-md-4">
		<fieldset>
			<a href="<?php echo url("/") ?>/admin/lands/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
			<br><br>
		</fieldset>
	</div>
</div>

</div><!--/Repaly Box-->
<style type="text/css">
	#saubenh{
			margin: 3px;
			padding: 5px;
			color: black;
			border: solid 1px #006899;
			background: white;
			border-radius: 5px
		}
		#giaidoan{
			margin: 3px;
			padding: 5px;
			color: black;
			border: solid 1px #006899;
			background: white;
			border-radius: 5px
		}
</style>
<script type="text/javascript">
	document.getElementById("btn1").onclick = function () {
			document.getElementById("saubenh").style.display = 'none';
		};
	document.getElementById("btn2").onclick = function () {
			document.getElementById("saubenh").style.display = 'block';
		};
	document.getElementById("btn3").onclick = function () {
			document.getElementById("giaidoan").style.display = 'block';
		};
	document.getElementById("btn4").onclick = function () {
			document.getElementById("giaidoan").style.display = 'none';
		};
</script>
@endsection()