<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Fund;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transfer;
use App\Models\TransferDetails;
use App\Models\VariantStocks;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ProductTransferController extends Controller
{
    public function index()
    {
        if (!check_access("product-transfer.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        return view('backend.product_transfer.index');
    }
    public function receivedIndex()
    {
        if (!check_access("product-transfer.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        return view('backend.product_transfer.received_list');
    }

    public function receiveTransfer($id)
    {
        $transfer = Transfer::find($id);

        if (!$transfer) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $transferDetails = TransferDetails::with('variant')->where('transfer_id', $transfer->id)->get();

        foreach ($transferDetails as $item) {
            $totalQty = TransferDetails::where('transfer_id', $transfer->id)
                ->where('product_id', $item->product_id)
                ->where('varient_id', $item->varient_id)
                ->sum('quantity');

            $fromStock = VariantStocks::where('product_id', $item->product_id)
                ->where('variant_id', $item->varient_id)
                ->where('branch_id', $transfer->form_branch_id)
                ->first();

            if (!$fromStock) {
                return response()->json([
                    'error' => "Stock not found in from-branch for  {$item->variant->product->name}, {$item->variant->size->name}, {$item->variant->color->colorName}"
                ], 400);
            }

            if ($totalQty > $fromStock->stock) {
                return response()->json([
                    'error' => "Total transfer quantity ({$totalQty}) is greater than available stock ({$fromStock->stock})."
                ], 400);
            }


            $fromStock->stock -= $item->quantity;
            $fromStock->save();



            $toStock = VariantStocks::where('product_id', $item->product_id)
                ->where('variant_id', $item->varient_id)
                ->where('branch_id', $transfer->to_branch_id)
                ->first();

            if ($toStock) {
                $toStock->stock += $item->quantity;
                $toStock->save();
            } else {
                VariantStocks::create([
                    'product_id' => $item->product_id,
                    'variant_id' => $item->varient_id,
                    'branch_id'  => $transfer->to_branch_id,
                    'stock'      => $item->quantity,
                    'created_by'  => auth()->user()->id,
                ]);
            }
        }

        $transfer->status = 1;
        $transfer->save();

        return response()->json(['success' => 'Transfer received successfully']);
    }


    public function returnTransfer($id)
    {
        $transfer = Transfer::find($id);

        if (!$transfer) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $transfer->status = 2;
        $transfer->save();

        return response()->json(['success' => 'Transfer returned successfully']);
    }


    public function show($id)
    {
        $transfer       = Transfer::with(['toBranch', 'formBranch'])->where('id', $id)->first();
        $company_info   = GeneralSetting::first();

        return view('backend.product_transfer.show', compact('transfer',  'company_info'));
    }

    public function receivedGetdata(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                // Super Admin হলে সব supplier দেখাবে
                $query = Transfer::with('toBranch', 'formBranch')->orderBy('created_at', 'desc');
            } else {
                $query = Transfer::with('toBranch', 'formBranch')->where('to_branch_id',  session('branch_id'))->orderBy('created_at', 'desc');
            }


            if ($request->form_branch_id) {
                $query->where('form_branch_id', $request->form_branch_id);
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
                    return Carbon::parse($row->date)->format('d-m-Y');
                })
                ->editColumn('from_branch', function ($row) {
                    return $row->formBranch->name ?? '';
                })
                ->editColumn('to_branch', function ($row) {
                    return $row->toBranch->name ?? '';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Recived</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-warning">Return</span>';
                    } else {
                        return '<span class="badge bg-danger">Pendding</span>';
                    }
                })



                ->addColumn('action', function ($row) {

                    $receiveBtn = "";
                    $returnBtn = "";
                    $printBtn = '<a href="' . route('purchase_invoice_print', $row->id) . '" target="_blank" class="btn btn-sm btn-info ms-2">
                    <i class="fa fa-print"></i>
                 </a>';


                    $showBtn = '<button data-id="' . $row->id . '" class="show btn btn-sm btn-primary me-2 rounded" style="padding:8px;">
                        <i class="fa fa-eye"></i>
                    </button>';

                    if ($row->status == 0) {
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
                        . $showBtn .  $receiveBtn .
                        $returnBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'from_branch'])
                ->make(true);
        }
    }


    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->roles->pluck('name')->contains('Super Admin') && session('branch_id') == null) {
                // Super Admin হলে সব supplier দেখাবে
                $query = Transfer::with('toBranch', 'formBranch')->orderBy('created_at', 'desc');
            } else {
                $query = Transfer::with('toBranch', 'formBranch')->where('form_branch_id',  session('branch_id'))->orderBy('created_at', 'desc');
            }



            if ($request->form_branch_id) {
                $query->where('form_branch_id', $request->form_branch_id);
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
                    return Carbon::parse($row->date)->format('d-m-Y');
                })
                ->editColumn('form_branch', function ($row) {
                    return $row->formBranch->name ?? '';
                })
                ->editColumn('to_branch', function ($row) {
                    return $row->toBranch->name ?? '';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Recived</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-warning">Return</span>';
                    } else {
                        return '<span class="badge bg-danger">Pendding</span>';
                    }
                })



                ->addColumn('action', function ($row) {



                    $printBtn = '<a href="' . route('purchase_invoice_print', $row->id) . '" target="_blank" class="btn btn-sm btn-info ms-2">
                    <i class="fa fa-print"></i>
                 </a>';


                    $showBtn = '<button data-id="' . $row->id . '" class="show btn btn-sm btn-primary me-2 rounded" style="padding:8px;">
                        <i class="fa fa-eye"></i>
                    </button>';

                    return '<div class="d-flex align-items-center  mb-2">'
                        . $showBtn .
                        '</div>';
                })
                ->rawColumns(['action', 'status', 'form_branch', 'to_branch'])
                ->make(true);
        }
    }
    public function form()
    {
        if (!check_access("product-transfer.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $products = Product::where('status', 1)->get();

        $branches = Branch::where('status', 1)
            ->where('id', '!=', session('branch_id'))
            ->get();

        return view('backend.product_transfer.form', compact('products', 'branches'));
    }

    public function store(Request $request)
    {
        if (!check_access("product-transfer.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        try {
            DB::beginTransaction();

            $lastInvoice = Transfer::latest()->first();
            $lastInvoiceNo = ($lastInvoice) ? $lastInvoice->id : 0;

            $invoice_no = 'PT-' . sprintf('%06d', $lastInvoiceNo + 1);

            $status = 0; // pendding

            $total = $request->total ?? [];

            $total_amount = array_sum($total);

            $transfer = Transfer::create([

                'form_branch_id' => $request->form_branch_id ?? session('branch_id'),
                'to_branch_id' => $request->to_branch_id,
                'transfer_id' => $invoice_no,
                'total_item' => $request->total_quantity ?? 0,
                'total_amount' => $total_amount,
                'date' => $request->transfer_date,
                'status' => $status,
                'created_by'  => auth()->user()->id,
            ]);

            $productIds = $request->input('product_id', []);
            $varients = $request->input('variant_id', []);
            $rates = $request->input('rate', []);
            $totals = $request->input('total', []);
            $quantitys = $request->input('quantity', []);
            foreach ($productIds as $key => $productId) {
                if (!$productId) {
                    continue; // skip if invoice_id is null
                }

                TransferDetails::create([
                    'transfer_id'     => $transfer->id,
                    'product_id'  => $productId,
                    'varient_id'   => $varients[$key] ?? null,
                    'quantity'    => $quantitys[$key] ?? null,
                    'rate'        => $rates[$key] ?? null,
                    'amount'      => $totals[$key] ?? 0,
                ]);
            }
            DB::commit();
            // return response()->json(['success' => true, 'message' => 'Transfer Successfully added!',]);
            Alert::success('Transfer Customer', 'Transfer Successfully!');
            return redirect()->route('product.transfer.form');
        } catch (\Exception $e) {
            DB::rollBack();
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Something went wrong! Please try again.',
            //     'error' => $e->getMessage()
            // ], 500);
            Alert::error('Transfer Failed', 'Some thing went wrong!');
            return redirect()->route('product.transfer.form');
        }
    }


    public function getProductVariant($id, $branchId = null)
    {
        $selectedbranchId = $branchId ?? session('branch_id'); // Get logged-in user's branch

        $variants = ProductVariant::with('product', 'size', 'color')
            ->where('product_id', $id)
            ->where('status', 1)
            ->get();

        // Get stock for each variant from VariantStocks
        $variants->map(function ($variant) use ($selectedbranchId) {

            $stock = \App\Models\VariantStocks::where('variant_id', $variant->id)
                ->where('branch_id', $selectedbranchId)
                ->value('stock'); // get stock for this branch

            $variant->stock = $stock ?? 0; // set 0 if no stock
            return $variant;
        });

        $product = Product::find($id);

        return response()->json([
            'data' => $variants,
            'purchase_price' => $product->purchase_price
        ]);
    }


    public function getVariantStock($variantId, $productId, $branchId = null)
    {
        $newBranchId = $branchId ?? session('branch_id');
        $stock = VariantStocks::where('variant_id', $variantId)
            ->where('branch_id', $newBranchId)
            ->value('stock');
        $product = Product::with('unit')->find($productId);


        return response()->json(['stock' => $stock ?? 0, 'product_unit' => $product->unit->name ?? '']);
    }
}
