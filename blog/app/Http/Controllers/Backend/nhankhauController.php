<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\ExcelNhanKhau as Export2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
class nhankhauController extends Controller
{
    function stripVN($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }
    public function getAll(Request $rq)
    {
        $nk = DB::table('nhankhau')->select('*');
        if($rq->s)
        {       
            $s = mb_strtolower($rq->s,'UTF-8');
            //$nk->where("ho_ten",'like','%'.$rq->s.'%');
            $nk->whereRaw("LOWER(ho_ten) LIKE BINARY '%".htmlspecialchars($s)."%'");
        }
        $nk=$nk->paginate(2)->appends(request()->query());
       
        return view('nhankhau.all',['nk'=>$nk]);
    }
    public function index($id, Request $rq)
    {   
        $hk = DB::table('hokhau')->select('*')->where('id',$id)->first();
        if(!$hk)
        {
            return view('layouts.404');
        }
        if(Auth::guard('nhankhau')->check())
        {
            if(Auth::guard('nhankhau')->user()->hokhau_id != $id)
            {
                return view('layouts.404');
            }
        }
    	$nk = DB::table('nhankhau')->select('*')->where('hokhau_id',$id);
        if($rq->s)
        {
            $s = mb_strtolower($rq->s,'UTF-8');
            $nk=$nk->whereRaw("LOWER(ho_ten) LIKE  '%".htmlspecialchars($s)."%'");
        }
        if($rq->sort!="")
        {
            $nk=$nk->orderBy('ho_ten',$rq->sort);
        }
        
        $nk=$nk->get();
    	return view('nhankhau.index',['id'=>$id,'nk'=>$nk]);
    }
    public function getAdd($id)
    {
        $hk = DB::table('hokhau')->select('*')->where('id',$id)->first();
        if(!$hk)
        {
            return view('layouts.404');
        }
    	return view('nhankhau.add',['id'=>$id]);
    }
    public function postAdd($id,Request $rq)
    {
    	$validate= $rq->validate([
   			'ho_ten'=>'required',
   			'ngay_sinh'=>'required|date_format:Y/m/d',
   			'quan_he'=>'required',
   			'email'=>'required|email',
   			// 'sdt'=>'required|regex:/^(\d+(,(0)[0-9]{3}[?-][0-9]{3}[?-][0-9]{3})?)/|not_regex:/[a-zA-Z]/|min:10|',
            'sdt'=>'required|regex:/(0)[0-9]{3}(-)?[0-9]{3}(-)?[0-9]{3}/|not_regex:/[a-zA-Z]/|min:10|max:12',
   			'ngay_nhap_khau'=>'required|date_format:Y/m/d',
            'fileimg'=>'mimes:png,jpg,jpeg,gif',
            'username'=>'required',
            'password' =>'required',
   		],
   		[
   			'ho_ten.required'=>'Họ tên  công dân không được để trống',
   			'ngay_sinh.required' =>'Ngày sinh không được để trống',
   			'quan_he.required' =>'Ngày cấp không được để trống',
   			'email.required'=>'Email không được để trống',
   			'email.email'=>'Bạn phải nhập email',
   			'sdt.required'=>'Số điện thoại không được để trống',
            'sdt.regex' =>'Nhập số điện thoại từ 0 - 9, phải có kí tự 0 đầu tiên, ví dụ : 0933363363,0933-363-363',
            'sdt.not_regex'=>'Không được nhập chữ',
            'sdt.min' =>'Số điện thoại phải có ít nhất 10 kí tự',
   			'ngay_nhap_khau.required'=>'Ngày nhập khẩu không được để trống',
   			'ngay_sinh.date_format'=>'Nhày sinh nhập đúng kiểu Năm/ tháng / ngày (1900/02/28)',
   			'ngay_nhap_khau.date_format' =>'Nhày nhập khẩu nhập đúng kiểu Năm/ tháng / ngày (1900/02/28)',
            'fileimg.mimes' =>'File không đúng định dạng png, jpg, jpeg,gif',
            'username.required' => 'Tài khoảng không được để trống',
            'password.required' =>'Mật khẩu không dược để trống',

   		]);
        $hk = DB::table('hokhau')->select('*')->where('id',$id)->first();
        if(!$hk)
        {
            return redirect()->route('error');
        }
   		try {

             if ($rq->imgbase64) {
           
                // $file = $rq->fileimg;
               
                
                // $namefile = 'hom-nay-up-hinh-'.time().'.jpg';
                // Storage::putFileAs('avatars', $file,$namefile);
                // $url = 'upload/avatars/'.$namefile;
                $image_64 = $rq->input('imgbase64');
                // @list($type, $file_data) = explode(';', $base64_image);
                // @list(, $file_data) = explode(',', $file_data);
                $base64_image = $rq->input('imgbase64');

                $image = $rq->imgbase64;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10).'.'.'png';
               
                Storage::put($imageName,base64_decode($image));
                $url = 'upload/avatars/'.$imageName;
                
            }
            else $url = '';
   			$date_ngaysinh = date_format(date_create($rq->ngay_sinh),'Y-m-d H:i:s');
   			$date_ngaynhapkhau = date_format(date_create($rq->ngay_nhap_khau),'Y-m-d H:i:s');


            //$username = str_replace(" ","",mb_strtolower(self::stripVN($rq->ho_ten)));
            
   			if($rq->ngay_mat!="")
   			{
   				$date_ngaymat = date_format(date_create($rq->ngay_mat),'Y-m-d H:i:s');
   				$idchuho=DB::table('nhankhau')->insertGetId(['ho_ten'=>htmlspecialchars($rq->ho_ten),'ngay_sinh'=>$date_ngaysinh,'ngay_mat'=>$date_ngaymat,'gioi_tinh'=>$rq->gioi_tinh,'quan_he'=>htmlspecialchars($rq->quan_he),'email'=>htmlspecialchars($rq->email),'sdt'=>htmlspecialchars($rq->sdt),'ngay_nhap_khau'=>$date_ngaynhapkhau,'hokhau_id'=>$id,'images'=>htmlspecialchars($url),'user'=>htmlspecialchars($rq->username),'password'=>htmlspecialchars(bcrypt($rq->password))]);
   			}
   			else
   			{
   				$date_ngaymat = "";
   				$idchuho=DB::table('nhankhau')->insertGetId(['ho_ten'=>htmlspecialchars($rq->ho_ten),'ngay_sinh'=>$date_ngaysinh,'ngay_mat'=>null,'gioi_tinh'=>$rq->gioi_tinh,'quan_he'=>htmlspecialchars($rq->quan_he),'email'=>htmlspecialchars($rq->email),'sdt'=>$rq->sdt,'ngay_nhap_khau'=>$date_ngaynhapkhau,'hokhau_id'=>$id,'images'=>htmlspecialchars($url),'user'=>htmlspecialchars($rq->username),'password'=>htmlspecialchars(bcrypt($rq->password))]);
   			}
   			$chuho = DB::table('hokhau')->where('id',$id)->where('chuho_id','<>',null)->first();
            if(!$chuho)
            {
                DB::table('hokhau')->where('id',$id)->update(['chuho_id'=>$idchuho]);
            }
   			
           
        } catch (UserException $exception) {
           return 1;
        }
        return redirect()->route('nhankhau',$id);
    }
    public function delete($id,$id_hk)
    {	
        $link = DB::table('nhankhau')->select('images')->where('id',$id)->first();
        $link = $link->images;
        if($link)
        {
            if (file_exists(storage_path('../public/'.$link))) 
            {
               unlink(storage_path('../public/'.$link));
            } 
            else 
            {
                       echo "The file does not exist";
                   }
            
        }
        
    	DB::table('nhankhau')->where('id',$id)->delete();
        $hk = DB::table('hokhau')->select('*')->where('chuho_id',$id)->first();
        if($hk)
        {
            DB::table('hokhau')->where('id',$id_hk)->update(['chuho_id'=>null]);    
        }
    	return redirect()->route('nhankhau',$id_hk)->with('message','Xóa nhân khẩu thành công');
    }
    public function getEdit($id,$id_hk)
    {
        $hk = DB::table('hokhau')->select('*')->where('id',$id_hk)->count();
        if($hk !=1)
        {
            return view('layouts.404');
        }
        $nk = DB::table('nhankhau')->select('*')->where('id',$id)->first();
        return view('nhankhau.edit',['id'=>$id,'nk'=>$nk]);
    }
    public function postEdit($id,$id_hk,Request $rq)
    {   

        $validate= $rq->validate([
                'ho_ten'=>'required',
                'ngay_sinh'=>'required|date_format:Y/m/d',
                'quan_he'=>'required',
                'email'=>'required|email',
                'sdt'=>'required',
                'ngay_nhap_khau'=>'required|date_format:Y/m/d',
                'fileimg'=>'mimes:png,jpg,jpeg,gif',
                

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
                'fileimg.mimes' =>'File không đúng định dạng png, jpg, jpeg,gif',


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
                Storage::putFileAs('', $file,$namefile);
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
            
            if($rq->password!="")
            {
                DB::table('nhankhau')->where('id',$id)->update(['password'=>htmlspecialchars($rq->password)]);
            }
            DB::table('nhankhau')->where('id',$id)->update([
                'ho_ten' =>htmlspecialchars($rq->ho_ten),
                'ngay_sinh' =>$date_ngaysinh,
                'ngay_mat' =>$date_ngaymat,
                'gioi_tinh' =>$rq->gioi_tinh,
                'quan_he'=>htmlspecialchars($rq->quan_he),
                'email' =>htmlspecialchars($rq->email),
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

        if(!$rq->id_hk)
        {
            return view('layouts.404');
        }
        $hk = DB::table('hokhau')->select('*')->where('id',$rq->id)->count();
        if($hk!=1)
        {
            return view('layouts.404');
        }
        if($rq->charset =='UTF-8')
        {
             return Excel::download(new Export2($rq->charset,$id) ,'nhankhau.csv');
        }
        else
        {   
            
            $download='test.csv';
            $array = DB::table('nhankhau')->select('*')->where('hokhau_id',$rq->id_hk)->get()->toArray();

           
            $output_array = array();
            $output_array[]= array('id','ho_ten','hinh_anh','ngay_sinh','ngay_mat','gioi_tinh','email','sdt','ngay_nhap_khau');
            foreach ($array as $key => $value) {
               $output_array[] = array("id" =>$value->id,'ho_ten'=>$value->ho_ten,'hinh_anh'=>$value->images,'ngay_sinh'=>$value->ngay_sinh,'ngay_mat'=>$value->ngay_mat,'gioi_tinh'=>$value->gioi_tinh,'email'=>$value->email,'sdt'=>$value->sdt,'ngay_nhap_khau'=> $value->ngay_nhap_khau);
            }
            
            header('Cache-Control: public');
            header('Pragma: public');
            header('Content-Type: application/octet-stream');
            header(sprintf("Content-Disposition: attachment;filename=".$download));
            header('Content-Transfer-Encoding: binary');

            $fp = fopen('php://temp', 'r+b');
            // foreach($array as $item){
            //     $repl = str_replace(array('"', "\n"), array('\"', '\n'), $item);
                foreach ($output_array as $row_array):
                    

                    $tmp_arr = str_replace(array('"', "\n"), array('\"', '\n'), $row_array);
                    fputcsv($fp, $tmp_arr);
                endforeach;
            // }
            rewind($fp);
            $temp = str_replace(PHP_EOL, "\r\n", stream_get_contents($fp));
            echo mb_convert_encoding($temp, 'SJIS', 'UTF-8');
            fclose($fp);
            exit;
        }
       
    }
    public function ajaxIndex($id){
        $nk=DB::table('nhankhau')->select('*')->where('hokhau_id',$id)->get();
        return view('nhankhau.ajaxIndex',['nk'=>$nk]);
    }
    public function getChangepassword()
    {
        return view('nhankhau.changepassword');
    }
    public function postChangepassword(Request $rq)
    {
        $validate =$rq->validate([
            'oldpassword' =>'required',
            'newpassword'=>'required',
            'repassword'=>'required|same:newpassword',
        ],[
            'oldpassword.required'=>'Mật khẩu cũ không được để trống',
            'newpassword.required'=>'Mật khẩu mới không được để trống',
            'repassword.required'=>'Vui lòng nhập lại mật khẩu mới',
            'repassword.same'=>'Nhập lại mật khẩu phải trùng với mật khẩu mới'

        ]);
        if(Auth::check())
        {
            if(Hash::check($rq->oldpassword,Auth::user()->password))
            {
                $new = User::find(Auth::user()->id);
                $new->password= Hash::make($rq->newpassword);
                $new->save();
                return redirect()->route('doimatkhau')->with('message','Đổi mật khẩu thành công');
            }
            else
            {
                return redirect()->route('doimatkhau')->with('error','Mật khẩu cũ không đúng');
            }
        }
        return 1;
    }
}
