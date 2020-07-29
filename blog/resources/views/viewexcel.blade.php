<meta http-equiv="Content-Type" content="text/html; charset={{$method}}" />
<table>
    <thead  style="background: red;">
        <tr style="background: red;">
            <th>ID</th>
            <th>HK_CD</th>
            <th>Chủ hộ id</th>
            <th>Địa chỉ</th>
            <th>Ngày cấp</th>
            <th>Số thành viên</th>
        </tr>
    </thead>
    <tbody>
   @foreach ($loans as $loan)
        <tr>
            <td>{{$loan->id}}</td>
            <td>{{$loan->hk_cd}}</td>
            <td>{{$loan->chuho_id}}</td>
            <td>{{$loan->dia_chi}}</td>
            <td>{{date_format(date_create($loan->ngay_cap),'d-m-Y')}}</td>
            <td>{{$loan->id}}</td>
        </tr>
    @endforeach
    </tbody>
</table>