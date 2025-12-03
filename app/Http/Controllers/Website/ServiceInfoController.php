<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\ServiceInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;

class ServiceInfoController extends Controller
{
    public function index()
    {
        try {

            $data = ServiceInfo::first();
            return view('website.service_info.index', compact('data'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());
            $data = ServiceInfo::find($id);
            // Validate the input fields
            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            $data->title = $request->title;
            $data->description = $request->description;
            $data->update();

            // Success alert
            Alert::success('Update Service Info', 'Data Updated Successfully!');
            return redirect()->route('servie');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
