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
  	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
	@yield('css')

</head>
<body>
	
	<div>
		<div style="display: grid; grid-template-columns: 300px auto;">
			<div style="border-right: 1px solid #d3d3d3; height: 100vh;overflow: auto; position: sticky;top: 0;padding: 20px; background: #2aabd2;color: #FFF">
				<div class="avatar" style="text-align: center;">
					<div style="width: 100px; margin: auto;border-radius: 100%;overflow: hidden;border: 1px solid #fff;height: 100px;">
						@if(Auth::check())<img src="{{asset('/')}}images/images.png" style="width: 100%;"> @endif
						  		@if(Auth::guard('nhankhau')->check())
						  			<img src="{{asset('/')}}{{Auth::guard('nhankhau')->user()->images}}" style="width: 100%;">
						  		@endif
					</div>
				</div>
				<div class="slidebar">
					@if(Auth::check())
					<div class="slidebar-li">
						<i class="fa fa-home"></i>
						<div>
							<a href="/">Quản lý hộ khẩu</a>
						</div>
					</div>
					<div class="slidebar-li">
						<i class="fa fa-bed"></i>
						<div>
							<a href="/quan-ly-nhan-khau.html">Quản lý nhân khẩu</a>
						</div>
					</div>
					<div class="slidebar-li">
						<div>
							<a href="">Quản lý admin</a>
						</div>
					</div>
					<div class="slidebar-li">
						<i class="fa fa-users"></i>
						<div>
							<a href="">Quản lý user</a>
						</div>
					</div>
					@endif
					<div class="slidebar-li">
						<i class="fa fa-cog"></i>
						<div>
							<a href="">Thông tin tài khoản</a>
						</div>
					</div>
					
					<div class="slidebar-li">
						<i class="fa fa-sign-out"></i>
						<div>
							<a href="{{asset('/')}}logout">Đăng xuất</a>
						</div>
					</div>
					
				</div>
			</div>
			<div style="padding:  0 20px;">
				@yield('main')
			</div>
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
		
		var url = '';
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