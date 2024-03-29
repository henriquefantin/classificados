<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $titulo
 * @property string $descricao
 * @property int $codFormaPagamento
 * @property int $codTipoAnuncio
 * @property integer $codEmpresa
 * @property string $dataFim
 * @property string $created_at
 * @property string $updated_at
 */
class Produto extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['titulo', 'descricao', 'codFormaPagamento', 'codTipoAnuncio', 'codEmpresa', 'dataFim', 'created_at', 'updated_at'];
}
