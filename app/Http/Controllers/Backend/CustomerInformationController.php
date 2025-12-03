<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerDuePaymentDetails;
use App\Models\CustomerInformation;
use App\Models\District;
use App\Models\Fund;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SalePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class CustomerInformationController extends Controller
{
    public function customerDuePaymentList(Request $request)
    {
        $customer_id = $request->customer_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $today = date('Y-m-d');

        // By Default No Data
        $reportData = collect([]);

        // Only Run Query If User Searched
        if ($customer_id && $from_date && $to_date) {

            $reportData = \DB::table('customer_due_payment_details')
                ->leftJoin('customer_information', 'customer_due_payment_details.customer_id', '=', 'customer_information.id')
                ->leftJoin('funds', 'customer_due_payment_details.fund_id', '=', 'funds.id')
                ->leftJoin('banks', 'customer_due_payment_details.bank_id', '=', 'banks.id')
                ->leftJoin('bank_accounts', 'customer_due_payment_details.account_id', '=', 'bank_accounts.id')
                ->select(
                    'customer_due_payment_details.*',
                    'customer_information.name as customer_name',
                    'funds.name as fund_name',
                    'banks.name as bank_name',
                    'bank_accounts.account_number as account_no'
                )
                ->where('customer_due_payment_details.branch_id', $request->branch_id  ?? session('branch_id'))
                ->where('customer_due_payment_details.customer_id', $customer_id)
                ->whereBetween('customer_due_payment_details.date', [$from_date, $to_date])
                ->orderBy('customer_due_payment_details.date', 'asc')
                ->get();
        }

        // Customers For Dropdown
        $customers = \DB::table('customer_information')
            ->where('branch_id', $request->branch_id  ?? session('branch_id'))
            ->where('status', 1)
            ->get();

        return view('backend.customer_information.payment_list', [
            'from_date'  => $from_date,
            'to_date'    => $to_date,
            'today'      => $today,
            'reportData' => $reportData,
            'customers'  => $customers,
            'customer_id' => $customer_id,
        ]);
    }



    public function customerDuePayment()
    {


        $paymentType = 'opening_due';
        $customers = CustomerInformation::where('status', 1)->where('branch_id', session('branch_id'))->get();
        $funds = Fund::where('status', 1)->get();
        return view('backend.sale.sale_due_payment', compact('customers', 'funds', 'paymentType'));
    }
    public function index()
    {
        if (!check_access("customer-information.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        return view('backend.customer_information.index');
    }




    public function getdata(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                // Super Admin হলে সব supplier দেখাবে
                $query = CustomerInformation::with('branch')->orderBy('created_at', 'desc');
            } else {
                $query = CustomerInformation::with('branch')->where('branch_id', session('branch_id'))->orderBy('created_at', 'desc');
            }

            if ($request->branch_id) {
                $query->where('branch_id', $request->branch_id);
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

                    $deleteUrl = route('customer-information.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');
                    if (check_access("customer-information.edit")) {
                        $editBtn = '<a href="' . route('customer-information.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }

                    if (check_access("customer-information.status")) {
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
                ->rawColumns(['action', 'status', 'district', 'branch'])
                ->make(true);
        }
    }
    // public function show($id)
    // {

    //     $data = CustomerInformation::findOrFail($id);

    //     return view('backend.customer_information.show', compact('data'));
    // }
    public function create()
    {
        if (!check_access("customer-information.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        return view('backend.customer_information.create');
    }
    public function store(Request $request)
    {
        if (!check_access("customer-information.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $branchId = $request->branch_id ?? session('branch_id');
        $request->validate([
            'name' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'address' => 'required',
            'date' => 'required|date',
            'phone' => [
                'required',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/',
                Rule::unique('customer_information', 'phone')
                    ->where('branch_id', $branchId),
            ],
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'opening_balance' => 'nullable|numeric',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',

        ]);

        try {
            DB::beginTransaction();
            $picture = "";
            $signature = "";
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $file_name = uploadImage($file, 'customer', 'customer');
                $picture = $file_name;
            }
            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $file_name = uploadImage($file, 'customer', 'signature');
                $signature = $file_name;
            }

            CustomerInformation::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' =>  $request->phone,
                'remarks' =>  $request->remarks,
                'opening_balance' =>  $request->opening_balance ? $request->opening_balance : 0,
                'picture' =>  $picture,
                'date' => $request->date,
                'branch_id' =>  $branchId,
                'status' => 1,
                'created_by'  => auth()->user()->id,

            ]);


            DB::commit();
            Alert::success('Create Customer', 'Customer Created Successfully!');
            return redirect()->route('customer-information.index');
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
        if (!check_access("customer-information.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = CustomerInformation::findOrFail($id);

        return view('backend.customer_information.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        if (!check_access("customer-information.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $branchId = $request->branch_id ?? session('branch_id');
        $request->validate([
            'name' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'address' => 'required',
            'phone' => [
                'required',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/',
                Rule::unique('customer_information', 'phone')
                    ->where('branch_id', $branchId)
                    ->ignore($id),
            ],
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,wedp|max:2048',
            'opening_balance' => 'nullable|numeric',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid Bangladeshi mobile number. Example: 01700000000, +8801700000000, or 8801700000000',

        ]);

        try {
            DB::beginTransaction();



            $find = CustomerInformation::find($id);

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
                    $oldPhotoPath = 'uploads/customer/' . $find->picture; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }

                // Upload new photo
                $file = $request->file('picture');
                $file_name = uploadImage($file, 'customer', 'customer');
                $picture = $file_name;
            }



            $data = [
                'name' => $request->name,
                'address' => $request->address,
                'phone' =>  $request->phone,
                'remarks' =>  $request->remarks,
                'opening_balance' =>  $request->opening_balance ? $request->opening_balance : 0,
                'picture' =>  $picture,
                'branch_id' => $branchId,
                'status' => $status,
                'updated_by' =>   auth()->user()->id,
            ];
            $find->update($data);

            DB::commit();
            Alert::success('Update Customer', 'Customer Updated Successfully!');
            return redirect()->route('customer-information.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!');
            return redirect()->route('customer-information.index');
        }
    }


    public function toggleStatus(Request $request)
    {
        if (!check_access("customer-information.status")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = CustomerInformation::find($request->id);
        if ($data) {
            $data->status = !$data->status;
            $data->save();
            return response()->json(['success' => true, 'status' => $data->status]);
        }
        return response()->json(['success' => false], 404);
    }
}