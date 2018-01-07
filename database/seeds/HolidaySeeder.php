<?php

use Illuminate\Database\Seeder;

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
        DB::table('holidays')->insert($holidays);
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

        while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {
            if($skipCsvCount == 0){
                $skipCsvCount++;
                continue;
            }
            $dataExploded[] = explode('-',$data[0]);
            $csv[] = $data;
            $holidays[] = array(
                'date' => $data[0],
                'year' => $dataExploded[$i][0],
                'month' => $dataExploded[$i][1],
                'day' => $dataExploded[$i][2],
                'holiday_name' => $data[1],
//                'day' => $data[2],
//                'name' => $data[3],
            );

            $skipCsvCount++;
            $i++;
        }

        fclose($temp);

        return $holidays;

    }

}
