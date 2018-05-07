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

        $admin_contactInfo = env('ADMIN_USER_MAIL');
        $holidays_data = Holiday::all();
        $holiday_info_array =array();

        if(is_null($holidays_data)){
            echo "国民の祝日のデータが未登録の状態です。大変お手数ですが、{$admin_contactInfo}までご連絡いただけると幸いです。";
        }else{

            foreach ($holidays_data as $holiday_info){
                $holiday_info_array[$holiday_info->date] = $holiday_info->holiday_name;
            }

            return response()
                ->json(
                    [
                        '国民の祝日全データ' => $holiday_info_array
                    ],
                    200, [],
                    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
                )->header('Content-Type', 'text/json');
        }

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
        $holidays_data = array();

        //requestされた年数のrecordの存在チェック
        $request_year_flag = DB::table('holidays')->where('year', '=', $id)->first();

        if(is_null($request_year_flag)){
//            header('location:' . '/');
            echo  $id . '年の国民の祝日は登録されていません。';
            exit;
        }else{
            $holidays = DB::table('holidays')->where('year', '=', $id)->get();
            foreach ($holidays as $holiday_info) {
                //配列の追加
                $holidays_data[$holiday_info->date] = $holiday_info->holiday_name;

            }
        }

        return response()->json(
            [
                $id . '年の国民の祝日' => $holidays_data
            ],
            200, [],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        )->header('Content-Type', 'text/json');
    }

    public function showDay($day){

        echo $day;


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
