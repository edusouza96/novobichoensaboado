<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContributeCashdeskRequest extends FormRequest
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
            'valueContribute' => 'required',
            'source' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'valueContribute.required' => 'O campo Valor é obrigatório',
            'source.required' => 'O campo Fonte é obrigatório',
        ];
    }
}
