<?php

namespace App\Http\Controllers;

use Cache;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    /**
     * History data time step in minutes.
     */
    const HISTORY_TIME_STEP = 30;

    /**
     * Current data time step in minutes.
     */
    const CURRENT_TIME_STEP = 1;

    /**
     * How many hours to show in a graphs.
     */
    const SHOW_HOURS = 24;

    /**
     * History data cache key
     */
    const CACHE_HISTORY_DATA_KEY = 'history_data';

    /**
     * Current data cache key
     */
    const CACHE_CURRENT_DATA_KEY = 'current_data';

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
        $success = true;
        $response_data = [];

        try {
            $history_data = Cache::remember(
                self::CACHE_HISTORY_DATA_KEY,
                self::HISTORY_TIME_STEP, function () {
                return DB::table('values')
                    ->select(['temperature', 'humidity', DB::raw('DATE_FORMAT(timestamp,\'%H:%i\') AS time')])
                    ->where([
                        [DB::raw('MOD(EXTRACT(MINUTE FROM timestamp), ' . self::HISTORY_TIME_STEP . ')'), '=', 0],
                        ['timestamp', '>', Carbon::now()->subHours(self::SHOW_HOURS)]
                    ])->get();
            });

            $current_data = Cache::remember(
                self::CACHE_CURRENT_DATA_KEY,
                self::CURRENT_TIME_STEP, function () {
                return DB::table('values')->select([
                    'temperature',
                    'humidity',
                    DB::raw('DATE_FORMAT(timestamp,\'%H:%i\') AS time')
                ])->orderBy('timestamp', 'DESC')->first();
            });

            $response_data['history'] = $history_data;
            $response_data['now'] = $current_data;
        } catch (Exception $e) {
            $success = false;
            $response_data = [];

            return var_dump($e);
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
