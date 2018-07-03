<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OffersManagementController extends Controller
{
    public function getoffers()
    {
    	try{
    		$offers=DB::select("select o.id as offerId, o.name as offerName, o.value as offerValue,o.details as offerDetails,o.store_id as storeId,s.name as storeName,s.`type`as storeType,s.location as storeLocation, s.city_id as storeCityId,c.name as storeCity, o.brand_id as brandId, b.name as brandName,b.`type`as liquorType from offer o,store s, brand b, city c where o.store_id=s.id and s.city_id=c.id and o.brand_id=b.id");
    		//dd($offers);
    		return response()->json(['offers'=>$offers], 200);
    		//return $stores;
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function deleteOffer(Request $request)
    {
    	$offerId=$request->id;;
    	try{
    		
                $deletedStatus= DB::delete('delete from offer where id=?',[$offerId]);
                //dd($deletedStatus);
        }
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function addEditOffer(Request $request)
    {
    	try{
    		$offerId=$request->id;

    		if($offerId==null)
    		{
                 

	            $insertStatus=  DB::table('offer')
	                             ->insertGetId(
	                                 [ /*'name' => $request->input('storeName'),
	                                   'category_id'=>$request->input('category'),
	                                   'image_id'=>$image_id*/
	                                   'name'=>$request->name,
	                                   'value'=>$request->value,
	                                   'details'=>$request->details,
	                                   'store_id'=>$request->store_id,
	                                   'brand_id'=>$request->brand_id,
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

                $updateStatus= DB::table('offer')
                    ->where('id', $offerId)
                    ->update(['name' => $request->name,'value'=>$request->value,'details'=>$request->details,'store_id'=>$request->store_id, 'brand_id'=>$request->brand_id]);
                              //  dd($updateStatus);
                $credentials= $request->all();
				return response()->json(['credential'=>$credentials,'new_id'=>$updateStatus], 200);
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

    public function searchOfferByFields(Request $request)
    {
    	try
    	{
    		$queryFirstpart="select o.id as offerId, o.name as offerName, o.value as offerValue,o.details as offerDetails, o.store_id as storeId,s.name as storeName,s.`type`as storeType,s.location as storeLocation, s.city_id as toreCityId,c.name as storeCity, o.brand_id as brandId, b.name as brandName, b.`type`as liquorType from offer o,store s, brand b, city c where o.store_id=s.id and s.city_id=c.id and o.brand_id=b.id";
    		$querySecondPart="";
    		$fullQuery="";

    		$storeName=$request->storeName;
    		$storeType=$request->storeType;
    		$city=$request->city;
    		$location=$request->location;
    		$brand=$request->brand;
    		$liquorType=$request->liquorType;

    		if($storeName)
    		{
    			if($querySecondPart)
	    		{
	    			$querySecondPart=$querySecondPart." and ";
	    		}
	    		else
	    		{
	    			$querySecondPart=$querySecondPart." and ( ";
	    		}

	    		$querySecondPart=$querySecondPart."s.name like '%".$storeName."%'";
    		}
    		if($storeType)
    		{
    			if($querySecondPart)
	    		{
	    			$querySecondPart=$querySecondPart." and ";
	    		}
	    		else
	    		{
	    			$querySecondPart=$querySecondPart." and ( ";
	    		}

	    		$querySecondPart=$querySecondPart."s.`type` like '%".$storeType."%'";
    		}
    		if($city)
    		{
    			if($querySecondPart)
	    		{
	    			$querySecondPart=$querySecondPart." and ";
	    		}
	    		else
	    		{
	    			$querySecondPart=$querySecondPart." and ( ";
	    		}

	    		$querySecondPart=$querySecondPart."c.name like '%".$city."%'";
    		}

    		if($location)
    		{
    			if($querySecondPart)
	    		{
	    			$querySecondPart=$querySecondPart." and ";
	    		}
	    		else
	    		{
	    			$querySecondPart=$querySecondPart." and ( ";
	    		}

	    		$querySecondPart=$querySecondPart."s.location like '%".$location."%'";
    		}

    		if($brand)
    		{
    			if($querySecondPart)
	    		{
	    			$querySecondPart=$querySecondPart." and ";
	    		}
	    		else
	    		{
	    			$querySecondPart=$querySecondPart." and ( ";
	    		}

	    		$querySecondPart=$querySecondPart."b.name like '%".$brand."%'";
    		}

    		if($liquorType)
    		{
    			if($querySecondPart)
	    		{
	    			$querySecondPart=$querySecondPart." and ";
	    		}
	    		else
	    		{
	    			$querySecondPart=$querySecondPart." and ( ";
	    		}

	    		$querySecondPart=$querySecondPart."b.`type` like '%".$liquorType."%'";
    		}

    		if($querySecondPart)
    		{
    			$querySecondPart=$querySecondPart." ) ";
    		}


    		$fullQuery=$queryFirstpart.$querySecondPart;

    		$searchRes=DB::select($fullQuery);
    		return response()->json(['searchRes'=>$searchRes], 200);
    		//dd($fullQuery);
    		/*if($querySecondPart)
    		{
    			$querySecondPart=$querySecondPart." or ";
    		}
    		else
    		{
    			$querySecondPart=$querySecondPart." and ( "
    		}*/

    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }

    public function searchSuggestion(Request $request)
    {
    	$searchVal=$request->searchVal;
    	
    	try{


    		$storeName=DB::select("select name as searchRes from store where name like '%".$searchVal."%'");
    		$storeType=DB::select("select type as searchRes from store where type like '%".$searchVal."%'");
    		$city=DB::select("select name as searchRes from city where name like '%".$searchVal."%'");
    		$location=DB::select("select location as searchRes from store where location like '%".$searchVal."%'");
    		$brand=DB::select("select name as searchRes from brand where name like '%".$searchVal."%'");
    		$liquorType=DB::select("select type as searchRes from brand where type like '%".$searchVal."%'");
			
			$response=array();
			$response[]=[
				['source'=>'Stores','value'=>$storeName],
				['source'=>'Store Types','value'=>$storeType],
				['source'=>'Cities','value'=>$city],
				['source'=>'Location','value'=>$location],
				['source'=>'Brand','value'=>$brand],
				['source'=>'Liquour Type','value'=>$liquorType],
				
			];
			//return response($response);

			return response()->json(['searchSuggestions'=>$response]);
    	}
    	catch(Exception $e)
    	{
    		report($e);
    	}
    }
}
