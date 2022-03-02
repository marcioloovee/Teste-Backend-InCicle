<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CountryRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'name'    => 'required|string|unique:countries,name',
                'code'    => 'required|unique:countries,code|size:2'
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'name'    => 'string|unique:countries,name,'.$this->country->id,
                'code'    => 'string|size:2|unique:countries,code,'.$this->country->id
            ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json($errors, 400)
        );
    }
}
