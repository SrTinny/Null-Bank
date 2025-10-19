<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static \Illuminate\Contracts\Pagination\Paginator paginate(int $perPage = null)
 * @method static self create(array $attributes = [])
 */
class Conta extends Model
{
    use HasFactory;
    protected $table = 'conta';
    protected $primaryKey = 'numero';
    public $incrementing = false;
    protected $fillable = ['numero','saldo','agencia_id','funcionario_matricula'];
    protected $keyType = 'int';

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    public function agencia()
    {
        return $this->belongsTo(Agencia::class, 'agencia_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_matricula', 'matricula');
    }

    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'conta_numero', 'numero');
    }
}
