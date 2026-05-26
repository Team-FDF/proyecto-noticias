<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use SoftDeletes;
    public $timestamps = false;
        protected $fillable = [
        'titulo',
        'lead',
        'descripcion',
        'banner',
        'imagen_lateral',
        'estado',
        'fecha',
        'link'
    ];


}

