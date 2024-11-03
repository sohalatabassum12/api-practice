<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products=Product::get();
        if($products->count()>0){
            return ProductResource::collection($products);

        }else{

           return response()->json(['message'=>'no'],200); 
        }


    
    }
    public function store(Request $request)
    {   $validator= Validator::make($request->all(),[
             'name'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'price'=>'required|integer',
    ]);
    if ($validator->fails()){
        return response()-> json([
            'messages'=>'All fields are mandatory ',
            'error'=>$validator->messages()

        ],422);
    }
    
        $product=Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,


        ]);
        return response()->json([
            'massage'=>'product created successfully',
            'data'=>new ProductResource($product)

        ],200);
    }
    
    public function show(Product $product){
        return new ProductResource($product);
    
    }
    public function update(Request $request,Product $product){
   
        $validator= Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'price'=>'required|integer',
   ]);
    if ($validator->fails()){
        return response()-> json([
            'messages'=>'All fields are mandatory ',
            'error'=>$validator->messages()

        ],422);
   }
   
       $product->update([
           'name'=>$request->name,
           'description'=>$request->description,
           'price'=>$request->price,

       ]);
       return response()->json([
           'massage'=>'product updated successfully',
           'data'=>new ProductResource($product)

       ],200);
    }
    public function distroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'massage'=>'product deleted successfully',
           
 
        ],200);
    }
}
