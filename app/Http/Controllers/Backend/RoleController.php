<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Alert;

class RoleController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::select(['id', 'name', 'guard_name', 'created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('permission', function ($data) {
                    $permissions = '';

                    if ($data->permissions) {

                        foreach ($data->permissions as $permission) {
                            $permissions .= '<span class="badge badge-info" style="margin-right: 5px">';
                            $permissions .= $permission->name;
                            $permissions .= '</span>';
                        }
                    }
                    return $permissions;
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    if (check_access("user.edit")) {
                        $action .= '<a href="' . route('admin.role.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }
                    if ($row->name !== 'Super Admin' && check_access("user.delete")) {
                        $action .= '<a href="' . route('admin.role.delete', $row->id) . '" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>';
                    }
                    return $action;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M, Y');
                })
                ->rawColumns(['action', 'permission'])
                ->make(true);
        }
    }

    public function index()
    {
        try {
            if (!check_access("role.list")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            return view('backend.roles.index');
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            if (!check_access("role.create")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $all_permissions    = Permission::all();
            $permissions_groups = Permission::select('group_name as name')->groupBy('group_name')->orderBy('group_name')->get();
            return view('backend.roles.create', compact('permissions_groups', 'all_permissions'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            if (!check_access("role.create")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }
            // Validate the input fields
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                Alert::error('Error', "Invalid Data given!");
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            $role = Role::create([
                'name' => $request->input('name'),
                'guard_name' => 'web',
            ]);

            $permissions = $request->input('permissions');

            if ($role && !empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            // Success alert
            Alert::success('Create Role', 'Role Created Successfully!');
            return redirect()->route('admin.role');
        } catch (\Exception $exception) {
            // Error alert
            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function edit($id)
    {
        try {
            if (!check_access("role.edit")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = Role::find($id);
            $all_permissions    = Permission::all();
            $permissions_groups = Permission::select('group_name as name')->groupBy('group_name')->orderBy('group_name')->get();
            return view('backend.roles.edit', compact('data', 'permissions_groups', 'all_permissions'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            if (!check_access("role.edit")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $role = Role::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                Alert::error('Error', "Invalid Data given!");
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }



            $permissions = $request->input('permissions');
            $name        = $request->input('name');
            Role::where('id', $role->id)->update(['name' => $name]);

            if ($role && !empty($permissions)) {
                $role->syncPermissions($permissions);
            }

            Alert::success('Update Role', 'Role Updated Successfully!');
            return redirect()->route('admin.role');
        } catch (\Exception $exception) {

            Alert::error('Error', $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        try {
            if (!check_access("role.delete")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }
            $data = Role::find($id);
            $data->delete();
            Alert::success('Delete Role', 'Role Deleted Successfully!');
            return redirect()->route('admin.role');
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function permissions()
    {
        try {
            if (!check_access("role.permissions")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $all_permissions    = Permission::all();
            $permissions_groups = Permission::select('group_name as name')->groupBy('group_name')->orderBy('group_name')->get();
            return view('backend.roles.permissions', compact('permissions_groups', 'all_permissions'));
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }
}
