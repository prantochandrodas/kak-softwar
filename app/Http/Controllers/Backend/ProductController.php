<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    public function index()
    {
        if (!check_access("product.list")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $categories = Category::where('status', 1)->get();
        $productBrand = Brand::where('status', 1)->get();
        return view('backend.product.index', compact('categories', 'productBrand'));
    }

    public function show($id)
    {

        $data = Product::with('unit', 'category', 'brand')->findOrFail($id);

        return view('backend.product.show', compact('data'));
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['category', 'subcategory', 'unit', 'brand'])->orderBy('created_at', 'desc');


            if ($request->categories) {
                $query->where('category_id', $request->categories);
            }

            if ($request->subcategory_id) {
                $query->where('subcategory_id', $request->subcategory_id);
            }

            if ($request->productBrand) {
                $query->where('brand_id', $request->productBrand);
            }

            if ($request->status || $request->status === '0') {
                $query->where('status', $request->status);
            }


            $data = $query->get();
            return DataTables::of($data)
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('category', function ($row) {
                    return $row->category ? $row->category->name : '';
                })
                ->addColumn('subcategory', function ($row) {
                    return $row->subcategory ? $row->subcategory->name : '';
                })
                ->addColumn('unit', function ($row) {
                    return $row->unit ? $row->unit->name : '';
                })
                ->addColumn('brand', function ($row) {
                    return $row->brand ? $row->brand->name : '';
                })

                ->addColumn('action', function ($row) {
                    $deleteBtn = '';
                    $editBtn = '';
                    $action = '';
                    $toggleIcon = '';

                    $deleteUrl = route('product.distroy', $row->id);
                    $csrfToken = csrf_field();
                    $method = method_field('DELETE');
                    if (check_access("product.edit")) {
                        $editBtn = '<a href="' . route('product.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }

                    if (check_access("product.status")) {
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
                ->rawColumns(['action', 'status', 'category', 'profit', 'brand', 'group'])
                ->make(true);
        }
    }
    public function create()
    {
        if (!check_access("product.create")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $productCat = Category::where('status', 1)->get();
        $productBrand = Brand::where('status', 1)->get();
        $productUnit = Unit::where('status', 1)->get();


        return view('backend.product.create', compact('productCat', 'productBrand', 'productUnit'));
    }

    public function store(Request $request)
    {
        if (!check_access("product.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|exists:units,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'barcode' => 'required|unique:products,barcode',
            'shit_no' => 'nullable',
            'sale_price' => 'nullable|numeric',
            'purchase_price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        try {
            DB::beginTransaction();
            $lastInvoice = Product::latest()->first();
            $lastInvoiceNo = ($lastInvoice) ? $lastInvoice->id : 0;
            $currentDateTime = now();
            $invoice_no =  $currentDateTime->format('ymdHis') . ($lastInvoiceNo + 1);
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = uploadImage($file, 'products', 'product');
                $imagePath = $file_name;
            }

            Product::create([
                'product_code' => $invoice_no,
                'category_id' =>  $request->category_id,
                'subcategory_id' =>  $request->subcategory_id,
                'unit_id' =>  $request->unit,
                'brand_id' =>  $request->brand_id,
                'name' => $request->name,
                'purchase_price' =>  $request->purchase_price,
                'sale_price' =>  $request->sale_price,
                'barcode' =>  $request->barcode,
                'shit_no' =>  $request->shit_no,
                'details' =>  $request->details,
                'image' => $imagePath,
                'status' => 1,
                'created_by'  => auth()->user()->id,
            ]);



            DB::commit();
            Alert::success('Create Product', 'Product Created Successfully!');
            return redirect()->route('product.create');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Create Error', 'Something went wrong! Please try again.');
            return redirect()->route('product.create');
        }
    }


    public function edit($id)
    {
        if (!check_access("product.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = Product::findOrFail($id);
        $productCat = Category::where('status', 1)->get();
        $productBrand = Brand::where('status', 1)->get();
        $productUnit = Unit::where('status', 1)->get();
        return view('backend.product.edit', compact('data', 'productCat', 'productBrand', 'productUnit'));
    }


    public function update(Request $request, $id)
    {
        if (!check_access("product.edit")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }

        $find = Product::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|exists:units,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'barcode' => 'required|unique:products,barcode,' . $find->id,
            'shit_no' => 'nullable',
            'sale_price' => 'nullable|numeric',
            'purchase_price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            DB::beginTransaction();





            $status = 0;
            if (!$request->status) {
                $status = 0;
            } else {
                $status = $request->status;
            }
            $imagePath = $find->image;
            $lastInvoice = Product::latest()->first();
            $lastInvoiceNo = ($lastInvoice) ? $lastInvoice->id : 0;
            $currentDateTime = now();
            $invoice_no =  $currentDateTime->format('ymdHis') . ($lastInvoiceNo + 1);
            if ($request->hasFile('image')) {
                if ($find->image) {
                    $oldPhotoPath = '/uploads/products/' . $find->image; // Adjust path based on your setup
                    if (file_exists(public_path($oldPhotoPath))) {
                        unlink(public_path($oldPhotoPath));
                    }
                }

                // Upload new photo
                $file = $request->file('image');
                $file_name = uploadImage($file, 'products', 'products');
                $imagePath = $file_name;
            }
            $data = [
                'product_code' => $invoice_no,
                'category_id' =>  $request->category_id,
                'subcategory_id' =>  $request->subcategory_id,
                'unit_id' =>  $request->unit,
                'brand_id' =>  $request->brand_id,
                'name' => $request->name,
                'purchase_price' =>  $request->purchase_price,
                'sale_price' =>  $request->sale_price,
                'barcode' =>  $request->barcode,
                'shit_no' =>  $request->shit_no,
                'details' =>  $request->details,
                'image' => $imagePath,
                'status' => $status,
                'updated_by' =>   auth()->user()->id,
            ];
            $find->update($data);

            DB::commit();
            Alert::success('Update Product', 'Product Updated Successfully!');
            return redirect()->route('product.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Update Failed', 'Some thing went wrong!');
            return redirect()->route('product.index');
        }
    }

    public function toggleStatus(Request $request)
    {
        if (!check_access("product.status")) {
            Alert::error('Error', "You don't have permission!");
            return redirect()->route('admin.dashboard');
        }
        $data = Product::find($request->id);
        if ($data) {
            $data->status = !$data->status;
            $data->save();
            return response()->json(['success' => true, 'status' => $data->status]);
        }
        return response()->json(['success' => false], 404);
    }


    public function getSubcategory($id)
    {
        $data = SubCategory::where('category_id', $id)->where('status', 1)->get();
        return response()->json(['data' => $data]);
    }
}
