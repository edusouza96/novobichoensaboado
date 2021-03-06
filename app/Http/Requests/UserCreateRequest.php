<?php

namespace BichoEnsaboado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            "nickname" => "required",
            "password" => "required",
            "role_id" => "required",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "O campo Nome completo é obrigatório.",
            "nickname.required" => "O campo Nome de usuário é obrigatório.",
            "password.required" => "O campo Senha é obrigatório.",
            "role_id.required" => "O campo Perfil é obrigatório.",
        ];
    }
}
