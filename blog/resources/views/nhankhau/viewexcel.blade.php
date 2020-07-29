<meta http-equiv="Content-Type" content="text/html; charset={{$method}}" />
<table>
    <thead  style="background: red;">
        <tr style="background: red;">
            <th>ID</th>
            <th>Họ tên</th>
            <th>Hình ảnh</th>
            <th>Ngày sinh</th>
            <th>Ngày mất</th>
            <th>Giới tính</th>
            <th>Quan hệ</th>
            <th>
                Email
            </th>
            <th>
                SDT
            </th>
            <th>Ngày nhập khẩu</th>
        </tr>
    </thead>
    <tbody>
   @foreach ($loans as $loan)
        <tr>
            <td>{{$loan->id}}</td>
            <td>{{$loan->ho_ten}}</td>
            <td>{{$loan->images}}</td>
            <td>{{date_format(date_create($loan->ngay_sinh),'d-m-Y')}}</td>
            <td>{{date_format(date_create($loan->ngay_mat),'d-m-Y')}}</td>
            <td>{{$loan->gioi_tinh}}</td>
            <td>{{$loan->quan_he}}</td>
            <td>{{$loan->email}}</td>
            <td>{{$loan->sdt}}</td>
            <td>{{date_format(date_create($loan->ngay_nhap_khau),'d-m-Y')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>