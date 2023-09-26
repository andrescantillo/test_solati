<?php

namespace App\Http\Requests;

use App\Helpers\LogActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document' => [
                'required',
                Rule::unique('employees')
                ->where(function ($query) {
                    $query->where('document',$this->document);
                })
            ],
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'birthday' => 'required|date',
            'id_companies' => 'required|exists:companies,id'
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
            'document.required' => 'El parametro :attribute es requerido',
            'document.unique' => 'El parametro :attribute ya está regitrado',
            'first_name.required' => 'El parametro :attribute es requerido',
            'last_name.required' => 'El parametro :attribute es requerido',
            'address.required' => 'El parametro :attribute es requerido',
            'phone.required' => 'El parametro :attribute es requerido',
            'birthday.required' => 'El parametro :attribute es requerido',
            'birthday.date' => 'El parametro :attribute no tiene un tipo de fecha permitido',
            "id_companies.required" => "El parametro :attribute es requerido",
            "id_companies.exists" => "El parametro :attribute no existe",
        ];
    }

    public function failedValidation(Validator $validator)
    {

        LogActivity::addToLog('Error validation Employee','false','StoreEmployee','',json_encode($validator->errors(),true));

        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}
