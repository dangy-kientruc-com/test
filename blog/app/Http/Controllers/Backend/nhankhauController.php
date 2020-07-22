<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\ExcelNhanKhau as Export2;
class nhankhauController extends Controller
{
    public function index($id)
    {
    	$nk = DB::table('nhankhau')->select('*')->where('hokhau_id',$id)->get();
    	return view('nhankhau.index',['id'=>$id,'nk'=>$nk]);
    }
    public function getAdd($id)
    {
    	return view('nhankhau.add',['id'=>$id]);
    }
    public function postAdd($id,Request $rq)
    {
    	$validate= $rq->validate([
   			'ho_ten'=>'required',
   			'ngay_sinh'=>'required|date_format:Y/m/d',
   			'quan_he'=>'required',
   			'email'=>'required|email',
   			'sdt'=>'required',
   			'ngay_nhap_khau'=>'required|date_format:Y/m/d',
            'fileimg'=>'mimes:png,jpg,jpeg,gif'

   		],
   		[
   			'ho_ten.required'=>'Họ tên  công dân không được để trống',
   			'ngay_sinh.required' =>'Ngày sinh không được để trống',
   			'quan_he.required' =>'Ngày cấp không được để trống',
   			'email.required'=>'Email không được để trống',
   			'email.email'=>'Bạn phải nhập email',
   			'sdt.required'=>'Số điện thoại không được để trống',
   			'ngay_nhap_khau.required'=>'Ngày nhập khẩu không được để trống',
   			'ngay_sinh.date_format'=>'Nhày sinh nhập đúng kiểu Năm/ tháng / ngày (1900/02/02)',
   			'ngay_nhap_khau.date_format' =>'Nhày nhập khẩu nhập đúng kiểu Năm/ tháng / ngày (1900/02/02)',
            'fileimg.mimes' =>'File không đúng định dạng png, jpg, jpeg,gif'

   		]);
       
   		try {
             if ($rq->hasFile('fileimg')) {
           
                $file = $rq->fileimg;
               
                
                $namefile = 'hom-nay-up-hinh-'.time().'.jpg';
                Storage::putFileAs('avatars', $file,$namefile);
                $url = 'upload/avatars/'.$namefile;
            }
   			$date_ngaysinh = date_format(date_create($rq->ngay_sinh),'Y-m-d H:i:s');
   			$date_ngaynhapkhau = date_format(date_create($rq->ngay_nhap_khau),'Y-m-d H:i:s');
   			if($rq->ngay_mat!="")
   			{
   				$date_ngaymat = date_format(date_create($rq->ngay_mat),'Y-m-d H:i:s');
   				DB::table('nhankhau')->insert(['ho_ten'=>$rq->ho_ten,'ngay_sinh'=>$date_ngaysinh,'ngay_mat'=>$date_ngaymat,'gioi_tinh'=>$rq->gioi_tinh,'quan_he'=>$rq->quan_he,'email'=>$rq->email,'sdt'=>$rq->sdt,'ngay_nhap_khau'=>$date_ngaynhapkhau,'hokhau_id'=>$id,'images'=>$url]);
   			}
   			else
   			{
   				$date_ngaymat = "";
   				DB::table('nhankhau')->insert(['ho_ten'=>$rq->ho_ten,'ngay_sinh'=>$date_ngaysinh,'ngay_mat'=>null,'gioi_tinh'=>$rq->gioi_tinh,'quan_he'=>$rq->quan_he,'email'=>$rq->email,'sdt'=>$rq->sdt,'ngay_nhap_khau'=>$date_ngaynhapkhau,'hokhau_id'=>$id,'images'=>$url]);
   			}
   			
   			
           
        } catch (UserException $exception) {
           return 1;
        }
        return redirect()->route('nhankhau',$id);
    }
    public function delete($id,$id_hk)
    {	
    	DB::table('nhankhau')->where('id',$id)->delete();
    	 return redirect()->route('nhankhau',$id_hk)->with('message','Xóa nhân khẩu thành công');
    }
    public function getEdit($id,$id_hk)
    {
        $nk = DB::table('nhankhau')->select('*')->where('id',$id)->first();
        return view('nhankhau.edit',['id'=>$id,'nk'=>$nk]);
    }
    public function postEdit($id,$id_hk,Request $rq)
    {    $validate= $rq->validate([
                'ho_ten'=>'required',
                'ngay_sinh'=>'required|date_format:Y/m/d',
                'quan_he'=>'required',
                'email'=>'required|email',
                'sdt'=>'required',
                'ngay_nhap_khau'=>'required|date_format:Y/m/d',
                'fileimg'=>'mimes:png,jpg,jpeg,gif'

            ],
            [
                'ho_ten.required'=>'Họ tên công dân không được để trống',
                'ngay_sinh.required' =>'Ngày sinh không được để trống',
                'quan_he.required' =>'Ngày cấp không được để trống',
                'email.required'=>'Email không được để trống',
                'email.email'=>'Bạn phải nhập email',
                'sdt.required'=>'Số điện thoại không được để trống',
                'ngay_nhap_khau.required'=>'Ngày nhập khẩu không được để trống',
                'ngay_sinh.date_format'=>'Nhày sinh nhập đúng kiểu Năm/ tháng / ngày (1900/02/02)',
                'ngay_nhap_khau.date_format' =>'Nhày nhập khẩu nhập đúng kiểu Năm/ tháng / ngày (1900/02/02)',
                'fileimg.mimes' =>'File không đúng định dạng png, jpg, jpeg,gif'

            ]);
        if($rq->hasFile('fileimg'))
        {
            $validate = $rq->validate([
                'fileimg'=>'mimes:png,jpg,jpeg,gif',
            ],
            [
                'fileimg.mimes'=>'File không đúng định dạng png, jpg, jpeg,gif',
            ]);
        }
        try {
            if ($rq->hasFile('fileimg')) {
                $file = $rq->fileimg;
               
                
                $namefile = 'hom-nay-up-hinh-'.time().'.jpg';
                Storage::putFileAs('avatars', $file,$namefile);
                $url = 'upload/avatars/'.$namefile;
                DB::table('nhankhau')->where('id',$id)->update(['images'=>$url]);
            }
            $date_ngaysinh = date_format(date_create($rq->ngay_sinh),'Y-m-d H:i:s');
            $date_ngaynhapkhau = date_format(date_create($rq->ngay_nhap_khau),'Y-m-d H:i:s');
            if($rq->ngay_mat!="")
            {
                $date_ngaymat = date_format(date_create($rq->ngay_mat),'Y-m-d H:i:s');
                
            }
            else
            {
                $date_ngaymat = null;
            }
            
            DB::table('nhankhau')->where('id',$id)->update([
                'ho_ten' =>$rq->ho_ten,
                'ngay_sinh' =>$date_ngaysinh,
                'ngay_mat' =>$date_ngaymat,
                'gioi_tinh' =>$rq->gioi_tinh,
                'quan_he'=>$rq->quan_he,
                'email' =>$rq->email,
                'sdt'=>$rq->sdt,
                'ngay_sinh' =>$date_ngaynhapkhau,
            ]);

           
        } catch (UserException $exception) {
           return 1;
        }
        return redirect()->route('nhankhau',$id_hk)->with('message','Cập nhật thành công');
    }
    public function export2(Request $rq,$id)
    {
        return Excel::download(new Export2($rq->charset,$id) ,'nhankhau.csv');
    }
    public function ajaxIndex($id){
        $nk=DB::table('nhankhau')->select('*')->where('hokhau_id',$id)->get();
        return view('nhankhau.ajaxIndex',['nk'=>$nk]);
    }
}
