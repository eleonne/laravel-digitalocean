<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PokemonController extends Controller
{
    public function send_pokemon(Request $request)
    {
        $data = json_decode($request->list, true);
        Storage::put('pokemon/' . $request->name . '.json', $request->list, 'public');
        
        return response()->json($data, 200);
    }
    
    public function list_folder()
    {
        $data = Storage::files('pokemon/');
        return response()->json($data, 200);
    }
}
