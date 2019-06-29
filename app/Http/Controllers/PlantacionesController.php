<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publicaciones;
use Carbon\Carbon;

class PlantacionesController extends Controller {

    public function index() {
        $plantaciones = Publicaciones::where('estado', '=', 1)->get();

        $result = [];
        foreach ($plantaciones as $plantacion) {
            array_push($result, [
                'usuario' => $plantacion->usuario,
                'planta' => $plantacion->planta,
                'zona' => $plantacion->zona,
                'descripcion' => $plantacion->descripcion,
                'estado' => $plantacion->estado,
            ]);
        }

        return response()->json($result, 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $idUsuario = $request->get("idUsuario");
        $idPlanta = $request->get("idPlanta");
        $idZona = $request->get("idZona");
        $descripcion = $request->get("descripcion");

        $plantacion = new Publicaciones();
        $plantacion->idUsuario = $idUsuario;
        $plantacion->idPlanta = $idPlanta;
        $plantacion->idZona = $idZona;
        $plantacion->descripcion = $descripcion;

        if ($plantacion->save()) return response()->json(200);

        return response()->json(500);
    }

    public function show($id) {
        $plantacion = Publicaciones::find($id);
        
        if ($plantacion) {
            $data = [
                'usuario' => $plantacion->usuario,
                'planta' => $plantacion->planta,
                'zona' => $plantacion->zona,
                'descripcion' => $plantacion->descripcion,
                'estado' => $plantacion->estado
            ];
            return response()->json($data);
        }

        return response()->json(404);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $idUsuario = $request->get("idUsuario");
        $idPlanta = $request->get("idPlanta");
        $idZona = $request->get("idZona");
        $descripcion = $request->get("descripcion");

        $plantacion = Publicaciones::find($id);

        if ($plantacion) {
            $plantacion->idPlanta = $idPlanta;
            $plantacion->idZona = $idZona;
            $plantacion->descripcion = $descripcion;

            if ($plantacion->update()) return response()->json(200);

            return response()->json(500);
        }

        return response()->json(404);
    }

    public function destroy($id) {
        $plantacion = Publicaciones::find($id);

        if ($plantacion) {
            $plantacion->estado = 0;
    
            if ($plantacion->update()) return response()->json(200);

            return response()->json(500);
        }

        return response()->json(404);
    }
}
