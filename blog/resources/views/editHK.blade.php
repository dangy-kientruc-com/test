
@extends('master')
@section('main')
	<div>
		<div class="container">
			<h2>
				Quản lý hộ khẩu và nhân khẩu
			</h2>
			<div style="display: flex;justify-content: space-between;align-items: center;">
				<div><h3>Sữa hộ khẩu</h3></div>
				<div>
					
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
						<label>HK_CD</label>
						<input type="text" name="hk_cd" class="form-control" value="{{$hk->hk_cd}}">
					</div>
					<div class="col-ld-6 col-md-6 col-xs-12">
						<label>Chủ hộ ID</label>
						<select class="form-control" name="chuho_id">
							@foreach($nk as $key =>$value)
								<option value="{{$value->id}}" <?php if($hk->chuho_id == $value->id) echo 'selected'; ?> >{{$value->ho_ten}} </option>
							@endforeach
						</select>
					</div>
					<div class="col-ld-6 col-md-6 col-xs-12">
						<label>Địa chỉ</label>
						<input type="text" name="dia_chi" class="form-control" value="{{$hk->dia_chi}}">
					</div>
					<div class="col-ld-6 col-md-6 col-xs-12">
						<label>Ngày cấp</label>
						<input type="text" id="datepicker" name="ngay_cap" class="form-control" value="<?php $date = date_create($hk->ngay_cap); echo date_format($date,'Y-m-d'); ?>">
					</div>
					<div class="col-xs-12 " style="margin-top: 10px;">
						<button class="btn btn-primary" type="submit">Cập nhật</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="fixed-tb" style="position: fixed;top: 50%;left: 50%;width: 300px;background: #FFF;border:1px solid #d3d3d3;padding: 20px;border-radius: 4px;transform: translate3d(-50%,-50%,0);display: none;">
		<div>Bạn có chắc thực hiện chức năng này</div>
		<hr>
		<div>
			<button class="btn btn-success" id="xacnhan">Xác nhận</button>
			<button class="btn btn-danger" id="huy">Hủy</button>
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