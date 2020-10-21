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
	<form  method="POST" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token()}}">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Cập nhật dữ liệu của Trang trại</h2>
				<fieldset class="form-group">
					<label>Tên trang trại</label>
					<input type="text" class="form-control" name="name"  value="<?= $farm['name'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Diện tích canh tác của trang trại</label>
					<input type="text" class="form-control" name="cultivated_area"  value="<?= $farm['cultivated_area'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Tháng hiện tại</label>
					<input type="text" class="form-control" name="current_month" value="<?= $farm['current_month'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<input type="submit" class="btn btn-success "  value="Lưu">
				</fieldset>
				<fieldset>
					<a href="<?php echo url("/") ?>/adminpage"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
					<br><br>
				</fieldset>
			</div>
			<div class="col-md-3">
			</div>
		</div>
	</form>
</div><!--/Repaly Box-->
@endsection()