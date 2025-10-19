<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'endereco';
    protected $primaryKey = 'cliente_cpf';
    public $incrementing = false;
    protected $fillable = ['cliente_cpf','tipo','nome','numero','bairro','CEP','cidade','estado','enderecocol'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_cpf', 'cpf');
    }
}
