<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        //
        echo "jacky";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = DB::table('categories')->get();
        $brand = DB::table('brands')->get();
        
        return view('admin.product.create', compact('category', 'brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = array();
        $data['product_title']= $request->product_title;
        $data['product_code']= $request->product_code;
        $data['product_quantity']= $request->product_quantity;
        $data['category_id']= $request->category_id;
        $data['subcategory_id']= $request->subcategory_id;
        $data['brand_id']= $request->brand_id;
        $data['product_size']= $request->product_size;
        $data['product_color']= $request->product_color;
        $data['selling_price']= $request->selling_price;
        $data['product_details']= $request->product_details;
        $data['video_link']= $request->video_link;
        $data['main_slider']= $request->main_slider;
        $data['hot_deal']= $request->hot_deal;
        $data['best_rated']= $request->trend;
        $data['trend']= $request->trend;
        $data['mid_slider']= $request->mid_slider;
        $data['hot_new']= $request->hot_new;
        $data['status']= 1;

        return response()->json($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //sub category ajax code 
    public function getSubcategory($id){
        $subcat = DB::table('subcategories')->where('category_id', $id)->get();
        return json_encode($subcat);
    }
}
