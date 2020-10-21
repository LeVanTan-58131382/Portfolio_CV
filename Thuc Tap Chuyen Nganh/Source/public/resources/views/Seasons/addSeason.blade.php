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
		<form action="{{ route('admin.seasons.getadd')}}" method="POST" enctype="multipart/form-data">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Thêm Mùa vụ</h2>
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<fieldset class="form-group">
					<label>Loại cây trồng</label>
					<select class="custom-select" name="sltType">
						<option value="-1" selected>Chọn một loại cây trồng</option>
						<?php foreach ($crop as $value): ?>
							<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
						<?php endforeach ?>
					</select>
					
				</fieldset>
				<fieldset class="form-group">
					<label>Tên mùa vụ</label>
					<input type="text" class="form-control" name="name" placeholder="Nhập vào tên mùa vụ">
				</fieldset>
				<fieldset class="form-group">
					<label>Mô tả mùa vụ</label>
					<textarea name="description" id="" cols="30" rows="10"></textarea>
				</fieldset>
				<fieldset class="form-group">
					<label>Tháng bắt đầu gieo trồng</label>
					<input type="number" class="form-control" min="1" max="12" name="start_month_planting" placeholder="Nhập vào tháng bắt đầu gieo trồng">
				</fieldset>
				<fieldset class="form-group">
					<label>Tháng kết thúc gieo trồng</label>
					<input type="number" class="form-control" min="1" max="12" name="end_month_planting" placeholder="Nhập vào tháng kết thúc gieo trồng">
				</fieldset>
				<fieldset>
					<input type="submit" style="width: 200px" class="btn btn-primary" value="Thêm">
					<br><br>
				</fieldset>
			</div>
			<div class="col-md-3"></div>
		</form>
	</div>
</div><!--/Repaly Box-->
@endsection()