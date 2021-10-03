<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Radio;

class RadioController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $radios = Radio::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $radios = Radio::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $radios->total(),
                'current_page' => $radios->currentPage(),
                'per_page'     => $radios->perPage(),
                'last_page'    => $radios->lastPage(),
                'from'         => $radios->firstItem(),
                'to'           => $radios->lastItem(),
            ],
            'radios' => $radios
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $radios = new Radio();
        $radios->puntos = $request->puntos;
        $radios->descripcion = $request->descripcion;
        $radios->respuesta = $request->respuesta;
        $radios->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $radios = Radio::findOrFail($request->id);
        $radios->puntos = $request->puntos;
        $radios->descripcion = $request->descripcion;
        $radios->respuesta = $request->respuesta;
        $radios->save();
    }

    public function destroy(Request $request)
    {
        $radios= Radio::findOrfail($request->id);
        $radios->delete();
    }
}
