<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CityManagementController extends Controller
{
    public function getCities()
    {
    	try{
    		$cities=DB::select("select id as id,name as name,state as state from city");
    		//dd($cities);
    		return response()->json(['cities'=>$cities], 200);
    		//return $cities;
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }
}
