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
		<form action="{{ route('admin.lands.getadd')}}" method="POST" enctype="multipart/form-data">
			<div class="col-md-2"></div>
			<div class="col-md-6">
				<h2 style="text-align: center;">Thêm Land</h2>
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<fieldset class="form-group">
					<label>Tên của thửa ruộng</label>
					<input type="text" class="form-control" name="name" placeholder="write land name...">
				</fieldset>
				<fieldset class="form-group">
					<label>Tên trang trại</label>
					<select class="custom-select" name="sltTypeFarm">
						<option value="-1" selected>Bạn hãy chọn một trang trại</option>
						<?php foreach ($farms as $value): ?>
							<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
						<?php endforeach ?>
					</select>
				</fieldset>
				<fieldset class="form-group">
					<label>Tên loại cây trồng</label>
					<select class="custom-select" name="sltType">
						<option value="-1" selected>Bạn hãy chọn một loại cây trồng</option>
						<?php foreach ($crops as $value): ?>
							<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
						<?php endforeach ?>
					</select>
				</fieldset>
				<div id="dt">
					<fieldset class="form-group">
					<label>Diện tích còn lại của các trang trại(mét vuông)</label></br>
					<?php foreach ($farms as $value): ?>
						<label>Diện tích còn lại của <?= $value['name'] ?>: <?= $value['vacant_area'] ?> mét vuông.</label></br>
					<?php endforeach ?>
					</fieldset>
				</div>
				<fieldset class="form-group">
					<label>Diện tích thửa ruộng (mét vuông)</label>
					<input type="number" class="form-control" name="square" placeholder="write square of land...">
				</fieldset>
				<fieldset class="form-group">
					<label>Số lượng cây trồng (cây)</label>
					<input type="number" class="form-control" name="quanty_crops" placeholder="nhập số lượng cây trồng...">
				</fieldset>
				<fieldset>
					<input type="submit" name="submit" style="width: 200px; margin-left: 300px" class="btn btn-primary" value="Thêm">
					<br><br>
					<a href="<?php echo url("/") ?>/admin/lands/list"><input type="button" style="width: 200px; margin-left: 300px" class="btn btn-primary"  value="Quay Về"></a>
			<br><br>
				</fieldset>
			</div>
			<div class="col-md-3">
			<input type="button" id="btn2" class="btn btn-info" value="Thông tin về mật độ cây trồng"/>
				<div id="matdo" style="display: none">
					<label>Mật độ cây trồng</label>
					<?php foreach ($crops as $val): ?>
						<label>Loại cây: <?= $val['name'].' '; ?> - Mật độ: <?= $val['density'].' cây trên một mét vuông' ?></label>
					<?php endforeach ?>
					<br><input class="btn btn-warning" type="button" id="btn1" value="Ẩn"/>
				</div>
			</div>
		</form>
	</div>
</div><!--/Repaly Box-->
<style type="text/css">
	#matdo, #dt{
		margin: 3px;
		padding: 5px;
		color: #006899;
		border: solid 1px #006899;
		background: white;
		border-radius: 5px
	}
</style>
<script type="text/javascript">
	document.getElementById("btn1").onclick = function () {
		document.getElementById("matdo").style.display = 'none';
	};

	document.getElementById("btn2").onclick = function () {
		document.getElementById("matdo").style.display = 'block';
	};
</script>
@endsection()