<?php

use Illuminate\Database\Seeder;
use \App\Holiday;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $holidays = self::loadHoliday();

        //DBのholidayテーブルないのrレコードの存在チェック
        //レコードがあった場合truncateしてから再度insertする。(データ更新)
        //レコードがなかった場合普通にinsertする。(データ挿入)
        $tableRecord = DB::table('holidays')->where('id', '=', '1')->get();
        if ( count($tableRecord) == 0 ){
            DB::table('holidays')->insert($holidays);
        }else{
            DB::table('holidays')->truncate($holidays);
            DB::table('holidays')->insert($holidays);
        }

    }

    private function loadHoliday()
    {
        //csvファイルを内閣府ホームページから取得
        $csvFileUrl = "http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu.csv";
        //内閣府ホームページから取得できなかった時ようにlocalにもcsvファイルを保持しておく
        $localCsvFile = dirname(__FILE__) . "/" . 'syukujitsu.csv';

        if(!empty($csvFileUrl)){
            $data = file_get_contents($csvFileUrl);
        }else{
            $data = file_get_contents($localCsvFile);
        }

        $data = mb_convert_encoding($data, 'UTF-8', 'sjis-win');
        $temp = tmpfile();
        $csv = array();

        fwrite($temp, (string)$data);
        rewind($temp);

        $skipCsvCount = 0;
        $i = 0;
        $holidays = array();

        //要素順に(日:0〜土:6)を設定
        $day_of_the_week = [
            '日', //0
            '月', //1
            '火', //2
            '水', //3
            '木', //4
            '金', //5
            '土', //6
        ];

        while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {
            if($skipCsvCount == 0){
                $skipCsvCount++;
                continue;
            }
            $dataExploded[] = explode('-',$data[0]);
            $csv[] = $data;

            //曜日を取得
            $date = date('w', strtotime($data[0]));

            $day_of_the_week[$date];
            $holidays[] = array(
                'date' => $data[0],
                'year' => $dataExploded[$i][0],
                'month' => $dataExploded[$i][1],
                'day' => $dataExploded[$i][2],
                'holiday_name' => $data[1],
                'day_of_the_week' => $day_of_the_week[$date] . "曜日",
            );
            $skipCsvCount++;
            $i++;

            //振替休日判定
            if($day_of_the_week[$date] === "日"){
                //国民の祝日が日曜日の場合は振替休日として次の日のデータに変更して再度データ挿入
                $Substitute_holiday = date('Y-m-d', strtotime($data[0] . '+1 day'));
                $date = date('w', strtotime($data[0] . '+1 day'));
                $dataExploded[] = explode('-',$Substitute_holiday);

                $holidays[] = array(
                    'date' => $Substitute_holiday,
                    'year' => $dataExploded[$i][0],
                    'month' => $dataExploded[$i][1],
                    'day' => $dataExploded[$i][2],
                    'holiday_name' => '振替休日',
                    'day_of_the_week' => $day_of_the_week[$date] . "曜日",
                );
                $skipCsvCount++;
                $i++;
            }

        }

        fclose($temp);

        return $holidays;


    }

}
