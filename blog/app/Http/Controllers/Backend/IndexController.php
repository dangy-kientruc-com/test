<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Excel as Export2;
use Illuminate\Support\Facades\Auth;
class IndexController extends Controller
{
    public function getError()
    {
        return view('index.truycap');
    }
    public function getLogin()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        if(Auth::guard('nhankhau')->check())
        {
            return redirect('/nhan-khau/'.Auth::guard('nhankhau')->user()->hokhau_id);
        }
        return view('index.login');
    }
    public function postLogin(Request $rq){
        if(Auth::attempt(['email'=>$rq->username,'password'=>$rq->password]))
        {
            return redirect('/');
        }
        else if(Auth::guard('nhankhau')->attempt(['user'=>$rq->username,'password'=>$rq->password]))
        {
            
           
            return redirect('/nhan-khau/'.Auth::guard('nhankhau')->user()->hokhau_id);
        }
        else
        {
            return redirect()->route('login')->with('message','Tài khoảng hoặc mật khẩu không đúng');
        }
    }
    public function getLogout()
    {
        Auth::logout();
        Auth::guard('nhankhau')->logout();
        return redirect()->route('login');
    }

   	public function index()
   	{	
       
   		$hk= DB::table('hokhau')->select('*')->get();
   		return view('index',['hk'=>$hk]);
   	}
   	public function getAddHokhau()
   	{
   		return view('addhokhau');
   	}
   	public function postAddHokhau(Request $rq)
   	{
   		$validate= $rq->validate([
   			'hk_cd'=>'required',
   			'dia_chi'=>'required',
   			'ngay_cap'=>'required|date_format:Y/m/d'
   		],
   		[
   			'hk_cd.required'=>'Hộ khẩu công dân không được để trống',
   			'dia_chi.required' =>'Địa chỉ không được để trống',
   			'ngay_cap.required' =>'Ngày cấp không được để trống',
            'ngay_cap.date_format' =>'Ngày cấp phải đúng định dạng Năm/Tháng/Ngày ex:2020/02/1995',
   		]);
   		try {
   			$date = date_create($rq->ngay_cap);

           DB::table('hokhau')->insert(['hk_cd'=>$rq->hk_cd,'chuho_id'=>null,'dia_chi'=>$rq->dia_chi,'ngay_cap'=>date_format($date,'Y-m-d H:i:s')]);
        } catch (UserException $exception) {
           return 1;
        }
   		return redirect()->route('hokhau');
   	}
   	public function getHokhau($id)
   	{	
   		$hk= DB::table('hokhau')->select('*')->where('id',$id)->first();
        $nk = DB::table('nhankhau')->select('*')->where('hokhau_id',$id)->get();
   		return view('editHK',['hk'=>$hk,'nk'=>$nk]);
   	}
   	public function setHokhau($id,Request $rq)
   	{
   		$validate= $rq->validate([
   			'hk_cd'=>'required',
   			'chuho_id'=>'required',
   			'dia_chi'=>'required',
   			'ngay_cap'=>'required'
   		],
   		[
   			'hk_cd.required'=>'Hộ khẩu công dân không được để trống',
   			'chuho_id.required' =>'Chọn id chủ hộ',
   			'dia_chi.required' =>'Địa chỉ không được để trống',
   			'ngay_cap.required' =>'Ngày cấp không được để trống'
   		]);
   		try {
   			$date = date_create($rq->ngay_cap);

           DB::table('hokhau')->where('id',$id)->update(['hk_cd'=>$rq->hk_cd,'chuho_id'=>$rq->chuho_id,'dia_chi'=>$rq->dia_chi,'ngay_cap'=>date_format($date,'Y-m-d H:i:s')]);
        } catch (UserException $exception) {
           return 1;
        }

   		return redirect()->route('hokhau');
   	}
   	public function deleteHokhau($id)
   	{
   		DB::table('hokhau')->where('id',$id)->delete();
        DB::table('nhankhau')->where('hokhau_id',$id)->delete();
   		return redirect()->route('hokhau');
   	}
    public function export()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            'Content-type: text/csv; charset=Shift-JIS',
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $reviews = DB::table('hokhau')->select('*')->get();

       
        $columns = array('id','hk_cd','chuho_id','dia_chi','ngay_cap','số lượng thành viên');

        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($reviews as $review) {
                $sl = DB::table('nhankhau')->where('hokhau_id',$review->id)->count();
                $date =  date_format(date_create($review->ngay_cap),'d-m-Y');
                fputcsv($file, array($review->id, $review->hk_cd, $review->chuho_id, $review->dia_chi,$date,$sl));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
        //return redirect()->route('hokhau',Response::stream($callback, 200, $headers););
        //return redirect()->route('hokhau');
    }
    public function export2(Request $rq)
    {

        return Excel::download(new Export2($rq->charset) ,'hokhau.csv');
    }
}
