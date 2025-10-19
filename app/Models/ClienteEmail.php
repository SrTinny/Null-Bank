<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteEmail extends Model
{
    protected $table = 'cliente_email';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = ['email','cliente_cpf'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_cpf', 'cpf');
    }
}
