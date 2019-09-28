<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CloseCashdeskRequest extends FormRequest
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
            'valueWithdraw' => 'required',
            'source' => 'required',
            'closingDate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'valueWithdraw.required' => 'O campo Valor a Retirar é obrigatório',
            'source.required' => 'O campo Destino é obrigatório',
            'closingDate.required' => 'O campo Data do Fechamento é obrigatório',
        ];
    }
}
