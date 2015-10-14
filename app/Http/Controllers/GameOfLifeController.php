<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameOfLifeController extends Controller
{
    public function engine(Request $request, $width, $height)
    {
        $engine = app('engine', [$width, $height]);

        $data = $request->input();
        $import = [];
        foreach ($data as $y=>$row) {
            foreach ($row as $x => $v) {
                if ($v) $import[] = [$x, $y];
            }
        }
        $engine->import($import);

        $engine->run();
        $next = $engine->export();

        $export = array_fill(0, $width, array_fill(0, $height, 0));
        foreach ($next as $live) {
            $export[$live[0]][$live[1]] = 1;
        }

        return response()->json($export);
    }

    public function index()
    {
        return view('game-of-life');
    }
}