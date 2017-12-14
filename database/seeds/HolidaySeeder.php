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
        $file = dirname(__FILE__) . "/" . 'syukujitsu.csv';
        $data = file_get_contents($file);
        $data = mb_convert_encoding($data, 'UTF-8', 'sjis-win');
        //$data = explode("/", $data);
        //$data = (string) $data;
        //$data = implode($data);
        $temp = tmpfile();
        $csv = array();

        fwrite($temp, (string)$data);
        rewind($temp);

        $skipCsvCount = 0;
        $i = 0;
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

//        $seeds = explode("\n", file_get_contents(dirname(__FILE__) . "/" .'syukujitsu.csv'));
//
//        foreach ($seeds as $seed) {
//
//            $holiday = explode("\t", $seed);
//
//            $holidays[] = array(
//                'name'			=> $holiday[0],
//                'year'			=> $holiday[1],
//                'month'		=> $holiday[2],
//                'day'		=> $holiday[3],
//            );
//
//        }

        return $holidays;

    }

}