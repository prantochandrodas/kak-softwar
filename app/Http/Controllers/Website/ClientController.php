<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alert;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    public function index()
    {
        try {

            return view('website.client.index');
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }


    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('icon', function ($row) {
                    return '<img src="' . asset('uploads/client/' . $row->icon) . '" height="40" alt="Logo">';
                })

                ->addColumn('action', function ($row) {
                    $action = '';

                    $action .= '<a href="' . route('client.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';


                    $action .= '<a href="' . route('client.delete', $row->id) . '" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>';
                    return $action;
                })

                ->rawColumns(['action', 'icon'])
                ->make(true);
        }
    }

    public function create()
    {
        try {


            return view('website.client.create');
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
                $imageName = $file ? uploadImage($file, 'client', 'client') : null;
            }


            // Ensure uniqueness by checking the database


            $data = Client::create([
                'icon' => $imageName,
                'name' => $request->input('name'),
                'url' => $request->input('url'),

            ]);


            // Success alert
            Alert::success('Create client', 'client Created Successfully!');
            return redirect()->route('client');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $data = Client::find($id);

            return view('website.client.edit', compact('data'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());
            $data = Client::find($id);
            // Validate the input fields
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',

                'icon' => 'sometimes|image',
            ]);




            $imageName = $data->icon;
            if ($request->hasFile('icon')) {
                if ($data->icon != null) {
                    $imagePath = public_path('uploads/client/' . $data->icon);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image file
                    }
                }
                $file = $request->file('icon');
                $file_name = uploadImage($file, 'client', 'banner');
                $imageName = $file_name;
            }

            $data->name = $request->name;
            $data->url = $request->url;
            $data->icon = $imageName;
            $data->update();

            // Success alert
            Alert::success('Update client', 'client Updated Successfully!');
            return redirect()->route('client');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function distroy($id)
    {
        $data = Client::find($id);
        if ($data->icon != null) {
            $imagePath = public_path('uploads/client/' . $data->icon);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }

        $data->delete();
        Alert::success('Client delete', 'client Deleted Successfully!');
        return redirect()->route('client');
    }
}
