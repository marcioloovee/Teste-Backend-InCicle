<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        if ($this->isMethod('post')) {
            return [
                'name'          => 'required|string',
                'cpf'           => 'required|string',
                'id_country'    => 'required|numeric|exists:countries,id',
                'id_city'       => 'required|numeric|exists:cities,id'
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'name'          => 'string',
                'cpf'           => 'string',
                'id_country'    => 'numeric|exists:countries,id',
                'id_city'       => 'numeric|exists:cities,id'
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
