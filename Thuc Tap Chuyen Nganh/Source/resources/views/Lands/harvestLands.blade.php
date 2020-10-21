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
		<form  method="POST" enctype="multipart/form-data">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Chi Tiết Thu Hoạch</h2>
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<?php foreach ($land as $value): ?>
					<fieldset class="form-group">
						<label>Tên của Thửa ruộng</label>
						<input readonly="" type="text" class="form-control" name="name" value="<?= $value['name'] ?>">
					</fieldset>
					<fieldset class="form-group">
						<label>Tên loại cây trồng</label>
						<?php
						foreach ($crop as $val) {
							if($val['id'] == $value["crop_id"])
								{?>
									<input readonly="" type="text" class="form-control"  value="<?= $val['name'] ?>">
								<?php } 
							}
							?>
						</fieldset>
					<?php endforeach ?>
					<fieldset class="form-group">
						<label>Tổng lượng nước đã tưới (mét khối)</label>
						<input readonly="" type="number" class="form-control" name="square" value="<?= $total_water ?>">
					</fieldset>
					<fieldset class="form-group">
						<label>Tổng lượng phân đã bón (kg)</label>
						<input readonly="" type="number" class="form-control" name="quanty_crops" value="<?= $total_fer ?>">
					</fieldset>
					<fieldset>
						<label for="">Sau khi thu hoạch bạn muốn</label>
							<select class="custom-select" name="sltChoose">
								<option value="-1" selected>Bạn hãy chọn một lựa chọn</option>
								<option value="0" >Tiếp tục duy trì và chăm sóc cho cây trồng của land</option>
								<option value="1" >Trồng một cây trồng khác sau khi thu hoạch</option>
								<option value="2" >Không trồng cây trồng khác sau khi thu hoạch (nhưng vẫn giữ lại land)</option>
								<option value="3" >Xóa land này sau khi thu hoạch</option>
							</select>
					</fieldset>
				</br>
					<fieldset>
						<label for="">Sau khi thu hoạch cây trồng sẽ trở về giai đoạn phát triển</label>
							<select class="custom-select" name="sltChooseStage">
								<option value="-1" selected>Bạn hãy chọn một lựa chọn</option>
								<?php foreach ($stage as $value): ?>
									<option value="<?= $value['numerical_order'] ?>"><?= $value['name'] ?></option>
								<?php endforeach ?>
							</select>
					</fieldset>
					<fieldset>
						<input type="submit" name="submit" style="width: 200px" class="btn btn-primary" value="Thu hoạch">
						<br><br>
					</fieldset>
				</div>
			</form>
		</div>
	</div><!--/Repaly Box-->
	@endsection()