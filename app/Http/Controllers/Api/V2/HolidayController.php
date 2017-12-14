<?php

namespace App\Http\Controllers\Api\V2;

use App\Holiday;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays_data = Holiday::all();
        return response()->json(
            [
                '国民の祝日データ' => $holidays_data
            ],
            200, [],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT

        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request_year = $id;
        //echo $request_year;
        $current_year = date('Y');
        $prev_year = $current_year - 1;
        $next_year = $current_year + 1;

        if ($request_year == $current_year || $request_year == $prev_year || $request_year == $next_year) {
            $holidays = DB::table('holidays')->where('year', '=', $id)->get();
            foreach ($holidays as $holiday_name) {
                $holidays_data[] = $holiday_name->holiday_name;
            }
        } else {
            echo <<< HTML
<p style="text-align: center">ごめんね！URLの入力欄には現在から前後3年の西暦を半角英数字で入れてね！</p>
<p style="text-align: center">例：/api/holidays/{$prev_year}</p>
<p style="text-align: center">例：/api/holidays/{$current_year}</p>
<p style="text-align: center">例：/api/holidays/{$next_year}</p>
HTML;
            exit;
        }

        return response()->json(
            [
                $id . '年の国民の祝日' => $holidays_data
            ],
            200, [],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
