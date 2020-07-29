<table id="list">
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
		        </tr>
		       	@endforeach
		    </tbody>
</table>
<script>
	$(document).ready( function () {
		    $('#list').DataTable();
		} );
</script>