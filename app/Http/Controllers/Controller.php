<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Visitor;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function __construct()
    {
		$routename =  Route::getCurrentRoute()->getActionName();
		if(strpos($routename, 'App\Http\Controllers\Frontend') !== false){
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$exist = Visitor::where('ip', $ip)->count();
			$oldTime  = session('visited_time');
			$currtime = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d H:i:s');
			$oldTime  = \Carbon\Carbon::parse($oldTime)->addHour('1')->format('Y-m-d H:i:s');
			session('visited_time', $currtime);
			if($exist == 0 OR $oldTime == "" OR $currtime > $oldTime){
				Visitor::create(['ip' => $ip]);
			}
		}
		
	}
}
