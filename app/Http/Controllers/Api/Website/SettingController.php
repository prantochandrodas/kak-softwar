<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function generalSetting()
    {
        try {
            $data = GeneralSetting::first();
            $data->logo = asset('storage/uploads/settings/'.$data->logo);
            $data->favicon = asset('storage/uploads/settings/'.$data->favicon);

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Something went wrong!",
                'error' => $exception->getMessage()
            ], 500);
        }
    }



}
