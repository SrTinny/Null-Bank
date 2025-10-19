<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Possui extends Model
{
    protected $table = 'possui';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = ['cliente_cpf','conta_numero','conta_conjunta','login','senha'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_cpf', 'cpf');
    }

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'conta_numero', 'numero');
    }
}
