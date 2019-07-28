<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plantas;

class PlantasController extends Controller {

    public function index(Request $request) {
        // if (!$request->ajax()) return redirect('/');

        $plantas = Plantas::where('estado', '=', 1)->get();

        return response()->json($plantas, 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        // if (!$request->ajax()) return redirect('/');

        $nombre = $request->get("nombre");
        $descripcion = $request->get("descripcion");
        $imagen = $request->file("imagen");

        $planta = new Plantas();
        $planta->nombre = $nombre;
        $planta->descripcion = $descripcion;

        if ($request->hasFile('imagen')) {
            request()->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            // $nombreImagen = $imagen->getClientOriginalName();
            $randomSring = str_random(20);
            $extension = $request->imagen->extension();
            $nombreImagen = $randomSring.'.'.$extension;
            $imagen->move('api/images', $nombreImagen);
            $planta->imagen = $nombreImagen;
        }

        if ($planta->save()) return response()->json(200);

        return response()->json(500);
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
            return response()->json($data);
        }

        return response()->json(404);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $nombre = $request->get("nombre");
        $descripcion = $request->get("descripcion");
        $imagen = $request->file("imagen");

        $planta = Plantas::find($id);
        if ($planta) {
            $planta->nombre = $nombre;
            $planta->descripcion = $descripcion;

            if ($request->hasFile('imagen')) {
                request()->validate([
                    'imagen' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
                ]);

                // $nombreImagen = $imagen->getClientOriginalName();
                if ($imagen->getClientOriginalName() != $planta->imagen) {
                    $randomSring = str_random(20);
                    $extension = $request->imagen->extension();
                    $nombreImagen = $randomSring.'.'.$extension;

                    $imagen->move('api/images', $nombreImagen);
                    $planta->imagen = $nombreImagen;
                }
            }

            if ($planta->update()) return response()->json(200);

            return response()->json(500);
        }

        return response()->json(404);
    }


    public function destroy($id) {
        $planta = Plantas::find($id);
        
        if ($planta) {
            $planta->estado = 0;
            if ($planta->update()) return response()->json(200);
            return response()->json(500);
        }

        return response()->json(404);
    }
}
