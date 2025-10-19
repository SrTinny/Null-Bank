<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'numero' => 'required|integer',
            'saldo' => 'required|numeric',
            'agencia_id' => 'required|integer',
            'funcionario_matricula' => 'required|integer',
        ];
    }
}
