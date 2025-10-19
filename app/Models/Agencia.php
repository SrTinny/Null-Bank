<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    protected $table = 'agencia';
    protected $fillable = ['nome','salario_montante_total','cidade'];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'agencia_id', 'id');
    }
}
