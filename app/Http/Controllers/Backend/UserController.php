<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Department;
use App\Models\Designation;
use App\Models\UserBranch;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getData(Request $request)
    {

        if ($request->ajax()) {
            $data = User::with(['roles:id,name', 'branches'])->select();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('branch', function ($row) {
                    if ($row->branches && $row->branches->count() > 0) {

                        return $row->branches->pluck('branch.name')->implode(', ');
                    }
                    return '';
                })

                ->addColumn('roles', function ($row) {
                    $roles = '';  // Initialize the $roles variable

                    foreach ($row->roles as $role) {
                        $roles .= '<span class="badge badge-info" style="margin-right: 5px">';
                        $roles .= $role->name;  // Display the role name
                        $roles .= '</span>';
                    }
                    return $roles;
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    $toggleIcon = '';
                    if (check_access("user.edit")) {
                        $action .= '<a href="' . route('admin.user.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }
                    // if (check_access("user.delete")) {
                    //     $action .= '<button type="button" class="btn btn-sm btn-danger deleteUser" data-id="' . $row->id . '" data-name="' . e($row->name) . '">
                    //         <i class="fa-solid fa-trash"></i>
                    //     </button>';
                    // }
                    $toggleIcon = $row->status
                        ? '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-danger ms-1"><i class="fa-solid fa-arrow-down"></i></button>'  // Active: Show red "disable" icon
                        : '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-success ms-1"><i class="fa-solid fa-arrow-up"></i></button>'; // Inactive: Show green "enable" icon
                    $action .= $toggleIcon;
                    return $action;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M, Y');
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->editColumn('photo', function ($row) {
                    $img = '';
                    if ($row->photo) {
                        $oldPhotoPath = 'uploads/users/' . $row->photo;
                        $img = '<img src="' . asset($oldPhotoPath) . '" class="mt-2" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; transition: transform 0.3s ease;" alt="User Photo" onmouseover="this.style.transform=\'scale(1.1)\'" onmouseout="this.style.transform=\'scale(1)\'">';
                    }
                    return $img;
                })
                ->rawColumns(['action', 'roles', 'photo', 'branch', 'status'])
                ->make(true);
        }
    }

    public function toggleStatus(Request $request)
    {

        $data = User::find($request->id);
        if ($data) {
            $data->status = !$data->status;
            $data->save();
            return response()->json(['success' => true, 'status' => $data->status]);
        }
        return response()->json(['success' => false], 404);
    }

    public function index()
    {
        try {
            if (!check_access("user.list")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            return view('backend.users.index');
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function getDesignation($id)
    {
        $data = Designation::where('department_id', $id)->where('status', 1)->get();
        // dd($floors);

        return response()->json(['data' => $data]);
    }

    public function create()
    {
        try {
            if (!check_access("user.create")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }
            $branches = Branch::where('status', 1)->get();
            $roles = Role::all();
            return view('backend.users.create', compact('roles', 'branches'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());

        try {
            if (!check_access("user.create")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }
            $isSuperAdmin = in_array(1, $request->roles ?? []);

            // Validate the input fields
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'branch_id' => $isSuperAdmin ? 'nullable|array' : 'nullable|array',
                'branch_id.*' => $isSuperAdmin ? 'nullable|exists:branches,id' : 'nullable|exists:branches,id',
                'address' => 'required',
                'phone' => [
                    'required',
                    'regex:/^(?:\+?88)?01[3-9]\d{8}$/'
                ],
                'password' => 'required|min:6|confirmed', // updated to min:6
                'photo' => 'sometimes|image|mimes:jpeg,wedp,png,jpg,gif|max:2048',
            ], [
                'address.required' => 'Address is required.',
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already in use.',
                'department_id.required' => 'Department is required.',
                'department_id.exists' => 'Selected department does not exist.',
                'designation_id.required' => 'Designation is required.',
                'designation_id.exists' => 'Selected designation does not exist.',
                'phone.required' => 'Phone number is required.',
                'phone.unique' => 'This mobile number is already in use.',
                'phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'photo.image' => 'Uploaded file must be an image.',
                'photo.mimes' => 'Allowed image formats: jpeg, png, jpg, gif.',
                'photo.max' => 'Maximum allowed image size is 2MB.',
            ]);



            if ($validator->fails()) {
                Alert::error('Error', "Invalid Data given!");
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            $inputs = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),

                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'created_by'  => auth()->user()->id,
            ];

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = uploadImage($file, 'users', 'user');
                $inputs['photo'] = $file_name;
            }

            // Create the user
            $user = User::create($inputs);

            $branches = $request->input('branch_id', []);

            if (!empty($branches)) {
                foreach ($branches as $branchId) {
                    // check if branchId is not null or empty
                    if (!empty($branchId)) {
                        UserBranch::create([
                            'branch_id'  => $branchId,
                            'user_id'    => $user->id,
                            'created_by' => auth()->user()->id,
                        ]);
                    }
                }
            }

            $role_ids = $request->input('roles');
            $roles = Role::whereIn('id', $role_ids)->pluck('name')->toArray(); // Convert IDs to names
            $user->syncRoles($roles);

            // Success alert
            Alert::success('Create User', 'User Created Successfully!');
            return redirect()->route('admin.user');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function edit($id)
    {
        try {
            if (!check_access("user.edit")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }
            $branches = Branch::where('status', 1)->get();
            $data = User::with('branches')->find($id);

            $roles = Role::all();
            return view('backend.users.edit', compact('data', 'roles', 'branches'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (!check_access("user.edit")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $user = User::findOrFail($id);
            // $validator = Validator::make($request->all(), [
            //     'name' => 'required|string|max:255',
            //     'email' => "required|email|unique:users,email,$user->id",
            //     'password' => 'nullable|min:6|confirmed',
            //     'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            // ]);
            $isSuperAdmin = in_array(1, $request->roles ?? []);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,$user->id",
                'branch_id' => $isSuperAdmin ? 'nullable|array' : 'nullable|array',
                'branch_id.*' => $isSuperAdmin ? 'nullable|exists:branches,id' : 'nullable|exists:branches,id',
                'address' => 'required',
                'phone' => [
                    'required',
                    'regex:/^(?:\+?88)?01[3-9]\d{8}$/'
                ],
                'password' => 'nullable|min:6|confirmed', // updated to min:6
                'photo' => 'sometimes|image|mimes:jpeg,wedp,png,jpg,gif|max:2048',
            ], [
                'address.required' => 'Address is required.',
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already in use.',
                'department_id.required' => 'Department is required.',
                'department_id.exists' => 'Selected department does not exist.',
                'designation_id.required' => 'Designation is required.',
                'designation_id.exists' => 'Selected designation does not exist.',
                'phone.required' => 'Phone number is required.',
                'phone.unique' => 'This mobile number is already in use.',
                'phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'photo.image' => 'Uploaded file must be an image.',
                'photo.mimes' => 'Allowed image formats: jpeg, png, jpg, gif.',
                'photo.max' => 'Maximum allowed image size is 2MB.',
            ]);
            if ($validator->fails()) {
                $firstError = $validator->errors()->first(); // প্রথম error message

                Alert::error('Error', $firstError);

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            $user->updated_by =   auth()->user()->id;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    $oldPhotoPath = 'storage/uploads/users/' . $user->photo; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }

                // Upload new photo
                $file = $request->file('photo');
                $file_name = uploadImage($file, 'users', 'user');
                $user->photo = $file_name;
            }


            $user->save();
            UserBranch::where('user_id', $user->id)->delete();
            $branches = $request->input('branch_id', []);

            if (!empty($branches)) {
                foreach ($branches as $branchId) {
                    // check if branchId is not null or empty
                    if (!empty($branchId)) {
                        UserBranch::create([
                            'branch_id'  => $branchId,
                            'user_id'    => $user->id,
                            'created_by' => auth()->user()->id,
                        ]);
                    }
                }
            }

            $role_ids = $request->input('roles');
            $roles = Role::whereIn('id', $role_ids)->pluck('name')->toArray(); // Convert IDs to names
            $user->syncRoles($roles);

            Alert::success('Update User', 'User Updated Successfully!');
            return redirect()->route('admin.user');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete(Request $request)
    {
        try {
            if (!check_access("user.delete")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = User::findOrFail($request->id);
            $data->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }



    public function profile()
    {
        try {
            if (!check_access("profile.view")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = User::with(['branch'])->find(\auth()->user()->id);
            $roles = Role::all();
            return view('backend.users.profile', compact('data', 'roles'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function Profile_edit($id)
    {
        try {
            if (!check_access("profile.edit")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }
            $data = User::find($id);
            $roles = Role::all();
            return view('backend.users.profile_edit', compact('data', 'roles'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }


    public function profileUpdate(Request $request, $id)
    {
        try {
            if (!check_access("profile.edit")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }
            $user = User::findOrFail($id);
            // $validator = Validator::make($request->all(), [
            //     'name' => 'required|string|max:255',
            //     'email' => "required|email|unique:users,email,$user->id",
            //     'password' => 'nullable|min:6|confirmed',
            //     'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            // ]);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,$user->id",

                'address' => 'required',
                'phone' => [
                    'required',
                    'regex:/^(?:\+?88)?01[3-9]\d{8}$/'
                ],
                'password' => 'nullable|min:6|confirmed', // updated to min:6
                'photo' => 'sometimes|image|mimes:jpeg,wedp,png,jpg,gif|max:2048',
            ], [
                'address.required' => 'Address is required.',
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already in use.',

                'phone.required' => 'Phone number is required.',
                'phone.unique' => 'This mobile number is already in use.',
                'phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'photo.image' => 'Uploaded file must be an image.',
                'photo.mimes' => 'Allowed image formats: jpeg, png, jpg, gif.',
                'photo.max' => 'Maximum allowed image size is 2MB.',
            ]);
            if ($validator->fails()) {
                Alert::error('Error', "Invalid Data given!");
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');

            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    $oldPhotoPath = 'storage/uploads/users/' . $user->photo; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }

                // Upload new photo
                $file = $request->file('photo');
                $file_name = uploadImage($file, 'users', 'user');
                $user->photo = $file_name;
            }

            $user->updated_by =   auth()->user()->id;
            $user->save();



            Alert::success('Update Profile', 'Profile Updated Successfully!');
            return redirect()->route('admin.user.profile');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
