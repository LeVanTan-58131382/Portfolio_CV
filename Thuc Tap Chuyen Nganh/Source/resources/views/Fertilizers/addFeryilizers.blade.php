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
		<form action="{{ route('admin.fertilizers.getadd')}}" method="POST" enctype="multipart/form-data">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Thêm Phân Bón</h2>
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<fieldset class="form-group">
					<label>Loại của Phân bón</label>
					<select class="custom-select" name="sltType">
						<option value="-1" selected>Chọn một loại của phân bón</option>
						<?php foreach ($type_fer as $value): ?>
							<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
						<?php endforeach ?>
					</select>
					
				</fieldset>
				<fieldset class="form-group">
					<label>Tên phân bón</label>
					<input type="text" class="form-control" name="name" placeholder="write fertilizers name...">
				</fieldset>
				<fieldset class="form-group">
					<label>Khối lượng phân bón</label>
					<input type="number" min="1" class="form-control" name="mass" placeholder="write mass of fertilizers...">
				</fieldset>
				<fieldset class="form-group">
					<label>Khối lượng phân bón cần cho 30 mét vuông canh tác cây trồng (kg)</label>
					<input type="double" min="0" class="form-control" name="mass30" placeholder="write mass of fertilizers...">
				</fieldset>
				<fieldset class="form-group">
					<label>Khoảng thời gian cần để mang lại hiệu quả</label>
					<input type="number" min="0" class="form-control" name="time" placeholder="write time to effective...">
				</fieldset>
				<fieldset>
					<input type="submit" style="width: 200px" class="btn btn-primary" value="Add">
					<br><br>
				</fieldset>
			</div>
			<div class="col-md-3"></div>
		</form>
	</div>
</div><!--/Repaly Box-->
@endsection()