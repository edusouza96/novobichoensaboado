<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceCreateRequest extends FormRequest
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
            "name" => "required",
            "value" => "required",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "O campo Nome é obrigatório.",
            "value.required" => "O campo Valor é obrigatório.",
        ];
    }
}
