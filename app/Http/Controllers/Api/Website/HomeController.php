<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        try {
            $data = [];
            $slider = Slider::first();
            $data['slider']= $slider;
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
