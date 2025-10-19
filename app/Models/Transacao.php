<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transacao extends Model
{
    use HasFactory;
    protected $table = 'transacao';
    protected $primaryKey = 'numero';
    public $incrementing = true;
    protected $fillable = ['tipo','data_hora','valor','conta_numero'];

    protected $casts = [
        'data_hora' => 'datetime',
        'valor' => 'decimal:2',
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'conta_numero', 'numero');
    }
}
