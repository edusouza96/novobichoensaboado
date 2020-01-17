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
            "neighborhood_id" => "required|numeric",
            "phone1" => "required|numeric|digits_between:8,9",
            "phone2" => "sometimes|numeric|digits_between:8,9",
        ];
    }

    public function messages()
    {
        return [
            "owner_name.required" => "O campo Nome do proprietario é obrigatório.",
            "name.required" => "O campo Nome do pet é obrigatório.",
            "breed_id.required" => "O campo Raça é obrigatório.",
            "neighborhood_id.required" => "O campo Bairro é obrigatório.",
            "phone1.required" => "O campo Telefone 1 é obrigatório.",
        ];
    }
}
