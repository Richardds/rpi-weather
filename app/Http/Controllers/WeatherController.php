<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeatherController extends Controller
{
    /**
     * Time step in minutes.
     */
    const TIME_STEP = 20;

    /**
     * How many minutes to show in a graphs.
     */
    const SHOW_HOURS = 6;

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function graphs(Request $request)
    {
        return view('graphs');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function data(Request $request)
    {
        $query = DB::table('data')
            ->select(['temperature', 'humidity', DB::raw('DATE_FORMAT(timestamp,\'%H:%i\') AS time')])
            ->where([
                [DB::raw('MOD(EXTRACT(MINUTE FROM timestamp), ' . self::TIME_STEP . ')'), '=', 0],
                ['timestamp', '>', Carbon::now()->subHours(self::SHOW_HOURS)]
            ]);

        return $query->get(); // --> JSON
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

        DB::table('data')->insert([
            'timestamp' => Carbon::now(),
            'temperature' => $request->get('temperature'),
            'humidity' => $request->get('humidity')
        ]);

        return response('OK');
    }
}
