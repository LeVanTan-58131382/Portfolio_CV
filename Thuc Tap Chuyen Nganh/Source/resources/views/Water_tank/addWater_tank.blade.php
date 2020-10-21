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
		<form action="{{ route('admin.sourceofwater.getadd')}}" method="POST" enctype="multipart/form-data">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Thêm Bồn Nước</h2>
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<fieldset class="form-group">
					<label>Tên bồn nước</label>
					<input type="text" class="form-control" name="name" placeholder="write water tank name...">
				</fieldset>
				<fieldset class="form-group">
					<label>Khối lượng nước trong bồn</label>
					<input type="number" class="form-control" name="volume" placeholder="write volume of water tank...">
				</fieldset>
				<fieldset>
					<input type="submit" style="width: 200px" class="btn btn-primary" value="Thêm">
					<br><br>
				</fieldset>
			</div>
			<div class="col-md-3"></div>
		</form>
	</div>
</div>
@endsection()