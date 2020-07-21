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
				        </tr>
				    </thead>
				    <tbody>
				    	@foreach ( $hk as $key => $value)
				        <tr>
				            <td>{{$value->id}}</td>
				            <td>{{$value->hk_cd}}</td>
				            <td>{{$value->chuho_id}}</td>
				            <td>{{$value->dia_chi}}</td>
				            <td>{{$value->ngay_cap}}</td>
				        </tr>
				       	@endforeach
				    </tbody>
				</table>
			</div>
		</div>
	</div>
	<script>
		$(document).ready( function () {
		    $('#table_id').DataTable();
		} );
	</script>
</body>
</html>