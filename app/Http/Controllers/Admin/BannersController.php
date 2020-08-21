<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;

class BannersController extends Controller
{
    public function banners(){
    	$banners = Banner::get()->toArray();
    	//dd($banners); die;
    	//echo"<pre>"; print_r($banners); die;
    	return view('admin/banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request ){
		if ($request->ajax()){
		$data = $request->all();
		//	echo "<pre>"; print_r($data); die;
		if($data['status']=="Active"){
			$status = 0; 
		}else{
			$status = 1;
   		}
   		Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
   		return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]); 
    	}
    }

    	//delte Banner
     public function deleteBanner($id){
        //Get Banner Image
        $bannerImage = Banner::where('id',$id)->first();

        //Get Banner Path
        $banner_image_path = 'dashboard/dist/img/banners_img/';

        //Delete banner Image from banners folder
        if(file_exists($banner_image_path.$bannerImage->image)){
        	unlink($banner_image_path.$bannerImage->image);
        }

        //Delete Banner from banners table
        Banner::where('id',$id)->delete();

        //U slucacju da zelimo da obrisemo samo fotografiju
        //Banner::where('id',$id)->update(['image'=>'']);
      

        $message = 'Banner has been deleted successfully';
        session::flash('success_message',$message); 
        return redirect()->back();
    }
}
