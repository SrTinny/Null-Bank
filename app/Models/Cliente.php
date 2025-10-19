<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static \Illuminate\Contracts\Pagination\Paginator paginate(int $perPage = null)
 * @method static self create(array $attributes = [])
 */
class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $primaryKey = 'cpf';
    public $incrementing = false;
    protected $fillable = ['cpf','nome','RG','orgao_emissor','UF'];
    protected $keyType = 'string';

    public function telefones()
    {
        return $this->hasMany(ClienteTelefone::class, 'cliente_cpf', 'cpf');
    }

    public function emails()
    {
        return $this->hasMany(ClienteEmail::class, 'cliente_cpf', 'cpf');
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'cliente_cpf', 'cpf');
    }
}
