<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Multiple;

class MultipleController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $multiples = Multiple::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $multiples = Multiple::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $multiples->total(),
                'current_page' => $multiples->currentPage(),
                'per_page'     => $multiples->perPage(),
                'last_page'    => $multiples->lastPage(),
                'from'         => $multiples->firstItem(),
                'to'           => $multiples->lastItem(),
            ],
            'multiples' => $multiples
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $multiples = new Multiple();
        $multiples->puntos = $request->puntos;
        $multiples->descripcion = $request->descripcion;
        $multiples->respuesta = $request->respuesta;
        $multiples->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $multiples = Multiple::findOrFail($request->id);
        $multiples->puntos = $request->puntos;
        $multiples->descripcion = $request->descripcion;
        $multiples->respuesta = $request->respuesta;
        $multiples->save();
    }

    public function destroy(Request $request)
    {
        $multiples= Multiple::findOrfail($request->id);
        $multiples->delete();
    }
}
