<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'id_orientador',
        'titulo',
        'id_aluno',
        'id_secretario',
        'status',
        'start',
        'end',
    ];
}
