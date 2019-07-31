<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use JWTAuth;

class RolesController extends Controller {
    
    public function index() {
        $roles = Roles::where('estado', '=', 1)->paginate(20);
        return response()->json($roles, 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $nombre = $request->get("nombre");
            $flag = $request->get("flag");

            $role = new Roles();
            $role->nombre = $nombre;
            $role->flag = $flag;

            if ($role->save()) return response()->json(200);

            return response()->json(500);
        }
        return response()->json(401);
    }

    public function show($id) {
        $role = Roles::find($id);
        
        if ($role) {
            $data = [
                'idRole' => $role->idRole,
                'nombre' => $role->nombre,
                'flag' => $role->flag,
                'estado' => $role->estado
            ];
            return response()->json($data);
        }

        return response()->json(404);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $nombre = $request->get("nombre");
            $flag = $request->get("flag");

            $role = Roles::find($id);
            if ($role) {
                $role->nombre = $nombre;
                $role->flag = $flag;

                if ($role->update()) return response()->json(200);

                return response()->json(500);
            }

            return response()->json(404);
        }
        return response()->json(401);
    }

    public function destroy($id) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $role = Roles::find($id);
            
            if ($role) {
                $role->estado = 0;
                if ($role->update()) return response()->json(200);
                return response()->json(500);
            }

            return response()->json(404);
        }
        return response()->json(401);
    }
}
