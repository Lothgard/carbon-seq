<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * @param frequency - shows the current viewing frequency of data
     * 1 - daily
     * 2 - weekly
     * 3 - monthly
     * default: daily
     */
    public function show(Request $request)
    {
        // Method-wide constants
        $borderWidth = 1;

        $a1BgColor     = "rgba(205, 220, 57, 0)";
        $a1BorderColor = "rgba(205, 220, 57, 0.7)";
        $a1PointColor  = "rgba(205, 220, 57, 1)";

        $a2BgColor     = "rgba(255, 152, 0, 0)";
        $a2BorderColor = "rgba(255, 152, 0, 0.7)";
        $a2PointColor  = "rgba(255, 152, 0, 1)";

        $frequency = $request->input('frequency');

        if (!isset($frequency) || (isset($frequency) && $frequency > 3)) {
            return redirect('/dashboard?frequency=1');
        }

        $data['frequency'] = $frequency;

        switch($frequency) {

            // WEEKLY
            // case 2:
            //     $where1 = [];
            //     $where2 = [];
            //     $labels = [];

            //     $arduinoOneCarbon = DB::table('tbl_records')->where($where1)->pluck('ppm');
            //     $arduinoTwoCarbon = DB::table('tbl_records')->where($where2)->pluck('ppm');

            //     $arduinoOneHumidity = DB::table('tbl_records')->where($where1)->pluck('humidity');
            //     $arduinoTwoHumidity = DB::table('tbl_records')->where($where2)->pluck('humidity');

            //     $arduinoOneTemp = DB::table('tbl_records')->where($where1)->pluck('temp_in_c');
            //     $arduinoTwoTemp = DB::table('tbl_records')->where($where2)->pluck('temp_in_c');
            //     break;

            // MONTHLY
            case 3:
                $labels = $this->generateMonthlyLabels();

                $data['arduinodata'] = DB::select('SELECT DATE_FORMAT(created_at, "%M %Y") as created_at, arduino_id, AVG(ppm) AS ppm, AVG(humidity) AS humidity, AVG(temp_in_c) AS temp_in_c FROM tbl_records GROUP BY arduino_id, YEAR(created_at), MONTH(created_at)');

                $arduinoOneCarbon = $this->createArray(DB::select('SELECT AVG(ppm) AS ppm FROM tbl_records WHERE arduino_id = 1 GROUP BY YEAR(created_at), MONTH(created_at)'), 'ppm');
                $arduinoTwoCarbon = $this->createArray(DB::select('SELECT AVG(ppm) AS ppm FROM tbl_records WHERE arduino_id = 2 GROUP BY YEAR(created_at), MONTH(created_at)'), 'ppm');

                $arduinoOneHumidity = $this->createArray(DB::select('SELECT AVG(humidity) AS humidity FROM tbl_records WHERE arduino_id = 1 GROUP BY YEAR(created_at), MONTH(created_at)'), 'humidity');
                $arduinoTwoHumidity = $this->createArray(DB::select('SELECT AVG(humidity) AS humidity FROM tbl_records WHERE arduino_id = 2 GROUP BY YEAR(created_at), MONTH(created_at)'), 'humidity');

                $arduinoOneTemp = $this->createArray(DB::select('SELECT AVG(temp_in_c) AS temp_in_c FROM tbl_records WHERE arduino_id = 1 GROUP BY YEAR(created_at), MONTH(created_at)'), 'temp_in_c');
                $arduinoTwoTemp = $this->createArray(DB::select('SELECT AVG(temp_in_c) AS temp_in_c FROM tbl_records WHERE arduino_id = 2 GROUP BY YEAR(created_at), MONTH(created_at)'), 'temp_in_c');

                break;

            // DAILY
            default:
                $labels = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24];
                
                $data['arduinodata'] = DB::select('SELECT * FROM tbl_records WHERE DATE(created_at) = CURDATE()');

                $arduinoOneCarbon = $this->createArray(DB::select('SELECT ppm FROM tbl_records WHERE DATE(created_at) = CURDATE() AND arduino_id = 1'), 'ppm');
                $arduinoTwoCarbon = $this->createArray(DB::select('SELECT ppm FROM tbl_records WHERE DATE(created_at) = CURDATE() AND arduino_id = 2'), 'ppm');

                $arduinoOneHumidity = $this->createArray(DB::select('SELECT humidity FROM tbl_records WHERE DATE(created_at) = CURDATE() AND arduino_id = 1'), 'humidity');
                $arduinoTwoHumidity = $this->createArray(DB::select('SELECT humidity FROM tbl_records WHERE DATE(created_at) = CURDATE() AND arduino_id = 2'), 'humidity');

                $arduinoOneTemp = $this->createArray(DB::select('SELECT temp_in_c FROM tbl_records WHERE DATE(created_at) = CURDATE() AND arduino_id = 1'), 'temp_in_c');
                $arduinoTwoTemp = $this->createArray(DB::select('SELECT temp_in_c FROM tbl_records WHERE DATE(created_at) = CURDATE() AND arduino_id = 2'), 'temp_in_c');

                break;
        }

        
        // CREATION OF TABLES


        $data['carbon'] = app()->chartjs
                ->name('chrCarbon')
                ->type('line')
                ->size(['width' => 400, 'height' => 200])
                ->labels($labels)
                ->datasets([
                    [
                        "label" => "Arduino 1",
                        'backgroundColor' => $a1BgColor,
                        'borderColor' => $a1BorderColor,
                        "pointBorderColor" => $a1PointColor,
                        "pointBackgroundColor" => $a1PointColor,
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        "borderWidth" => $borderWidth,
                        'data' => $arduinoOneCarbon
                    ],
                    [
                        "label" => "Arduino 2",
                        'backgroundColor' => $a2BgColor,
                        'borderColor' => $a2BorderColor,
                        "pointBorderColor" => $a2PointColor,
                        "pointBackgroundColor" => $a2PointColor,
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        "borderWidth" => $borderWidth,
                        'data' => $arduinoTwoCarbon
                    ]
                ])
                ->options([]);

            $data['humidity'] = app()->chartjs
                ->name('chrHumidity')
                ->type('line')
                ->size(['width' => 400, 'height' => 200])
                ->labels($labels)
                ->datasets([
                    [
                        "label" => "Arduino 1",
                        'backgroundColor' => $a1BgColor,
                        'borderColor' => $a1BorderColor,
                        "pointBorderColor" => $a1PointColor,
                        "pointBackgroundColor" => $a1PointColor,
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        "borderWidth" => $borderWidth,
                        'data' => $arduinoOneHumidity,
                    ],
                    [
                        "label" => "Arduino 2",
                        'backgroundColor' => $a2BgColor,
                        'borderColor' => $a2BorderColor,
                        "pointBorderColor" => $a2PointColor,
                        "pointBackgroundColor" => $a2PointColor,
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        "borderWidth" => $borderWidth,
                        'data' => $arduinoTwoHumidity
                    ]
                ])
                ->options([]);

            $data['temperature'] = app()->chartjs
                ->name('chrTemperature')
                ->type('line')
                ->size(['width' => 400, 'height' => 200])
                ->labels($labels)
                ->datasets([
                    [
                        "label" => "Arduino 1",
                        'backgroundColor' => $a1BgColor,
                        'borderColor' => $a1BorderColor,
                        "pointBorderColor" => $a1PointColor,
                        "pointBackgroundColor" => $a1PointColor,
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        "borderWidth" => $borderWidth,
                        'data' => $arduinoOneTemp
                    ],
                    [
                        "label" => "Arduino 2",
                        'backgroundColor' => $a2BgColor,
                        'borderColor' => $a2BorderColor,
                        "pointBorderColor" => $a2PointColor,
                        "pointBackgroundColor" => $a2PointColor,
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        "borderWidth" => $borderWidth,
                        'data' => $arduinoTwoTemp
                    ]
                ])
                ->options([]);


        return view('dashboard.dashboard', $data);
    }


    private function createArray($object, $key)
    {
        $stack = [];

        foreach ($object as $item) {
            array_push($stack, $item->$key);
        }

        return $stack;
    }

    private function generateWeeklyLabels()
    {
        $data = DB::select('SELECT * FROM tbl_records WHERE created_at IN (ADDTIME(CURDATE, 14), DATE_SUB(CURDATE, INTERVAL 14 DAY))');
    }


    private function generateMonthlyLabels()
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $nowYear = date('Y');

        $data = DB::table('tbl_records')
                ->select(DB::raw('DATE_FORMAT(created_at, "%m") AS datestamp'))
                ->whereYear('created_at', $nowYear)
                ->orderBy('datestamp', 'ASC')
                ->first();

        $startMonth = intval($data->datestamp);

        $offsetMonths = [];

        for ($i = 0; $i < $startMonth - 1; $i++) {
            array_push($offsetMonths, $months[$i]);
        }

        array_splice($months, 0, $startMonth -1);

        return array_merge($months, $offsetMonths);
    }


}