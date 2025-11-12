<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

//Trait for return validation errors in json response

trait ApiRequest
{
    /**
     * @return never
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json(
            [
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
