<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Alert;

class IndustryController extends Controller
{
    public function index()
    {
        try {

            return view('website.industry.index');
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }


    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Industry::orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('icon', function ($row) {
                    return '<img src="' . asset('uploads/industry/' . $row->icon) . '" height="40" alt="Logo">';
                })

                ->addColumn('action', function ($row) {
                    $action = '';

                    $action .= '<a href="' . route('industry.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';


                    $action .= '<a href="' . route('industry.delete', $row->id) . '" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>';
                    return $action;
                })

                ->rawColumns(['action', 'icon'])
                ->make(true);
        }
    }

    public function create()
    {
        try {


            return view('website.industry.create');
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {


            // Validate the input fields
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'icon' => 'required|image',
            ]);

            $imageName = null;
            if ($request->hasFile('icon') && $request->file('icon')) {
                $file = $request->file('icon');
                $imageName = $file ? uploadImage($file, 'industry', 'industry') : null;
            }


            // Ensure uniqueness by checking the database


            $data = Industry::create([
                'icon' => $imageName,
                'name' => $request->input('name'),

            ]);


            // Success alert
            Alert::success('Create Industry', 'Industry Created Successfully!');
            return redirect()->route('industry');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $data = Industry::find($id);

            return view('website.industry.edit', compact('data'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());
            $data = Industry::find($id);
            // Validate the input fields
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',

                'icon' => 'sometimes|image',
            ]);




            $imageName = $data->icon;
            if ($request->hasFile('icon')) {
                if ($data->icon != null) {
                    $imagePath = public_path('uploads/industry/' . $data->icon);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image file
                    }
                }
                $file = $request->file('icon');
                $file_name = uploadImage($file, 'industry', 'banner');
                $imageName = $file_name;
            }

            $data->name = $request->name;
            $data->icon = $imageName;
            $data->update();

            // Success alert
            Alert::success('Update Industry', 'Industry Updated Successfully!');
            return redirect()->route('industry');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function distroy($id)
    {
        $data = Industry::find($id);
        if ($data->icon != null) {
            $imagePath = public_path('uploads/industry/' . $data->icon);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }

        $data->delete();
        Alert::success('Industry delete', 'Industry Deleted Successfully!');
        return redirect()->route('industry');
    }
}
