<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $products = new Product;
        $products = $products->with('category');
        $products = $products->with('productImages');

        $category_id = $request->category_id;
        if($category_id){
            $products = $products->where('category_id',$category_id);
        }
        $products = $products->get();
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $this->validate($request,[
            'name' => 'required|min:3|max:20',
            'description' => 'required|min:5|max:150',
            'price' => 'required',
            'category_id' => 'required',
            'images' => 'required|array',
            'images.*' => 'required|mimes:jpg,png,jpeg'
        ]);

         $product = new Product;
         $product->name = $request->name;
         $product->description = $request->description;
         $product->price = $request->price;
         $product->category_id = $request->category_id;
         $product->save();

         $images = $request->file('images');
         $image_details = array();

         foreach ($images as $image) {
            $path = $image->store('public');
            $exploded_string = explode('/',$path);
            $image_details[] = new ProductImage ([
                'name' => $exploded_string[1],
                'path' => $exploded_string[0],
                'url' => asset("storage/{$exploded_string[1]}")
            ]);
         }

         $product->productImages()->saveMany($image_details);

         return response()->json([
            'success' => true,
            'message' => 'Product save successfuly',
         ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        $product = $product->with(['productImages']);
        $product = $product->get();
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $this->validate($request,[
            'name' => 'required|min:3|max:20',
            'description' => 'required|min:5|max:150',
            'price' => 'required',
            'category_id' => 'required',
            'images' => 'required|array',
            'images.*' => 'required|mimes:jpg,png,jpeg'
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();

        $images = $request->file('images');
        $image_details = array();
        foreach ($images as $image) {
            $path = $image->store('public');
            $exploded_string = explode('/',$path);
            $image_details[] = new ProductImage ([
                'name' => $exploded_string[1],
                'path' => $exploded_string[0],
                'url' => asset("storage/{$exploded_string[1]}")
            ]);
        }
        $product->productImages()->saveMany($image_details);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function  destroyproductimages(Request $request,Product $product)
    {
          //delete Product Imagex
      
          
          $image = ProductImage::where('id', $request->image_id)
                                ->where('product_id', $product->id)
                                ->first();
                               

            $image_path = $image->path;
            $image_name = $image->name;

            $path_name =  $image_path . "/" . $image_name; 
         
            Storage::delete($path_name);
    
            $image->delete();

            return response()->json([
                "success" => true,
                "message"  => "Image deleted successfully",
            ],200);
    }

    public function featuredProduct(Request $request, Product $product)
    {
        $this->validate($request,[
            'toggle_value' => 'required|boolean'
        ]);

        $toggle_value = $request->toggle_value;
        $product->featured = $toggle_value;
        $product->save();
        return response()->json([
            'success' => true,
            'message' => "Product is" . $toggle_value == 1 ? 'now': 'not more' . 'featured' ,
            'product' => $product
        ],200);
    }
}
