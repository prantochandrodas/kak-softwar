<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BankBranch;
use App\Models\Branch;
use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BankAccountController extends Controller
{

    public function getBranch($id)
    {
        $data = BankBranch::where('bank_id', $id)->where('status', 1)->get();
        // dd($floors);

        return response()->json(['data' => $data]);
    }
    public function getAccount($id)
    {
        $data = BankAccount::where('branch_id', $id)->where('status', 1)->get();
        // dd($floors);

        return response()->json(['data' => $data]);
    }
    public function index()
    {
        if (!check_access("bank-account.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        return view('backend.bank_account.index');
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                $data = BankAccount::with('bank', 'branch', 'bankBranch')->orderBy('created_at', 'desc')->get();
            } else {

                $data = BankAccount::with('bank', 'branch', 'bankBranch')->where('branch_id', session('branch_id'))->orderBy('created_at', 'desc')->get();
            }


            return DataTables::of($data)
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('bank', function ($row) {
                    return $row->bank ? $row->bank->name : '';
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch ? $row->branch->name : '';
                })
                ->addColumn('bank_branch', function ($row) {
                    return $row->bankBranch ? $row->bankBranch->name : '';
                })
                ->addColumn('action', function ($row) {
                    $deleteBtn = '';
                    $editBtn = '';
                    $action = '';
                    $toggleIcon = '';

                    $deleteUrl = route('bank-account.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');
                    if (check_access("bank-account.edit")) {
                        $editBtn = '<a href="' . route('bank-account.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }

                    if (check_access("bank-account.status")) {
                        // Status Toggle Icon Button
                        $toggleIcon = $row->status
                            ? '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-danger ms-1"><i class="fa-solid fa-arrow-down"></i></button>'  // Active: Show red "disable" icon
                            : '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-success ms-1"><i class="fa-solid fa-arrow-up"></i></button>'; // Inactive: Show green "enable" icon
                    }
                    $toggleBtn =  $toggleIcon;
                    $showBtn = '<button data-id="' . $row->id . '" class="show btn btn-sm btn-info me-2 rounded" style="padding:8px;">
                        <i class="fa fa-eye"></i>
                    </button>';
                    $deleteBtn = '<form action="' . $deleteUrl . '" method="POST">
                    ' . $csrfToken . '
                    ' . $method . '
                    <button type="submit" class="delete btn btn-danger btn-sm" style="padding:8px;">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;">
                                <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            </button>
                </form>';
                    return '<div class="d-flex align-items-center  mb-2">'
                        . $editBtn . $toggleBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'category', 'bank_branch'])
                ->make(true);
        }
    }
    // public function show($id)
    // {

    //     $data = Product::with('group', 'category', 'brand')->findOrFail($id);

    //     return view('backend.bank_account.show', compact('data'));
    // }
    public function create()
    {
        if (!check_access("bank-account.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $banks = Bank::where('status', 1)->get();

        return view('backend.bank_account.create', compact('banks'));
    }
    public function store(Request $request)
    {
        if (!check_access("bank-account.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'bank_branch_id' => 'required|exists:bank_branches,id',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|numeric',
            'account_type' => 'required',
        ]);

        try {
            DB::beginTransaction();


            $bank = Bank::findOrFail($request->bank_id);
            $fundId = $bank->fund_id;

            if ($fundId) {
                $fund = Fund::find($fundId);
                if ($fund) {
                    $addAmount = $request->opening_balance ?? 0;
                    $fund->balance += $addAmount;
                    $fund->opening_balance += $addAmount;
                    $fund->save();
                }
            }

            BankAccount::create([
                'branch_id' => $request->branch_id ?? session('branch_id'),
                'bank_id' => $request->bank_id,
                'bank_branch_id' => $request->bank_branch_id,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'account_type' => $request->account_type,
                'date' => date('Y-m-d'),
                'status' => 1,
                'created_by'  => auth()->user()->id,
            ]);

            DB::commit();

            Alert::success('Create Bank Account', 'Bank Account Created Successfully!');
            return redirect()->route('bank-account.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        if (!check_access("bank-account.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = BankAccount::findOrFail($id);
        $banks = Bank::where('status', 1)->get();


        return view('backend.bank_account.edit', compact('data', 'banks'));
    }

    public function update(Request $request, $id)
    {
        if (!check_access("bank-account.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'bank_id' => 'required|exists:banks,id',
            'bank_branch_id' => 'required|exists:bank_branches,id',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|numeric',
            'account_type' => 'required',
        ]);


        try {
            DB::beginTransaction();



            $find = BankAccount::find($id);

            $status = 0;
            if (!$request->status) {
                $status = 0;
            } else {
                $status = $request->status;
            }


            $data = [
                'bank_id' => $request->bank_id,
                'branch_id' =>  $request->branch_id ?? session('branch_id'),
                'bank_branch_id' => $request->bank_branch_id,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'account_type' => $request->account_type,
                'status' => $status,
                'updated_by' =>   auth()->user()->id,
            ];
            $find->update($data);

            DB::commit();
            Alert::success('Update Product', 'Product Updated Successfully!');
            return redirect()->route('bank-account.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!');
            return redirect()->route('bank-account.index');
        }
    }


    public function toggleStatus(Request $request)
    {
        if (!check_access("bank-account.status")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = BankAccount::find($request->id);
        if ($data) {
            $data->status = !$data->status;
            $data->save();
            return response()->json(['success' => true, 'status' => $data->status]);
        }
        return response()->json(['success' => false], 404);
    }
}