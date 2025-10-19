<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Funcionario extends Model
{
    use HasFactory;
    protected $table = 'funcionario';
    protected $primaryKey = 'matricula';
    public $incrementing = false;
    protected $fillable = ['matricula','nome','senha','endereco','cidade','cargo','sexo','dt_nascimento','salario','agencia_id'];
    protected $keyType = 'int';

    protected $casts = [
        'dt_nascimento' => 'date',
        'salario' => 'decimal:2',
    ];

    public function agencia()
    {
        return $this->belongsTo(Agencia::class, 'agencia_id');
    }

    public function contas()
    {
        return $this->hasMany(Conta::class, 'funcionario_matricula', 'matricula');
    }
}
