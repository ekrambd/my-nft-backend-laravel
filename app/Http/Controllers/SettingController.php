<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class SettingController extends Controller
{
    public function info()
    {
    	try
    	{
    		$info = setting();
    	    return response()->json(['status'=>true, 'data'=>$info]);
    	}catch(Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }

    public function appSettings(Request $request)
    {
    	try
    	{   

    		$setting = setting();

    		if($request->app_logo)
            {
               $position = strpos($request->app_logo, ';');
               $sub = substr($request->app_logo, 0 ,$position);
               $ext = explode('/', $sub)[1];
               $name = time().user()->id.".".$ext;
               $img = Image::make($request->app_logo);
               $upload_path = 'uploads/settings/';
               $image_url = $upload_path.$name;
               $img->save($image_url);
            }else{
            	$image_url = $setting->image_url;
            }
  
    		$setting->user_id = user()->id;
    		$setting->app_name = $request->app_name ?? 'NFTX';
    		$setting->app_logo = $image_url;
    		$setting->contract_address = $request->contract_address;
    		$setting->update();

    		return response()->json(['status'=>true, 'message'=>"Successfully updated"]);
    		
    	}catch(Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }
}
