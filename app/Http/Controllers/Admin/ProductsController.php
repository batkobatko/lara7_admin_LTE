<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Product;
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
    	}else{
    		$title = "Eddit Product";
    	}
    	//filter Arrays (slicno kao na Amazonu)
    	$fabricArray = array('Cotton','Poliester','wool');
    	$sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
    	$paternArray = array('Checked','Plain','Printed','Self','Solid');
    	$fitArray = array('Regular','Slim');
    	$occasionArray = array('Casual','Formal');

    	//Kreiranje relacija (Section with Categories and Subcategories)
    	$categories = Section::with('categories')->get();
    	$categories = json_decode(json_encode($categories), true);
    	//echo "<pre>"; print_r($categories); die;


    	return view('admin.products.add_edit_product')->with(compact('title','fabricArray','sleeveArray','paternArray','fitArray','occasionArray','categories'));
    }
}
