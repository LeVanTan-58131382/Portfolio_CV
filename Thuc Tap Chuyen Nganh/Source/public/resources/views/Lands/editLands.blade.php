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
		<div class="col-md-1"></div>
		<div class="col-md-6">
			<h2>Cập Nhật Thửa ruộng</h2>
			<form method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<?php foreach ($land as $value): ?>
					<fieldset class="form-group">
						<label>Land ID</label>
						<input type="number" readonly=""  class="form-control" value="<?= $value['id'] ?>">
					</fieldset>
					<fieldset class="form-group">
						<label>Tên Thửa ruộng</label>
						<input type="text" name="name" class="form-control" value="<?= $value['name'] ?>">
					</fieldset>
					<fieldset class="form-group">
						<label>Tên trang trại</label>
						<select class="custom-select" name="sltTypeFarm">
							<option value="-1" >Bạn hãy chọn một trang trại</option>
							<?php foreach ($farms as $valu): ?>
								<option selected=""  value="<?= $valu['id'] ?>"><?= $valu['name'] ?></option>
								<option value="<?= $valu['id'] ?>"><?= $valu['name'] ?></option>
							<?php endforeach ?>
						</select>
					</fieldset>
					<fieldset class="form-group">
						<label>Tên loại cây trồng</label>
						<select class="custom-select" name="sltType">
							<option value="-1" >Choose a Type name of Crops</option>
							<?php foreach ($crops as $va): ?>
								<option selected=""  value="<?= $va['id'] ?>"><?= $va['name'] ?></option>
								<option value="<?= $va['id'] ?>"><?= $va['name'] ?></option>
							<?php endforeach ?>
						</select>
					</fieldset>
				</br>
				<fieldset class="form-group">
					<label>Ảnh cây trồng</label></br>
					<?php
					foreach ($crops as $val) {
						if($val['id'] == $value["crop_id"])
							{?>
								<img style="width: 200px; height: 150px" src="{!!url('/')!!}/resources/upload/{!!$val['image']!!}" alt="">
							<?php }
						}
						?>
					</fieldset>
					<fieldset class="form-group">
						<label>Số lượng cây trồng</label>
						<input type="text" class="form-control" name="quanty_crops" value="<?= $value['quanty_crops'] ?>">
					</fieldset>
					<fieldset class="form-group">
						<label>Diện tích</label>
						<input type="text" class="form-control" name="square" value="<?= $value['square'].' mét vuông' ?>">
					</fieldset>
					<fieldset class="form-group">
						<label>Số ngày phát triển</label>
						<input type="text" class="form-control" name="dev_days" value="<?= $value['dev_days'] ?>">
					</fieldset>
				<?php endforeach ?>
				<fieldset>
					<input type="submit" style="width: 200px" class="btn btn-primary" value="Lưu">
					<br><br>
				</fieldset>
			</form>
			<fieldset>
				<a href="<?php echo url("/") ?>/admin/lands/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
				<br><br>
			</fieldset>
		</div>
	</div>
</div><!--/Repaly Box-->
@endsection()