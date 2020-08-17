<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

 
class IndexController extends Controller
{
    public function index(){
    	//get Featured Items
    	$featuredItemsCount = Product::where('is_featured','Yes')->where('status',1)->count();
    	$featuredItems =Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
    	$featuredItemsChunk = array_chunk($featuredItems,4);
    	//echo "<pre>"; print_r($featuredItemsChunk); die;
    	//dd($featuredItems);die;

    	//Get New products 
    	$newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(12)->get()->toArray();
    	//u pojedinim slucajevima "toArray" nece raditi

    	//$newProducts = json_decode(json_encode($newProducts),true);
    	//echo "<pre>"; print_r($newProducts); die;
    	//dd($newProducts); die;

    	$page_name = "index";
    	return view('front.index')->with(compact('page_name','featuredItemsChunk',"featuredItemsCount",'newProducts'));
    }
}