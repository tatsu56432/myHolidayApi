<?php

namespace App\Http\Controllers\Api\V2\month\day;

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
    public function show()
    {

    }

    public function showDay($id,$month,$day){

        $monthConverted = sprintf("%02d", $month);
        $dayConverted = sprintf("%02d", $day);
        $holidays_data = array();
        $holidays = DB::table('holidays')->where('year', '=', $id)->where('month', '=', $monthConverted)->where('day', '=', $dayConverted)->get();
        $request_day_flag = DB::table('holidays')->where('year', '=', $id)->where('month', '=', $monthConverted)->where('day', '=', $dayConverted)->first();

        if(is_null($request_day_flag)){
            echo  $id . '年'. $month .'月'. $day .'日の国民の祝日は登録されていません。';
            exit;
        }else{
            foreach ($holidays as $holiday_name){
                $holidays_data[] = $holiday_name->holiday_name;
            }
        }

        return response()->json(
            [
                $id . '年'. $monthConverted .'月'. $dayConverted .'日の国民の祝日' => $holidays_data
            ],
            200, [],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        )->header('Content-Type','text/json');

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
