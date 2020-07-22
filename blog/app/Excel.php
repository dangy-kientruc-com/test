<?php

namespace App;

use DB;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class Excel implements FromView
{	
	protected $method;
	public function __construct($method){
		$this->method = $method;
	}
	public function view(): View
	{	
	    return view('viewexcel', [
	        'loans' => DB::table('hokhau')->select('*')->get(),
	        'method'=>$this->method,	
	    ]);
	 }
}