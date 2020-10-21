@extends('admin')

@section('content')
<div >
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h2>Chi Tiết Phân Bón</h2>
			<input type="hidden" name="_token" value="{{ csrf_token()}}">
			<fieldset class="form-group">
				<label>Id Phân bón</label>
				<p><?= $fer['id'] ?></p>
			</fieldset>
			<fieldset class="form-group">
				<label>Tên phân bón</label>
				<p><?= $fer['name'] ?></p>
			</fieldset>
			<fieldset class="form-group">
				<label>Khối lượng phân bón</label>
				<p><?= $fer['mass'] ?></p>
			</fieldset>
			<fieldset class="form-group">
				<label>Khối lượng phân bón cần cho 30 mét vuông canh tác cây trồng (kg)</label>
				<p><?= $fer['mass_suiable_30_m'] ?></p>
			</fieldset>
			<fieldset class="form-group">
				<label>Khoảng thời gian cần để mang lại hiệu quả (ngày)</label>
				<p><?= $fer['effective_time'] ?></p>
			</fieldset>
			<fieldset class="form-group">
				<label>Tên loại phân bón</label>
				<?php 
				foreach ($type_fer as $val) {
					if($val['id'] == $fer["type_fertilizer_id"]) 
						echo '</br>'.$val["name"];
				}
				?>
			</fieldset>
			<fieldset>
				<a href="<?php echo url("/") ?>/admin/fertilizers/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
				<br><br>
			</fieldset>
		</div>
		<div class="col-md-3">
			
		</div>
	</div>
</div><!--/Repaly Box-->
@endsection()