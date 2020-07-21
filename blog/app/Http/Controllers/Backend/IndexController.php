<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class IndexController extends Controller
{
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

           DB::table('hokhau')->insert(['hk_cd'=>$rq->hk_cd,'chuho_id'=>$rq->chuho_id,'dia_chi'=>$rq->dia_chi,'ngay_cap'=>date_format($date,'Y-m-d H:i:s')]);
        } catch (UserException $exception) {
           return 1;
        }
   		return redirect()->route('hokhau');
   	}
   	public function getHokhau($id)
   	{	
   		$hk= DB::table('hokhau')->select('*')->where('id',$id)->first();
   		return view('editHK',['hk'=>$hk]);
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
   		return redirect()->route('hokhau');
   	}
}
