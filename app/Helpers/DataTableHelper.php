<?php

namespace App\Helpers;

use App\Models\Brand;
use App\Models\Model;
use App\Models\Product;
use App\Models\ProductPart;

class DataTableHelper
{
    public static function searchBrandProduct($query,$keyword) {
        $brands = Brand::where('bn_name','LIKE', "%{$keyword}%")->orWhere('name','LIKE', "%{$keyword}%")->pluck('id');
        $products = Product::whereIn('brand_id',$brands)->pluck('id');
        if($products){
            $query->orWhereIn('product_id',$products);
        }
    }

    public static function searchBrandProductPart($query,$keyword) {
        $brands = Brand::where('bn_name','LIKE', "%{$keyword}%")->orWhere('name','LIKE', "%{$keyword}%")->pluck('id');
        $product_parts = ProductPart::whereIn('brand_id',$brands)->pluck('id');
        if($product_parts){
            $query->orWhereIn('product_part_id',$product_parts);
        }
    }

    public static function searchModelProduct($query,$keyword) {
        $brands = Model::where('bn_name','LIKE', "%{$keyword}%")->orWhere('name','LIKE', "%{$keyword}%")->pluck('id');
        $products = Product::whereIn('model_id',$brands)->pluck('id');
        if($products){
            $query->orWhereIn('product_id',$products);
        }
    }

    public static function searchModelProductPart($query,$keyword) {
        $brands = Model::where('bn_name','LIKE', "%{$keyword}%")->orWhere('name','LIKE', "%{$keyword}%")->pluck('id');
        $product_parts = ProductPart::whereIn('model_id',$brands)->pluck('id');
        if($product_parts){
            $query->orWhereIn('product_part_id',$product_parts);
        }
    }

    public static function searchProduct($query,$keyword) {
        $products = Product::where('bn_name','LIKE', "%{$keyword}%")->orWhere('name','LIKE', "%{$keyword}%")->orWhere('registration_number','LIKE', "%{$keyword}%")->pluck('id');
        if($products){
            $query->orWhereIn('product_id',$products);
        }
    }

    public static function searchProductPart($query,$keyword) {
        $product_parts = ProductPart::where('bn_name','LIKE', "%{$keyword}%")->orWhere('name','LIKE', "%{$keyword}%")->orWhere('sku','LIKE', "%{$keyword}%")->pluck('id');
        if($product_parts){
            $query->orWhereIn('product_part_id',$product_parts);
        }
    }

}
