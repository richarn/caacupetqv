<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zonas;
use JWTAuth;

class ZonasController extends Controller {
    
    public function index() {
        $zonas = Zonas::where('estado', '=', 1)->paginate(20);

        return response()->json($zonas, 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $nombre = $request->get("nombre");

            $zona = new Zonas();
            $zona->nombre = $nombre;

            if ($zona->save()) return response()->json(['success' => true, 'status' => 200, 'zone' => $zone]);

            return response()->json(['success' => false, 'status' => 500]);
        }
        return response()->json(['success' => false, 'status' => 404]);
    }

    public function show($id) {
        $zona = Zonas::find($id);
        
        if ($zona) {
            $data = [
                'idZona' => $zona->idZona,
                'nombre' => $zona->nombre,
                'estado' => $zona->estado
            ];
            return response()->json(['success' => true, 'status' => 200, 'zone' => $zone]);
        }

        return response()->json(['success' => false, 'status' => 404]);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $nombre = $request->get("nombre");

            $zona = Zonas::find($id);
            if ($zona) {
                $zona->nombre = $nombre;

                if ($zona->update()) return response()->json(['success' => true, 'status' => 200, 'zone' => $zone]);

                return response()->json(['success' => false, 'status' => 500]);
            }

            return response()->json(['success' => false, 'status' => 404]);
        }
        return response()->json(['success' => false, 'status' => 401]);
    }

    public function destroy($id) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $zona = Zonas::find($id);

            if ($zona) {
                $zona->estado = 0;
        
                if ($zona->update()) return response()->json(['success' => true, 'status' => 200]);

                return response()->json(['success' => false, 'status' => 500]);
            }

            return response()->json(['success' => false, 'status' => 404]);
        }
        return response()->json(['success' => false, 'status' => 401]);
    }

    public function searchByName(Request $request) {
        $name = $request->get('name');
        $zonas = Zonas::where('nombre', 'like', '%'.$name.'%')->paginate(20);

        return response()->json($zonas, 200);
    }
}
