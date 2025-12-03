<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;


class SettingController extends Controller
{
    public function generalSetting()
    {
        try {
            if (!check_access("general.settings")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = GeneralSetting::first();
            return view('backend.settings.general_setting', compact('data'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function generalSettingUpdate(Request $request)
    {
        //        dd($request->all());
        try {
            if (!check_access("general.settings")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = GeneralSetting::first();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'vat_type' => 'required',
                'vat' => 'required',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
                'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',

            ]);
            if ($validator->fails()) {
                Alert::error('Error', "Invalid Data given!");
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->phone = $request->input('phone');
            $data->vat_type = $request->input('vat_type');
            $data->vat = $request->input('vat');
            $data->address = $request->input('address');
            $data->about_company = $request->input('about_company');
            $data->copy_right_text = $request->input('copy_right_text');
            $data->google_map = $request->input('google_map');
            $data->updated_by =   auth()->user()->id;


            if ($data->logo != null) {
                $imagePath = public_path('uploads/settings/' . $data->logo);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file
                }
            }
            $imageName = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = uploadImage($file, 'logo', 'logo');
                $imageName = $file_name;

                $data->logo = $imageName;
            }

            if ($request->hasFile('favicon')) {
                if ($data->favicon) {
                    $oldPhotoPath = 'uploads/settings/' . $data->favicon; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }
                // Upload new photo
                $file = $request->file('favicon');
                $file_name = uploadImage($file, 'settings', 'favicon');
                $data->favicon = $file_name;
            }
            $data->save();

            Alert::success('General Setting', 'General Setting Updated Successfully!');
            return redirect()->back();
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function slider()
    {
        try {
            if (!check_access("slider.update")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = Slider::first();
            return view('backend.settings.slider', compact('data'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function sliderUpdate(Request $request)
    {
        //        dd($request->all());
        try {
            if (!check_access("slider.update")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = Slider::first();
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'title_end' => 'required|string|max:255',
                'bio' => 'required|string|max:255',
                'bg_color' => 'required',
                'video_url' => 'required',
                'button_details' => 'required',
                'button_text' => 'required',
                'button_url' => 'required',
            ]);
            if ($validator->fails()) {
                Alert::error('Error', "Invalid Data given!");
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            $data->title = $request->input('title');
            $data->title_end = $request->input('title_end');
            $data->bio = $request->input('bio');
            $data->bg_color = $request->input('bg_color');
            $data->video_url = $request->input('video_url');
            $data->button_details = $request->input('button_details');
            $data->button_text = $request->input('button_text');
            $data->button_url = $request->input('button_url');

            $data->save();

            Alert::success('Slider', 'Slider Updated Successfully!');
            return redirect()->back();
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }
}