<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dependente extends Model
{
    protected $table = 'dependentes';
    protected $fillable = ['nome','dt_nascimento','parentesco','idade','funcionario_matricula'];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_matricula', 'matricula');
    }
}
