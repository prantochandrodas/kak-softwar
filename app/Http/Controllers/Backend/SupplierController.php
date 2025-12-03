<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Branch;
use App\Models\BranchFundBalance;
use App\Models\Fund;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierDuePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function supplierDuePaymentList(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $today = date('Y-m-d');

        // By Default No Data
        $reportData = collect([]);

        // Only Run Query If User Searched
        if ($supplier_id && $from_date && $to_date) {

            $reportData = \DB::table('supplier_due_payments')
                ->leftJoin('suppliers', 'supplier_due_payments.supplier_id', '=', 'suppliers.id')
                ->leftJoin('funds', 'supplier_due_payments.fund_id', '=', 'funds.id')
                ->leftJoin('banks', 'supplier_due_payments.bank_id', '=', 'banks.id')
                ->leftJoin('bank_accounts', 'supplier_due_payments.account_id', '=', 'bank_accounts.id')
                ->select(
                    'supplier_due_payments.*',
                    'suppliers.name as supplier_name',
                    'funds.name as fund_name',
                    'banks.name as bank_name',
                    'bank_accounts.account_number as account_no'
                )
                ->where('supplier_due_payments.branch_id', $request->branch_id ?? session('branch_id'))
                ->where('supplier_due_payments.supplier_id', $supplier_id)
                ->whereBetween('supplier_due_payments.date', [$from_date, $to_date])
                ->orderBy('supplier_due_payments.date', 'asc')
                ->get();
        }

        // suppliers For Dropdown
        $suppliers = \DB::table('suppliers')
            ->where('branch_id', $request->branch_id ?? session('branch_id'))
            ->where('status', 1)
            ->get();

        return view('backend.supplier.payment_list', [
            'from_date'  => $from_date,
            'to_date'    => $to_date,
            'today'      => $today,
            'reportData' => $reportData,
            'suppliers'  => $suppliers,
            'supplier_id' => $supplier_id,
        ]);
    }

    public function getDue($invoiceId)
    {
        $data = Supplier::find($invoiceId);

        return response()->json(['due_amount' => $data ? $data->opening_balance : 0]);
    }

    private function generateVoucherNo()
    {
        $date = date('Ymd');

        // আজকের দিনের কয়টা voucher আছে
        $lastVoucher = DB::table('purchase_payments')
            ->whereDate('created_at', today())
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastVoucher && isset($lastVoucher->voucher_no)) {
            $lastNumber = (int) substr($lastVoucher->voucher_no, -4); // শেষ 4 digit
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'DP-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function due_payment_store(Request $request)
    {

        try {
            DB::beginTransaction();

            $supplierIds = $request->input('supplier_id', []); // default empty array
            $fundIds = $request->input('fund_id', []);
            $bankIds = $request->input('bank_id', []);
            $accountIds = $request->input('account_id', []);
            $dates = $request->input('date', []);
            $amounts = $request->input('amount', []);
            $branchId = $request->branch_id ?? session('branch_id');
            foreach ($supplierIds as $key => $supplier_id) {
                if (!$supplier_id) {
                    continue; // skip if invoice_id is null
                }
                $voucherNo = $this->generateVoucherNo();
                SupplierDuePayment::create([
                    'voucher_no'     => $voucherNo,
                    'supplier_id' => $supplier_id,
                    'fund_id'     => $fundIds[$key] ?? null,
                    'bank_id'     => $bankIds[$key] ?? null,
                    'account_id'  => $accountIds[$key] ?? null,
                    'date'        => $dates[$key] ?? null,
                    'amount'      => $amounts[$key] ?? 0,
                    'branch_id'   => $request->branch_id ?? session('branch_id'),
                    'created_by'  => auth()->user()->id,
                ]);

                $amount = $amounts[$key] ?? 0;
                $branchFund = BranchFundBalance::where('branch_id', $branchId)
                    ->where('fund_id', $fundIds[$key])
                    ->where('bank_id', $bankIds[$key] ?? null)
                    ->where('account_id', $accountIds[$key] ?? null)
                    ->first();

                if ($branchFund) {
                    // Balance update
                    $branchFund->balance -= $amount ?? 0;
                    $branchFund->save();
                } else {
                    Alert::error('Payment Failed', 'Branch Fund not found!');
                    return redirect()->back();
                }
                // // Deduct from fund balance if fund_id exists
                // if (isset($fundIds[$key]) && $fundIds[$key] != null) {
                //     $fund = Fund::find($fundIds[$key]);
                //     if ($fund) {
                //         $fund->balance -= $amount;
                //         $fund->save();
                //     }
                // }

                // // Deduct from bank account balance if account_id exists
                // if (isset($accountIds[$key]) && $accountIds[$key] != null) {
                //     $account = BankAccount::find($accountIds[$key]);
                //     if ($account) {
                //         $account->balance -= $amount;
                //         $account->save();
                //     }
                // }


                $supplier = Supplier::find($supplier_id);
                if ($supplier) {
                    $supplier->opening_balance -= $amount;
                    $supplier->save();
                }
            }

            DB::commit();
            Alert::success('Create Payment', 'Payment Created Successfully!');
            return redirect()->route('supplier.due.payment');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!', $e);
            return redirect()->route('supplier.due.payment');
        }
    }
    public function supplier_due_payment()
    {
        // if (!check_access("purchase.list")) {
        //     Alert::error('Error', "You don't have permission!");
        //     return redirect()->route('admin.dashboard');
        // }

        $user = auth()->user();
        $funds = Fund::where('status', 1)->get();
        $isSuperAdmin = $user->roles->pluck('name')->contains('Super Admin');
        $branchId = session('branch_id');
        // Super Admin & no branch selected
        if ($isSuperAdmin && !$branchId) {
            $suppliers = [];
        } else {
            $suppliers = Supplier::where('status', 1)->where('branch_id', session('branch_id'))->get();
        }

        return view('backend.supplier.due_payment', compact('suppliers', 'funds'));
    }

    public function index()
    {
        if (!check_access("supplier.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        return view('backend.supplier.index');
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                // Super Admin হলে সব supplier দেখাবে
                $query = Supplier::with('branch')->orderBy('created_at', 'desc');
            } else {
                $query = Supplier::with('branch')->where('branch_id', session('branch_id'))->orderBy('created_at', 'desc');
            }

            if ($request->branch_id) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            $data = $query->get();


            return DataTables::of($data)
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch ? $row->branch->name : '';
                })

                ->addColumn('action', function ($row) {
                    $deleteBtn = '';
                    $editBtn = '';
                    $action = '';
                    $toggleIcon = '';

                    $deleteUrl = route('supplier.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');
                    if (check_access("supplier.edit")) {
                        $editBtn = '<a href="' . route('supplier.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }

                    if (check_access("supplier.status")) {
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
                        . $showBtn . $editBtn . $toggleBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'category', 'branch'])
                ->make(true);
        }
    }
    public function show($id)
    {

        $data = Supplier::findOrFail($id);

        return view('backend.supplier.show', compact('data'));
    }
    public function create()
    {
        if (!check_access("supplier.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }


        return view('backend.supplier.create');
    }
    public function store(Request $request)
    {
        if (!check_access("supplier.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => [
                'required',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/'
            ],
            'contact_p_phone' => [
                'required',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/'
            ],
            'email' => 'required|email',
            'contact_person' => 'required|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'opening_balance' => 'nullable|numeric',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',
            'contact_p_phone.required' => 'Phone number is required.',
            'contact_p_phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',
        ]);

        try {
            DB::beginTransaction();
            $picture = "";
            $signature = "";
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $file_name = uploadImage($file, 'supplier', 'supplier');
                $picture = $file_name;
            }
            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $file_name = uploadImage($file, 'supplier', 'signature');
                $signature = $file_name;
            }

            Supplier::create([
                'name' => $request->name,
                'address' => $request->address,
                'office_phone' =>  $request->phone,
                'office_email' =>  $request->email,
                'contact_person' =>  $request->contact_person,
                'contact_person_number' =>  $request->contact_p_phone,
                'opening_balance' =>  $request->opening_balance ? $request->opening_balance : 0,
                'picture' =>  $picture,
                'signature' =>  $signature,
                'date' => date('Y-m-d'),
                'status' => 1,
                'branch_id' => $request->branch_id ?? session('branch_id'),
                'created_by'  => auth()->user()->id,
            ]);


            DB::commit();
            Alert::success('Create Product', 'Product Created Successfully!');
            return redirect()->route('supplier.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again.',
                'error' => $e->getMessage() // optional, for debugging
            ], 500);
        }
    }
    public function edit($id)
    {
        if (!check_access("supplier.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = Supplier::findOrFail($id);


        return view('backend.supplier.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        if (!check_access("supplier.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => [
                'required',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/'
            ],
            'contact_p_phone' => [
                'required',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/'
            ],
            'email' => 'required|email',
            'contact_person' => 'required|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'opening_balance' => 'nullable|numeric',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',
            'contact_p_phone.required' => 'Phone number is required.',
            'contact_p_phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',
        ]);


        try {
            DB::beginTransaction();



            $find = Supplier::find($id);

            $status = 0;
            if (!$request->status) {
                $status = 0;
            } else {
                $status = $request->status;
            }

            $signature = $find->signature;
            $picture = $find->picture;

            if ($request->hasFile('picture')) {
                if ($find->picture) {
                    $oldPhotoPath = 'uploads/supplier/' . $find->picture; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }

                // Upload new photo
                $file = $request->file('picture');
                $file_name = uploadImage($file, 'supplier', 'supplier');
                $picture = $file_name;
            }
            if ($request->hasFile('signature')) {
                if ($find->signature) {
                    $oldPhotoPath = 'uploads/supplier/' . $find->signature; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }

                // Upload new photo
                $file = $request->file('signature');
                $file_name = uploadImage($file, 'supplier', 'signature');
                $signature = $file_name;
            }


            $data = [
                'name' => $request->name,
                'address' => $request->address,
                'office_phone' =>  $request->phone,
                'office_email' =>  $request->email,
                'contact_person' =>  $request->contact_person,
                'contact_person_number' =>  $request->contact_p_phone,
                'opening_balance' =>  $request->opening_balance ? $request->opening_balance : 0,
                'branch_id' => $request->branch_id ?? session('branch_id'),
                'picture' =>  $picture,
                'signature' =>  $signature,
                'status' => $status,
                'updated_by' =>   auth()->user()->id,
            ];
            $find->update($data);

            DB::commit();
            Alert::success('Update Supplier', 'Supplier Updated Successfully!');
            return redirect()->route('supplier.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!');
            return redirect()->route('supplier.index');
        }
    }


    public function toggleStatus(Request $request)
    {
        if (!check_access("supplier.status")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = Supplier::find($request->id);
        if ($data) {
            $data->status = !$data->status;
            $data->save();
            return response()->json(['success' => true, 'status' => $data->status]);
        }
        return response()->json(['success' => false], 404);
    }
}