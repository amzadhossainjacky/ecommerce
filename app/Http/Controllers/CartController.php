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
            $data['qty'] = 1;
            $data['price'] = $product->selling_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            $data['options']['color'] ="";
            $data['options']['size'] = "";
            Cart::add($data);
            return response()->json(['success' => 'Successfully added on your cart!']);
        }else{
            
            $data = array();
            $data['id'] = $product->id;
            $data['name'] = $product->product_title;
            $data['qty'] = 1;
            $data['price'] = $product->discount_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            $data['options']['color'] ="";
            $data['options']['size'] = "";
            Cart::add($data);
            return response()->json(['success' => 'Successfully added on your cart!']);
        }
    }

    public function check(){

        $data = Cart::content();
        return response()->json($data);
    }

    public function showCart(){

        $cart = Cart::content();
        return view('pages.show_cart', compact('cart'));
    }

    public function removeCart($rowId){
        Cart::remove($rowId);
        return redirect()->back();
    }

    public function updateCart(Request $request, $rowId){
        
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        return redirect()->back();
    }
}
