<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BranchFundBalance;
use App\Models\Fund;
use App\Models\FundTransfer;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class FundTransferController extends Controller
{
    public function receiveFundTransfer($id)
    {
        $transfer = FundTransfer::find($id);

        if (!$transfer) {
            return response()->json(['error' => 'Data not found'], 404);
        }
        $findFormBranchFund = BranchFundBalance::where('fund_id', $transfer->from_fund_id)
            ->where('branch_id', $transfer->from_branch_id)
            ->where('bank_id', $transfer->from_bank_id ?? null)
            ->where('account_id', $transfer->from_acc_id ?? null)
            ->first();

        if (!$findFormBranchFund) {
            return response()->json(['error' => 'Fund Data not found'], 404);
        }


        if ($findFormBranchFund->balance < $transfer->transaction_amount) {
            return response()->json(['error' => 'Dose not have enough balance'], 404);
        }

        $findToBranchFund = BranchFundBalance::where('fund_id', $transfer->to_fund_id)
            ->where('branch_id', $transfer->to_branch_id)
            ->where('bank_id', $transfer->to_bank_id ?? null)
            ->where('account_id', $transfer->to_acc_id ?? null)
            ->first();

        if ($findFormBranchFund) {
            $findFormBranchFund->balance -= $transfer->transaction_amount;
            $findFormBranchFund->save();
        }
        if ($findToBranchFund) {
            $findToBranchFund->balance += $transfer->transaction_amount;
            $findToBranchFund->save();
        } else {
            BranchFundBalance::create([
                'branch_id'  =>  $transfer->to_branch_id,
                'fund_id'    => $transfer->to_fund_id,
                'bank_id'    => $transfer->to_bank_id ?? null,
                'account_id' => $transfer->to_account_id ?? null,
                'balance'    =>  $transfer->transaction_amount ?? 0,
                'created_by'  => auth()->user()->id,
            ]);
        }

        $transfer->status = 1;
        $transfer->save();

        return response()->json(['success' => 'Transfer received successfully']);
    }


    public function returnTransfer($id)
    {
        $transfer = FundTransfer::find($id);

        if (!$transfer) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $transfer->status = 3;
        $transfer->save();

        return response()->json(['success' => 'Transfer returned successfully']);
    }
    public function receive_index()
    {
        // if (!check_access("product-transfer.list")) {
        //     Alert::error('Error', "You don't have permission!");
        //     return redirect()->route('admin.dashboard');
        // }

        return view('backend.fund_transfer.receive_list');
    }

    public function receive_getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                // Super Admin হলে সব supplier দেখাবে
                $query = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount', 'toFund', 'toBank', 'toAccount', 'toBranch', 'formBranch'])->orderBy('created_at', 'desc');
            } else {
                $query = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount', 'toFund', 'toBank', 'toAccount', 'toBranch', 'formBranch'])->where('to_branch_id',  session('branch_id'))->orderBy('created_at', 'desc');
            }

            if ($request->from_branch_id) {
                $query->where('from_branch_id', $request->from_branch_id);
            }
            if ($request->to_branch_id) {
                $query->where('to_branch_id', $request->to_branch_id);
            }

            if ($request->from_date && $request->to_date) {
                $from = Carbon::parse($request->from_date)->startOfDay();
                $to   = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('date', [$from, $to]);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->editColumn('date', function ($row) {
                    return Carbon::parse($row->transaction_date)->format('d-m-Y');
                })
                ->editColumn('form_branch', function ($row) {
                    return $row->formBranch->name ?? '';
                })
                ->editColumn('to_branch', function ($row) {
                    return $row->toBranch->name ?? '';
                })
                ->addColumn('from_fund', function ($row) {
                    return $row->fromFund ? $row->fromFund->name : '';
                })
                ->addColumn('from_bank', function ($row) {
                    return $row->fromBank ? $row->fromBank->name : '-';
                })
                ->addColumn('from_account', function ($row) {
                    return $row->fromAccount ? $row->fromAccount->account_number : '-';
                })
                ->addColumn('to_fund', function ($row) {
                    return $row->toFund ? $row->toFund->name : '';
                })
                ->addColumn('to_bank', function ($row) {
                    return $row->toBank ? $row->toBank->name : '-';
                })
                ->addColumn('to_account', function ($row) {
                    return $row->toAccount ? $row->toAccount->account_number : '-';
                })
                ->editColumn('attachment', function ($row) {
                    if ($row->attachment) {
                        $url = asset('uploads/fund_transfer/' . $row->attachment); // যদি storage/app/public এ থাকে
                        return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-light" title="View Attachment">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8.5 1a3.5 3.5 0 0 1 3.5 3.5v6a4.5 4.5 0 0 1-9 0V5a.5.5 0 0 1 1 0v5.5a3.5 3.5 0 0 0 7 0v-6a2.5 2.5 0 1 0-5 0v6a1.5 1.5 0 0 0 3 0V5.5a.5.5 0 0 1 1 0v6a2.5 2.5 0 1 1-5 0V4.5A3.5 3.5 0 0 1 8.5 1z"/>
                                </svg>
                            </a>';
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Recived</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-warning">Pendding</span>';
                    } else {
                        return '<span class="badge bg-danger">Return</span>';
                    }
                })



                ->addColumn('action', function ($row) {

                    $receiveBtn = "";
                    $returnBtn = "";




                    if ($row->status == 2) {
                        // Receive Button
                        $receiveBtn = '<button data-id="' . $row->id . '" class="receive btn btn-sm btn-success me-2 rounded" style="padding:8px;">
                        <i class="fa fa-check"></i> Receive
                    </button>';

                        // Return Button
                        $returnBtn = '<button data-id="' . $row->id . '" class="return btn btn-sm btn-danger rounded" style="padding:8px;">
                        <i class="fa fa-undo"></i> Return
                    </button>';
                    }


                    return '<div class="d-flex align-items-center  mb-2">'
                        .  $receiveBtn .
                        $returnBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'form_branch', 'to_branch', 'attachment', 'to_account', 'to_bank', 'to_fund', 'from_account', 'from_bank', 'from_fund'])
                ->make(true);
        }
    }
    public function index()
    {
        if (!check_access("fund-transfer.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        return view('backend.fund_transfer.index');
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                // Super Admin হলে সব supplier দেখাবে
                $query = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount', 'toFund', 'toBank', 'toAccount', 'toBranch', 'formBranch'])->orderBy('created_at', 'desc');
            } else {
                $query = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount', 'toFund', 'toBank', 'toAccount', 'toBranch', 'formBranch'])->where('from_branch_id',  session('branch_id'))->orderBy('created_at', 'desc');
            }

            if ($request->from_branch_id) {
                $query->where('from_branch_id', $request->from_branch_id);
            }
            if ($request->to_branch_id) {
                $query->where('to_branch_id', $request->to_branch_id);
            }

            if ($request->from_date && $request->to_date) {
                $from = Carbon::parse($request->from_date)->startOfDay();
                $to   = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('date', [$from, $to]);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->editColumn('date', function ($row) {
                    return Carbon::parse($row->transaction_date)->format('d-m-Y');
                })
                ->editColumn('form_branch', function ($row) {
                    return $row->formBranch->name ?? '';
                })
                ->editColumn('to_branch', function ($row) {
                    return $row->toBranch->name ?? '';
                })
                ->addColumn('from_fund', function ($row) {
                    return $row->fromFund ? $row->fromFund->name : '';
                })
                ->addColumn('from_bank', function ($row) {
                    return $row->fromBank ? $row->fromBank->name : '-';
                })
                ->addColumn('from_account', function ($row) {
                    return $row->fromAccount ? $row->fromAccount->account_number : '-';
                })
                ->addColumn('to_fund', function ($row) {
                    return $row->toFund ? $row->toFund->name : '';
                })
                ->addColumn('to_bank', function ($row) {
                    return $row->toBank ? $row->toBank->name : '-';
                })
                ->addColumn('to_account', function ($row) {
                    return $row->toAccount ? $row->toAccount->account_number : '-';
                })
                ->editColumn('attachment', function ($row) {
                    if ($row->attachment) {
                        $url = asset('uploads/fund_transfer/' . $row->attachment); // যদি storage/app/public এ থাকে
                        return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-light" title="View Attachment">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8.5 1a3.5 3.5 0 0 1 3.5 3.5v6a4.5 4.5 0 0 1-9 0V5a.5.5 0 0 1 1 0v5.5a3.5 3.5 0 0 0 7 0v-6a2.5 2.5 0 1 0-5 0v6a1.5 1.5 0 0 0 3 0V5.5a.5.5 0 0 1 1 0v6a2.5 2.5 0 1 1-5 0V4.5A3.5 3.5 0 0 1 8.5 1z"/>
                                </svg>
                            </a>';
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Recived</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-warning">Pendding</span>';
                    } else {
                        return '<span class="badge bg-danger">Return</span>';
                    }
                })



                ->addColumn('action', function ($row) {
                    $deleteBtn = '';
                    $editBtn = '';
                    $action = '';
                    $deleteUrl = route('fund-transfer.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');


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
                        . $deleteBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'form_branch', 'to_branch', 'attachment', 'to_account', 'to_bank', 'to_fund', 'from_account', 'from_bank', 'from_fund'])
                ->make(true);
        }
    }

    public function distroy($id)
    {
        if (!check_access("fund-transfer.delete")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        try {
            DB::beginTransaction();

            // Fund Transfer রেকর্ড খুঁজে পাওয়া
            $transfer = FundTransfer::findOrFail($id);


            $findFormBranchFund = BranchFundBalance::where('fund_id', $transfer->from_fund_id)
                ->where('branch_id', $transfer->from_branch_id)
                ->where('bank_id', $transfer->from_bank_id ?? null)
                ->where('account_id', $transfer->from_acc_id ?? null)
                ->first();
            $findToBranchFund = BranchFundBalance::where('fund_id', $transfer->to_fund_id)
                ->where('branch_id', $transfer->to_branch_id)
                ->where('bank_id', $transfer->to_bank_id ?? null)
                ->where('account_id', $transfer->to_acc_id ?? null)
                ->first();


            if ($transfer->status == 1) {
                $findToBranchFund->balance -= $transfer->transaction_amount;
                $findToBranchFund->save();

                $findFormBranchFund->balance += $transfer->transaction_amount;
                $findFormBranchFund->save();
            }

            // Attachment ফাইল থাকলে delete করা যায় (optional)
            if ($transfer->attachment && file_exists(public_path('uploads/fund_transfer/' . $transfer->attachment))) {
                @unlink(public_path('uploads/fund_transfer/' . $transfer->attachment));
            }

            // Fund Transfer রেকর্ড delete করা
            $transfer->delete();

            DB::commit();
            Alert::success('Delete Success', 'Fund Transfer Deleted successfully!');
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            Alert::error('Delete Failed', 'Sothing went wrong।');
            return redirect()->back();
        }
    }
    public function create()
    {
        if (!check_access("fund-transfer.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $funds = Fund::where('status', 1)->get();
        return view('backend.fund_transfer.create', compact('funds'));
    }


    public function store(Request $request)
    {
        if (!check_access("fund-transfer.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }



        $request->validate([
            'from_fund_id' => 'required|exists:funds,id',
            'to_fund_id' => 'required|exists:funds,id',
            'remarks' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'attachment' => 'nullable|mimes:jpeg,png,jpg,gif,webp,pdf|max:2048',

        ]);



        try {
            DB::beginTransaction();

            $fromFund = Fund::find($request->from_fund_id);



            $findFromBranchFund = BranchFundBalance::where('fund_id', $request->from_fund_id)
                ->where('branch_id', $request->from_branch_id)
                ->where('bank_id', $request->from_bank_id ?? null)
                ->where('account_id', $request->from_account_id ?? null)
                ->first();

            $findToBranchFund = BranchFundBalance::where('fund_id', $request->to_fund_id)
                ->where('branch_id', $request->to_branch_id)
                ->where('bank_id', $request->to_bank_id ?? null)
                ->where('account_id', $request->to_account_id ?? null)
                ->first();
            if (!$findFromBranchFund) {
                Alert::error('warning', ' Fund dose not found');
                return redirect()->back();
            }

            if ($findFromBranchFund->balance < $request->amount) {
                Alert::error('Insufficient balance', $fromFund->name . 'Dose not have enough balance');
                return redirect()->back();
            }
            $attachment = "";
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $file_name = uploadImage($file, 'fund_transfer', 'attachment');
                $attachment = $file_name;
            }

            $voucher  = FundTransfer::latest()->first();

            if ($voucher) {
                $voucherNumber = 'FHR-' . date('Y') . $voucher->id + 1;
            } else {
                $voucherNumber = 'FHR-' . date('Y') . '1';
            }
            $status = null;
            if ($request->from_branch_id == $request->to_branch_id) {
                $status = 1;
                $findFromBranchFund->balance -= $request->amount;
                $findFromBranchFund->save();

                if ($findToBranchFund) {
                    $findToBranchFund->balance += $request->amount;
                    $findToBranchFund->save();
                } else {
                    BranchFundBalance::create([
                        'branch_id'  =>  $request->to_branch_id,
                        'fund_id'    => $request->to_fund_id,
                        'bank_id'    => $request->to_bank_id ?? null,
                        'account_id' => $request->to_account_id ?? null,
                        'balance'    =>  $request->amount ?? 0,
                        'created_by'  => auth()->user()->id,
                    ]);
                }
            } else {
                $status = 2;
            }

            FundTransfer::create([
                'voucher_no' => $voucherNumber,
                'from_branch_id' => $request->from_branch_id,
                'from_fund_id' => $request->from_fund_id,
                'from_bank_id' => $request->from_bank_id,
                'from_acc_id'  => $request->from_account_id,
                'to_branch_id' => $request->to_branch_id,
                'to_fund_id' => $request->to_fund_id,
                'to_bank_id' => $request->to_bank_id,
                'to_acc_id'  => $request->to_account_id,
                'transaction_date'  => $request->date,
                'transaction_amount'  => $request->amount,
                'particulars'  => $request->remarks,
                'attachment'  => $attachment,
                'status' =>  $status,
                'created_by'  => auth()->user()->id,

            ]);

            DB::commit();
            Alert::success('Data Created', 'Data Created Successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Data Generate Failed', 'Some thing went wrong!');
            return redirect()->back();
        }
    }
}