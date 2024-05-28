<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PokemonController extends Controller
{

    private $players = [
        ['name' => 'Nicholas', 'captured'=> [], 'picture'=> 'nicholas.jpg'],
        ['name' => 'Gabriela', 'captured'=> [], 'picture'=> 'gabriela.jpg'],
        ['name' => 'João', 'captured'=> [], 'picture'=> 'joao.jpg'],
        ['name' => 'Megan', 'captured'=> [], 'picture'=> 'megan.jpg'],
        ['name' => 'Meggy', 'captured'=> [], 'picture'=> 'meggy.jpg'],
        ['name' => 'Hamza', 'captured'=> [], 'picture'=> 'hamza.jpg'],
        ['name' => 'Zeiri', 'captured'=> [], 'picture'=> 'zeiri.jpg'],
        ['name' => 'Gabriele', 'captured'=> [], 'picture'=> 'gabriele.jpg'],
        ['name' => 'Luiza', 'captured'=> [], 'picture'=> 'luiza.jpg'],
        ['name' => 'John', 'captured'=> [], 'picture'=> 'john.jpg']
    ];

    public function send_pokemon(Request $request)
    {
        $data = json_decode($request->list, true);
        Storage::put('pokemon/' . $request->name . '.json', $request->list, 'public');
        
        return response()->json($data, 200);
    }

    public function start() {
        foreach ($this->players as $player)
            Storage::put('pokemon/' . $player['name'] . '.json', '[]', 'public');
    }
    
    public function list_folder()
    {
        $data = Storage::files('pokemon/');
        return response()->json($data, 200);
    }

    public function getPlayers() {
        $data = [];
        foreach($this->players as $player) {
            $captured = json_decode(Storage::get('pokemon/' . $player['name'] . '.json'), true);
            if (count($captured) > 0) {
                $player['captured'] = $captured;
                $data[] = $player;
            }
        }
        return response()->json($data, 200);
    }

    public function getPlayersList() {
        return response()->json($this->players, 200);
    }

    public function getPlayerDetails(Request $request) {
        $data = [];
        foreach($this->players as $player) {
            if ($player['name'] == $request->name) {
                $captured = json_decode(Storage::get('pokemon/' . $player['name'] . '.json'), true);
                $player['captured'] = $captured;
                $data = $player;
            }
        }
        return response()->json($data, 200);
    }
}
