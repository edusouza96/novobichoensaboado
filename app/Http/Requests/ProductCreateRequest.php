<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            "barcode" => "required",
            "name" => "required",
            "value_sales" => "required",
            "value_buy" => "required",
            "quantity" => "required",
        ];
    }

    public function messages()
    {
        return [
            "barcode.required" => "O campo Código de Barras é obrigatório.",
            "name.required" => "O campo Nome é obrigatório.",
            "value_sales.required" => "O campo Valor de Venda é obrigatório.",
            "value_buy.required" => "O campo Valor de Compra é obrigatório.",
            "quantity.required" => "O campo Quantidade é obrigatório.",
        ];
    }
}
