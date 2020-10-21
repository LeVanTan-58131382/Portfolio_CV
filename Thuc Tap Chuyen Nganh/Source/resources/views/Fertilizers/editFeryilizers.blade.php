@extends('admin')

@section('content')
<div >
	<form method="POST" enctype="multipart/form-data" >
		<input type="hidden" name="_token" value="{{ csrf_token()}}">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Chỉnh Sửa Phân Bón</h2>
				<fieldset class="form-group">
					<label>Id Phân bón</label>
					<input type="number" readonly="" class="form-control"  value="<?= $fer['id'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Tên phân bón</label>
					<input type="text" class="form-control" name="name"  value="<?= $fer['name'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Khối lượng phân bón</label>
					<input min="1" type="text" class="form-control" name="mass" value="<?= $fer['mass'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Khối lượng phân bón cần cho 30 mét vuông canh tác cây trồng (kg)</label>
					<input min="0" type="text" class="form-control" name="mass30" value="<?= $fer['mass_suiable_30_m'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Khoảng thời gian cần để mang lại hiệu quả (ngày)</label>
					<input min="0" type="text" class="form-control" name="time" value="<?= $fer['effective_time'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Tên loại phân bón</label>
					<select class="custom-select" name="sltType">
						<?php foreach ($type_fer as $value): ?>
							<option selected="" value="<?= $fer['type_fertilizer_id'] ?>"><?php 
								foreach ($type_fer as $val) {
									if($val['id'] == $fer["type_fertilizer_id"]) 
										echo $val["name"];
								}
								?></option>
							<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
						<?php endforeach ?>
					</select>
				</fieldset>
				<fieldset> 
					<a href="<?php echo url("/") ?>/admin/fertilizers/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
					<br><br>
				</fieldset>
				<fieldset>
					<input type="submit" style="width: 200px" class="btn btn-primary" value="Lưu">
					<br><br>
				</fieldset>
			</div>
			<div class="col-md-3">

			</div>
		</div>
	</form>
</div><!--/Repaly Box-->
@endsection()