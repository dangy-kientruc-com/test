<?php

namespace App;

use DB;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Excel implements FromView
{	
	protected $method;
	private $headers = [
         'Content-type: text/csv; charset=SHIFT-JIS',
    ];
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