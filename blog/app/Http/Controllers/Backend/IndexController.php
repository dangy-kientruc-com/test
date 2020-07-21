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
}
