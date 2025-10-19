<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteTelefone extends Model
{
    protected $table = 'cliente_telefones';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = ['telefone','cliente_cpf'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_cpf', 'cpf');
    }
}
