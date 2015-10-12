<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameOfLifeController extends Controller
{
    public function engine(Request $request, $width, $height)
    {
        $engine = app('engine', [$width, $height]);

        $data = $request->input();

        $engine->import($data);

        $engine->run();

        return response()->json($engine->export());
    }
}