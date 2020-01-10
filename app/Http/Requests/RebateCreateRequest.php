<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RebateCreateRequest extends FormRequest
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
            "name.required" => "O campo Nome da promoção/desconto é obrigatório.",
            "vaçu.required" => "O campo Valor em % do desconto é obrigatório.",
        ];
    }
}
