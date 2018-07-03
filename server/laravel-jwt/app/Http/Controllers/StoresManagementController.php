<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Routing;
class StoresManagementController extends Controller
{
    public function getStores()
    {
    	try{
    		$stores=DB::select("select s.id as storeId,s.name as name,s.`type` as type,s.location as location,c.name as city from store s,city c where s.city_id=c.id");
    		//dd($stores);
    		return response()->json(['stores'=>$stores], 200);
    		//return $stores;
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function deleteStore(Request $request)
    {
    	$storeId=$request->id;
    	//$storeId=5;
    	try{
    		
                $deletedStatus= DB::delete('delete from store where id=?',[$storeId]);
                //dd($deletedStatus);
                /*if($deletedStatus==1)
                {
                	$this->getStores();
                }*/
                /*else
                {
                	return response()->json(['new_id'=>$deletedStatus], 401);
                }*/
				
        }
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function addEditStore(Request $request)
    {
    	try{
    		$storeId=$request->id;
    		//$storeId=10;
    		if($storeId==null)
    		{
                 $image_id=null;
            	/*if($_FILES)
                {
                        $location="D:/LexCredo Request Images/stores";               
                        
                        if(!file_exists($location))
                             mkdir($location); 

                          $pathForDb="stores/".basename($_FILES["storeImage"]["name"]);    
                          
                        $location=$location.DIRECTORY_SEPARATOR;
                        $target_file =$location. basename($_FILES["storeImage"]["name"]);

                         $ext =pathinfo($target_file,PATHINFO_EXTENSION);
                         $size = $_FILES["storeImage"]["size"];

                        if (move_uploaded_file($_FILES["storeImage"]["tmp_name"], $target_file)) {

                          $image_id=DB::table('images')->insertGetId(['name'=>basename($_FILES["storeImage"]["name"]),'extension'=>$ext,'path'=>$pathForDb,'size'=>$size]);
                      //   dd($image_id);      
                        }

                        
                }*/

            $insertStatus=  DB::table('store')
                             ->insertGetId(
                                 [ /*'name' => $request->input('storeName'),
                                   'category_id'=>$request->input('category'),
                                   'image_id'=>$image_id*/
                                   'name'=>$request->name,
                                   'type'=>$request->type,
                                   'location'=>$request->location,
                                   'city_id'=>$request->cityId,
                                 ]
                            );
            $credentials= $request->all();
			       return response()->json(['credential'=>$credentials,'new_id'=>$insertStatus], 200);
            }
            else
            {
                /*if($_FILES)
                {
                        $location="D:/LexCredo Request Images/stores";               
                        
                        if(!file_exists($location))
                             mkdir($location); 

                          $pathForDb="stores/".basename($_FILES["storeImage"]["name"]);    
                          
                        $location=$location.DIRECTORY_SEPARATOR;
                        $target_file =$location. basename($_FILES["storeImage"]["name"]);

                         $ext =pathinfo($target_file,PATHINFO_EXTENSION);
                         $size = $_FILES["storeImage"]["size"];

                        if (move_uploaded_file($_FILES["storeImage"]["tmp_name"], $target_file)) {

                          $image_id=DB::table('images')->insertGetId(['name'=>basename($_FILES["storeImage"]["name"]),'extension'=>$ext,'path'=>$pathForDb,'size'=>$size]);
                      //   dd($image_id);      
                        }

                        
                }*/
                /*$request->name="abc";
                $request->type="bar";
                $request->location="fjhdj";
                $request->cityId=2;*/

                $updateStatus= DB::table('store')
                    ->where('id', $storeId)
                    ->update(['name' => $request->name,'type'=>$request->type,'location'=>$request->location,'city_id'=>$request->cityId]);
                              //  dd($updateStatus);

                $credentials= $request->all();
				        return response()->json(['credential'=>$credentials,'new_id'=>$updateStatus], 200);
            }
        
			
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }
}
