<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Contoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ApiController extends Controller
{

    public function index()
    {
        return response()
                ->json(['health' => 'OK'], 200);
    }

    public function store(Request $request)
    {
        $arduinoId   = $request->input('arduinoId');
        $ppm         = $request->input('ppm');
        $humidity    = $request->input('humidity');
        $temperature = $request->input('temperature');
        $received    = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
                'arduinoId'   => 'required',
                'ppm'         => 'required',
                'humidity'    => 'required',
                'temperature' => 'required'
            ]);

        if ($validator->fails()) { 
            return response()
                    ->json(
                            $validator
                                ->errors()
                                ->all(),
                            400
                        );
        }

        $new = [
                'arduino_id' => $arduinoId,
                'ppm'        => $ppm,
                'humidity'   => $humidity,
                'temp_in_c'  => $temperature,
                'created_at' => $received,
                'updated_at' => $received
            ];

        DB::table('tbl_records')->insert($new);

        $jsonResponse = ['message' => 'New record successfully saved'];

        return response()->json($jsonResponse, 200);
    }

    public function get()
    {
        // API for getting all of the records
        $data = DB::table('tbl_records')->get();
        return response()->json($data, 200);
    }


}