<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function check_validation_by_model($validator)
	{
		try 
		{
			if($validator->fails()) 
			{
                $validations = $validator->errors()->messages();
				$errorsArray = [];
				foreach($validations as $field_name=>$errors) 
				{
                    foreach($errors as $errorMsg)
                    {
						$errorsArray[] = $errorMsg;
                    }
				}
				$errorMessages = implode("\n", $errorsArray);
				throw new Exception($errorMessages,403);
			}
			
		} catch (\Exception $e) 
		{
			return ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()??404];
		}
	}


	protected function singleValidation($validator)
    {
		try 
		{
            // Get all the errors thrown
            $errors = collect($validator->errors());
			$error  = $errors->unique()->first()[0];
            throw new Exception($error,403);

		} catch (\Exception $e) 
		{
            return ['success'=>false, 'msg'=> $e->getMessage(),'code'=> $e->getCode()??404];
        }
    }
}
