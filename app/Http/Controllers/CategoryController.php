<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    protected $category;

    public function index()
    {
        $categories = Category::latest()->get();
        return view('backend.categories.index', compact('categories'));
    }



    public function getCategoryListData(Request $request)
    {
        try 
        {
            $req= $request->only('category_id');
            if(array_key_exists('category_id',$req))
            {
                $categories = Category::where('id',$req['category_id'])->where('is_active',1)->select('category_title as text','id')->get();
            }else 
            {
                $categories = Category::select('category_title as text','id')->where('is_active',1)->get();
            }

            return response()->json([
                'success'   => true,
                'msg'       => 'data loaded',
                'data'      => $categories,
            ]);

        }catch(Exception $e) 
        {
            $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
            return response()->json($resp, $resp['code']);
        }
    }



    public function createCategory(Request $request,Category $category)
    {
        try 
        {
            $this->category = $category;
            $req            = $request->only($this->category->accessable_field);
            $validator      = Validator::make($req, $this->category::$rules,$this->category::$msg);

            if($validator->fails()) 
            {

                $validation = $this->singleValidation($validator); 
    
                if( !is_null($validation) && !$validation['success'] )
                    throw new Exception($validation['msg'], $validation['code']);
            }


            if($inserted_data = $this->category->create($req))
            {
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Category Created Successfully!',
                    'data'      => $inserted_data,
                ],201);
            }
            else
                throw new Exception('Unable to Create Category!', 400);
            

        } catch (\Exception $e) 
        {
            $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
            return response()->json($resp, $resp['code']);
        }
    }


    public function updateCategory(Request $request, Category $category)
    {
        try 
        {
            $this->category_id  = $request->category_id;

            if(is_null($this->category_id))
                throw new Exception("Category Reference is Missing!", 403);


            $res = $this->checkCategoryExistsInDB();
        
            if(!is_null($res) && !$res['success'])
                throw new Exception($res['msg'], $res['code']);

            $req = $request->only($category->accessable_field);
            $category::$rules['category_title'] = str_replace(':id',$this->category_id,$category::$rules['category_title']);
            $validator = Validator::make($req, $category::$rules, $category::$msg);

            if($validator->fails()) 
            {

                $validation = $this->singleValidation($validator); 
    
                if( !is_null($validation) && !$validation['success'] )
                    throw new Exception($validation['msg'], $validation['code']);
            }


            if($category->where('id', $this->category_id)->update($req))
            {
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Category Updated Successfully!',
                    'data'      => Category::find($this->category_id),
                ],201);
            }
            else
                throw new Exception('Unable to Update Category!', 400);
            

        } catch (\Exception $e) 
        {
            $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
            return response()->json($resp, $resp['code']);
        }
    }




    private function checkCategoryExistsInDB()
    {
        try 
        {
            $category = Category::find($this->category_id);
            
            if(is_null($category))
                throw new Exception("Category Not Found!", 404);
                

        }catch(Exception $e) 
        {
           return $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
        }
    }






















}
