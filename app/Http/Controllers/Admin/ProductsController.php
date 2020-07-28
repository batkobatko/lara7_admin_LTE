<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Product;
use App\Category;
use App\ProductsAttribute;
use Session;
use Image;

class ProductsController extends Controller
{
    public function products(){
    	Session::put('page','products');
		$products = Product::with(['category'=>function($query){
			$query->select('id','category_name');
		},'section'=>function($query){
			$query->select('id','name');
		}])->get();
		//$products = json_decode(json_encode($products));
		//echo "<pre>"; print_r($products); die;  
		return view('admin.products.products')->with(compact('products'));	
    }

    public function updateProductStatus(Request $request){
        if ($request->ajax()){
            $data = $request->all();
        //  echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0; 
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]); 
        }
    }
    public function deleteProduct($id){
        //Delete Product
        Product::where('id',$id)->delete();

        $message = 'Product has been deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditProduct(Request $request,$id=null){
    	if($id==""){
    		$title = "Add Product";
            $product = new Product;
            $productdata = array();
            $message = "Product added successfully";
            }else{
    		$title = "Edit Product";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata),true);
        //    echo"<pre>"; print_r($productdata); die;
            $product = Product::find($id);
            $message = "Product updated successfully";
    	}
 
        if($request->isMethod('post')){
            $data = $request->all();
         // echo "<pre>"; print_r($data); die;

    // Product Validations
      $rules = [
        'category_id' => 'required',
        'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
        'product_code' => 'required|regex:/^[\w-]*$/',
        'product_price' => 'required|numeric',
        'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
      ];

      $customMessages = [
        'product_id.required' => 'Category is required', 
        'product_name.required' => 'Product Name is required', 
        'product_name.regex' => 'Valid Product Name is reuqired',
        'product_code.required' => 'Product Code is required', 
        'product_code.regex' => 'Valid Product Code is reuqired',
        'product_price.required' => 'Product Price is required', 
        'product_price.regex' => 'Valid Product Pame is reuqired',
        'product_color.required' => 'Product Color is required', 
        'product_color.regex' => 'Valid Product Color is reuqired',
      ];
      $this->validate($request, $rules, $customMessages);

        if(empty($data['is_featured'])){
            $is_fetured = "No";
        }else{
            $is_fetured = "Yes";
        }

        if(empty($data['product_discount'])){
            $data['product_discount'] = "";
        }

        if(empty($data['product_weight'])){
            $data['product_weight'] = "";
        }

        if(empty($data['description'])){
            $data['description'] = "";
        }

        if(empty($data['wash_care'])){
            $data['wash_care'] = "";
        }

         if(empty($data['fabric'])){
            $data['fabric'] = "";
        }

         if(empty($data['pattern'])){
            $data['pattern'] = "";
        }

         if(empty($data['sleeve'])){
            $data['sleeve'] = "";
        }

         if(empty($data['fit'])){
            $data['fit'] = "";
        }

         if(empty($data['occasion'])){
            $data['occasion'] = "";
        }

         if(empty($data['meta_title'])){
            $data['meta_title'] = "";
        }

         if(empty($data['meta_keywords'])){
            $data['meta_keywords'] = "";
        }
 
        //Upload product Image
        if($request->hasFile('main_image')){
            $image_tmp = $request->file('main_image'); 
            if($image_tmp->isValid()){
               //Get Image Extension (Upload images after Resize)
                $image_name = $image_tmp->getClientOriginalName();
                //Get Original Image Name
                $extension = $image_tmp->getClientOriginalExtension();
                // Generate New Image Name
                $imageName = $image_name.'_'.rand(111,9999).'.'.$extension;
                // Set Path for small, medium and large iamges 
                $large_image_path = 'dashboard/dist/img/product_img/large/'.$imageName;
                $medium_image_path = 'dashboard/dist/img/product_img/medium/'.$imageName;
                $small_image_path = 'dashboard/dist/img/product_img/small/'.$imageName;
                // Upload Large Image
                Image::make($image_tmp)->save($large_image_path); //W:1040 H:1200
                // Upload Medium and Small Images after Resize
                Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                //Save Product Main Image in product table
                $product->main_image = $imageName;
            }
        }
                
                //Upload product Video
                if($request->hasFile('product_video')){
                    $video_tmp = $request->file('product_video'); 
                    if($video_tmp->isValid()){
                    // Upload video 
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name.'_'.rand().'.'.$extension;
                    $video_path = 'dashboard/dist/vid/product_videos/';
                    $video_tmp->move($video_path,$videoName);
                    //Save Video in product table
                    $product->product_video = $videoName;
            }
        }

      // Save product details in table
      $categoryDetails = Category::find($data['category_id']);
      $product->section_id = $categoryDetails['section_id'];
      $product->category_id = $data['category_id'];
      $product->product_name = $data['product_name'];
      $product->product_code = $data['product_code'];
      $product->product_color = $data['product_color'];
      $product->product_price = $data['product_price'];
      $product->product_discount = $data['product_discount'];
      $product->product_weight = $data['product_weight'];
      $product->description = $data['description'];
      $product->wash_care = $data['wash_care'];
      $product->fabric = $data['fabric'];
      $product->pattern = $data['pattern'];
      $product->sleeve = $data['sleeve'];
      $product->fit = $data['fit'];
      $product->occasion = $data['occasion'];
      $product->meta_title = $data['meta_title'];
      $product->meta_keywords = $data['meta_keywords'];
      $product->meta_description = $data['meta_description'];
      $product->is_featured = $is_fetured;
      $product->status = 1; //omogucava da status prilikom unosa bude odmah aktivan
      $product->save();
      session::flash('success_message',$message);
      return redirect('admin/products');
    
    }
        // echo "<pre>"; print_r($categoruDetails); die;
     	// filter Arrays (slicno kao na Amazonu)
    	$fabricArray = array('Cotton','Poliester','wool');
    	$sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
    	$patternArray = array('Checked','Plain','Printed','Self','Solid');
    	$fitArray = array('Regular','Slim');
    	$occasionArray = array('Casual','Formal');

    	// Kreiranje relacija (Section with Categories and Subcategories)
    	$categories = Section::with('categories')->get();
    	$categories = json_decode(json_encode($categories), true);
    	// echo "<pre>"; print_r($categories); die;


    	return view('admin.products.add_edit_product')->with(compact('title','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','categories', 'productdata'));
    }

    public function deleteProductImage($id){
        // Get Product Image
        $productImage = Product::select('main_image')->where('id',$id)->first();

        // Get product Image Path
        $small_image_path = 'dashboard/dist/img/product_img/small/';
        $medium_image_path = 'dashboard/dist/img/product_img/medium/';
        $large_image_path = 'dashboard/dist/img/product_img/large/';

        // Delete product small image if exist in small Folder
        if(file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path.$productImage->main_image);
        }

        // Delete product medium image if exist in medium Folder
        if(file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path.$productImage->main_image);
        }

        // Delete product large image if exist in large Folder
        if(file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path.$productImage->main_image);
        }
         //delete Product Image from products tabler
        Product::where('id', $id)->update(['main_image'=>'']);

        $message = 'Product image has been deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }

     public function deleteProductVideo($id){
        // Get Product Video
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        // Get Product Video Path
        $product_video_path = 'dashboard/dist/vid/product_videos/';

        // Delete Product Video from vategory_iamges folder if exist
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }
 
        //delete Product Video from categories folder
        Product::where('id', $id)->update(['product_video'=>'']);

        $message = 'Product video has been deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addAttributes(Request $request,$id){
      if($request->isMethod('post')){
          $data = $request->all();
          //echo "<pre>"; print_r($data); die;
          foreach ($data['sku'] as $key => $value){
              if(!empty($value)){

                //SKU alredy exist check
                $attrCountSKU = ProductsAttribute::where('sku',$value)->count();
                if($attrCountSKU>0){
                  $message = 'SKU alredy exist. Please add another SKU';
                  session::flash('error_message',$message);
                  return redirect()->back();
                }

                //Size alredy exist check
                $attrCountSize = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                if($attrCountSize>0){
                  
                  $message = 'Size  alredy exist. Please add another Size';
                  session::flash('error_message',$message);
                  return redirect()->back();
                }

                $attribute = new ProductsAttribute;
                $attribute->product_id = $id;
                $attribute->sku = $value;
                $attribute->size = $data['size'][$key];
                $attribute->price = $data['price'][$key];
                $attribute->stock = $data['stock'][$key];
                $attribute->save();
              }
          }

      $success_message = 'Product Attributes has been added successfully!';
      session::flash('success_message',$success_message);
      return redirect()->back();

      }



      $productdata = Product::find($id);
      $productdata = json_decode(json_encode($productdata),true);
      // echo "<pre>"; print_r($productdata); die;
      $title = "Product Attributes";
      return view('admin.products.add_attributes')->with(compact('productdata','title'));

    }
}



/*
--Product
    -Size: small    Medium     Large
    - Price: 1200    1300       1400
    -  Stock: 20     10         20
    - SKU:BFT01-S   BFT01-M     BFT01-L 

    SKU(Stock Keeping Unit)

*/