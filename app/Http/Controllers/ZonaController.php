<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zonas;

class ZonaController extends Controller {
    
    public function index() {
        $zonas = Zonas::get();

        return response()->json($zonas, 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $nombre = $request->get("nombre");

        $zona = new Zonas();
        $zona->nombre = $nombre;

        if ($zona->save()) return response()->json(200);

        return response()->json(500);
    }

    public function show($id) {
        $zona = Zonas::findOrFail($id);
        
        if ($zona) {
            $data = [
                'idZona' => $zona->idzona,
                'nombre' => $zona->nombre,
                'estado' => $zona->estado
            ];
            return response()->json($data);
        }

        return response()->json(404);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $nombre = $request->get("nombre");

        $zona = Zonas::findOrFail($id);
        if ($zona) {
            $zona->nombre = $nombre;

            if ($zona->update()) return response()->json(200);
        }

        return response()->json(500);
    }

    public function destroy($id) {
        $zona = Zonas::findOrFail($id);
        $zona->estado = 0;
        if ($zona->update()) return response()->json(200);

        return response()->json(500);
    }
}
