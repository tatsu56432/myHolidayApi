<?php

namespace App\Http\Controllers\Api\V2\month;

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


    }


    public function showMonth($id,$month){

        $monthConverted = sprintf("%02d", $month);

        $holidays_data = array();
        $holidays = DB::table('holidays')->where('year', '=', $id)->where('month', '=', $monthConverted)->get();
        $request_month_flag = DB::table('holidays')->where('year', '=', $id)->where('month', '=', $monthConverted)->first();

        if(is_null($request_month_flag)){
            echo  $id . '年'. $month .'月の国民の祝日は登録されていません。';
            exit;
        }else{
            foreach ($holidays as $holiday_info) {
                //配列の追加
                $holidays_data[$holiday_info -> date] = $holiday_info -> holiday_name;
            }
        }

        return response()->json(
            [
                $id . '年'. $monthConverted .'月の国民の祝日' => $holidays_data
            ],
            200, [],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        )->header('Content-Type', 'text/json');

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
