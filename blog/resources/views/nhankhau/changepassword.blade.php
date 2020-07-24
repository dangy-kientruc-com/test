@extends('master')
@section('main')
	<div>
		<h2>
			Đổi mật khẩu
		</h2>
		<div>
			<form method="post">
				{{csrf_field()}}
				@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{Session::get('error')}}
				</div>
				@endif
				@if(Session::has('message'))
				<div class="alert alert-success">
					{{Session::get('message')}}
				</div>
				@endif
				<div style="width: 100%;max-width: 400px;margin: auto;margin-bottom: 10px;">
					<label>Mật khẩu cũ</label>
					<input type="password" name="oldpassword" class="form-control">
				</div>
				<div style="width: 100%;max-width: 400px;margin: auto;margin-bottom: 10px;">
					<label>Mật khẩu mới</label>
					<input type="password" name="newpassword" class="form-control">
				</div>
				<div style="width: 100%;max-width: 400px;margin: auto;margin-bottom: 10px;">
					<label>Nhập lại mật khẩu</label>
					<input type="password" name="repassword" class="form-control">
				</div>
				<div style="width: 100%;max-width: 400px;margin: auto;margin-bottom: 10px;">
					<button class="btn btn-primary">Gửi</button>
				</div>
			</form>
		</div>
	</div>
@endsection