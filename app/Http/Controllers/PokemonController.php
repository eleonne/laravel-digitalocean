<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PokemonController extends Controller
{

    private $players = [
        ['name' => 'Nicholas', 'captured'=> [], 'picture'=> 'm1.png'],
        ['name' => 'Gabriela', 'captured'=> [], 'picture'=> 'f1.jpg'],
        ['name' => 'João', 'captured'=> [], 'picture'=> 'm2.jpg'],
        ['name' => 'Megan', 'captured'=> [], 'picture'=> 'f2.jpg'],
        ['name' => 'Meggy', 'captured'=> [], 'picture'=> 'f3.png'],
        ['name' => 'Hamza', 'captured'=> [], 'picture'=> 'm3.png'],
        ['name' => 'Zeiri', 'captured'=> [], 'picture'=> 'm4.png'],
        ['name' => 'Gabriele', 'captured'=> [], 'picture'=> 'f4.png'],
        ['name' => 'Luiza', 'captured'=> [], 'picture'=> 'f5.jpg'],
        ['name' => 'John', 'captured'=> [], 'picture'=> 'm5.png']
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

    function compareCaptured($a, $b) {
        if ($a['captured'] == $b['captured']) {
            return 0;
        }
        return ($a['captured'] < $b['captured']) ? 1 : -1;
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
        usort($data, [$this, 'compareCaptured']);
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

    public function getMaxPlayer() {
        return array_reduce($this->players, function ($carry, $item) {
            if ($carry !== null)
                $carry['captured'] = json_decode(Storage::get('pokemon/' . $carry['name'] . '.json'), true);
            $item['captured'] = json_decode(Storage::get('pokemon/' . $item['name'] . '.json'), true);
            if ($carry === null || count($item['captured']) > count($carry['captured'])) {
                return $item;
            }
            return $carry;
        }, null);
    }

    public function populate() {
        // Define the source and destination paths
        // echo base_path();exit;
        $sourcePath = base_path('pokemon');
        $destinationPath = storage_path('app/pokemon');

        // Copy the directory
        if (File::copyDirectory($sourcePath, $destinationPath)) {
            echo "Folder copied successfully.";
        } else {
            echo "Failed to copy the folder.";
        }
    }
}
