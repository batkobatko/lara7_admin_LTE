<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners(){
        //active sidebar banners
        Session::put('page','banners');
    	$banners = Banner::get()->toArray();
    	//dd($banners); die;
    	//echo"<pre>"; print_r($banners); die;
    	return view('admin/banners.banners')->with(compact('banners'));
    }

    public function addEditBanner(Request $request,$id=null){
        if($id==""){
            //Add Banner
            $banner = new Banner;
            $title = "Add Banner Image";
            $message = "Banner added successfully!";

        }else{
            //Eddit Banner
            $banner = Banner::find($id);
            $title = "Eddit Banner Image";
            $message = "Banner updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];

            //Upload product Image
        if($request->hasFile('image')){
            $image_tmp = $request->file('image'); 
            if($image_tmp->isValid()){
               //Get Image Extension (Upload images after Resize)
                $image_name = $image_tmp->getClientOriginalName();
                //Get Original Image Name
                $extension = $image_tmp->getClientOriginalExtension();
                // Generate New Image Name
                $imageName = $image_name.'_'.rand(111,9999).'.'.$extension;
                // Set Path for small, medium and large iamges 
                $banner_image_path = 'dashboard/dist/img/banners_img/'.$imageName;
                // Upload Banners Images after Resize
                Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);
                //Save Banner Image in banners table
                $banner->image = $imageName;
            }
        }
        
        $banner->save();   
        session::flash('success_message',$message);
        return redirect('admin/banners');     
    }
  
        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
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
   		return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]); 
    	}
    }

    	//delete Banner
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
