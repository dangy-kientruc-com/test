<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" i>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
</head>
<body>
	<div class="main">

		<div class="form-login">
			<h3>Đăng nhập</h3>
			@if(Session::has('message'))
			<div class="alert alert-danger">
				{{Session::get('message')}}
			</div>
			@endif
			<form method="post">
				{{ csrf_field() }}
				<div>
					<label>User name hoặc email</label>
					<input type="text" name="username" class="form-control" placeholder="username hoặc email của bạn">
				</div>
				<div style="margin-top: 10px;">
					<label>Mật phẩu</label>
					<input type="password" name="password" class="form-control" placeholder="Mật khẩu của bạn">
				</div>
				<div style="margin-top: 10px;">
					<button class="btn btn-primary">Đăng nhập</button>
				</div>
			</form>
		</div>
	</div>
	<style>
		.main
		{
			width: 100%;height: 100%;
			background: #d5d5d5;
		}
		.form-login
		{
			margin:auto;
			margin-top: 50px;
			width: 500px;padding: 20px;
			border-radius: 4px;
			background: #FFF;
			box-shadow: 3px 3px 3px  rgba(0,0,0,0.5);
		}
		body
		{
			background: #d5d5d5;
		}
		.form-login form
		{
			margin-top: 10px;
		}
	</style>
</body>
</html>