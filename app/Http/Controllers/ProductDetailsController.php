<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Response;

class ProductDetailsController extends Controller
{
    //

    public function productView($id, $product_title){

        $product = DB::table('products')
        ->join('categories', 'products.category_id','categories.id')
        ->join('subcategories', 'products.subcategory_id','subcategories.id')
        ->join('brands', 'products.brand_id','brands.id')
        ->select('products.*', 'categories.category_name', 'subcategories.subcategory_name')
        ->where('products.id', $id)
        ->first();

        $product_color = explode(',',$product->product_color);
        $product_size = explode(',',$product->product_size);

        return view('pages.product_details', compact('product','product_color','product_size'));

    }

    public function cartProductView($id){

        $product = DB::table('products')
        ->join('categories', 'products.category_id','categories.id')
        ->join('subcategories', 'products.subcategory_id','subcategories.id')
        ->join('brands', 'products.brand_id','brands.id')
        ->select('products.*', 'categories.category_name', 'subcategories.subcategory_name','brands.brand_name')
        ->where('products.id', $id)
        ->first();

        $product_color = explode(',',$product->product_color);
        $product_size = explode(',',$product->product_size);

        return response::json(array(
            'product'=>$product,
            'size'=>$product_size,
            'color'=>$product_color,
        ));
    }

    public function addToCart(Request $request){

        $product = DB::table('products')->where('id',$request->product_id)->first();

        if($product->discount_price == NULL){
            if($request->qty <= 0){
                $notification=array(
                    'messege'=>'Please enter valid product quantity',
                    'alert-type'=>'error'
                     );
                return Redirect()->to('/')->with($notification);
            }else{
                $data = array();
                $data['id'] = $request->product_id;
                $data['name'] = $product->product_title;
                $data['qty'] = $request->qty;
                $data['price'] = $product->selling_price;
                $data['weight'] = 1;
                $data['options']['image'] = $product->image_one;
                $data['options']['color'] = $request->color;
                $data['options']['size'] = $request->size;
                Cart::add($data);
            
                $notification=array(
                    'messege'=>'Successfully added on your cart!',
                    'alert-type'=>'success'
                     );
                return Redirect()->to('/')->with($notification);
               // return response()->json($data);
            }
           
        }else{

            if($request->qty <= 0){
                $notification=array(
                    'messege'=>'Please enter valid product quantity',
                    'alert-type'=>'error'
                     );
                return Redirect()->to('/')->with($notification);
            }else{
                $data = array();
                $data['id'] = $product->id;
                $data['name'] = $product->product_title;
                $data['qty'] = 1;
                $data['price'] = $product->discount_price;
                $data['weight'] = 1;
                $data['options']['image'] = $product->image_one;
                $data['options']['color'] = $request->color;
                $data['options']['size'] = $request->size;         
                Cart::add($data);
            
                $notification=array(
                    'messege'=>'Successfully added on your cart!',
                    'alert-type'=>'success'
                     );
                return Redirect()->to('/')->with($notification);

                //return response()->json($data);
            }    
        }
    }
}
