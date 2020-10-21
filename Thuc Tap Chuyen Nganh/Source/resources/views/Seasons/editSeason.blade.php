@extends('admin')

@section('content')
<div >
	<form method="POST" enctype="multipart/form-data" >
		<input type="hidden" name="_token" value="{{ csrf_token()}}">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Chỉnh Sửa Mùa Vụ</h2> 
				<fieldset class="form-group">
					<label>Id Mùa vụ</label>
					<input type="number" readonly="" class="form-control"  value="<?= $season['id'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Tên Mùa vụ</label>
					<input type="text" class="form-control" name="name"  value="<?= $season['name'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Mô tả Mùa vụ</label>
					<textarea name="" id="" cols="30" rows="10"><?= $season['description'] ?></textarea>
				</fieldset>
				<fieldset class="form-group">
					<label>Tháng bắt đầu gieo trồng</label>
					<input type="text" class="form-control" name="mass" value="<?= $season['start_month_planting'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Tháng kết thúc gieo trồng</label>
					<input type="text" class="form-control" name="mass" value="<?= $season['end_month_planting'] ?>">
				</fieldset>
				<fieldset class="form-group">
						<label>Tên loại cây trồng</label>
						<select class="custom-select" name="sltTypeFarm">
							<option value="-1" >Bạn hãy chọn một loại cây trồng</option>
							<?php foreach ($crops as $valu): ?>
								<option selected=""  value="<?= $valu['id'] ?>"><?= $valu['name'] ?></option>
								<option value="<?= $valu['id'] ?>"><?= $valu['name'] ?></option>
							<?php endforeach ?>
						</select>
					</fieldset>
				<fieldset> 
					<a href="<?php echo url("/") ?>/admin/seasons/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
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