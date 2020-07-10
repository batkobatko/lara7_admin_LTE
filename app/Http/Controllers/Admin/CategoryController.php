<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\File;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Section;
use App\Category;
use Session;
use Image;

 
class CategoryController extends Controller
{
    public function categories(){
    	Session::put('page','categories');
    	$categories = Category::get();
    //	$categories = json_decode(json_encode($categories));
    //	echo "<pre>"; print_r($categories); die;
    	return view('admin.categories.categories')->with(compact('categories'));
    }
    public function updateCategoryStatus(Request $request){
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
            $category = new Category;
        }else{
            $title = "Edit Category";
            //Edit Category Functionality
        }
        if($request->isMethod('post')){
            $data = $request->all();
        //  echo "<pre>"; print_r($data); die;

        // Category Validations
      $rules = [
        'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
        'section_id' => 'required',
        'url' => 'required',
      //  'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ];

      $customMessages = [
        'category_name.required' => 'Category Name is required', 
        'category_name.regex' => 'Valid Category Name is reuqired',
        'section_id.required' => 'Section is required',
        'url.required' => 'Category URL is required',
        'category_image.image' => 'Valid Category Image is required',
      ];
      $this->validate($request, $rules, $customMessages);

            // (Upload image - script:)
            // (Upload Category - script:)
        if($request->hasFile('category_image')){
            $image_tmp = $request->file('category_image');
            if($image_tmp->isValid()){
                //Get Image extension
                $extension = $image_tmp->getClientOriginalExtension();
                // Generate New Image Name
                $imageName = rand(111,99999).'.'.$extension;
                $imagePath = 'dashboard/dist/img/category_img/'.$imageName;
                //Upload the Image
                Image::make($image_tmp)->save($imagePath); 
                //Save category image
                $category->category_image = $imageName;

            }
        }

        // if(empty($data['category_image'])){
        // $data['category_image']="";
        // }
            if(empty($data['category_discount'])){
            $data['category_discount']="";
            }
 
            if(empty($data['description'])){
            $data['description']="";
            }

            if(empty($data['meta_title'])){
            $data['meta_title']="";
            }
            
            if(empty($data['meta_description'])){
            $data['meta_description']="";
            }

            if(empty($data['meta_keywords'])){
            $data['meta_keywords']="";
            }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
           $category->category_image = $data['category_image'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();
        
            session::flash('success_message', 'Category added successufully!');
            return redirect('admin/categories');
  }
            //Get All Sections
        $getSections = Section::get();
      

        return view('admin.categories.add_edit_category')->with(compact('title','getSections'));
    }
}