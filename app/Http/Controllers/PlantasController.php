<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plantas;
use JWTAuth;
use Storage;

class PlantasController extends Controller {

    public function index(Request $request) {
        // if (!$request->ajax()) return redirect('/');

        $plantas = Plantas::where('estado', '=', 1)->paginate(20);

        foreach ($plantas as $planta) {
            $planta->publicaciones = $planta->publications->count();
            unset($planta->publications);
        }

        return response()->json($plantas, 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        // if (!$request->ajax()) return redirect('/');
        $user = JWTAuth::parseToken()->authenticate();

        $nombre = $request->get("nombre");
        $descripcion = $request->get("descripcion");
        // $imagen = $request->file("imagen");

        $images = Storage::disk('api')->files($user->id.'/temp');
        
        $planta = new Plantas();
        $planta->nombre = $nombre;
        $planta->descripcion = $descripcion;
        if (count($images) > 0) {
            $name = str_replace("temp", "plantas", $images[0]);
            $planta->imagen = $name;
            Storage::disk('api')->move($images[0], $name);
        }

        if ($planta->save()) return response()->json(['success' => true, 'status' => 200, 'plant' => $planta]);

        return response()->json(['success' => false, 'status' => 500]);
    }

    public function show($id) {
        $planta = Plantas::find($id);
        
        if ($planta) {
            $data = [
                'idPlanta' => $planta->idPlanta,
                'nombre' => $planta->nombre,
                'descripcion' => $planta->descripcion,
                'imagen' => $planta->imagen,
                'estado' => $planta->estado
            ];
            return response()->json(['success' => true, 'status' => 200, 'plants' => $data]);
        }

        return response()->json(['success' => false, 'status' => 404]);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $user = JWTAuth::parseToken()->authenticate();

        $nombre = $request->get("nombre");
        $descripcion = $request->get("descripcion");
        $imagen = $request->file("imagen");

        $planta = Plantas::find($id);
        if ($planta) {
            $planta->nombre = $nombre;
            $planta->descripcion = $descripcion;

            $images = Storage::disk('api')->files($user->id.'/temp');
            if (count($images) > 0) {
                $name = str_replace("temp", "plantas", $images[0]);
                $planta->imagen = $name;
                Storage::disk('api')->move($images[0], $name);
            }

            if ($planta->update()) return response()->json(['success' => true, 'status' => 200, 'plant' => $planta]);

            return response()->json(['success' => false, 'status' => 500]);
        }

        return response()->json(['success' => false, 'status' => 404]);
    }


    public function destroy($id) {
        $planta = Plantas::find($id);
        
        if ($planta) {
            $planta->estado = 0;
            if ($planta->update()) return response()->json(['success' => true, 'status' => 200]);
            return response()->json(['success' => false, 'status' => 500]);
        }

        return response()->json(['success' => false, 'status' => 404]);
    }

    public function searchByName(Request $request) {
        $name = $request->get('name');
        $plantas = Plantas::where('nombre', 'like', '%'.$name.'%')->paginate(20);

        foreach ($plantas as $planta) {
            $planta->publicaciones = $planta->publications->count();
            unset($planta->publications);
        }

        return response()->json($plantas, 200);
    }
}
