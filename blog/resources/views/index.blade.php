<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/index.css')}}">
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
	<header></header>
	<div>
		<div class="container">
			<h2>
				Quản lý hộ khẩu và nhân khẩu
			</h2>
			<div style="display: flex;justify-content: space-between;align-items: center;">
				<div><h3>Danh sách hộ khẩu</h3></div>
				<div>
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
				            <td>{{$value->hk_cd}}</td>
				            <td>{{$value->chuho_id}}</td>
				            <td>{{$value->dia_chi}}</td>
				            <td><?php $date = date_create($value->ngay_cap); echo date_format($date,'d/m/Y'); ?></td>
				            <td>1</td>
				            <td>
				            	<a href="xoa-ho-khau/{{$value->id}}" class="delete"><button class="btn btn-danger">Xóa</button></a>
				            	<a href="sua-ho-khau/{{$value->id}}"><button class="btn btn-primary">Edit</button></a>
				            	<button class="btn ">Thêm NK</button>
				            </td>
				        </tr>
				       	@endforeach
				    </tbody>
				</table>
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
	</script>
</body>
</html>