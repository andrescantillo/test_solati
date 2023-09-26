<?php

namespace App\Http\Requests;

use App\Helpers\LogActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50',
            'nick' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El parametro :attribute es requerido',
            'nick.required' => 'El parametro :attribute es requerido',
            'email.required' => 'El parametro :attribute es requerido',
            "password.required" => "El parametro :attribute es requerido"
        ];
    }

    public function failedValidation(Validator $validator)
    {

        LogActivity::addToLog('Error register','false','RegisterApi','',json_encode($validator->errors(),true));

        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }

}
