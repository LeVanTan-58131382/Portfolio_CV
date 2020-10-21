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
<?php $i = 0; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_insert_2").click(function(){

			$("#stage").append('<div><fieldset class="form-group"><label>--------------------------------------------------------------------</label></fieldset><fieldset class="form-group"><label style="text-align: center;">Giai đoạn phát triển thứ hai (II)</label></fieldset><fieldset class="form-group"><label>Tên giai đoạn phát triển</label><input type="text" class="form-control" name="stage[1][nameStage]" ></fieldset><fieldset class="form-group"><label>Ngày bắt đầu của giai đoạn</label><input type="number" class="form-control" name="stage[1][starday]"></fieldset><fieldset class="form-group"><label>Ngày kết thúc của giai đoạn</label><input type="number" class="form-control" name="stage[1][endday]" ></fieldset><fieldset class="form-group"><label>Loại phân cần bón</label><input type="text" class="form-control" name="stage[1][fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng phân cần bón</label><input type="text" class="form-control" name="stage[1][mass_fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng nước cần tưới</label><input type="number" class="form-control" name="stage[1][volume_water_needed]" ></fieldset><fieldset class="form-group"><label>Mô tả giai đoạn</label><textarea type="text" class="form-control" name="stage[1][description]"></textarea></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp từ </label><input type="number" class="form-control" name="stage[1][suitable_humidity_from]" ></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp đến </label><input type="number" class="form-control" name="stage[1][suitable_humidity_to]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp từ </label><input type="number" class="form-control" name="stage[1][suitable_temperature_from]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp đến </label><input type="number" class="form-control" name="stage[1][suitable_temperature_to]" ></fieldset><fieldset class="form-group"><label>Ánh sáng thích hợp </label><input type="text" class="form-control" name="stage[1][suitable_light]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp từ </label><input type="number" class="form-control" name="stage[1][suitable_ph_from]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp đến </label><input type="number" class="form-control" name="stage[1][suitable_ph_to]" ></fieldset><fieldset><input class="btn btn-danger" value="Delete" type="button" id="delete_2"></fieldset></div>');
			document.getElementById("btn_insert_2").disabled = true;
		});
		$("#btn_insert_3").click(function(){

			$("#stage").append('<div><fieldset class="form-group"><label>--------------------------------------------------------------------</label></fieldset><fieldset class="form-group"><label style="text-align: center;">Giai đoạn phát triển thứ ba (III)</label></fieldset><fieldset class="form-group"><label>Tên giai đoạn phát triển</label><input type="text" class="form-control" name="stage[2][nameStage]" ></fieldset><fieldset class="form-group"><label>Ngày bắt đầu của giai đoạn</label><input type="number" class="form-control" name="stage[2][starday]"></fieldset><fieldset class="form-group"><label>Ngày kết thúc của giai đoạn</label><input type="number" class="form-control" name="stage[2][endday]" ></fieldset><fieldset class="form-group"><label>Loại phân cần bón</label><input type="text" class="form-control" name="stage[2][fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng phân cần bón</label><input type="text" class="form-control" name="stage[2][mass_fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng nước cần tưới</label><input type="number" class="form-control" name="stage[2][volume_water_needed]" ></fieldset><fieldset class="form-group"><label>Mô tả giai đoạn</label><textarea type="text" class="form-control" name="stage[2][description]"></textarea></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp từ </label><input type="number" class="form-control" name="stage[2][suitable_humidity_from]" ></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp đến </label><input type="number" class="form-control" name="stage[2][suitable_humidity_to]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp từ </label><input type="number" class="form-control" name="stage[2][suitable_temperature_from]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp đến </label><input type="number" class="form-control" name="stage[2][suitable_temperature_to]" ></fieldset><fieldset class="form-group"><label>Ánh sáng thích hợp </label><input type="text" class="form-control" name="stage[2][suitable_light]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp từ </label><input type="number" class="form-control" name="stage[2][suitable_ph_from]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp đến </label><input type="number" class="form-control" name="stage[2][suitable_ph_to]" ></fieldset><fieldset><input class="btn btn-danger" value="Delete" type="button" id="delete_3"></fieldset></div>');
			document.getElementById("btn_insert_3").disabled = true;
		});
		$("#btn_insert_4").click(function(){

			$("#stage").append('<div><fieldset class="form-group"><label>--------------------------------------------------------------------</label></fieldset><fieldset class="form-group"><label style="text-align: center;">Giai đoạn phát triển thứ tư (VI)</label></fieldset><fieldset class="form-group"><label>Tên giai đoạn phát triển</label><input type="text" class="form-control" name="stage[3][nameStage]" ></fieldset><fieldset class="form-group"><label>Ngày bắt đầu của giai đoạn</label><input type="number" class="form-control" name="stage[3][starday]"></fieldset><fieldset class="form-group"><label>Ngày kết thúc của giai đoạn</label><input type="number" class="form-control" name="stage[3][endday]" ></fieldset><fieldset class="form-group"><label>Loại phân cần bón</label><input type="text" class="form-control" name="stage[3][fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng phân cần bón</label><input type="text" class="form-control" name="stage[3][mass_fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng nước cần tưới</label><input type="number" class="form-control" name="stage[3][volume_water_needed]" ></fieldset><fieldset class="form-group"><label>Mô tả giai đoạn</label><textarea type="text" class="form-control" name="stage[3][description]"></textarea></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp từ </label><input type="number" class="form-control" name="stage[3][suitable_humidity_from]" ></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp đến </label><input type="number" class="form-control" name="stage[3][suitable_humidity_to]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp từ </label><input type="number" class="form-control" name="stage[3][suitable_temperature_from]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp đến </label><input type="number" class="form-control" name="stage[3][suitable_temperature_to]" ></fieldset><fieldset class="form-group"><label>Ánh sáng thích hợp </label><input type="text" class="form-control" name="stage[3][suitable_light]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp từ </label><input type="number" class="form-control" name="stage[3][suitable_ph_from]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp đến </label><input type="number" class="form-control" name="stage[3][suitable_ph_to]" ></fieldset><fieldset><input class="btn btn-danger" value="Delete" type="button" id="delete_4"></fieldset></div>');
			document.getElementById("btn_insert_4").disabled = true;
		});
		$("#btn_insert_5").click(function(){

			$("#stage").append('<div><fieldset class="form-group"><label>--------------------------------------------------------------------</label></fieldset><fieldset class="form-group"><label style="text-align: center;">Giai đoạn phát triển thứ năm (V)</label></fieldset><fieldset class="form-group"><label>Tên giai đoạn phát triển</label><input type="text" class="form-control" name="stage[4][nameStage]" ></fieldset><fieldset class="form-group"><label>Ngày bắt đầu của giai đoạn</label><input type="number" class="form-control" name="stage[4][starday]"></fieldset><fieldset class="form-group"><label>Ngày kết thúc của giai đoạn</label><input type="number" class="form-control" name="stage[4][endday]" ></fieldset><fieldset class="form-group"><label>Loại phân cần bón</label><input type="text" class="form-control" name="stage[4][fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng phân cần bón</label><input type="text" class="form-control" name="stage[4][mass_fertilizer_needed]" ></fieldset><fieldset class="form-group"><label>Lượng nước cần tưới</label><input type="number" class="form-control" name="stage[4][volume_water_needed]" ></fieldset><fieldset class="form-group"><label>Mô tả giai đoạn</label><textarea type="text" class="form-control" name="stage[4][description]"></textarea></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp từ </label><input type="number" class="form-control" name="stage[4][suitable_humidity_from]" ></fieldset><fieldset class="form-group"><label>Độ ẩm thích hợp đến </label><input type="number" class="form-control" name="stage[4][suitable_humidity_to]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp từ </label><input type="number" class="form-control" name="stage[4][suitable_temperature_from]" ></fieldset><fieldset class="form-group"><label>Nhiệt độ thích hợp đến </label><input type="number" class="form-control" name="stage[4][suitable_temperature_to]" ></fieldset><fieldset class="form-group"><label>Ánh sáng thích hợp </label><input type="text" class="form-control" name="stage[4][suitable_light]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp từ </label><input type="number" class="form-control" name="stage[4][suitable_ph_from]" ></fieldset><fieldset class="form-group"><label>Độ ph thích hợp đến </label><input type="number" class="form-control" name="stage[4][suitable_ph_to]" ></fieldset><fieldset><input class="btn btn-danger" value="Delete" type="button" id="delete_5"></fieldset></div>');
			document.getElementById("btn_insert_5").disabled = true;
		});
	});
