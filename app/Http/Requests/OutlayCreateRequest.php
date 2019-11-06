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
            "value" => "required_if:paid,1",
            "date_pay" => "required_if:paid,1",
            "source" => "required_if:paid,1",
            "cost_center" => "required",
        ];
    }

    public function messages()
    {
        return [
            "description.required" => "O campo Descrição é obrigatório.",
            "value.required_if" => "O campo Valor é obrigatório.",
            "date_pay.required_if" => "O campo Data de Pagamento/Vencimento é obrigatório.",
            "source.required_if" => "O campo Fonte é obrigatório.",
            "cost_center.required" => "O campo Centro de Custo é obrigatório.",
        ];
    }
}
