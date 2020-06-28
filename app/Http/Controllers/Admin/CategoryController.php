<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Section;
use App\Category;
use Session;
 
class CategoryController extends Controller
{
    public function categories(){
    	Session::put('page','categories');
    	$categories = Category::get();
    //	$categories = json_decode(json_encode($categories));
    //	echo "<pre>"; print_r($categories); die;
    	return view('admin.categories.categories')->with(compact('categories'));
    }
    public function updateCategoryStatus(Request $request ){
    	if ($request->ajax()){
    		$data = $request->all();
    	//	echo "<pre>"; print_r($data); die;
    		if($data['status']=="Active"){
    			$status = 0; 
    		}else{
    			$status = 1;
       		}
       		Category::where('id',$data['category_id'])->update(['status'=>$status]);
       		return response()->json(['status'=>$status,'category_id'=>$data['category_id']]); 
    	}
    }

    public function addEditCategory(Request $request, $id=null){
    //    echo "test"; die;
        if($id==""){ 
            $title = "Add Category";
            //Add Category Funcionlaity
        }else{
            $title = "Edit Category";
            //Edit Category Functionality
        }

            //Get All Sections
        $getSections = Section::get();


        return view('admin.categories.add_edit_category')->with(compact('title','getSections'));
    }
}