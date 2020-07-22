<?php

namespace App;

use DB;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class ExcelNhanKhau implements FromView
{	
	protected $method;
	protected $id;
	public function __construct($method,$id){
		$this->method = $method;
		$this->id = $id;
	}
	public function view(): View
	{	
	    return view('nhankhau.viewexcel', [
	        'loans' => DB::table('nhankhau')->select('*')->where('hokhau_id',$this->id)->get(),
	        'method'=>$this->method,	
	    ]);
	 }
}