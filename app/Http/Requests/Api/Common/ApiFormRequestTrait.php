<?php

namespace App\Http\Requests\Common;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

trait ApiFormRequestTrait
{
    protected function failedValidation(Validator $validator)
    {
        $response['data']    = [];
        $response['status']  = 'NG';
        $response['summary'] = 'Failed validation.';
        $response['errors']  = $validator->errors()->toArray();
        $response['message']  = $validator->errors()->all();


        throw new HttpResponseException(
            response()->json( $response, 422 )
        );
    }
}
