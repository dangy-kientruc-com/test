<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/index.css')}}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" i>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
</head>
<body>
	@include('layouts.header')
	<div>
		<div class="container">
			<h2>
				Quản lý hộ khẩu và nhân khẩu
			</h2>
			<div style="display: flex;justify-content: space-between;align-items: center;">
				<div><h3>Danh sách hộ khẩu</h3></div>
				<div>
					<button class="btn btn-info" id="show-popup" data-url="{{asset('/')}}ho-khau/export">Show poup</button>
					<a href="them-ho-khau.html"><button class="btn btn-primary">Thêm hộ khẩu</button></a>
				</div>
			</div>
			<div>
				<table id="table_id" class="display">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>HK_CD</th>
				            <th>Chủ hộ id</th>
				            <th>Địa chỉ</th>
				            <th>Ngày Cấp</th>
				             <th>Số thành viên</th>
				            <th>Hoạt động</th>

				        </tr>
				    </thead>
				    <tbody>
				    	@foreach ( $hk as $key => $value)
				        <tr>
				            <td>{{$value->id}}</td>
				            <td><a href="/nhan-khau/{{$value->id}}">[xem]</a></td>
				            <td>{{$value->chuho_id}}</td>
				            <td>{{$value->dia_chi}}</td>
				            <td><?php $date = date_create($value->ngay_cap); echo date_format($date,'d/m/Y'); ?></td>
				            <td> <?php  echo DB::table('nhankhau')->where('hokhau_id',$value->id)->count(); ?> thành viên <button class="btn click-list" data-url="{{asset('/')}}danh-sach-nhan-khau/{{$value->id}}">[xem tv]</button></td>
				            <td>
				            	<a href="xoa-ho-khau/{{$value->id}}" class="delete"><button class="btn btn-danger">Xóa</button></a>
				            	<a href="sua-ho-khau/{{$value->id}}"><button class="btn btn-primary">Edit</button></a>
				            	<a href="nhan-khau/them-nhan-khau/{{$value->id}}"><button class="btn ">Thêm NK</button></a>
				            </td>
				        </tr>
				       	@endforeach
				    </tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="show-list" style="display: none;">
		 <div class="container">
		 	<div>
		 		<h3>Danh sách có trong hộ khẩu</h3>
		 	</div>
		 	<div class="DS"></div>
		 </div>
	</div>
	<div class="fixed-tb fadeIn" style="position: fixed;top: 50%;left: 50%;width: 300px;background: #FFF;border:1px solid #d3d3d3;padding: 20px;border-radius: 4px;transform: translate3d(-50%,-50%,0);display: none;">
		<div>Bạn có chắc thực hiện chức năng này</div>
		<hr>
		<div>
			<button class="btn btn-success" id="xacnhan">Xác nhận</button>
			<button class="btn btn-danger" id="huy">Hủy</button>
		</div>
	</div>

	<div class="popup-excel fadeIn" style="position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.8);display: none;z-index: 111">
			<div style="width: 600px;background: #FFF;padding: 10px;margin: auto;margin-top: 100px;position: relative;border-radius: 4px;">
				<div class="close-popup-excel" style="width: 30px;height: 30px;border-radius: 100%;background: #FFF;position: absolute;top: -40px;right: -40px;display: flex;align-items: center;justify-content: center;">X</div>
				<div style="border-bottom: 1px solid #d3d3d3;"><h3>Danh sách hộ khẩu</h3></div>
				<div>
					<div style="display: grid;grid-template-columns: repeat(7,1fr);font-size:18px;font-weight: bold;margin: 10px 0;">
						<div>
							id
						</div>
						<div>HK_CD</div>
						<div>Chủ hộ</div>
						<div>Địa chỉ</div>
						<div>Ngày cấp</div>
						<div>Số lượng</div>
					</div>
					<div class="PP">
						@foreach ( $hk as $key => $value)
						<div class="PC" style="display: grid;grid-template-columns: repeat(7,1fr);">
							<div>{{$value->id}}</div>
							<div>{{$value->hk_cd}}</div>
							<div>{{$value->chuho_id}}</div>
							<div>{{$value->dia_chi}}</div>
							<div>{{date_format(date_create($value->ngay_cap),'d-m-Y')}}</div>
							<div><?php  echo DB::table('nhankhau')->where('hokhau_id',$value->id)->count(); ?> thành viên</div>
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
						<div><button class="btn btn-info" id="Download" data-url="{{asset('/')}}ho-khau/export">Download</button></div>
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
		.fadeIn
		{
			animation: fadeIn 0.1s linear 1;
		}
		@keyframes fadeIn
		{
			0%
			{
				opacity: 0;
			}
			100%
			{
				opacity: 1;
			}
		}
	</style>
	<script>
		$(document).ready( function () {
		    $('#table_id').DataTable();
		} );
		$('.delete').click(function(e){
			var _this= $(this);
			$('#xacnhan').click(function(){
				window.location.href = $(_this).attr('href');
			});
			$('.fixed-tb').css('display','block');
			e.preventDefault();

		});
		
		$('#huy').click(function(){
				$('.fixed-tb').css('display','none');
		});
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
		});
		$('.click-list').click(function(){
			$('.show-list .DS').html('');
			
			var url = $(this).attr('data-url');
			$.ajax({
				url:url,

			}).done(function(data){

				$('.show-list .DS').html(data);
				$('.show-list').css('display','block');
			});
		})
	</script>
</body>
</html>