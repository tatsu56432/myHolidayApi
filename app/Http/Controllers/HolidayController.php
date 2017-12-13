<?php

namespace App\Http\Controllers;

use App\Holiday;
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

        if($request_year == 2016 || $request_year == 2017 || $request_year == 2018){
            $holidays = DB::table('holidays')->where('year','=',$id)->get();
            foreach ($holidays as $name) {
                $holidays_data[] = $name->name;
            }
        }else{
            $seireki = date('Y');
            $prev_year = $seireki -1;
            $next_year = $seireki +1;
            echo<<< HTML
<p style="text-align: center">ごめんね！URLの入力欄には現在から前後3年の西暦を半角英数字で入れてね！</p>
<p style="text-align: center">例：/api/holidays/{$prev_year}</p>
<p style="text-align: center">例：/api/holidays/{$seireki}</p>
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
