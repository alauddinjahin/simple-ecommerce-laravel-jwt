<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exact;
use Illuminate\Support\Facades\DB;
use Illuminate\database\QueryException;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{



public function index()
{

    $products = Product::with('category', 'createdBy')->get();
    return view('backend.products.index', compact('products'));
}


public function createProduct(Request $request)
{

    try
    { 
    
        $data               = $request->all();
        $data['created_by'] = auth()->user()->id??1;

        if (array_key_exists('image',$data) && !is_null($data['image']))
        {
            $data['image'] = $this->upload_image($data['image']);
        }

        $id = Product::insertGetId($data);
        if(!$id)
            throw new Exception("Unable to create Product!", 403);

        $product = Product::where('id',$id)->with('category','subcategory')->first();
            

        return response()->json([
            'data'  =>$product,
            'msg'   =>'Product Created'
        ],201);

    }catch(Exception $e)
    {
        return response()->json([
            'data'  =>null,
            'msg'   =>$e->getMessage()
        ],$e->getCode());
    }

}


public function updateProduct(Request $request,Product $product)
{

    try
    { 
    
        $data               = $request->all();
        $data['created_by'] = auth()->user()->id??null;

        if(!array_key_exists('product_id',$data))
            throw new Exception("Product ID Missing!", 403);

        if(is_null($data['product_id']))
            throw new Exception("Product ID is Required!", 403);


        if(is_null($data['unit_price']))
            throw new Exception("Unit price is Required!", 403);

        $regex = "/[A-z]/";

        if(preg_match($regex,$data['unit_price']))
        {
            throw new Exception("Unit price Should Not be String!", 403);
        }            

        $productData = $product->where('id',$data['product_id'])->first();
        if(is_null($productData))
            throw new Exception("Product Not Found!", 403);
        
        $this->image = $productData->image;
        $this->id    = $data['product_id'];
            
        if (array_key_exists('image',$data) && !is_null($data['image']))
        {
            $this->unlink($this->image);
            $data['image'] = $this->upload_image($data['image']);
        }


        unset($data['product_id']);
        $res = $product->where('id',$this->id)->update($data);
        if(!$res)
            throw new Exception("Unable to Update Product!", 403);

        $db_res = Product::where('id',$this->id)->with('category','subcategory')->first();
            

        return response()->json([
            'data'  =>$db_res,
            'msg'   =>'Product Updated'
        ],200);


    }catch(Exception $e)
    {
        return response()->json([
            'data'  =>null,
            'msg'   =>$e->getMessage()
        ],$e->getCode());
    }

}



private function upload_image($base64_image)
{
   try{  
        if(!empty($base64_image))
        {
            $base64_str      = $base64_image;
            $base64_data_img = explode(',',$base64_str);
            $base64_str      = $base64_data_img[1]??$base64_str;
            $image           = base64_decode($base64_str);
            $destinationPath = base_path("public/products/");

            if(!file_exists($destinationPath))
            mkdir($destinationPath);

            $image_name      = Str::uuid()->toString().".png";
            $path            = ($destinationPath.$image_name);

            if ($image){
                file_put_contents($path, $image);
            } 
            return $image_name;
        }

    }catch(Exception $e){
        $exception_code = $e->getCode();
        $response_code 	= $exception_code < 200 || $exception_code > 500 ? 500 : $exception_code;
        return response()->json($this->catch_exception($e), $response_code);
    }
}

// sudo chmod -R 777 storage


 private function unlink($file)
 {
     $pathToUpload = base_path("public/products/");
     if ($file != '' && file_exists($pathToUpload. $file)) {
         @unlink($pathToUpload. $file);
     }
 }



}


