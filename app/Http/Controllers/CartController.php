<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use DB;

class CartController extends Controller
{
    //

    public function addCart($id){

        $product = DB::table('products')->where('id',$id)->first();

        if($product->discount_price == NULL){

            $data = array();
            $data['id'] = $product->id;
            $data['name'] = $product->product_title;
            $data['qty'] = $product->product_quantity;
            $data['price'] = $product->selling_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            Cart::add($data);
            return response()->json(['success' => 'Successfully added on your cart!']);
        }else{
            
            $data = array();
            $data['id'] = $product->id;
            $data['name'] = $product->product_title;
            $data['qty'] = $product->product_quantity;
            $data['price'] = $product->discount_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            Cart::add($data);
            return response()->json(['success' => 'Successfully added on your cart!']);
        }
    }

    public function check(){

        $data = Cart::content();
        return response()->json($data);
    }
}
