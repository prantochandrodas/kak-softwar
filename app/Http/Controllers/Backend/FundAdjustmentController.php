<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BranchFundBalance;
use App\Models\Fund;
use App\Models\FundAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class FundAdjustmentController extends Controller
{

    public function index()
    {
        if (!check_access("fund-adjustment.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        return view('backend.fund_adjustment.index');
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                $query = FundAdjustment::with(['fund', 'account', 'bank', 'branch'])->orderBy('created_at', 'desc');
            } else {
                $query = FundAdjustment::with(['fund', 'account', 'bank', 'branch'])->where('branch_id', session('branch_id'))->orderBy('created_at', 'desc');
            }



            if ($request->branch_id) {
                $query->where('branch_id', $request->branch_id);
            }



            if ($request->from_date && $request->to_date) {
                $from = Carbon::parse($request->from_date)->startOfDay();
                $to   = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('date', [$from, $to]);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->editColumn('date', function ($row) {
                    return Carbon::parse($row->date)->format('d-m-Y');
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch ? $row->branch->name : '';
                })
                ->addColumn('fund', function ($row) {
                    return $row->fund ? $row->fund->name : '';
                })
                ->addColumn('bank', function ($row) {
                    return $row->bank ? $row->bank->name : '';
                })
                ->addColumn('account', function ($row) {
                    return $row->account ? $row->account->account_name : '';
                })
                ->editColumn('type', function ($row) {
                    if ($row->type == 1) {
                        return '<span class="badge bg-success">Opening Balance</span>';
                    } elseif ($row->type == 2) {
                        return '<span class="badge bg-primary">Adjustment</span>';
                    } else {
                        return '<span class="badge bg-secondary">Unknown</span>';
                    }
                })



                ->rawColumns(['date', 'bank', 'fund', 'account', 'type'])
                ->make(true);
        }
    }

    public function create()
    {
        if (!check_access("fund-adjustment.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }


        $funds = Fund::where('status', 1)->get();
        return view('backend.fund_adjustment.create', compact('funds'));
    }

    public function store(Request $request)
    {
        // if (!check_access("branch.create")) {
        //     Alert::error('Error', "You don't have permission!");
        //     return redirect()->route('admin.dashboard');
        // }



        try {
            DB::beginTransaction();
            $openingBlance = 0;
            if ($request->type == 1) {
                $openingBlance = $request->amount;
            }

            FundAdjustment::create([
                'branch_id' => $request->branch_id ?? session('branch_id'),
                'fund_id' => $request->fund_id,
                'bank_id' => $request->bank_id ?? null,
                'account_id' => $request->account_id ?? null,
                'type' => $request->type,
                'amount' => $request->amount,
                'date' => $request->date,
                'note' => $request->note,
                'created_by'  => auth()->user()->id,
            ]);


            $branchFund = BranchFundBalance::where('branch_id',  $request->branch_id ?? session('branch_id'))
                ->where('fund_id', $request->fund_id)
                ->where('bank_id', $request->bank_id ?? null)
                ->where('account_id',  $request->account_id ?? null)
                ->first();



            if ($branchFund) {
                // Balance update
                $branchFund->balance += $request->amount ?? 0;
                $branchFund->opening_balance +=  $openingBlance ?? 0;
                $branchFund->save();
            } else {
                // Create new record
                BranchFundBalance::create([
                    'branch_id'  => $request->branch_id ?? session('branch_id'),
                    'fund_id'    => $request->fund_id,
                    'bank_id'    => $request->bank_id ?? null,
                    'account_id' =>  $request->account_id ?? null,
                    'balance'    =>  $request->amount ?? 0,
                    'opening_balance'    =>    $openingBlance ?? 0,
                    'created_by'  => auth()->user()->id,
                ]);
            }


            DB::commit();
            Alert::success('Data Created', 'data Created Successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Data Generate Failed', 'Some thing went wrong!');
            return redirect()->back();
        }
    }
}