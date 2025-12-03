<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BranchFundBalance;
use App\Models\CustomerDuePaymentDetails;
use App\Models\CustomerInformation;
use App\Models\Fund;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DuePaymentController extends Controller
{

    public function getCustomer($id)
    {
        $data = CustomerInformation::where('branch_id', $id)->where('status', 1)->get();

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
    public function sale_due_payment_form()
    {
        if (!check_access("purchase.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $paymentType = 'invoice_payment';
        // $paymentType = 'opening_due';

        $customers = CustomerInformation::where('status', 1)->where('branch_id', session('branch_id'))->get();
        $funds = Fund::where('status', 1)->get();
        return view('backend.sale.sale_due_payment', compact('customers', 'funds', 'paymentType'));
    }


    public function getSaleInvoice($id)
    {
        $data = Sale::where('customer_id', $id)
            ->where('due_amount', '!=', 0)
            ->get();

        return response()->json(['data' => $data]);
    }


    public function getSaleInvoiceDue($invoiceId)
    {
        $sale = Sale::find($invoiceId);

        return response()->json(['due_amount' => $sale ? $sale->due_amount : 0]);
    }


    public function getOpeningBalance($id)
    {
        $customer = CustomerInformation::find($id);
        return response()->json([
            'opening_balance' => $customer->opening_balance ?? 0,
        ]);
    }
    public function saleDuePaymentStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $invoiceIds = $request->input('invoice_id', []); // default empty array
            $customerIds = $request->input('customer_id', []);
            $fundIds = $request->input('fund_id', []);
            $bankIds = $request->input('bank_id', []);
            $accountIds = $request->input('account_id', []);
            $dates = $request->input('date', []);
            $amounts = $request->input('amount', []);
            $paymentType = $request->payment_type;
            $branchId = $request->branch_id ?? session('branch_id');
            if ($paymentType == 'invoice_payment') {
                foreach ($invoiceIds as $key => $sale_id) {
                    if (!$sale_id) {
                        continue; // skip if invoice_id is null
                    }

                    SalePayment::create([
                        'sale_id' => $sale_id,
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
                        $branchFund->balance += $amount ?? 0;
                        $branchFund->save();
                    } else {
                        // Create new record
                        BranchFundBalance::create([
                            'branch_id'  => $branchId,
                            'fund_id'    => $fundIds[$key],
                            'bank_id'    => $bankIds[$key] ?? null,
                            'account_id' => $accountIds[$key] ?? null,
                            'balance'    => $amount ?? 0,
                            'created_by' => auth()->user()->id,
                        ]);
                    }

                    // // Deduct from fund balance if fund_id exists
                    // if (isset($fundIds[$key]) && $fundIds[$key] != null) {
                    //     $fund = Fund::find($fundIds[$key]);
                    //     if ($fund) {
                    //         $fund->balance += $amount;
                    //         $fund->save();
                    //     }
                    // }

                    // // Deduct from bank account balance if account_id exists
                    // if (isset($accountIds[$key]) && $accountIds[$key] != null) {
                    //     $account = BankAccount::find($accountIds[$key]);
                    //     if ($account) {
                    //         $account->balance += $amount;
                    //         $account->save();
                    //     }
                    // }


                    $sale = Sale::find($sale_id);
                    if ($sale) {
                        $sale->paid_amount += $amount;
                        $sale->due_amount -= $amount;


                        if ($sale->paid_amount == 0) {
                            $sale->status = 0; // unpaid
                        } elseif ($sale->paid_amount > 0 && $sale->paid_amount < $sale->total_amount) {
                            $sale->status = 2; // partially paid
                        } elseif ($sale->paid_amount >= $sale->total_amount) {
                            $sale->status = 1; // fully paid
                        }

                        $sale->save();
                    }
                }
            }

            if ($paymentType == 'opening_due') {
                foreach ($fundIds as $key => $fundId) {
                    CustomerDuePaymentDetails::create([
                        'customer_id' => $customerIds[$key] ?? null,
                        'fund_id'     => $fundId ?? null,
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
                        $branchFund->balance += $amount ?? 0;
                        $branchFund->save();
                    } else {
                        // Create new record
                        BranchFundBalance::create([
                            'branch_id'  => $branchId,
                            'fund_id'    => $fundIds[$key],
                            'bank_id'    => $bankIds[$key] ?? null,
                            'account_id' => $accountIds[$key] ?? null,
                            'balance'    => $amount ?? 0,
                            'created_by' => auth()->user()->id,
                        ]);
                    }


                    $customer = CustomerInformation::find($customerIds[$key]);
                    if ($customer) {
                        $customer->opening_balance -= $amount;
                        $customer->save();
                    }
                }
            }

            DB::commit();
            Alert::success('Create Payment', 'Payment  Successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!' . $e);
            return redirect()->back();
        }
    }
    public function index()
    {
        // if (!check_access("purchase.list")) {
        //     Alert::error('Error', "You don't have permission!");
        //     return redirect()->route('admin.dashboard');
        // }

        $suppliers = Supplier::where('status', 1)->where('branch_id', session('branch_id'))->get();
        $funds = Fund::where('status', 1)->get();
        return view('backend.purchase.due_payment', compact('suppliers', 'funds'));
    }


    public function getInvoice($id)
    {
        $data = Purchase::where('supplier_id', $id)
            ->where('due_amount', '!=', 0)
            ->get();

        return response()->json(['data' => $data]);
    }

    public function getInvoiceDue($invoiceId)
    {
        $purchase = Purchase::find($invoiceId);

        return response()->json(['due_amount' => $purchase ? $purchase->due_amount : 0]);
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


    public function due_payment_store(Request $request)
    {

        try {
            DB::beginTransaction();

            $invoiceIds = $request->input('invoice_id', []); // default empty array
            $fundIds = $request->input('fund_id', []);
            $bankIds = $request->input('bank_id', []);
            $accountIds = $request->input('account_id', []);
            $dates = $request->input('date', []);
            $amounts = $request->input('amount', []);
            $branchId = $request->branch_id ?? session('branch_id');
            foreach ($invoiceIds as $key => $purchase_id) {
                if (!$purchase_id) {
                    continue; // skip if invoice_id is null
                }
                $voucherNo = $this->generateVoucherNo();
                PurchasePayment::create([
                    'voucher_no'     => $voucherNo,
                    'purchase_id' => $purchase_id,
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


                $purchase = Purchase::find($purchase_id);
                if ($purchase) {
                    $purchase->paid_amount += $amount;
                    $purchase->due_amount -= $amount;


                    if ($purchase->paid_amount == 0) {
                        $purchase->status = 0; // unpaid
                    } elseif ($purchase->paid_amount > 0 && $purchase->paid_amount < $purchase->total_amount) {
                        $purchase->status = 2; // partially paid
                    } elseif ($purchase->paid_amount >= $purchase->total_amount) {
                        $purchase->status = 1; // fully paid
                    }

                    $purchase->save();
                }
            }

            DB::commit();
            Alert::success('Create Payment', 'Payment Created Successfully!');
            return redirect()->route('due.payment');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!');
            return redirect()->route('due.payment');
        }
    }
}
