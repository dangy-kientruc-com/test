<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	@include('layouts.header')
	<div>
		<div class="container">
			@yield('main')
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
	<style>
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
		var url = '';
		$('.delete').click(function(e){
			url = $(this).attr('href');
			$('#xacnhan').click(function(){
				window.location.href = url;
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