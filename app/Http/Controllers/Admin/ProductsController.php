<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Product;
use App\Category;
use Session;

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
            }else{
    		$title = "Eddit Product";
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
      $product->is_featured = $is_fetured;
      $product->status = 1; //omogucava da sstatus prilikom unosa bude odmah aktivan
      $product->save();
      session::flash('success_message','Product added successfully');
      return redirect('admin/products');
     
    }


     // echo "<pre>"; print_r($categoruDetails); die;

 
    	// filter Arrays (slicno kao na Amazonu)
    	$fabricArray = array('Cotton','Poliester','wool');
    	$sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
    	$paternArray = array('Checked','Plain','Printed','Self','Solid');
    	$fitArray = array('Regular','Slim');
    	$occasionArray = array('Casual','Formal');

    	// Kreiranje relacija (Section with Categories and Subcategories)
    	$categories = Section::with('categories')->get();
    	$categories = json_decode(json_encode($categories), true);
    	// echo "<pre>"; print_r($categories); die;


    	return view('admin.products.add_edit_product')->with(compact('title','fabricArray','sleeveArray','paternArray','fitArray','occasionArray','categories'));
    }
}
