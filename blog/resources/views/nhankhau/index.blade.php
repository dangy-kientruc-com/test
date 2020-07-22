@extends('master')
@section('main')
<div>
	<h2>
		Quản lý nhân khâu của hộ khẩu {{$id}}
	</h2>
	<div style="display: flex;justify-content: space-between;align-items: center;">
		<div><h3>Danh sách thành viên có trong hộ khẩu</h3></div>
		<div>
			<button class="btn btn-info" id="show-popup"> Show popup</button>
			<a href="them-nhan-khau/{{$id}}"><button class="btn btn-primary">Thêm nhân khẩu</button></a>
		</div>
	</div>
	@if(Session::has('message'))
	<div class="alert alert-success">
		{{Session::get('message')}}
	</div>
	@endif
	
	<div>
		<table id="table_id" class="display">
		    <thead>
		        <tr>
		            <th>ID</th>
		            <th>Họ tên</th>
		            <th>Hình ảnh</th>
		            <th>Ngày sinh</th>
		            <th>Ngày mất</th>
		            <th>Giới tính</th>
		            <th>Quan hệ</th>
		            <th>Email</th>
		            <th>SDT</th>
		            <th>Ngày nhập khẩu</th>
		            <th></th>
		        </tr>
		    </thead>
		    <tbody>
		    	@foreach ($nk as $key =>$value)
		        <tr>
		            <td>{{$value->id}}</td>
		            <td>{{$value->ho_ten}}</td>
		            <td style="width: 50px;">
		            	<img src="{{asset('/').$value->images}}" style="width: 100%;">
		            </td>
		            <td>{{date_format(date_create($value->ngay_sinh),'d-m-Y')}}</td>
		            <td> @if ($value->ngay_mat !="") {{date_format(date_create($value->ngay_mat),'d-m-Y')}} @endif</td>
		            <td>@if($value->gioi_tinh == 1 ) {{ 'Nam'}} @else {{'Nữ'}} @endelse @endif</td>
		            <td>{{$value->quan_he}}</td>
		            <td>{{$value->email}}</td>
		            <td>{{$value->sdt}}</td>
		            <td>{{date_format(date_create($value->ngay_nhap_khau),'d-m-Y')}}</td>
		            <td>
		            	<a href="xoa-nhan-khau/{{$value->id}}-{{$value->hokhau_id}}" class="delete"><button class="btn btn-danger">Xóa</button></a>
		            	<a href="sua-nhan-khau/{{$value->id}}-{{$value->hokhau_id}}"><button class="btn btn-primary">Edit</button></a>
		            </td>
		        </tr>
		       	@endforeach
		    </tbody>
		</table>
	</div>
</div>
<div class="popup-excel" style="position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.8);display: none;">
			<div style="width: 1200px;background: #FFF;padding: 10px;margin: auto;margin-top: 100px;position: relative;border-radius: 4px;">
				<div class="close-popup-excel" style="width: 30px;height: 30px;border-radius: 100%;background: #FFF;position: absolute;top: -40px;right: -40px;display: flex;align-items: center;justify-content: center;">X</div>
				<div style="border-bottom: 1px solid #d3d3d3;"><h3>Danh sách hộ khẩu</h3></div>
				<div>
					<div style="display: grid;grid-template-columns: 100px auto 100px 100px 100px 100px 100px 200px 100px 100px;grid-gap: 5px;font-size:14px;font-weight: bold;margin: 10px 0;">
						<div>
							id
						</div>
						<div>Họ tên</div>
						<div>Hình ảnh</div>
						<div>Ngày sinh</div>
						<div>Ngày mất</div>
						<div>Giới tính</div>
						<div>Quan hệ</div>
						<div>
							Email
						</div>
						<div>
							SDT
						</div>
						<div>Ngày NK</div>
					</div>
					<div class="PP">
						@foreach ($nk as $key =>$value)
						<div class="PC" style="display: grid;grid-template-columns: 100px auto 100px 100px 100px 100px 100px 200px 100px 100px;grid-gap: 5px;">
							<div>{{$value->id}}</div>
							<div>{{$value->ho_ten}}</div>
							<div><img src="{{asset('/').$value->images}}" style="width: 100%;max-width: 50px;"></div>
							<div>{{date_format(date_create($value->ngay_sinh),'d-m-Y')}}</div>
						
							<div> @if ($value->ngay_mat !="") {{date_format(date_create($value->ngay_mat),'d-m-Y')}} @endif</div>
							<div>@if($value->gioi_tinh == 1 ) {{ 'Nam'}} @else {{'Nữ'}} @endelse @endif</div>
							<div>{{$value->quan_he}}</div>
							<div>{{$value->email}}</div>
							<div>{{$value->sdt}}</div>
							<div>{{date_format(date_create($value->ngay_nhap_khau),'d-m-Y')}}</div>
							
						</div>
						@endforeach
					</div>
					<div style="border-top: 1px solid #d3d3d3;padding: 10px 0;margin-top: 10px;display: flex;align-items: center;justify-content: space-between;">
						<div style="display: flex;align-items: center;">
							<div>
								<input type="radio" name="charset" value="UTF-8" checked="">
								UTF-8
							</div>
							<div style="margin-left: 10px;">
								<input type="radio" name="charset" value="SHIFT-JIS">
								SHIFT-JIS
							</div>
						</div>
						<div><button class="btn btn-info" id="Download" data-url="{{asset('/')}}nhan-khau/export-{{$id}}">Download</button></div>
					</div>
				</div>
			</div>
	</div>
	<style>
		.PP .PC
		{
			padding: 5px 0;
		}
		.PP .PC:nth-child(2n)
		{
			background: #f3f3f3;
		}
	</style>
<script>
	$('#show-popup').click(function(){
			$('.popup-excel').css('display','block');
			//  var url =$(this).attr('data-url');
			//  console.log(url);
			// window.location.href=url;
		});
		$('.close-popup-excel').click(function(){
			$('.popup-excel').css('display','none');
		});
		$('#Download').click(function(){
			$(this).attr('disabled','disabled');
			console.log($('input[name="charset"]:checked').val());
			var url =$(this).attr('data-url');
			console.log(url);
			window.location.href=url+'?charset='+$('input[name="charset"]:checked').val();
		})
</script>
@endsection