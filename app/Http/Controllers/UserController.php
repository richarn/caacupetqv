<?php

namespace App\Http\Controllers;

use App\User;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller {
    
    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $role = Roles::where('flag', '=', 'n')->first();
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $role->idRole,
            'password' => Hash::make($request->get('password'))
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'), 201);
    }

    public function getAuthenticatedUser() {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $user = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'image' => $user->image,
                    'estado' => $user->estado,
                    'role' => $user->roles
                ];
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function userList() {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $users = User::where('id', '<>', $user->id)->where('estado', '=', '1')->paginate(20);
            
            foreach ($users as $temp) {
                $temp->role = $temp->roles;
                unset($temp->roles);
            }

            return response()->json($users);
        }
        return response()->json(['success' => false, 'status' => 401]);
    }

    public function deleteUser($id) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $user->roles->flag == 'a') {
            $find = User::where('id', '=', $id);
            if ($find) {
                $find->estado = 0;
                if ($find->update()) return response()->json(['success' => true, 'status' => 200]);
                return response()->json(['success' => false, 'status' => 500]);
            }
            return response()->json(['success' => false, 'status' => 404]);
        }
        return response()->json(['success' => false, 'status' => 401]);
    }

    public function validateEmail(Request $request) {
        $email = $request->get('email');
        $find = User::where('email', '=', $email)->first();
        if ($find) return response()->json(200);
        return response()->json(404);
    }

    public function searchByName(Request $request) {
        $name = $request->get('name');
        $users = User::where('name', 'like', '%'.$name.'%')->paginate(20);

        return response()->json($users, 200);
    }
}
