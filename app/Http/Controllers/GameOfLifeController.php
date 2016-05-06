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

    public function stream(Request $request, $width, $height)
    {
        /** @var \CTLaravel\GoL\Engine $engine */
        $engine = app('engine', [$width, $height]);
        $import = [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0],
            [0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($engine, $width, $height, $import) {
            $count = 50;
            echo "retry: 10000\n";
            while ($count >= 0) {
                $export = $this->translate($width, $height, $import, $engine);
                echo "id: " . $count . "\n";
                echo "data: " . json_encode($export) . "\n\n";
                $import = $export;
                ob_flush();
                flush();

                $count--;
                sleep(1);
            }
            echo "data: " . json_encode([]) . "\n\n";

            ob_flush();
            flush();
        });
        $response->headers->set('X-Accel-Buffering', ' no');
        $response->headers->set('Content-Type', 'text/event-stream');

        return $response;
    }

    /**
     * @param $width
     * @param $height
     * @param $data
     * @param $engine \CTLaravel\GoL\Engine
     *
     * @return array
     */
    public function translate($width, $height, $data, $engine)
    {
        $import = [];
        foreach ($data as $y => $row) {
            foreach ($row as $x => $v) {
                if ($v) $import[] = [$x, $y];
            }
        }
        $engine->import($import);

        $engine->run();
        $next = $engine->export();

        $export = array_fill(0, $width, array_fill(0, $height, 0));

        foreach ($next as $live) {
            $export[($live[0])][($live[1])] = 1;
        }

        return $export;
    }

    public function socket(Request $request)
    {
        return view('socket');
    }
}