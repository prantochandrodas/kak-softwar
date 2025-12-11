<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BranchFundBalance;
use App\Models\Expense;
use App\Models\ExpenseHead;
use App\Models\Fund;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{

    public function getBank($id)
    {
        $data = Bank::where('fund_id', $id)->where('status', 1)->get();

        if ($data->count() > 0) {
            return response()->json([
                'hasBank' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'hasBank' => false,
                'data' => []
            ]);
        }
    }

    public function getAccountByBank($id)
    {
        $data = BankAccount::where('bank_id', $id)->where('status', 1)->get();

        if ($data->count() > 0) {
            return response()->json([
                'data' => $data
            ]);
        } else {
            return response()->json([
                'data' => []
            ]);
        }
    }




    public function printDebitVoucher($id)
    {
        try {
            $model          = Expense::with('fund', 'head', 'bank', 'branch', 'account')->where('id', $id)->first();
            $receive_by     = $receive_by = auth()->user()->name;
            $company_info   = GeneralSetting::first();

            return view('backend.expense.debit_voucher_print', compact('model', 'receive_by', 'company_info'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function index()
    {
        if (!check_access("expense.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $branchId = session('branch_id');

        $heads = ExpenseHead::where('status', 1)
            ->get();
        $funds = Fund::where('status', 1)->get();
        return view('backend.expense.index', compact('heads', 'funds'));
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $query = Expense::with(['head', 'fund', 'bank', 'branch', 'account'])->orderBy('created_at', 'desc');
            if ($request->head_id) {
                $query->where('head_id', $request->head_id);
            }

            if ($request->branch_id) {
                $query->where('branch_id', $request->branch_id);
            }
            if ($request->fund_id) {
                $query->where('fund_id', $request->fund_id);
            }

            if ($request->from_date && $request->to_date) {
                $from = Carbon::parse($request->from_date)->startOfDay();
                $to   = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('date', [$from, $to]);
            }

            $data = $query->get();
            return DataTables::of($data)
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch ? $row->branch->name : '';
                })
                ->addColumn('fund', function ($row) {
                    return $row->fund ? $row->fund->name : '';
                })
                ->addColumn('head', function ($row) {
                    return $row->head ? $row->head->name : '';
                })
                ->addColumn('bank_info', function ($row) {
                    // Combine bank, branch, account
                    $parts = [];
                    if ($row->bank) $parts[] = $row->bank->name;
                    if ($row->account) $parts[] = $row->account->account_number;

                    return !empty($parts) ? implode(' | ', $parts) : '-'; // show '-' if all null
                })
                ->addColumn('action', function ($row) {
                    $deleteBtn = '';
                    $editBtn = '';
                    $action = '';
                    $toggleIcon = '';

                    $deleteUrl = route('expense.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');
                    if (check_access("expense.edit")) {
                        $editBtn = '<a href="' . route('expense.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }


                    $printBtn = '<a href="' . route('print-debit-voucher', $row->id) . '" target="_blank" class="btn btn-sm btn-info ms-2">
                    <i class="fa fa-print"></i>
                 </a>';

                    if (check_access("expense.status")) {
                        // Status Toggle Icon Button
                        $toggleIcon = $row->status
                            ? '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-danger ms-1"><i class="fa-solid fa-arrow-down"></i></button>'  // Active: Show red "disable" icon
                            : '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-success ms-1"><i class="fa-solid fa-arrow-up"></i></button>'; // Inactive: Show green "enable" icon
                    }

                    $toggleBtn =  $toggleIcon;
                    $showBtn = '<button data-id="' . $row->id . '" class="show btn btn-sm btn-primary me-2 rounded" style="padding:8px;">
                        <i class="fa fa-eye"></i>
                    </button>';
                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger deleteUser ms-2" data-id="' . $row->id . '">
                            <i class="fa-solid fa-trash"></i>
                        </button>';
                    return '<div class="d-flex align-items-center  mb-2">'
                        . $showBtn . $editBtn .  $printBtn . $deleteBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'branch'])
                ->make(true);
        }
    }

    public function distroy(Request $request)
    {
        try {
            if (!check_access("expense.delete")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $data = Expense::findOrFail($request->id);

            $branchFund = BranchFundBalance::where('branch_id', $data->branch_id ?? session('branch_id'))
                ->where('fund_id',  $data->fund_id)
                ->where('bank_id', $data->bank_id ?? null)
                ->where('account_id', $data->account_id ?? null)
                ->first();


            if ($branchFund) {
                // Balance update
                $branchFund->balance += $data->amount ?? 0;
                $branchFund->save();
            } else {

                Alert::error('Expense Create Failed.', 'Branch fund record not found!');
                return redirect()->back();
            }

            $data->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }
    public function show($id)
    {

        $model          = Expense::with('fund', 'head', 'bank', 'branch', 'account')->where('id', $id)->first();
        $receive_by     = $receive_by = auth()->user()->name;
        $company_info   = GeneralSetting::first();

        return view('backend.expense.show', compact('model', 'receive_by', 'company_info'));
    }
    public function create()
    {
        if (!check_access("expense.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $heads = ExpenseHead::where('status', 1)
            ->get();
        $funds = Fund::where('status', 1)->get();

        return view('backend.expense.create', compact('heads', 'funds'));
    }
    public function store(Request $request)
    {
        if (!check_access("expense.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'fund_id' => 'required|exists:funds,id',
            'head_id' => 'required|exists:expense_heads,id',
            'amount' => 'required|numeric',
            'name' => 'nullable|string|max:255',
            'details' => 'required|string',
            'date' => 'required|date',
            'document' => 'nullable|mimes:jpeg,png,jpg,gif,webp,pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $lastInvoice = Expense::latest()->first();
            $lastInvoiceNo = ($lastInvoice) ? $lastInvoice->id : 0;

            // Get the current date and time
            $currentDateTime = now(); // This gets the current date and time in the default format

            // Format the invoice number with date and time
            $invoice_no =  $currentDateTime->format('ymdHis') . ($lastInvoiceNo + 1);
            $document = null;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $file_name = uploadImage($file, 'expense_document', 'document');
                $document = $file_name;
            }


            Expense::create([
                'fund_id' => $request->fund_id,
                'bank_id' => $request->bank_id,
                'branch_id' => $request->branch_id ?? session('branch_id'),
                'account_id' => $request->account_id,
                'invoice_no' => $invoice_no,
                'head_id' =>  $request->head_id,
                'amount' =>  $request->amount,
                'exp_person' =>  $request->name,
                'date' =>  $request->date,
                'note' =>  $request->details,
                'document' => $document,
                'created_by'  => auth()->user()->id,

            ]);


            $branchFund = BranchFundBalance::where('branch_id', $request->branch_id ?? session('branch_id'))
                ->where('fund_id',  $request->fund_id)
                ->where('bank_id', $request->bank_id ?? null)
                ->where('account_id', $request->account_id ?? null)
                ->first();

            if ($branchFund) {
                // Balance update
                $branchFund->balance -= $request->amount ?? 0;
                $branchFund->save();
            } else {

                Alert::error('Expense Create Failed.', 'Branch fund record not found!');
                return redirect()->back();
            }



            DB::commit();
            Alert::success('Create Expense', 'Expense Created Successfully!');
            return redirect()->route('expense.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Create Error', 'Some thing went wrong' . $e);
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        if (!check_access("expense.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = Expense::findOrFail($id);
        $heads = ExpenseHead::where('status', 1)
            ->where('branch_id', session('branch_id'))
            ->get();
        $funds = Fund::where('status', 1)->get();

        return view('backend.expense.edit', compact('data', 'heads', 'funds'));
    }

    public function update(Request $request, $id)
    {
        if (!check_access("expense.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'fund_id' => 'required|exists:funds,id',
            'head_id' => 'required|exists:expense_heads,id',
            'amount' => 'required|numeric',
            'name' => 'nullable|string|max:255',
            'date' => 'required|date',
            'details' => 'required|string',
            'document' => 'nullable|mimes:jpeg,png,jpg,gif,webp,pdf|max:2048',
        ]);




        try {
            DB::beginTransaction();


            $find = Expense::find($id);

            $document = $find->document;

            if ($request->hasFile('document')) {
                if ($find->document) {
                    $oldPhotoPath = 'uploads/expense_document/' . $find->document; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }

                // Upload new photo
                $file = $request->file('document');
                $file_name = uploadImage($file, 'expense_document', 'document');
                $document = $file_name;
            }


            $branchFund = BranchFundBalance::where('branch_id', $find->branch_id ?? session('branch_id'))
                ->where('fund_id',  $find->fund_id)
                ->where('bank_id', $find->bank_id ?? null)
                ->where('account_id', $find->account_id ?? null)
                ->first();

            if ($branchFund) {
                // Balance update
                $branchFund->balance += $find->amount ?? 0;
                $branchFund->save();
            } else {

                Alert::error('Expense Create Failed.', 'Branch fund record not found!');
                return redirect()->back();
            }

            $branchFund = BranchFundBalance::where('branch_id', $request->branch_id ?? session('branch_id'))
                ->where('fund_id',  $request->fund_id)
                ->where('bank_id', $request->bank_id ?? null)
                ->where('account_id', $request->account_id ?? null)
                ->first();

            if ($branchFund) {
                // Balance update
                $branchFund->balance -= $request->amount ?? 0;
                $branchFund->save();
            } else {

                Alert::error('Expense Create Failed.', 'Branch fund record not found!');
                return redirect()->back();
            }



            $data = [
                'fund_id' => $request->fund_id,
                'bank_id' => $request->bank_id,
                'branch_id' => $request->branch_id ?? session('branch_id'),
                'account_id' => $request->account_id,
                'head_id' =>  $request->head_id,
                'amount' =>  $request->amount,
                'exp_person' =>  $request->name,
                'date' =>  $request->date,
                'note' =>  $request->details,
                'document' => $document,
                'updated_by' =>   auth()->user()->id,
            ];

            $find->update($data);
            DB::commit();
            Alert::success('Update Product', 'Product Updated Successfully!');
            return redirect()->route('expense.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!');
            return redirect()->route('expense.index');
        }
    }


    // public function toggleStatus(Request $request)
    // {
    //     if (!check_access("expense.status")) {
    //         Alert::error('Error', "You don't have permission!");
    //         return redirect()->route('admin.dashboard');
    //     }
    //     $data = Product::find($request->id);
    //     if ($data) {
    //         $data->status = !$data->status;
    //         $data->save();
    //         return response()->json(['success' => true, 'status' => $data->status]);
    //     }
    //     return response()->json(['success' => false], 404);
    // }
}