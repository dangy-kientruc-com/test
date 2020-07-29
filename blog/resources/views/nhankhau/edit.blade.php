@extends('master')
@section('main')
<div>
	<h2>
		Quản lý nhân khâu của hộ khẩu {{$id}}
	</h2>
	<div style="display: flex;justify-content: space-between;align-items: center;">
		<div><h3>Sửa nhân khẩu</h3></div>
		<div>
			<button id="comeback" class="btn btn-primary">Quay lại</button>
		</div>
	</div>
	<div>
		<form method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
			@if(Session::has('error'))
			<div class="alert alert-danger">
				{{Session::get('error')}}
			</div>
			@endif
			<div class="col-xs-12">
				<div style="height: 100px;width: 100px;border:1px dashed #d3d3d3; position: relative;padding: 5px;">
					<input type="file" name="fileimg" style="position: absolute;width: 100%;height: 100%;opacity: 0;z-index: 1;" id="imgInp">
					<img src="{{asset('/')}}{{$nk->images}}" id="blah" style="width: 100%;">
					<input type="hidden"  name="imgbase64" value="{{old('imgbase64')}}">
				</div>
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12 mt50">
				<label>Họ tên</label>
				<input type="text" name="ho_ten" class="form-control" value="{{$nk->ho_ten}}">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Ngày sinh</label>
				<input type="text" name="ngay_sinh" id="ngay_sinh" class="form-control" value="{{date_format(date_create($nk->ngay_sinh),'Y/m/d')}}"  style="background: #FFF;">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Ngày_mất</label>
				<input type="text" name="ngay_mat" id="ngay_mat" class="form-control" value="@if($nk->ngay_mat!=null){{date_format(date_create($nk->ngay_mat),'Y/m/d')}} @endif"  style="background: #FFF;">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Giới tính</label>
				<select class="form-control" name="gioi_tinh">
					<option value="1"  @if($nk->gioi_tinh == 1) {{'seletect'}} @endif>Nam</option>
					<option value="2" @if($nk->gioi_tinh == 2) {{'seletect'}} @endif>Nữ</option>
				</select>
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Quan hệ với chủ hộ</label>
				<input type="text" name="quan_he" class="form-control" value="{{$nk->quan_he}}">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>email</label>
				<input type="text" name="email" class="form-control" value="{{$nk->email}}">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Số diện thoại</label>
				<input type="text" name="sdt" class="form-control" value="{{$nk->sdt}}">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Ngày nhập khẩu</label>
				<input type="text" name="ngay_nhap_khau" id="ngay_nhap_khau" class="form-control" value="{{date_format(date_create($nk->ngay_nhap_khau),'Y/m/d')}}"  style="background: #FFF;">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Tài khoản</label>
				<div class="form-control">
					{{$nk->user}}
				</div>
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Mật khẩu</label>
				<input type="password" name="password" class="form-control">
			</div>
			<div class="col-xs-12 " style="margin-top: 10px;">
				<button class="btn btn-primary" type="submit">Cập nhật</button>
			</div>
		</form>
	</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$( function() {
	    $( "#ngay_sinh" ).datepicker({dateFormat:'yy/mm/dd'});
	    $( "#ngay_mat" ).datepicker({dateFormat:'yy/mm/dd'});
	    $( "#ngay_nhap_khau").datepicker({dateFormat:'yy/mm/dd'});
 	} );
	$('#comeback').click(function(e){
		history.back();
	});
	function readURL(input) {
		  if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    
		    reader.onload = function(e) {
		      $('#blah').attr('src', e.target.result);
		       $('input[name="imgbase64"]').val(e.target.result);
		    }
		    
		    reader.readAsDataURL(input.files[0]); // convert to base64 string
		  }
		}

		$("#imgInp").change(function() {
		  readURL(this);
	});
</script>
@endsection