<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BranchFundBalance;
use App\Models\CustomerInformation;
use App\Models\Fund;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SalePayment;
use App\Models\VariantStocks;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
{
    public function salePaymentList(Request $request)
    {
        $customer_id = $request->customer_id ?? null;
        $from_date = $request->from_date ?? date('Y-m-d');
        $to_date = $request->to_date ?? date('Y-m-d');
        $today = date('Y-m-d');
        // Filter query
        $query = \DB::table('sale_payments')
            ->join('sales', 'sale_payments.sale_id', '=', 'sales.id')
            ->leftJoin('customer_information', 'sales.customer_id', '=', 'customer_information.id')
            ->leftJoin('funds', 'sale_payments.fund_id', '=', 'funds.id')
            ->leftJoin('banks', 'sale_payments.bank_id', '=', 'banks.id')
            ->leftJoin('bank_accounts', 'sale_payments.account_id', '=', 'bank_accounts.id')
            ->select(
                'sale_payments.*',
                'customer_information.name as customer_name',
                'funds.name as fund_name',
                'banks.name as bank_name',
                'bank_accounts.account_number as account_no'
            )
            ->where('sale_payments.branch_id', $request->branch_id  ?? session('branch_id'))
            ->whereBetween('sale_payments.date', [$from_date, $to_date]);

        if ($customer_id) {
            $query->where('sales.customer_id', $customer_id);
        }

        $reportData = $query->orderBy('sale_payments.date', 'asc')->get();

        // All suppliers for the filter dropdown
        $customers = \DB::table('customer_information')->where('branch_id', $request->branch_id ?? session('branch_id'))->where('status', 1)->get();

        return view('backend.sale.payment_list', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'today' => $today,
            'reportData' => $reportData,
            'customers' => $customers,
            'customer_id' => $customer_id,
        ]);
    }
    public function index()
    {
        if (!check_access("sale.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        return view('backend.sale.index');
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                $query = Sale::with(['customer', 'branch'])->orderBy('created_at', 'desc');
            } else {
                $query = Sale::with(['customer', 'branch'])->where('branch_id', session('branch_id'))->orderBy('created_at', 'desc');
            }


            if ($request->status || $request->status === '0') {
                $query->where('status', $request->status);
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
                ->editColumn('vat', function ($row) {
                    return $row->vat ? $row->vat : 0;
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Paid</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-warning">Partial Paid</span>';
                    } else {
                        return '<span class="badge bg-danger">Unpaid</span>';
                    }
                })

                ->addColumn('final_amount', function ($row) {
                    return number_format($row->total_amount - $row->discount, 2);
                })
                ->addColumn('customer', function ($row) {
                    return $row->customer ? $row->customer->name : '';
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch ? $row->branch->name : '';
                })

                ->addColumn('action', function ($row) {
                    $deleteBtn = '';
                    $editBtn = '';
                    $action = '';
                    $toggleIcon = '';

                    $deleteUrl = route('sale.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');

                    $editBtn = '<a href="' . route('sale.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></a>';



                    $printBtn = '<a href="' . route('sale_invoice_print', $row->id) . '" target="_blank" class="btn btn-sm btn-info ms-2">
                    <i class="fa fa-print"></i>
                 </a>';


                    // Status Toggle Icon Button
                    $toggleIcon = $row->status
                        ? '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-danger ms-1"><i class="fa-solid fa-arrow-down"></i></button>'  // Active: Show red "disable" icon
                        : '<button data-id="' . $row->id . '" class="toggle-status btn btn-sm btn-success ms-1"><i class="fa-solid fa-arrow-up"></i></button>'; // Inactive: Show green "enable" icon


                    $toggleBtn =  $toggleIcon;
                    $showBtn = '<button data-id="' . $row->id . '" class="show btn btn-sm btn-primary me-2 rounded" style="padding:8px;">
                        <i class="fa fa-eye"></i>
                    </button>';
                    if (check_access("sale.delete")) {
                        $deleteBtn = '<button type="button" class="btn btn-sm btn-danger deleteUser ms-2" data-id="' . $row->id . '">
                            <i class="fa-solid fa-trash"></i>
                        </button>';
                    }
                    return '<div class="d-flex align-items-center  mb-2">'
                        . $showBtn .  $printBtn  . $deleteBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'customer', 'final_amount', 'vat', 'branch'])
                ->make(true);
        }
    }

    public function show($id)
    {

        $sale       = Sale::with('customer', 'details', 'details.variant', 'payments')->where('id', $id)->first();


        $receive_by     = $receive_by = auth()->user()->name;
        $company_info   = GeneralSetting::first();

        return view('backend.sale.show', compact('sale', 'receive_by', 'company_info'));
    }

    public function sale_invoice_print($id)
    {

        $sale       = Sale::with('customer', 'details', 'details.variant', 'payments')->where('id', $id)->first();


        $receive_by     = $receive_by = auth()->user()->name;
        $company_info   = GeneralSetting::first();

        return view('backend.sale.print', compact('sale', 'receive_by', 'company_info'));
    }
    public function form()
    {
        if (!check_access("sale.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $products = Product::where('status', 1)->get();
        $customers = CustomerInformation::where('status', 1)->get();
        $funds = Fund::where('status', 1)->get();
        return view('backend.sale.sale_form', compact('products', 'customers', 'funds'));
    }

    public function  store(Request $request)
    {

        try {
            DB::beginTransaction();
            if ($request->phone !== null) {
                $customer = CustomerInformation::where('phone', $request->phone)->where('branch_id', $request->branch_id ?? session('branch_id'))->first();
                if (!$customer) {
                    $customer = CustomerInformation::create([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'opening_balance' => 0,
                        'date' => date('Y-m-d'),
                        'status' => 1,
                        'created_by'  => auth()->user()->id,
                        'branch_id' => $request->branch_id ?? session('branch_id'),
                    ]);
                }
            }



            $totalPayableAmount = $request->payable_amount ?  $request->payable_amount : 0;
            $totalPaymentAmount = $request->paid_amount ?  $request->paid_amount : 0;
            $totalDueAmount = $request->due_amount ?  $request->due_amount : 0;
            $discount = $request->discount_amount ? $request->discount_amount : 0;

            $vat = $request->vat_amount ?? 0;
            $lastInvoice = Sale::latest()->first();
            $lastInvoiceNo = ($lastInvoice) ? $lastInvoice->id : 0;

            $invoice_no = 'SL-' . sprintf('%06d', $lastInvoiceNo + 1);

            $status = 0; // ডিফল্ট unpaid

            if ($totalPaymentAmount == 0) {
                $status = 0; // Unpaid
            } elseif ($totalDueAmount == 0) {
                $status = 1; // Paid
            } else {
                $status = 2; // Partially Paid
            }


            $sale = sale::create([
                'customer_id' => $customer->id ?? null,
                'invoice_no' => $invoice_no,
                'paid_amount' => $totalPaymentAmount,
                'due_amount' => $totalDueAmount,
                'total_amount' => $totalPayableAmount +  $discount,
                'discount' => $discount,
                'vat' => $vat,
                'remarks' => $request->note,
                'status' => $status,
                'date' => $request->date,
                'branch_id' => $request->branch_id ?? session('branch_id'),
                'created_by'  => auth()->user()->id,
            ]);

            $products = $request->input('product_id', []);
            $variants = $request->input('variant_id', []);
            $quantitys = $request->input('qty', []);
            $prices = $request->input('rate', []);
            $totalAmounts = $request->input('sub_total', []);


            foreach ($products as $key => $productId) {
                if (!$productId) {
                    continue;
                }

                SaleDetails::create([
                    'sale_id'     => $sale->id,
                    'product_id'  => $productId,
                    'variant_id'  => $variants[$key] ?? null,
                    'quantity'    => $quantitys[$key] ?? null,
                    'rate'        => $prices[$key] ?? null,
                    'amount'      => $totalAmounts[$key] ?? 0,
                    'branch_id'   => $request->branch_id ?? session('branch_id'),
                    'created_by'  => auth()->user()->id,
                ]);


                if (isset($variants[$key]) && $variants[$key] != null) {
                    $variant = ProductVariant::find($variants[$key]);
                    $variantStock = VariantStocks::where('variant_id', $variant->id)
                        ->where('branch_id', $request->branch_id ?? session('branch_id'))
                        ->first();
                    if ($variantStock) {
                        $newStock = $variantStock->stock - $quantitys[$key];
                        if ($newStock < 0) {
                            DB::rollBack();
                            Alert::error('Insufficient Stock', 'This product does not have sufficient stock. The sale cannot be completed!');
                            return redirect()->back();
                        }
                        $variantStock->stock -= $quantitys[$key] ?? 0;
                        $variantStock->save();
                    }
                }
            }


            $fundIds = $request->input('fund_id', []);
            $bankIds = $request->input('bank_id', []);
            $accountIds = $request->input('account_id', []);
            $paymentAmounts = $request->input('payment_amount', []);
            $branchId = $request->branch_id ?? session('branch_id');
            if (!empty($fundIds)) {
                foreach ($fundIds as $key => $fundId) {
                    if (isset($fundIds[$key]) && $fundIds[$key] != null) {
                        SalePayment::create([
                            'sale_id'     => $sale->id,
                            'fund_id'     => $fundId ?? null,
                            'bank_id'     => $bankIds[$key] ?? null,
                            'account_id'  => $accountIds[$key] ?? null,
                            'amount'      => $paymentAmounts[$key] ?? null,
                            'date'        => date('Y-m-d'),
                            'branch_id'   => $request->branch_id ?? session('branch_id'),
                            'created_by'  => auth()->user()->id,
                        ]);
                    }

                    $branchFund = BranchFundBalance::where('branch_id', $branchId)
                        ->where('fund_id', $fundId)
                        ->where('bank_id', $bankIds[$key] ?? null)
                        ->where('account_id', $accountIds[$key] ?? null)
                        ->first();

                    if ($branchFund) {
                        // Balance update
                        $branchFund->balance += $paymentAmounts[$key] ?? 0;
                        $branchFund->save();
                    } else {
                        // Create new record
                        BranchFundBalance::create([
                            'branch_id'  => $branchId,
                            'fund_id'    => $fundId,
                            'bank_id'    => $bankIds[$key] ?? null,
                            'account_id' => $accountIds[$key] ?? null,
                            'balance'    => $paymentAmounts[$key] ?? 0,
                            'created_by'  => auth()->user()->id,
                        ]);
                    }
                }
            }

            DB::commit();
            Alert::success('Sale Created', 'Sale Created Successfully!');
            return redirect()->route('sale_invoice_print', ['id' => $sale->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Sale Generate Failed', 'Some thing went wrong!' . $e);
            return redirect()->route('sale.form');
        }
    }
    public function checkCustomer(Request $request, $branch = null)
    {

        $phone = $request->phone;
        $customer = CustomerInformation::where('phone', $phone)->where('branch_id', $branch)->first();

        if ($customer) {
            return response()->json([
                'exists' => true,
                'name' => $customer->name,
                'address' => $customer->address,
            ]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    public function getProductVariant($id, $branchId = null)
    {
        $variants = ProductVariant::with('product', 'size', 'color')
            ->where('product_id', $id)
            ->where('status', 1)
            ->get();

        // Get stock for each variant from VariantStocks
        $variants->map(function ($variant) use ($branchId) {
            $stock = \App\Models\VariantStocks::where('variant_id', $variant->id)
                ->where('branch_id', $branchId)
                ->value('stock');

            $variant->stock = $stock ?? 0;
            return $variant;
        });

        // Only variants with stock > 0
        $variants = $variants->filter(function ($variant) {
            return $variant->stock > 0;
        })->values();

        $product = Product::find($id);

        // ===========================
        //   VAT CALCULATION SECTION
        // ===========================
        $setting = \App\Models\GeneralSetting::first();
        $vatType = $setting->vat_type;   // inside_vat or outside_vat
        $vat = (float)$setting->vat;     // vat percentage

        $salePrice = (float)$product->sale_price;
        $vatAmount = 0;
        $priceWithoutVat = $salePrice;

        if ($vatType === 'inside_vat') {
            // VAT included in sale price
            // Formula: VAT amount = (price * vat) / (100 + vat)
            $vatAmount = ($salePrice * $vat) / (100 + $vat);

            // Price without VAT
            $priceWithoutVat = $salePrice - $vatAmount;
        } elseif ($vatType === 'outside_vat') {
            // VAT outside price
            // VAT = price * (vat / 100)
            $vatAmount = $salePrice * ($vat / 100);

            // Price does not change
            $priceWithoutVat = $salePrice;
        }

        return response()->json([
            'data' => $variants,
            'sale_price' => round($priceWithoutVat, 2),   // final price user will see
            'vat_amount' => round($vatAmount, 2),         // calculated VAT amount
            'vat_type' => $vatType,
            'original_sale_price' => $salePrice
        ]);
    }




    public function distroy(Request $request)
    {

        try {
            DB::beginTransaction();
            if (!check_access("sale.delete")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            $sale = Sale::findOrFail($request->id);

            // Get all purchase details
            $details = DB::table('sale_details')
                ->where('sale_id', $sale->id)
                ->get();


            // Check stock availability first
            foreach ($details as $item) {



                $variant = ProductVariant::find($item->variant_id);


                if ($variant) {
                    $variantStock = VariantStocks::where('variant_id', $variant->id)
                        ->where('branch_id', $item->branch_id)
                        ->first();

                    if ($variantStock) {
                        $variantStock->stock += $item->quantity;
                    }

                    $variantStock->save();
                }
            }




            $payments = DB::table('sale_payments')->where('sale_id', $sale->id)->get();

            foreach ($payments as $pay) {




                $branchFund = BranchFundBalance::where('branch_id', $pay->branch_id)
                    ->where('fund_id', $pay->fund_id)
                    ->where('bank_id', $pay->bank_id ?? null)
                    ->where('account_id', $pay->account_id ?? null)
                    ->first();

                if ($branchFund) {
                    // Balance update
                    $branchFund->balance -= $pay->amount ?? 0;
                    $branchFund->save();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Fund Blance not found"
                    ], 404);
                }
            }


            // Delete purchase details first
            DB::table('sale_payments')->where('sale_id', $sale->id)->delete();

            // Delete sale details
            DB::table('sale_details')->where('sale_id', $sale->id)->delete();

            // Delete purchase
            $sale->delete();
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Sale Delete Failed', 'Some thing went wrong!' . $e);
            return redirect()->route('sale.form');
        }
    }
}