</script>
<div >
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<h2 style="text-align: center;">Thêm Cây Trồng</h2>
			<form action="{{ route('admin.crops.getadd')}}" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<fieldset class="form-group">
					<label>Tên cây trồng</label>
					<input type="text" class="form-control" name="name" placeholder="nhập vào tên cây trồng...">
				</fieldset>
				<fieldset class="form-group">
					<label>Mô tả cây trồng</label>
					<textarea type="text" class="form-control" id="description" name="description"></textarea>
				</fieldset>
				<fieldset class="form-group">
					<label>Ảnh</label>
					<input type="file" class="form-control" name="image" >
				</fieldset>
				<fieldset class="form-group">
					<label>Mật độ cây trồng (cây/m2)</label>
					<input min="1" type="number" class="form-control" name="density" placeholder="nhập mật độ cây trồng...">
				</fieldset>
				<fieldset class="form-group">
					<label>Độ PH thích hợp từ</label>
					<input min="1" type="number" class="form-control" name="ph_from" placeholder="độ ph thích hợp từ...">
				</fieldset>
				<fieldset class="form-group">
					<label>Độ PH thích hợp đến</label>
					<input min="1" type="number" class="form-control" name="ph_to" placeholder="độ ph thích hợp đến...">
				</fieldset>
				<fieldset class="form-group">
					<label>Tổng số giai đoạn phát triển</label>
					<input min="1" type="number" class="form-control" name="quanty_stages_dev" placeholder="nhập tổng số giai đoạn phát triển">
				</fieldset>
				<fieldset class="form-group">
					<label>--------------------------------------------------------------------</label>
				</fieldset>
				<fieldset class="form-group">
					<label style="text-align: center;">Giai đoạn thứ nhất</label>
				</fieldset>
				<fieldset class="form-group">
					<label>Tên giai đoạn phát triển</label>
					<input type="text" class="form-control" name="stage[0][nameStage]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Ngày bắt đầu của giai đoạn</label>
					<input type="number" class="form-control" name="stage[0][starday]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Ngày kết thúc của giai đoạn</label>
					<input type="number" class="form-control" name="stage[0][endday]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Loại phân bón phù hợp</label>
					<input type="text" class="form-control" name="stage[0][fertilizer_needed]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Lượng phân bón cần thiết</label>
					<input type="text" class="form-control" name="stage[0][mass_fertilizer_needed]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Lượng nước cần thiết </label>
					<input type="number" class="form-control" name="stage[0][volume_water_needed]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Mô tả giai đoạn </label>
					<textarea type="text" class="form-control" id="description_1" name="stage[0][description]"></textarea>
				</fieldset>

				<fieldset class="form-group">
					<label>Độ ẩm thích hợp từ </label>
					<input type="number" class="form-control" name="stage[0][suitable_humidity_from]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Độ ẩm thích hợp đến </label>
					<input type="number" class="form-control" name="stage[0][suitable_humidity_to]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Nhiệt độ thích hợp từ </label>
					<input type="number" class="form-control" name="stage[0][suitable_temperature_from]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Nhiệt độ thích hợp đến </label>
					<input type="number" class="form-control" name="stage[0][suitable_temperature_to]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Ánh sáng thích hợp </label>
					<input type="text" class="form-control" name="stage[0][suitable_light]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Độ ph thích hợp từ </label>
					<input type="number" class="form-control" name="stage[0][suitable_ph_from]" >
				</fieldset>
				<fieldset class="form-group">
					<label>Độ ph thích hợp đến </label>
					<input type="number" class="form-control" name="stage[0][suitable_ph_to]" >
				</fieldset>

				<div id="stage">

				</div>
				<fieldset>
					<input id="btn_insert_2" name="btn_insert" type="button" style="width: 200px" class="btn btn-primary" value="Thêm giai đoạn thứ hai">
					<input id="btn_insert_3" name="btn_insert" type="button" style="width: 200px" class="btn btn-primary" value="Thêm giai đoạn thứ ba">
					<input id="btn_insert_4" name="btn_insert" type="button" style="width: 200px" class="btn btn-primary" value="Thêm giai đoạn thứ tư">
					<input id="btn_insert_5" name="btn_insert" type="button" style="width: 200px" class="btn btn-primary" value="Thêm giai đoạn thứ năm">
				</fieldset>
			</br>
			<fieldset>
				<input type="submit" style="width: 200px; margin-left: 400px" class="btn btn-primary" value="Thêm">
				<br><br>
				<a href="<?php echo url("/") ?>/admin/lands/list"><input type="button" style="width: 200px; margin-left: 400px" class="btn btn-primary"  value="Quay Về"></a>
			</fieldset>
		</form>
	</div>
	<div class="col-md-2"></div>
</div>
</div><!--/Repaly Box-->
<script> CKEDITOR.replace( 'description',
{
	filebrowserBrowseUrl: baseURL + 'public/ckeditor/ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl: baseURL + 'public/ckeditor/ckfinder/ckfinder.html?type=Images',
}); </script>
<script> CKEDITOR.replace( 'description_1',
{
	filebrowserBrowseUrl: baseURL + 'public/ckeditor/ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl: baseURL + 'public/ckeditor/ckfinder/ckfinder.html?type=Images',
}); </script>

@endsection()
