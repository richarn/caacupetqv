<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Storage;

class UploadController extends Controller {
    
    public function images(Request $request) {
        $imagen = $request->file("imagen");
        
        $user = JWTAuth::parseToken()->authenticate();
        
        if ($user) {
            $files = Storage::disk('api')->files($user->id.'/temp');
            
            if (count($files) > 0) {
                foreach ($files as $file) {
                    Storage::disk('api')->delete($file);
                }
            }
            if ($request->hasFile('imagen')) {
                request()->validate([
                    'imagen' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
                ]);
    
                $randomSring = str_random(20);
                $extension = $request->imagen->extension();
                $nombreImagen = $randomSring.'.'.$extension;
                $imagen->move('storage/api/'.$user->id.'/temp', $nombreImagen);
                return response()->json(['success' => true, 'status' => 200]);
            }
            return response()->json(['success' => false, 'status' => 404]);
        }

        return response()->json(['success' => false, 'status' => 401]);
    }
}
