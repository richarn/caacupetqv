<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publicaciones;
use Carbon\Carbon;

class PlantacionesController extends Controller {

    public function index() {
        $plantaciones = Publicaciones::where('estado', '=', 1)->paginate(20);

        foreach ($plantaciones as $plantacion) {
            $plantacion->usuario;
            $plantacion->planta;
            $plantacion->zona;
            unset($plantacion->idUsuario);
            unset($plantacion->idPlanta);
            unset($plantacion->idZona);
        }

        return response()->json($plantaciones, 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $idUsuario = $request->get("idUsuario");
        $idPlanta = $request->get("idPlanta");
        $idZona = $request->get("idZona");
        $descripcion = $request->get("descripcion");
        $latLng = $request->get("latLng");

        $plantacion = new Publicaciones();
        $plantacion->idUsuario = $idUsuario;
        $plantacion->idPlanta = $idPlanta;
        $plantacion->idZona = $idZona;
        $plantacion->descripcion = $descripcion;
        $plantacion->latLng = $latLng;

        if ($plantacion->save()) return response()->json(['success' => true, 'status' => 200, 'publication' => $plantacion]);

        return response()->json(['success' => false, 'status' => 500]);
    }

    public function show($id) {
        $plantacion = Publicaciones::find($id);
        
        if ($plantacion) {
            $data = [
                'usuario' => $plantacion->usuario,
                'planta' => $plantacion->planta,
                'zona' => $plantacion->zona,
                'descripcion' => $plantacion->descripcion,
                'latLng' => $plantacion->latLng,
                'estado' => $plantacion->estado
            ];
            return response()->json(['success' => true, 'status' => 200, 'publicationes' => $data]);
        }

        return response()->json(['success' => false, 'status' => 404]);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $idUsuario = $request->get("idUsuario");
        $idPlanta = $request->get("idPlanta");
        $idZona = $request->get("idZona");
        $descripcion = $request->get("descripcion");
        $latLng = $request->get("latLng");

        $plantacion = Publicaciones::find($id);

        if ($plantacion) {
            $plantacion->idPlanta = $idPlanta;
            $plantacion->idZona = $idZona;
            $plantacion->descripcion = $descripcion;
            $plantacion->latLng = $latLng;

            if ($plantacion->update()) return response()->json(['success' => true, 'status' => 200, 'publication' => $plantacion]);

            return response()->json(['success' => false, 'status' => 500]);
        }

        return response()->json(['success' => false, 'status' => 404]);
    }

    public function destroy($id) {
        $plantacion = Publicaciones::find($id);

        if ($plantacion) {
            $plantacion->estado = 0;
    
            if ($plantacion->update()) return response()->json(['success' => true, 'status' => 200]);

            return response()->json(['success' => false, 'status' => 500]);
        }

        return response()->json(['success' => false, 'status' => 404]);
    }
}
