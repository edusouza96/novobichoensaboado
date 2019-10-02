<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpenCashdeskRequest extends FormRequest
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
            'valueStart' => 'required_if:openWithoutNewContribute,false',
            'source' => 'required_if:openWithoutNewContribute,false',
        ];
    }

    public function messages()
    {
        return [
            'valueStart.required_if' => 'O campo Valor é obrigatório',
            'source.required_if' => 'O campo Fonte é obrigatório',
        ];
    }
}
