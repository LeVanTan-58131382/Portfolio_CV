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
		<form>
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Chi Tiết Bồn Nước</h2>
				<fieldset class="form-group">
					<label>Tên bồn nước</label>
					<input type="text" class="form-control" value="<?= $water['name'] ?>">
				</fieldset>
				<fieldset class="form-group">
					<label>Khối lượng nước trong bồn</label>
					<input type="number" class="form-control" value="<?= $water['volume'] ?>">
				</fieldset>
				<fieldset>
					<a href="<?php echo url("/") ?>/admin/sourceofwater/list"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
					<br><br>
				</fieldset>
			</div>
			<div class="col-md-3"></div>
		</form>
	</div>
</div>
@endsection()