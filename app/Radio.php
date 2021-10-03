<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $table = 'radios'; //la tabla con que va a trabajar
    //protected $primaryKey = 'id'; //para cambiar la llave primaria con la que va a trabajar
    protected $fillable = ['id', 'respuesta', 'puntos','descripcion']; //los campos con que va a trabajar
}
