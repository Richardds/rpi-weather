<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeatherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

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
