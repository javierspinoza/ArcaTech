<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = 'examenes'; //la tabla con que va a trabajar
    //protected $primaryKey = 'id'; //para cambiar la llave primaria con la que va a trabajar
    protected $fillable = ['id', 'tiempo', 'intento', 'nombre','descripcion']; //los campos con que va a trabajar

    // public function articulos()
    // {
    //     return $this->hasMany('App\Articulo');
    // }
}
