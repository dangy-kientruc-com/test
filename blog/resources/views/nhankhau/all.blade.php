@extends('master')
@section('main')
	<div style="margin-top: 20px;">
		<div><h2>Danh sách nhân khẩu</h2></div>
		<div>
			<form method="get">
				<div style="display: grid;grid-template-columns: 70% auto; grid-gap: 10px;">
					<div>
						<input type="" name="s" class="form-control" placeholder="Nhập tên nhân khẩu cần tìm">
					</div>
					<div>
						<button class="btn btn-info">Tìm kiếm</button>
					</div>
				</div>
			</form>
		</div>
		<div style="border:1px solid #d3d3d3;margin-top: 10px;padding: 15px;border-radius: 4px;">
			<div class="body-show" style="display: grid;grid-template-columns: 50px auto 100px 100px 100px 100px 200px 200px 100px;background-color: #2aabd2">
				<div>ID</div>
				<div>Họ tên</div>
				<div>Hình ảnh</div>
				<div>Ngày sinh</div>
				<div>Ngày mất</div>
				<div>Giới tính</div>
				<div>Email</div>
				<div>SDT</div>
				<div>Ngày nhập khẩu</div>
			</div>
			<div class="body-show">
				@foreach ($nk as $key=>$value)
				<div class="show-li">
					<div>{{$value->id}}</div>
					<div>{{$value->ho_ten}}</div>
					<div><img src="{{asset('/')}}{{$value->images}}" style="width: 50px;"></div>
					<div>{{date_format(date_create($value->ngay_sinh),'d-m-Y')}}</div>
					<div>@if ($value->ngay_mat !="") {{date_format(date_create($value->ngay_mat),'d-m-Y')}} @endif</div>
					<div>@if($value->gioi_tinh == 1) {{'Nam'}} @else {{'Nữ'}}  @endif</div>
					<div>{{$value->email}}</div>
					<div>{{$value->sdt}}</div>
					<div>{{date_format(date_create($value->ngay_nhap_khau),'d-m-Y')}}</div>
				</div>
				@endforeach
			</div>
			<div>
				{{$nk->links()}}
			</div>
		</div>
	</div>
	<style>
		.show-li
		{
			display: grid;grid-template-columns: 50px auto 100px 100px 100px 100px 200px 200px 100px;
		}
		.show-li:nth-child(2n)
		{
			background: #f3f3f3;
		}
		.body-show div
		{
			padding: 5px;
		}
	</style>
@endsection