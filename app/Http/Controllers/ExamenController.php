<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Examen;

class ExamenController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $examenes = Examen::orderBy('id', 'desc')->paginate(1);
        }
        else{
            $examenes = Examen::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'examenes' => $examenes
        ];
    }

    public function selectCategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $examenes = new Examen();
        $examenes->nombre = $request->nombre;
        $examenes->descripcion = $request->descripcion;
        $examenes->tiempo = $request->tiempo;
        $examenes->intento = $request->intento;
        $examenes->save();
    }
}
