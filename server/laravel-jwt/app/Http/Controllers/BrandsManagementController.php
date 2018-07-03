<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BrandsManagementController extends Controller
{
    
    public function getBrands()
    {
    	try{
    		$brands=DB::select("select id, name, type, manufacturer from brands");
    		return response()->json(['brands'=>$brands], 200);
    		//dd($brands);
    		//return $brands;
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function deleteBrand(Request $request)
    {
    	$brandId=$request->id;
    	//$brandId=10;
    	try{
    		
                $deletedStatus= DB::delete('delete from brands where id=?',[$brandId]);
                //dd($deletedStatus);
        }
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function addEditBrand(Request $request)
    {
    	try{
    		$brandId=$request->id;

    		if($brandId==null)
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

            $insertStatus=  DB::table('brands')
                             ->insertGetId(
                                 [ /*'name' => $request->input('storeName'),
                                   'category_id'=>$request->input('category'),
                                   'image_id'=>$image_id*/
                                   'name'=>$request->name,
                                   'type'=>$request->type,
                                   'manufacturer'=>$request->manufacturer,
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

                $updateStatus= DB::table('brands')
                    ->where('id', $brandId)
                    ->update(['name' => $request->name,'type'=>$request->type,'Manufacturer'=>$request->manufacturer]);

                $credentials= $request->all();
				return response()->json(['credential'=>$credentials,'new_id'=>$updateStatus], 200);
                              //  dd($updateStatus);

                //return redirect('/editStore/'.$request->input('storeId'));
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
