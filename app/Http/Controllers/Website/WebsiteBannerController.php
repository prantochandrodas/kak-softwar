<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\WebsiteBanner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Alert;
use Illuminate\Support\Facades\Validator;

class WebsiteBannerController extends Controller
{
    public function index()
    {
        try {

            $data = WebsiteBanner::first();
            return view('website.banner.index', compact('data'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }


    // public function getData(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = WebsiteBanner::orderBy('created_at', 'desc');
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('image', function ($row) {
    //                 return '<img src="' . asset('uploads/banners/' . $row->id) . '" height="40" alt="Logo">';
    //             })

    //             ->addColumn('action', function ($row) {
    //                 $action = '';

    //                 $action .= '<a href="' . route('website-banner.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';


    //                 $action .= '<a href="' . route('website-banner.delete', $row->id) . '" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>';
    //                 return $action;
    //             })

    //             ->rawColumns(['action', 'image'])
    //             ->make(true);
    //     }
    // }

    // public function create()
    // {
    //     try {


    //         return view('website.project.create');
    //     } catch (\Exception $exception) {
    //         Alert::error('Error', $exception->getMessage());
    //         return redirect()->back();
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {

            $data = WebsiteBanner::find($id);
            // Validate the input fields
            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string|max:255',
                'subtitle' => 'nullable|string',
                'description' => 'nullable|string',
                'image' => 'sometimes|image',
            ]);



            $imageName = $data->image; // Default to existing image if not updated
            if ($request->hasFile('image')) {
                if ($data->image != null) {
                    $imagePath = public_path('uploads/banners/' . $data->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image file
                    }
                }
                $file = $request->file('image');
                $file_name = uploadImage($file, 'banners', 'banner');
                $imageName = $file_name;
            }

            $data->title = $request->title;
            $data->subtitle = $request->subtitle;
            $data->description = $request->description;
            $data->image = $imageName;
            $data->update();

            // Success alert
            Alert::success('Create banner', 'Banner Created Successfully!');
            return redirect()->route('website-banner');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
