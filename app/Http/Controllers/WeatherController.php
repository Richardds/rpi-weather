<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeatherController extends Controller
{
    /**
     * Time step in minutes.
     */
    const TIME_STEP = 30;

    /**
     * How many minutes to show in a graphs.
     */
    const SHOW_HOURS = 24;

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function graphs(Request $request)
    {
        return view('graphs');
    }

    private function makeApiResponse(array $data, bool $success = true)
    {
        return [
            'data' => $success ? $data : [],
            'success' => $success
        ];
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function data(Request $request)
    {
        $history_query = DB::table('values')
            ->select(['temperature', 'humidity', DB::raw('DATE_FORMAT(timestamp,\'%H:%i\') AS time')])
            ->where([
                [DB::raw('MOD(EXTRACT(MINUTE FROM timestamp), ' . self::TIME_STEP . ')'), '=', 0],
                ['timestamp', '>', Carbon::now()->subHours(self::SHOW_HOURS)]
            ]);

        $now_query = DB::table('values')->select([
            'temperature',
            'humidity',
            DB::raw('DATE_FORMAT(timestamp,\'%H:%i\') AS time')
        ])->orderBy('timestamp', 'DESC');

        $success = true;
        $response_data = [];
        
        try {
            $response_data['history'] = $history_query->get();
            $response_data['now'] = $now_query->first();
        } catch (Exception $e) {
            $success = false;
        }

        return $this->makeApiResponse($response_data, $success);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => 'alpha_num|required',
            'temperature' => 'numeric|required',
            'humidity' => 'numeric|required',
        ]);

        if ($request->get('key') != env('ACCESS_KEY')) {
            return response('Forbidden', 403);
        }

        DB::table('values')->insert([
            'timestamp' => Carbon::now(),
            'temperature' => $request->get('temperature'),
            'humidity' => $request->get('humidity')
        ]);

        return response('OK');
    }
}
