<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
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
            "owner_name" => "required",
            "name" => "required",
            "breed_id" => "required|numeric",
            
        ];
    }

    public function messages()
    {
        return [
            "owner_name.required" => "O campo Nome do proprietario é obrigatório.",
            "name.required" => "O campo Nome do pet é obrigatório.",
            "breed_id.required" => "O campo Raça é obrigatório.",
            
        ];
    }
}
