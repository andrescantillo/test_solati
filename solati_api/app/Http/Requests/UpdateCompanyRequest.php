<?php

namespace App\Http\Requests;

use App\Helpers\LogActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
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
            'nit' => [
                'required',
                Rule::unique('companies')
                ->where(function ($query) {
                    $query->where('nit',$this->nit);
                })->ignore($this->route('company')->id)
            ],
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
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
            'nit.unique' => 'El parametro :attribute ya está regitrado',
            'name.required' => 'El parametro :attribute es requerido',
            'address.required' => 'El parametro :attribute es requerido',
            'phone.required' => 'El parametro :attribute es requerido',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        LogActivity::addToLog('Error validation company','false','UpdateCompany','',json_encode($validator->errors(),true));

        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}
