<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

 
class IndexController extends Controller
{
    public function index(){
    	//get Featured Items
    	$featuredItemsCount = Product::where('is_featured','Yes')->count();
    	$featuredItems =Product::where('is_featured','Yes')->get()->toArray();
    	$featuredItemsChunk = array_chunk($featuredItems, 4);
    	//echo "<pre>"; print_r($featuredItemsChunk); die;
    	//dd($featuredItems);die;
    	$page_name = "index";
    	return view('front.index')->with(compact('page_name','featuredItemsChunk',"featuredItemsCount"));
    }
}