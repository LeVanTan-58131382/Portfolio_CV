$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
}); // nếu không có đoạn này sẽ xảy ra lỗi 419
$(document).ready(function(){
	$('.qty').blur(function(){
		let rowid = $(this).data('id'); // id này là id của cái input quanty, có giá trị là rowId
		console.log("ok");
		$.ajax({
			url : 'cart/'+rowid, // cái rowid này mình sẽ chuyển sang controller
			// còn cái 'cart' phía trên là Route::resource('cart','CartController');
			type : 'put',
			dataType : 'json',
			data : {
				qty : $(this).val(),
			},
			success : function(data){
				if(data.error){
					toastr.error(data.error, 'Thông báo', {timeOut: 5000});
				}else{
					toastr.success(data.result, 'Thông báo', {timeOut: 5000});
					location.reload();
				}
			}
		});
	});
	
});
$(document).ready(function(){
  $(".text").focus(function(){
    $(this).css("background-color", "yellow");
  });
  $(".text").blur(function(){
    $(this).css("background-color", "green");
  });
 });