<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nome
 * @property string $cnpj
 * @property string $email
 * @property string $telefone
 * @property string $celular
 * @property string $instagram
 * @property string $cep
 * @property string $pais
 * @property string $estado
 * @property string $cidade
 * @property string $bairro
 * @property string $rua
 * @property string $numero
 * @property string $complemento
 * @property string $arquivo
 * @property int $nivelCliente
 * @property string $created_at
 * @property string $updated_at
 */
class Empresa extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'empresa';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nome', 'cnpj', 'email', 'telefone', 'celular', 'instagram', 'cep', 'pais', 'estado', 'cidade', 'bairro', 'rua', 'numero', 'complemento', 'arquivo', 'nivelCliente', 'created_at', 'updated_at'];
}
