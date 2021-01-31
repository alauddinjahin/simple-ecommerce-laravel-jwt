<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function listOfProduct()
    {
        try 
        {

            $products = Product::with('category', 'createdBy')->get();

            if(is_null($products) && count($products)<1)
                throw new Exception("Product Not Found!", 404);

            return response()->json([
                'data'      =>$products,
                'success'   =>true,
            ],200);


        } catch (Exception $e) 
        {
            return response()->json([
                'data'      => null,
                'success'   => false,
            ],200);
        }
            
    }



}
