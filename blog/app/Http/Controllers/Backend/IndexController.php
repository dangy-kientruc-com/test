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
    public function test()
    {
        $download='test.csv';
        $array = DB::table('hokhau')->select('*')->get()->toArray();

       
        $output_array = array();
        foreach ($array as $key => $value) {
           $output_array[] = array("id" =>$value->id,'hk_cd'=>$value->hk_cd,'chuho_id'=>$value->chuho_id,'dia_chi'=>$value->dia_chi,'ngay_cap'=>$value->ngay_cap);
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
    public function test2()
    {

    }
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
        if(Auth::attempt(['email'=>htmlspecialchars($rq->username),'password'=>htmlspecialchars($rq->password)]))
        {
            return redirect('/');
        }
        else if(Auth::guard('nhankhau')->attempt(['user'=>htmlspecialchars($rq->username),'password'=>htmlspecialchars($rq->password)]))
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
        $nk= DB::table('nhankhau')->select('*')->get();
   		$hk= DB::table('hokhau')->select('hokhau.id','hokhau.chuho_id','hokhau.dia_chi','hokhau.ngay_cap','hokhau.hk_cd',DB::raw('count(nhankhau.hokhau_id) as sl'))->leftjoin('nhankhau','nhankhau.hokhau_id','hokhau.id')->groupBy('hokhau.id')->groupBy('hokhau.chuho_id')->groupBy('hokhau.dia_chi')->groupBy('hokhau.ngay_cap')->groupBy('hokhau.hk_cd')->paginate(2)->appends(request()->query());
        $all= DB::table('hokhau')->select('*')->get();
   		return view('index',['hk'=>$hk,'nk'=>$nk,'all'=>$all]);
   	}
   	public function getAddHokhau()
   	{
   		return view('addhokhau');
   	}
   	public function postAddHokhau(Request $rq)
   	{
   		$validate= $rq->validate([
   			'hk_cd'=>'required|numeric',
   			'dia_chi'=>'required',
   			'ngay_cap'=>'required|date_format:Y/m/d',

   		],
   		[
   			'hk_cd.required'=>'Mã hộ khẩu không được để trống',
            'hk_cd.numeric'=>' Mã hộ khẩu chỉ được nhập số',
   			'dia_chi.required' =>'Địa chỉ không được để trống',
   			'ngay_cap.required' =>'Ngày cấp không được để trống',
            'ngay_cap.date_format' =>'Ngày cấp phải đúng định dạng Năm/Tháng/Ngày ex:2020/02/1995',
   		]);
   		try {
   			$date = date_create($rq->ngay_cap);

           DB::table('hokhau')->insert(['hk_cd'=>htmlspecialchars($rq->hk_cd),'chuho_id'=>null,'dia_chi'=>htmlspecialchars($rq->dia_chi),'ngay_cap'=>date_format($date,'Y-m-d H:i:s')]);
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

           DB::table('hokhau')->where('id',$id)->update(['hk_cd'=>htmlspecialchars($rq->hk_cd),'chuho_id'=>htmlspecialchars($rq->chuho_id),'dia_chi'=>htmlspecialchars($rq->dia_chi),'ngay_cap'=>date_format($date,'Y-m-d H:i:s')]);
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
        
        if($rq->charset == 'UTF-8')
        {
              return Excel::download(new Export2($rq->charset) ,'hokhau.csv');
        }
         else
        {
             $download='hokhau.csv';
            $array = DB::table('hokhau')->select('*')->get()->toArray();

           
            $output_array = array();
            foreach ($array as $key => $value) {
               $output_array[] = array("id" =>$value->id,'hk_cd'=>$value->hk_cd,'chuho_id'=>$value->chuho_id,'dia_chi'=>$value->dia_chi,'ngay_cap'=>$value->ngay_cap);
            }
            
            header('Cache-Control: public');
            header('Pragma: public');
            header('Content-Type: application/octet-stream; charset:SJIS-win');
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
}
