<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeSalaryCreateRequest extends FormRequest
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
            "user_id" => "required",
            "date_pay" => "required",
            "description" => "required",
            "value" => "required",
            "source" => "required",
        ];
    }

    public function messages()
    {
        return [
            "user_id.required" => "O campo Funcionário é obrigatório.",
            "date_pay.required" => "O campo Data de Pagamento é obrigatório.",
            "description.required" => "O campo Descrição é obrigatório.",
            "value.required" => "O campo Valor é obrigatório.",
            "source.required" => "O campo Fonte é obrigatório.",
        ];
    }
}
