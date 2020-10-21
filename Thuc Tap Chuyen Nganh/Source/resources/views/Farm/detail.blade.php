@extends('admin')

@section('content')
<div >
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h2>Thông tin về Trang trại</h2>
				<fieldset class="form-group">
					<label>Tên trang trại</label>
					<p><?= $farm['name'] ?></p>
				</fieldset>
				<fieldset class="form-group">
					<label>Diện tích canh tác của trang trại</label>
					<p><?= $farm['cultivated_area'] ?></p>
				</fieldset>
				<fieldset class="form-group">
					<label>Tháng hiện tại</label>
					<p><?= $farm['current_month'] ?></p>
				</fieldset>
				<fieldset>
					<a href="<?php echo url("/") ?>/adminpage"><input type="button" style="width: 200px" class="btn btn-primary" value="Quay Về"></a>
					<br><br>
				</fieldset>
		</div>
		<div class="col-md-3">
		</div>
	</div>
</div><!--/Repaly Box-->
@endsection()