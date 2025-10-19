<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cpf' => 'required|string|max:11',
            'nome' => 'required|string|max:100',
            'RG' => 'required|string|max:15',
            'orgao_emissor' => 'required|string|max:45',
            'UF' => 'required|string|max:45',
        ];
    }
}
