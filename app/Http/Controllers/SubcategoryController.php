<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{

    protected $subcategory_id;

    public function index()
    {
        $subcategories = Subcategory::with('categories:id,category_title')->latest()->get();
        return view('backend.subcategories.index', compact('subcategories'));
    }



    public function getSubcategoryListData(Request $request)
    {
        try 
        {
            $this->category_id = $request->category_id;
            
            if(!is_null($this->category_id))
            {
                $subcategories = Subcategory::where('category_id',$this->category_id)->where('is_active',1)->select('subcategory_title as text','id')->get();
                return response()->json([
                    'success'   => true,
                    'msg'       => 'data loaded',
                    'data'      => $subcategories,
                ]);
            }else 
            {
                $subcategories = Subcategory::select('subcategory_title as text','id')->get();
                return response()->json([
                    'success'   => true,
                    'msg'       => '*',
                    'data'      => $subcategories,
                ]);
            }

        }catch(Exception $e) 
        {
            $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
            return response()->json($resp, $resp['code']);
        }
    }



    public function createSubcategory(Request $request,Subcategory $subcategory)
    {
        try 
        {
            $req            = $request->only($subcategory->accessable_field);
            $validator      = Validator::make($req, $subcategory::$rules, $subcategory::$msg);

            if($validator->fails()) 
            {

                $validation = $this->singleValidation($validator); 
    
                if( !is_null($validation) && !$validation['success'] )
                    throw new Exception($validation['msg'], $validation['code']);
            }


            $result = $this->getSubcategoryDataIfNotExistsInRequest($req);

            if (!$result['success'])
                throw new Exception($result['msg'], $result['code']);


            if($inserted_data = $subcategory->create($result['req_data']))
            {
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Subcategory Created Successfully!',
                    'data'      => Subcategory::with('categories:id,category_title')->find($inserted_data['id']),
                ],201);
            }
            else
                throw new Exception('Unable to Create Subcategory!', 400);
            

        } catch (\Exception $e) 
        {
            $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
            return response()->json($resp, $resp['code']);
        }
    }


    public function updateSubcategory(Request $request, Subcategory $subcategory)
    {
        try 
        {
            $this->subcategory_id  = $request->subcategory_id;

            if(is_null($this->subcategory_id))
                throw new Exception("Subcategory Reference is Missing!", 403);


            $res = $this->checkSubcategoryExistsInDB();
        
            if(!is_null($res) && !$res['success'])
                throw new Exception($res['msg'], $res['code']);

            $req = $request->only($subcategory->accessable_field);
            $subcategory::$rules['subcategory_title'] = str_replace(':id',$this->subcategory_id,$subcategory::$rules['subcategory_title']);
            $validator = Validator::make($req, $subcategory::$rules, $subcategory::$msg);

            if($validator->fails()) 
            {

                $validation = $this->singleValidation($validator); 
    
                if( !is_null($validation) && !$validation['success'] )
                    throw new Exception($validation['msg'], $validation['code']);
            }


            $result = $this->getSubcategoryDataIfNotExistsInRequest($req);

            if (!$result['success'])
                throw new Exception($result['msg'], $result['code']);


            if($subcategory->where('id', $this->subcategory_id)->update($result['req_data']))
            {
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Subcategory Updated Successfully!',
                    'data'      => Subcategory::with('categories:id,category_title')->find($this->subcategory_id),
                ],201);
            }
            else
                throw new Exception('Unable to Update Subcategory!', 400);
            

        } catch (\Exception $e) 
        {
            $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
            return response()->json($resp, $resp['code']);
        }
    }




    private function checkSubcategoryExistsInDB()
    {
        try 
        {
            $subcategory = Subcategory::find($this->subcategory_id);
            
            if(is_null($subcategory))
                throw new Exception("Subcategory Not Found!", 404);
                

        }catch(Exception $e) 
        {
           return $resp = ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()];
        }
    }




    private function getSubcategoryDataIfNotExistsInRequest($req)
    {
        try {

            if (!array_key_exists('category_title', $req)) 
            {
                $category = Category::find($req['category_id']);

                if (is_null($category))
                    throw new Exception("Category Not Found", 404);

                // $req['category_title'] = $category->category_title;
            }

            return ['success' => true, 'msg' => 'ok', 'req_data' => $req];

        } catch (Exception $e) {
            return $resp = ['success' => false, 'msg' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }









}
