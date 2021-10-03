<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Texto extends Model
{
    protected $table = 'textos'; //la tabla con que va a trabajar
    //protected $primaryKey = 'id'; //para cambiar la llave primaria con la que va a trabajar
    protected $fillable = ['id', 'puntos', 'descripcion']; //los campos con que va a trabajar
}
