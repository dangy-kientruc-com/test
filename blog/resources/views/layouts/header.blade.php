<header>
	<div class="container">
		<div class="list">
			<div class="h_menu">
				@if(Auth::check())
				<a href="/" style="color:{{Request::is('/')? 'red':''}}">Quản lý hộ khẩu</a>
				<a href="/quan-ly-nhan-khau.html" style="color:{{Request::is('quan-ly-nhan-khau.html')? 'red':''}}"> quản lý nhân khẩu</a>
				
					@else
					Chào mừng bạn đến với chương trình quản lý nhân khẩu
					
				@endif
			</div>
			<div>
				<div class="dropdown show ">
					<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<div style="display: flex;align-items: center;">
						  	<div style="margin-right: 10px;"> @if(Auth::check()) {{Auth::user()->name}} @endif</div>
						  	<div style="width: 50px;height: 50px;overflow: hidden;border-radius: 100%;">
						  		@if(Auth::check())<img src="{{asset('/')}}images/images.png" style="width: 100%;"> @endif
						  		@if(Auth::guard('nhankhau')->check())
						  			<img src="{{asset('/')}}{{Auth::guard('nhankhau')->user()->images}}" style="width: 100%;">
						  		@endif
						  	</div>
						</div>
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
						<div style="padding: 10px;">
					    	<a class="dropdown-item" href="/nhan-khau/doi-mat-khau">Thông tin cá nhân</a>
					    </div>
					   	<div style="padding: 10px;">
					    	<a class="dropdown-item" href="/nhan-khau/doi-mat-khau">Đổi mật khẩu</a>
					    </div>
					    
					    <div style="padding: 10px;">
					    	<a class="dropdown-item" href="/logout">Logout</a>
					    </div>
					 </div>
				</div>
			</div>
		</div>
	</div>
</header>
<style>
	header
	{
		position: sticky;
		height: 60px;border-bottom: 1px solid #d3d3d3;
		top: 0;background: #FFF;z-index: 100;
	}
	header .list
	{
		height: 60px;
		display: flex;align-items: center;justify-content: space-between;
	}
	.h_menu
	{
		display: flex;align-items: center;
	}
	.h_menu a 
	{
		margin-right: 20px;
		color: #5d5d5d;
	}
</style>