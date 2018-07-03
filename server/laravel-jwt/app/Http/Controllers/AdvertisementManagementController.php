<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdvertisementManagementController extends Controller
{
    public function getAds()
    {
    	try{
    		$ads=DB::select("select id,title,details,position from advertisements");
    		//dd($ads);
        return response()->json(['ads'=>$ads], 200);
    		//return $stores;
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function deleteAd(Request $request)
    {
    	$adId=$request->id;
    	try{
    		
                $deletedStatus= DB::delete('delete from advertisements where id=?',[$adId]);
                //dd($deletedStatus);
        }
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function addEditAd(Request $request)
    {
    	try{
    		$adId=$request->id;

    		if($adId==null)
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

            $insertStatus=  DB::table('advertisements')
                             ->insertGetId(
                                 [ /*'name' => $request->input('storeName'),
                                   'category_id'=>$request->input('category'),
                                   'image_id'=>$image_id*/
                                   'title'=>$request->title,
                                   'details'=>$request->details,
                                   'position'=>$request->position,
                                 ]
                            );
            $credentials= $request->all();
            return response()->json(['credential'=>$credentials,'new_id'=>$insertStatus], 200);
			//return redirect('/getStore');
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

                $updateStatus= DB::table('advertisements')
                    ->where('id', $adId)
                    ->update(['title' => $request->title,'details'=>$request->details,'position'=>$request->position]);
                              //  dd($updateStatus);

                $credentials= $request->all();
                return response()->json(['credential'=>$credentials,'new_id'=>$updateStatus], 200);
                //return redirect('/editStore/'.$request->input('adId'));
            }
        
			//return response($categoryDetails[0]);
        	//return view('addStore', $data);
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }
}
