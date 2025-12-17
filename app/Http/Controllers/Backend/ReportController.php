<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerDuePaymentDetails;
use App\Models\CustomerInformation;
use App\Models\Expense;
use App\Models\Fund;
use App\Models\FundAdjustment;
use App\Models\FundTransfer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\PurchasePayment;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SalePayment;
use App\Models\Supplier;
use App\Models\SupplierDuePayment;
use App\Models\VariantStocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{

    public function profitReport(Request $request)
    {
        $from_date = $request->from_date ?? now()->startOfMonth()->toDateString();
        $to_date = $request->to_date ?? now()->endOfMonth()->toDateString();
        $product_id = $request->product_id ?? null;

        $products = Product::where('status', 1)->get();

        $salesQuery = \App\Models\SaleDetails::with(['sale', 'product'])
            ->whereHas('sale', function ($q) use ($from_date, $to_date) {
                $q->whereBetween('date', [$from_date, $to_date]);
            });

        if ($product_id) {
            $salesQuery->where('product_id', $product_id);
        }

        $sales = $salesQuery->get();

        $reportData = [];
        $total_purchase_cost = 0;
        $total_sale_amount = 0;
        $total_profit = 0;

        foreach ($products as $product) {
            $productSales = $sales->where('product_id', $product->id);

            if ($productSales->count() > 0) {
                $totalQty = $productSales->sum('quantity'); // মোট sale quantity
                $purchaseCost = $totalQty * $product->purchase_price;
                $saleAmount = $totalQty * $product->sale_price;
                $profit = $saleAmount - $purchaseCost;

                $reportData[] = [
                    'product_name' => $product->name,
                    'product_unit' => $product->unit->name,
                    'quantity' => $totalQty,
                    'purchase_price' => $product->purchase_price,
                    'sale_price' => $product->sale_price,
                    'purchase_cost' => $purchaseCost,
                    'sale_amount' => $saleAmount,
                    'profit' => $profit,
                ];

                $total_purchase_cost += $purchaseCost;
                $total_sale_amount += $saleAmount;
                $total_profit += $profit;
            }
        }

        $total_expense = \App\Models\Expense::whereBetween('date', [$from_date, $to_date])->sum('amount');
        $net_profit = $total_profit - $total_expense;

        return view('backend.report.profit_report', compact(
            'products',
            'product_id',
            'from_date',
            'to_date',
            'reportData',
            'total_purchase_cost',
            'total_sale_amount',
            'total_profit',
            'total_expense',
            'net_profit'
        ));
    }
    public function fundHistoryReport(Request $request)
    {
        if (!check_access("fund-history-report")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;
        $branch_id = $request->branch_id ?? session('branch_id');

        $fund_id = $request->fund_id;
        $bank_id = $request->bank_id ?? null;
        $account_id = $request->account_id ?? null;
        $funds = Fund::where('status', 1)->get();


        $salesPayments = [];
        $supplierPayments = [];
        $expenses = [];
        $summary = [];
        $purchasePayments = [];
        $customerDuePayments = [];
        $adjustments = [];
        $reviceTransfers = [];
        $transfers = [];


        if ($from_date && $to_date) {



            // sell collection
            $salesPayments = SalePayment::with(['sale', 'fund', 'bank', 'account'])
                ->whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->get();

            $totalSellCollection = SalePayment::whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id)
                ->where('account_id', $account_id)->where('branch_id', $branch_id)->sum('amount');
            $openingSale = SalePayment::where('fund_id', $fund_id)
                ->whereDate('date', '<', $from_date)
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->sum('amount');


            // Customer DuePayment Details

            $customerDuePayments = CustomerDuePaymentDetails::with(['customer', 'fund', 'bank', 'account'])
                ->whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->get();
            $totalCustomerDueCollection =  CustomerDuePaymentDetails::with(['customer', 'fund', 'bank', 'account'])
                ->whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->sum('amount');


            $openingCustomerDue =  CustomerDuePaymentDetails::with(['customer', 'fund', 'bank', 'account'])
                ->whereDate('date', '<', $from_date)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->sum('amount');


            // purchase
            $purchasePayments = PurchasePayment::with(['purchase.supplier', 'fund', 'bank', 'account'])->whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->get();

            $totalPurchaseExpenses = PurchasePayment::whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->sum('amount');

            $openingPurchase = PurchasePayment::where('fund_id', $fund_id)
                ->whereDate('date', '<', $from_date)
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->sum('amount');


            // supplierPayments

            $supplierPayments = SupplierDuePayment::with(['supplier', 'fund', 'bank', 'account'])->whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->get();



            $totalSupplierPayment = SupplierDuePayment::whereBetween('date', [$from_date, $to_date])
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->where('branch_id', $branch_id)
                ->sum('amount');

            $openingSupplierPayment = SupplierDuePayment::where('fund_id', $fund_id)
                ->whereDate('date', '<', $from_date)
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->sum('amount');


            // expense

            $expenses = Expense::with(['head', 'fund', 'bank', 'account'])->where('fund_id', $fund_id)
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->get();
            $expensesTotal = Expense::where('fund_id', $fund_id)
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->sum('amount');


            $openingExpense = Expense::where('fund_id', $fund_id)
                ->whereDate('date', '<', $from_date)
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->sum('amount');


            // fund adjustment
            $adjustments = FundAdjustment::with(['fund', 'bank', 'account'])
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->get();


            $totalAdjustment = FundAdjustment::with(['fund', 'bank', 'account'])
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->sum('amount');

            $openingFundAdjustments = FundAdjustment::with(['fund', 'bank', 'account'])
                ->whereDate('date', '<', $from_date)
                ->where('branch_id', $branch_id)
                ->where('fund_id', $fund_id)
                ->where('bank_id', $bank_id ?? null)
                ->where('account_id', $account_id ?? null)
                ->sum('amount');


            // fund transfer
            $transfers = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount'])
                ->whereBetween('transaction_date', [$from_date, $to_date])
                ->where('from_branch_id', $branch_id)
                ->where('from_fund_id', $fund_id)
                ->where('from_bank_id', $bank_id ?? null)
                ->where('from_acc_id', $account_id ?? null)
                ->where('status', 1)
                ->get();

            $totalTransfer = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount'])
                ->whereBetween('transaction_date', [$from_date, $to_date])
                ->where('from_branch_id', $branch_id)
                ->where('from_fund_id', $fund_id)
                ->where('from_bank_id', $bank_id ?? null)
                ->where('from_acc_id', $account_id ?? null)
                ->where('status', 1)
                ->sum('transaction_amount');

            $openingTransfer = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount'])
                ->whereDate('transaction_date', '<', $from_date)
                ->where('from_branch_id', $branch_id)
                ->where('from_fund_id', $fund_id)
                ->where('from_bank_id', $bank_id ?? null)
                ->where('from_acc_id', $account_id ?? null)
                ->where('status', 1)
                ->sum('transaction_amount');
            // revice transfer
            $reviceTransfers = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount'])
                ->whereBetween('transaction_date', [$from_date, $to_date])
                ->where('to_branch_id', $branch_id)
                ->where('to_fund_id', $fund_id)
                ->where('to_bank_id', $bank_id ?? null)
                ->where('to_acc_id', $account_id ?? null)
                ->where('status', 1)
                ->get();

            $reviceTotalTransfer = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount'])
                ->whereBetween('transaction_date', [$from_date, $to_date])
                ->where('to_branch_id', $branch_id)
                ->where('to_fund_id', $fund_id)
                ->where('to_bank_id', $bank_id ?? null)
                ->where('to_acc_id', $account_id ?? null)
                ->where('status', 1)
                ->sum('transaction_amount');

            $openingReviceTransfer = FundTransfer::with(['fromFund', 'fromBank', 'fromAccount'])
                ->whereDate('transaction_date', '<', $from_date)
                ->where('to_branch_id', $branch_id)
                ->where('to_fund_id', $fund_id)
                ->where('to_bank_id', $bank_id ?? null)
                ->where('to_acc_id', $account_id ?? null)
                ->where('status', 1)
                ->sum('transaction_amount');


            // previous balance
            $previous_balance =
                $openingSale + $openingCustomerDue +  $openingReviceTransfer + $openingFundAdjustments
                - $openingPurchase
                - $openingExpense - $openingSupplierPayment - $openingTransfer;

            // balance
            $balance = ($previous_balance + $totalSellCollection + $totalCustomerDueCollection + $totalAdjustment + $reviceTotalTransfer) -  $totalPurchaseExpenses - $totalSupplierPayment - $expensesTotal - $totalTransfer;

            $summary = [
                'previous_balance'   => $previous_balance,
                'totalSellCollection' => $totalSellCollection,
                'totalCustomerDueCollection' => $totalCustomerDueCollection,
                'expensesTotal' => $expensesTotal,
                'totalAdjustment' => $totalAdjustment,
                'totalTransfer' => $totalTransfer,
                'reviceTotalTransfer' => $reviceTotalTransfer,
                'totalSupplierPaymentCollection'  => $totalPurchaseExpenses + $totalSupplierPayment,
                'balance'            =>  $balance
            ];
        }
        return view('backend.report.fund_history_report', compact(
            'fund_id',
            'from_date',
            'to_date',
            'bank_id',
            'account_id',
            'branch_id',
            'salesPayments',
            'purchasePayments',
            'supplierPayments',
            'customerDuePayments',
            'reviceTransfers',
            'adjustments',
            'transfers',
            'expenses',
            'summary',
            'funds'
        ));
    }

    // public function fundReport(Request $request)
    // {
    //     $fund_id = $request->fund_id;
    //     $from_date = $request->from_date;
    //     $to_date = $request->to_date;
    //     $branch_id = $request->branch_id ?? session('branch_id');
    //     $funds = Fund::where('status', 1)->get();

    //     $openingBalance = 0;
    //     $transactions = collect();

    //     if ($fund_id && $from_date && $to_date) {

    //         // 🎯 Fund Table Opening Balance (MAIN OPENING)
    //         $fundOpening = 0;

    //         $openingSale = SalePayment::where('fund_id', $fund_id)
    //             ->whereDate('date', '<', $from_date)
    //             ->where('branch_id', $branch_id)
    //             ->sum('amount');

    //         $openingPurchase = PurchasePayment::where('fund_id', $fund_id)
    //             ->whereDate('date', '<', $from_date)
    //             ->where('branch_id', $branch_id)
    //             ->sum('amount');



    //         $openingExpense = Expense::where('fund_id', $fund_id)
    //             ->whereDate('date', '<', $from_date)
    //             ->where('branch_id', $branch_id)
    //             ->sum('amount');

    //         $openingBalance = $fundOpening
    //             + $openingSale
    //             - $openingPurchase
    //             - $openingExpense;

    //         // 2️⃣ Date Range Transactions (From → To)

    //         // Sale Payments
    //         $sales = SalePayment::with('sale')
    //             ->where('fund_id', $fund_id)
    //             ->whereBetween('date', [$from_date, $to_date])
    //             ->where('branch_id', $branch_id)
    //             ->get()
    //             ->map(function ($item) {
    //                 return [
    //                     'date' => $item->date,
    //                     'type' => 'Sale Payment',
    //                     'transaction_no' => $item->sale->invoice_no ?? 'N/A',
    //                     'debit' => 0,
    //                     'credit' => $item->amount
    //                 ];
    //             });

    //         // Purchase Payments
    //         $purchases = PurchasePayment::with('purchase')
    //             ->where('fund_id', $fund_id)
    //             ->whereBetween('date', [$from_date, $to_date])
    //             ->where('branch_id', $branch_id)
    //             ->get()
    //             ->map(function ($item) {
    //                 return [
    //                     'date' => $item->date,
    //                     'type' => 'Purchase Payment',
    //                     'transaction_no' => $item->purchase->invoice_no ?? 'N/A',
    //                     'debit' => $item->amount,
    //                     'credit' => 0
    //                 ];
    //             });



    //         // Expenses
    //         $expenses = Expense::where('fund_id', $fund_id)
    //             ->whereBetween('date', [$from_date, $to_date])
    //             ->where('branch_id', $branch_id)
    //             ->get()
    //             ->map(function ($item) {
    //                 return [
    //                     'date' => $item->date,
    //                     'type' => 'Expense',
    //                     'transaction_no' => $item->invoice_no ?? 'N/A',
    //                     'debit' => $item->amount,
    //                     'credit' => 0
    //                 ];
    //             });

    //         $transactions = collect()
    //             ->merge($sales)
    //             ->merge($purchases)
    //             ->merge($expenses)
    //             ->sortBy('date')
    //             ->values();
    //     }

    //     return view('backend.fund.report', compact(
    //         'funds',
    //         'fund_id',
    //         'from_date',
    //         'to_date',
    //         'openingBalance',
    //         'transactions'
    //     ));
    // }
    public function customer_report(Request $request)
    {
        if (!check_access("customer-report")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $customer_id = $request->customer_id ?? null;
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;

        $branchId = $request->branch_id ?? session('branch_id');
        $branch_id = $request->branch_id ?? session('branch_id');
        $customers = CustomerInformation::where('status', 1)->where('branch_id', $request->branch_id ?? session('branch_id'))->get();
        $sales = [];
        $payments = [];
        $summary = [];
        $opening_due_payments = [];
        if ($customer_id && $from_date && $to_date) {


            $sales = Sale::with(['customer', 'details'])
                ->where('customer_id', $customer_id)
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branchId)
                ->get();


            $payments = SalePayment::with(['sale'])
                ->whereHas('sale', function ($q) use ($customer_id, $from_date, $to_date) {
                    $q->where('customer_id', $customer_id)
                        ->whereBetween('date', [$from_date, $to_date]);
                })
                ->where('branch_id', $branchId)
                ->get();

            $opening_due_payments = CustomerDuePaymentDetails::whereBetween('date', [$from_date, $to_date])->where('customer_id', $customer_id)
                ->get();

            $total_sale = Sale::with('details')
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branch_id)
                ->where('customer_id', $customer_id)
                ->get()
                ->sum(function ($sale) {
                    $details_sum = $sale->details->sum('amount'); // sum of sale details
                    return $details_sum - $sale->discount +  $sale->vat;       // subtract discount from sale
                });




            $totalSalePayments = SalePayment::whereHas('sale', function ($q) use ($customer_id, $from_date, $to_date) {
                $q->where('customer_id', $customer_id)
                    ->whereBetween('date', [$from_date, $to_date]);
            })->where('branch_id', $branchId)->sum('amount');

            $totalDuePayment = CustomerDuePaymentDetails::whereBetween('date', [$from_date, $to_date])->where('branch_id', $branchId)
                ->sum('amount');
            $total_payment = $totalSalePayments;

            $saleDuePayments = Sale::where('customer_id', $customer_id)
                ->whereDate('date', '<', $from_date)
                ->where('branch_id', $branchId)
                ->sum('due_amount');
            $customerOpeningDueBlance = CustomerInformation::where('id', $customer_id)->where('branch_id', $branchId)->value('opening_balance') ?? 0;

            $previous_due = $saleDuePayments + $customerOpeningDueBlance;
            $totalExpense =  $saleDuePayments  + $total_sale + $customerOpeningDueBlance;

            $summary = [
                'previous_due'   => $previous_due,
                'totalExpense' => $totalExpense,
                'total_sale' => $total_sale,
                'total_payment'  => $total_payment,
                'due'            => ($previous_due + $total_sale) - $total_payment,
            ];
        }
        return view('backend.report.customer_report', compact(
            'branch_id',
            'from_date',
            'customer_id',
            'to_date',
            'sales',
            'payments',
            'opening_due_payments',
            'summary',
            'customers'
        ));
    }
    public function sale_report(Request $request)
    {
        if (!check_access("sale-report")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;
        $branch_id = $request->branch_id ?? session('branch_id');


        $sales = [];
        $payments = [];
        $summary = [];

        if ($from_date && $to_date) {


            $sales = Sale::with(['details'])
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branch_id)
                ->get();


            $payments = SalePayment::with(['sale'])
                ->whereHas('sale', function ($q) use ($from_date, $to_date) {
                    $q->whereBetween('date', [$from_date, $to_date]);
                })
                ->where('branch_id', $branch_id)
                ->get();


            $total_sale = Sale::with('details')
                ->whereBetween('date', [$from_date, $to_date])
                ->where('branch_id', $branch_id)
                ->get()
                ->sum(function ($sale) {
                    $details_sum = $sale->details->sum('amount'); // sum of sale details
                    return $details_sum - $sale->discount +  $sale->vat;       // subtract discount from sale
                });


            $total_payment = SalePayment::whereHas('sale', function ($q) use ($from_date, $to_date) {
                $q->whereBetween('date', [$from_date, $to_date]);
            })->where('branch_id', $branch_id)->sum('amount');

            $previous_due = Sale::whereDate('date', '<', $from_date)
                ->where('branch_id', $branch_id)
                ->sum('due_amount');

            $summary = [
                'previous_due'   => $previous_due,
                'total_sale'     => $total_sale,
                'total_payment'  => $total_payment,
                'due'            => ($previous_due + $total_sale) - $total_payment,
            ];
        }

        return view('backend.report.sale_report', compact(
            'from_date',
            'to_date',
            'branch_id',
            'sales',
            'payments',
            'summary'
        ));
    }

    public function stock_report(Request $request)
    {
        if (!check_access("stock-report")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $product_id = $request->product_id ?? null;
        $from_date = $request->from_date ?? date('Y-m-d');
        $to_date = $request->to_date ?? date('Y-m-d');
        $today = date('Y-m-d');
        $products = Product::where('status', 1)->get();
        $filterProducts = Product::where('status', 1)->get();
        $branchIdFromRequest = $request->branch_id ?? null;
        $user = Auth::user();
        if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
            if ($branchIdFromRequest) {
                // If request has branch_id → filter by that branch
                $productVariants = $product_id
                    ? VariantStocks::with('variant')
                    ->where('product_id', $product_id)
                    ->where('branch_id', $branchIdFromRequest)
                    ->get()
                    : VariantStocks::with('variant')
                    ->where('branch_id', $branchIdFromRequest)
                    ->get();
            } else {

                // If no request branch_id → return all branches
                $productVariants = $product_id
                    ? VariantStocks::with('variant')
                    ->where('product_id', $product_id)
                    ->get()
                    : VariantStocks::with('variant')->get();
            }
        } else {
            $productVariants = $product_id
                ? VariantStocks::with('variant')->where('product_id', $product_id)->where('branch_id', session('branch_id'))->get()
                : VariantStocks::with('variant')->where('branch_id',  session('branch_id'))->get();
        }


        $reportData = [];


        foreach ($productVariants as $item) {
            $pid = $item->product_id;
            $sid = $item->variant->size_id ?? null;
            $cid = $item->variant->color_id ?? null;
            $bid = $item->branch_id;
            $vid = $item->variant_id;
            // Opening balance = stock before from_date
            $openingBalance =
                \DB::table('purchase_details')
                ->join('purchases', 'purchase_details.purchase_id', '=', 'purchases.id')
                ->where('purchase_details.product_id', $pid)
                ->where('purchase_details.size_id', $sid ?? null)
                ->where('purchase_details.color_id', $cid ?? null)
                ->where('purchase_details.branch_id', $bid)
                ->whereDate('purchases.purchase_date', '<', $from_date)
                ->sum('purchase_details.quantity')
                -
                \DB::table('sale_details')
                ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
                ->where('sale_details.product_id', $pid)
                ->where('sale_details.variant_id', $vid)
                ->where('sale_details.branch_id', $bid)
                ->whereDate('sales.date', '<', $from_date)
                ->sum('sale_details.quantity')
                +
                \DB::table('transfer_details')
                ->join('transfers', 'transfer_details.transfer_id', '=', 'transfers.id')
                ->where('transfer_details.product_id', $pid)
                ->where('transfer_details.varient_id', $vid)
                ->where('transfers.to_branch_id', $bid) // যে ব্রাঞ্চে পণ্য গেছে
                ->where('transfers.status', 1) // ট্রান্সফার রিসিভ হয়েছে
                ->whereDate('transfers.date', '<', $from_date)
                ->sum('transfer_details.quantity')
                -
                \DB::table('transfer_details')
                ->join('transfers', 'transfer_details.transfer_id', '=', 'transfers.id')
                ->where('transfer_details.product_id', $pid)
                ->where('transfer_details.varient_id', $vid)
                ->where('transfers.form_branch_id', $bid)
                ->where('transfers.status', 1)
                ->whereDate('transfers.date', '<', $from_date)
                ->sum('transfer_details.quantity');


            // Current period transactions
            $currentPurchase = \DB::table('purchase_details')
                ->join('purchases', 'purchase_details.purchase_id', '=', 'purchases.id')
                ->where('purchase_details.product_id', $pid)
                ->where('purchase_details.size_id', $sid ?? null)
                ->where('purchase_details.color_id', $cid ?? null)
                ->where('purchase_details.branch_id', $bid)
                ->whereBetween('purchases.purchase_date', [$from_date, $to_date])
                ->sum('purchase_details.quantity');



            $currentStockRevice =    \DB::table('transfer_details')
                ->join('transfers', 'transfer_details.transfer_id', '=', 'transfers.id')
                ->where('transfer_details.product_id', $pid)
                ->where('transfer_details.varient_id', $vid)
                ->where('transfers.to_branch_id', $bid) // যে ব্রাঞ্চে পণ্য গেছে
                ->where('transfers.status', 1) // ট্রান্সফার রিসিভ হয়েছে
                ->whereBetween('transfers.date', [$from_date, $to_date])
                ->sum('transfer_details.quantity');
            $currentStockTransfer =    \DB::table('transfer_details')
                ->join('transfers', 'transfer_details.transfer_id', '=', 'transfers.id')
                ->where('transfer_details.product_id', $pid)
                ->where('transfer_details.varient_id', $vid)
                ->where('transfers.form_branch_id', $bid) // যে ব্রাঞ্চে পণ্য গেছে
                ->where('transfers.status', 1) // ট্রান্সফার রিসিভ হয়েছে
                ->whereBetween('transfers.date', [$from_date, $to_date])
                ->sum('transfer_details.quantity');

            $currentSale = \DB::table('sale_details')
                ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
                ->where('sale_details.product_id', $pid)
                ->where('sale_details.variant_id', $vid)
                ->where('sale_details.branch_id', $bid)
                ->whereBetween('sales.date', [$from_date, $to_date])
                ->sum('sale_details.quantity');



            // Closing stock = opening + current transactions
            $currentStock = $openingBalance + $currentPurchase +  $currentStockRevice -   $currentStockTransfer - $currentSale;

            $reportData[] = [
                'product' => $item->product->name . ' ' . $item->product->name_arabic ?? '',
                'product_code' => $item->product->barcode ?? '',
                'size' => $item->variant->size->name ?? '',
                'color' => $item->variant->color->color_name ?? '',
                'branch' => $item->branch->name ?? '',
                'openingBalance' => $openingBalance,
                'currentPurchase' => $currentPurchase,
                'currentSale' => $currentSale,
                'currentStock' => $currentStock,
                'stockRecived' => $currentStockRevice,
                'stockTransfer' => $currentStockTransfer,
            ];
        }

        return view('backend.report.stock_report', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'today' => $today,
            'products' => $products,
            'filterProducts' => $filterProducts,
            'reportData' => $reportData,
        ]);
    }
    public function product_stock(Request $request)
    {

        if ($request->ajax()) {
            $barcode = $request->barcode ?? null;
            if ($request->product_id) {
                $product_id = $request->product_id ?? null;
            } else {

                if ($barcode) {
                    $product = Product::where('barcode', $barcode)->first();
                    $product_id = $product->id ?? null;
                } else {
                    $product_id =  null;
                }
            }



            $user = Auth::user();
            $branchIdFromRequest = $request->branch_id ?? null;

            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {

                if ($branchIdFromRequest) {
                    $productVariants = VariantStocks::with('variant')
                        ->when($product_id, fn($q) => $q->where('product_id', $product_id))
                        ->where('branch_id', $branchIdFromRequest)
                        ->get();
                } else {
                    $productVariants = VariantStocks::with('variant')
                        ->when($product_id, fn($q) => $q->where('product_id', $product_id))
                        ->get();
                }
            } else {
                $productVariants = VariantStocks::with('variant')
                    ->when($product_id, fn($q) => $q->where('product_id', $product_id))
                    ->where('branch_id', session('branch_id'))
                    ->get();
            }

            $reportData = [];

            foreach ($productVariants as $item) {

                $pid = $item->product_id;
                $sid = $item->variant->size_id ?? null;
                $cid = $item->variant->color_id ?? null;
                $bid = $item->branch_id;
                $vid = $item->variant_id;

                $currentPurchase = \DB::table('purchase_details')
                    ->join('purchases', 'purchase_details.purchase_id', '=', 'purchases.id')
                    ->where('purchase_details.product_id', $pid)
                    ->where('purchase_details.size_id', $sid)
                    ->where('purchase_details.color_id', $cid)
                    ->where('purchase_details.branch_id', $bid)
                    ->sum('purchase_details.quantity');

                $currentStockRecived = \DB::table('transfer_details')
                    ->join('transfers', 'transfer_details.transfer_id', '=', 'transfers.id')
                    ->where('transfer_details.product_id', $pid)
                    ->where('transfer_details.varient_id', $vid)
                    ->where('transfers.to_branch_id', $bid)
                    ->where('transfers.status', 1)
                    ->sum('transfer_details.quantity');

                $currentStockTransfer = \DB::table('transfer_details')
                    ->join('transfers', 'transfer_details.transfer_id', '=', 'transfers.id')
                    ->where('transfer_details.product_id', $pid)
                    ->where('transfer_details.varient_id', $vid)
                    ->where('transfers.form_branch_id', $bid)
                    ->where('transfers.status', 1)
                    ->sum('transfer_details.quantity');

                $currentSale = \DB::table('sale_details')
                    ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
                    ->where('sale_details.product_id', $pid)
                    ->where('sale_details.variant_id', $vid)
                    ->where('sale_details.branch_id', $bid)
                    ->sum('sale_details.quantity');

                $currentStock = $currentPurchase + $currentStockRecived - $currentStockTransfer - $currentSale;

                $reportData[] = [
                    'product' => $item->product->name,
                    'product_code' => $item->product->barcode,
                    'size' => $item->variant->size->name ?? '',
                    'color' => $item->variant->color->color_name ?? '',
                    'branch' => $item->branch->name ?? '',
                    'purchase' => $currentPurchase,
                    'sale' => $currentSale,
                    'received' => $currentStockRecived,
                    'transfer' => $currentStockTransfer,
                    'current_stock' => $currentStock,
                ];
            }

            return response()->json(['data' => $reportData]);
        }

        // === Normal page load ===

        return view('backend.dashboard', [
            'products' => Product::where('status', 1)->get(),
            'reportData' => []
        ]);
    }

    public function purchase_report(Request $request)
    {
        if (!check_access("purchase-report")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $supplier_id = $request->supplier_id ?? null;
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;

        $suppliers = Supplier::where('branch_id', session('branch_id'))->where('status', 1)->get();

        $purchases = [];
        $payments = [];
        $summary = [];

        if ($supplier_id && $from_date && $to_date) {


            $purchases = Purchase::with(['supplier', 'details'])
                ->where('supplier_id', $supplier_id)
                ->whereBetween('purchase_date', [$from_date, $to_date])
                ->get();


            $payments = PurchasePayment::with('purchase')
                ->whereBetween('date', [$from_date, $to_date])   // PurchasePayment table date
                ->whereHas('purchase', function ($q) use ($supplier_id) {
                    $q->where('supplier_id', $supplier_id);
                })
                ->get();


            $total_purchase = PurchaseDetails::whereHas('purchase', function ($q) use ($supplier_id, $from_date, $to_date) {
                $q->where('supplier_id', $supplier_id)
                    ->whereBetween('purchase_date', [$from_date, $to_date]);
            })->sum('amount');


            $total_payment = PurchasePayment::whereBetween('date', [$from_date, $to_date])
                ->whereHas('purchase', function ($q) use ($supplier_id) {
                    $q->where('supplier_id', $supplier_id);
                })
                ->sum('amount');
            // ✅ Previous due before "from_date"
            $previous_due = Purchase::where('supplier_id', $supplier_id)
                ->whereDate('purchase_date', '<', $from_date)
                ->sum('due_amount');

            // ✅ Summary calculation
            $summary = [
                'previous_due'   => $previous_due,
                'total_purchase' => $total_purchase,
                'total_payment'  => $total_payment,
                'due'            => ($previous_due + $total_purchase) - $total_payment,
            ];
        }

        return view('backend.report.purchase_report', compact(
            'suppliers',
            'supplier_id',
            'from_date',
            'to_date',
            'purchases',
            'payments',
            'summary'
        ));
    }
}
