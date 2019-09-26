<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicao extends Model
{
    protected $fillable = [
        'id_requisitante',
        'id_secretario',
        'titulo',
        'descricao',
        'status',
    ];
}
