<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Texto;

class TextoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $textoLibre = Texto::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $textoLibre = Texto::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $textoLibre->total(),
                'current_page' => $textoLibre->currentPage(),
                'per_page'     => $textoLibre->perPage(),
                'last_page'    => $textoLibre->lastPage(),
                'from'         => $textoLibre->firstItem(),
                'to'           => $textoLibre->lastItem(),
            ],
            'textoLibre' => $textoLibre
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $textoLibre = new Texto();
        $textoLibre->puntos = $request->puntos;
        $textoLibre->descripcion = $request->descripcion;
        $textoLibre->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $textoLibre = Texto::findOrFail($request->id);
        $textoLibre->puntos = $request->puntos;
        $textoLibre->descripcion = $request->descripcion;
        $textoLibre->save();
    }

    public function destroy(Request $request)
    {
        $textoLibre= Texto::findOrfail($request->id);
        $textoLibre->delete();
    }
}
