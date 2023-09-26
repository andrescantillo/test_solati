<?php

namespace App\Http\Requests;

use App\Helpers\LogActivity as HelpersLogActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
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
            'nit' => [                                                                  
                'required',                                                         
                Rule::exists('companies','nit')->where(function ($query){
                    $query->where('nit', $this->nit);
                }),                                                                  
            ]
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
            'nit.required' => 'El parametro :attribute es requerido',
            'nit.exists' => 'El parametro :attribute no existe'
        ];
    }


    public function failedValidation(Validator $validator)
    {

        HelpersLogActivity::addToLog('Error getUserByNit migration api','false','getUserByNit',json_encode(request()->all()),json_encode($validator->errors(),true));

        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}
