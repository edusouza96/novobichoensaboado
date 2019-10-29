<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutlayCreateRequest extends FormRequest
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
            "description" => "required",
            "value" => "required",
            "date_pay" => "required",
            "source" => "required",
            "cost_center" => "required",
        ];
    }

    public function messages()
    {
        return [
            "description.required" => "O campo Descrição é obrigatório.",
            "value.required" => "O campo Valor é obrigatório.",
            "date_pay.required" => "O campo Data de Pagamento/Vencimento é obrigatório.",
            "source.required" => "O campo Fonte é obrigatório.",
            "cost_center.required" => "O campo Centro de Custo é obrigatório.",
        ];
    }
}
