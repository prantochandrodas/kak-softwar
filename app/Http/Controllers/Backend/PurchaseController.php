<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BranchFundBalance;
use App\Models\Color;
use App\Models\Fund;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\Size;
use App\Models\Supplier;
use App\Models\User;
use App\Models\VariantStocks;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{

    public function getSupplier($id)
    {
        $supplier = Supplier::where('branch_id', $id)
            ->where('status', 1)
            ->get();

        return response()->json(['supplier' => $supplier]);
    }
    public function purchasePaymentList(Request $request)
    {
        $supplier_id = $request->supplier_id ?? null;
        $from_date = $request->from_date ?? date('Y-m-d');
        $to_date = $request->to_date ?? date('Y-m-d');
        $today = date('Y-m-d');

        // Filter query
        $query = \DB::table('purchase_payments')
            ->join('purchases', 'purchase_payments.purchase_id', '=', 'purchases.id')
            ->leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->leftJoin('funds', 'purchase_payments.fund_id', '=', 'funds.id')
            ->leftJoin('banks', 'purchase_payments.bank_id', '=', 'banks.id')
            ->leftJoin('bank_accounts', 'purchase_payments.account_id', '=', 'bank_accounts.id')
            ->select(
                'purchase_payments.*',
                'suppliers.name as supplier_name',
                'funds.name as fund_name',
                'banks.name as bank_name',
                'bank_accounts.account_number as account_no'
            )
            ->where('purchase_payments.branch_id', $request->branch_id ?? session('branch_id'))
            ->whereBetween('purchase_payments.date', [$from_date, $to_date]);

        if ($supplier_id) {
            $query->where('purchases.supplier_id', $supplier_id);
        }

        $reportData = $query->orderBy('purchase_payments.date', 'asc')->get();

        // All suppliers for the filter dropdown
        $suppliers = \DB::table('suppliers')->where('branch_id', $request->branch_id ?? session('branch_id'))->where('status', 1)->get();

        return view('backend.purchase.payment_list', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'today' => $today,
            'reportData' => $reportData,
            'suppliers' => $suppliers,
            'supplier_id' => $supplier_id,
        ]);
    }

    public function index()
    {
        if (!check_access("purchase.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $suppliers = Supplier::where('status', 1)->where('branch_id', session('branch_id'))->get();
        return view('backend.purchase.index', compact('suppliers'));
    }

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

    public function getAccountByBank($id, $branchId = null)
    {
        $branchId = $branchId ?? session('branch_id');
        $data = BankAccount::where('bank_id', $id)->where('branch_id', $branchId)->where('status', 1)->get();

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

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = User::find(auth()->user()->id);



            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                $query = Purchase::with(['supplier', 'branch'])->orderBy('created_at', 'desc');
            } else {
                $query = Purchase::with(['supplier', 'branch'])->where('branch_id', session('branch_id'))->orderBy('created_at', 'desc');
            }


            if ($request->branch_id) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->supplier_id) {
                $query->where('supplier_id', $request->supplier_id);
            }
            if ($request->status || $request->status === '0') {
                $query->where('status', $request->status);
            }



            if ($request->from_date && $request->to_date) {
                $from = Carbon::parse($request->from_date)->startOfDay();
                $to   = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('purchase_date', [$from, $to]);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->editColumn('date', function ($row) {
                    return Carbon::parse($row->purchase_date)->format('d-m-Y');
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

                ->addColumn('supplier', function ($row) {
                    return $row->supplier ? $row->supplier->name : '';
                })
                ->addColumn('branch', function ($row) {
                    return $row->branch ? $row->branch->name : '';
                })

                ->addColumn('action', function ($row) {
                    $deleteBtn = '';
                    $editBtn = '';
                    $action = '';
                    $toggleIcon = '';

                    $deleteUrl = route('purchase.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');
                    if (check_access("purchase.edit")) {
                        $editBtn = '<a href="' . route('purchase.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }


                    $printBtn = '<a href="' . route('purchase_invoice_print', $row->id) . '" target="_blank" class="btn btn-sm btn-info ms-2">
                    <i class="fa fa-print"></i>
                 </a>';

                    if (check_access("purchase.status")) {
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
                        . $showBtn .  $printBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'branch'])
                ->make(true);
        }
    }



    public function show($id)
    {
        $purchase       = Purchase::with('supplier', 'details', 'payments')->where('id', $id)->first();
        $receive_by     = $receive_by = auth()->user()->name;
        $company_info   = GeneralSetting::first();

        return view('backend.purchase.show', compact('purchase', 'receive_by', 'company_info'));
    }

    public function purchase_invoice_print($id)
    {

        $purchase       = Purchase::with('supplier', 'details', 'payments')->where('id', $id)->first();


        $receive_by     = $receive_by = auth()->user()->name;
        $company_info   = GeneralSetting::first();

        return view('backend.purchase.print', compact('purchase', 'receive_by', 'company_info'));
    }

    public function distroy(Request $request)
    {
        try {
            if (!check_access("purchase.delete")) {
                Alert::error('Error', "You don't have permission!");
                return redirect()->route('admin.dashboard');
            }

            DB::beginTransaction();

            $purchase = Purchase::findOrFail($request->id);

            // Fetch purchase details
            $details = DB::table('purchase_details')
                ->where('purchase_id', $purchase->id)
                ->get();


            foreach ($details as $item) {

                // Variant খুঁজবো product_id + purchaseId এর ভিত্তিতে
                $variant = ProductVariant::where('product_id', $item->product_id)

                    ->where('color_id', $item->color_id ?? null)
                    ->where('size_id', $item->size_id ?? null)
                    ->first();
                if ($variant) {
                    // VariantStocks থেকে stock কমাবো
                    $variantStock = VariantStocks::where('variant_id', $variant->id)
                        ->where('branch_id', $item->branch_id)
                        ->first();

                    if ($variantStock) {

                        // Stock কমানো
                        $variantStock->stock -= $item->quantity;

                        if ($variantStock->stock < 0) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => "Stock is not available"
                            ], 400);
                        }

                        $variantStock->save();
                    }
                }
            }

            // Restore payments
            $payments = DB::table('purchase_payments')->where('purchase_id', $purchase->id)->get();
            foreach ($payments as $pay) {

                if (!empty($pay->fund_id)) {
                    $fund = Fund::find($pay->fund_id);
                    if ($fund) {
                        $fund->balance += $pay->amount;
                        $fund->save();
                    }
                }

                if (!empty($pay->account_id)) {
                    $account = BankAccount::find($pay->account_id);
                    if ($account) {
                        $account->balance += $pay->amount;
                        $account->save();
                    }
                }
            }

            // Delete payments
            DB::table('purchase_payments')->where('purchase_id', $purchase->id)->delete();

            // Delete purchase details
            DB::table('purchase_details')->where('purchase_id', $purchase->id)->delete();

            // Delete purchase
            $purchase->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function purchase_form()
    {
        if (!check_access("purchase.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $funds = Fund::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->where('branch_id', session('branch_id'))->get();
        $product = Product::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        return view('backend.purchase.purchase_form', compact('funds', 'suppliers', 'product', 'sizes', 'colors'));
    }

    public function getProductData(Request $request)
    {
        $product = Product::with('unit')->find($request->id);

        return response()->json([
            'purchase_price' => $product->purchase_price,
            'unit' => $product->unit ? $product->unit->name : '',
        ]);
    }

    public function getSupplierData($id)
    {
        $supplier = \App\Models\Supplier::find($id);

        if (!$supplier) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $supplier->name,
                'phone' => $supplier->office_phone,
                'email' => $supplier->office_email,
                'address' => $supplier->address,
            ]
        ]);
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

        return 'PV-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }


    public function store(Request $request)
    {

        if (!check_access("purchase.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        try {
            DB::beginTransaction();

            $lastInvoice = Purchase::latest()->first();
            $lastInvoiceNo = ($lastInvoice) ? $lastInvoice->id : 0;

            $invoice_no = 'PUR-' . sprintf('%06d', $lastInvoiceNo + 1);

            $status = 0; // ডিফল্ট unpaid

            if ($request->totalPaid == 0) {
                $status = 0; // Unpaid
            } elseif ($request->remaining == 0) {
                $status = 1; // Paid
            } else {
                $status = 2; // Partially Paid
            }

            $purchase = Purchase::create([

                'supplier_id' => $request->supplierId,
                'branch_id' => $request->branchId ?? session('branch_id'),
                'invoice_no' => $invoice_no,
                'transporation_cost' => $request->transporationCost ?? 0,
                'total_amount' => $request->payabeleAmount,
                'final_amount' => $request->payabeleAmount,
                'due_amount' => $request->remaining,
                'paid_amount' => $request->totalPaid,
                'purchase_date' => $request->purchaseDate,
                'terms_condition' => $request->terms_condition,
                'note' => $request->note,
                'status' => $status,
                'created_by'  => auth()->user()->id,

            ]);

            $cart = $request->input('cart', []);
            foreach ($cart as $item) {
                DB::table('purchase_details')->insert([
                    'product_id'    => $item['productId'] ?? null,
                    'size_id'     => $item['sizeId'] ?? null,
                    'color_id'    =>  $item['colorId'] ?? null,
                    'purchase_id'   => $purchase->id,
                    'quantity'      => $item['qty'] ?? 0,
                    'rate'          => $item['price'] ?? 0,
                    'amount'        => $item['total'] ?? 0,
                    'branch_id' => $request->branchId ?? session('branch_id'),
                    'created_by'  => auth()->user()->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                // Update product stock if productId exists
                if (!empty($item['productId'])) {

                    $productId = $item['productId'];
                    $colorId   = $item['colorId'] ?? null;
                    $sizeId    = $item['sizeId'] ?? null;

                    // 1️⃣ Check if the variant already exists
                    $existingVariant = ProductVariant::where('product_id', $productId)
                        ->where('color_id', $colorId)
                        ->where('size_id', $sizeId)
                        ->first();

                    if ($existingVariant) {

                        // 2️⃣ Check stock per branch
                        $existingStock = VariantStocks::where('variant_id', $existingVariant->id)
                            ->where('branch_id', $request->branchId ?? session('branch_id'))
                            ->first();

                        if ($existingStock) {
                            // Stock exists → update stock
                            $existingStock->update([
                                'stock' => $existingStock->stock + ($item['qty'] ?? 0),
                            ]);
                        } else {
                            // No stock record for this branch → create new row
                            VariantStocks::create([
                                'branch_id'  => $request->branchId ?? session('branch_id'),
                                'product_id' => $productId,
                                'variant_id' => $existingVariant->id,
                                'stock'      => $item['qty'] ?? 0,
                                'created_by' => auth()->user()->id,
                            ]);
                        }
                    } else {

                        // 3️⃣ Create new variant
                        $variant = ProductVariant::create([
                            'purchase_id' => $purchase->id,
                            'product_id'  => $productId,
                            'size_id'     => $sizeId,
                            'color_id'    => $colorId,
                            'price'       => $item['price'] ?? 0,
                            'status'      => 1,
                        ]);

                        // Create stock for this branch
                        VariantStocks::create([
                            'branch_id'  => $request->branchId ?? session('branch_id'),
                            'product_id' => $productId,
                            'variant_id' => $variant->id,
                            'stock'      => $item['qty'] ?? 0,
                            'created_by' => auth()->user()->id,
                        ]);
                    }
                }
            }


            $payment = $request->input('payments', []);
            foreach ($payment as $item) {
                $voucherNo = $this->generateVoucherNo();
                DB::table('purchase_payments')->insert([
                    'voucher_no'     => $voucherNo,
                    'fund_id'    => $item['fundId'],
                    'purchase_id'    => $purchase->id,
                    'bank_id'       => $item['bank'],
                    'account_id'     => $item['account'],
                    'amount'         => $item['amount'],
                    'date' => $request->purchaseDate,
                    'branch_id' => $request->branchId ?? session('branch_id'),
                    'created_by'  => auth()->user()->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);


                $branchFund = BranchFundBalance::where('branch_id', $request->branchId ?? session('branch_id'))
                    ->where('fund_id', $item['fundId'])
                    ->where('bank_id', $item['bank'] ?? null)
                    ->where('account_id', $item['account'] ?? null)
                    ->first();

                if ($branchFund) {
                    // Balance update
                    $branchFund->balance -= $item['amount'] ?? 0;
                    $branchFund->save();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong! Please try again.',
                        'error' => 'Branch fund record not found!'
                    ], 500);
                }

                // $fund = Fund::findOrFail($item['fundId']); // item er fundId use kora hocche
                // if ($fund) {
                //     $fund->balance -= $item['amount']; // balance theke amount minus
                //     $fund->save();
                // }

                // if (isset($item['account']) && $item['account'] != null) {
                //     $account = BankAccount::findOrFail($item['account']);
                //     $account->balance -= $item['amount'];
                //     $account->save();
                // }
            }


            DB::commit();
            return response()->json(['success' => true, 'message' => 'Purchase added Successfully!', 'id' => $purchase->id,]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}