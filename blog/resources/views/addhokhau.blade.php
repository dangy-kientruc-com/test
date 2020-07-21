@extends('master')
@section('main')

<div>
	<h2>
		Quản lý hộ khẩu và nhân khẩu
	</h2>
	<div style="display: flex;justify-content: space-between;align-items: center;">
		<div><h3>Thêm hộ khẩu</h3></div>
		<div>
			<button id="comeback" class="btn btn-primary">Quay lại</button>
		</div>
		
	</div>
	<div>
		<form method="post">
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
			<div class="col-ld-6 col-md-6 col-xs-12 mt50">
				<label>Hộ khẩu công dân</label>
				<input type="text" name="hk_cd" class="form-control" value="{{old('hk_cd')}}">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Chủ hộ ID</label>
				<select class="form-control" name="chuho_id">
					<option value="">Chọn Chủ hộ</option>
					<option value="1"> Chủ hộ 1</option>
					<option value="2"> Chủ hộ 2</option>
				</select>
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Địa chỉ</label>
				<input type="text" name="dia_chi" class="form-control" value="{{old('dia_chi')}}">
			</div>
			<div class="col-ld-6 col-md-6 col-xs-12">
				<label>Ngày cấp</label>
				<input id="datepicker" type="text" name="ngay_cap" class="form-control" value="{{old('ngay_cap')}}">
			</div>
			<div class="col-xs-12 " style="margin-top: 10px;">
				<button class="btn btn-primary" type="submit">Thêm</button>
			</div>
		</form>
	</div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$( function() {
    $( "#datepicker" ).datepicker({dateFormat:'yy/mm/dd'});
 } );
	$('#comeback').click(function(e){
		history.back();
	})
</script>
@endsection