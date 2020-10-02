<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     public function Category(){
    	return $this->belongsTo('App\Category','category_id');
    }
    public function section(){
    	return $this->belongsTo('App\Section','section_id');
    }

    public function brand(){
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function attributes(){
    	return $this->hasMany('App\ProductsAttribute');
    }

     public function images(){							
    	return $this->hasMany('App\ProductsImage');    
    	//pozivamo model images
    	//one product many images
    }

    public static function productFilters(){
        // filter Arrays (slicno kao na Amazonu)
        $productFilters['fabricArray'] = array('Pamuk','Poliester','Vuna','Čista vuna');
        $productFilters['sleeveArray'] = array('Dugi rukav','Polu-rukav','Kratki rukav','Bez rukava');
        $productFilters['patternArray'] = array('Checked','Plain','Printed','Self','Solid');
        $productFilters['fitArray'] = array('Regular','Slim');
        $productFilters['occasionArray'] = array('Casual','Formal');
        return $productFilters;
    }
}
