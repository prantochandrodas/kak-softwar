<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use SkipsFailures;
    public function model(array $row)
    {
        DB::beginTransaction();
        try {

            // Category
            $category = Category::firstOrCreate(
                ['name' => $row['category']],
                ['status' => 1, 'created_by' => auth()->user()->id]
            );

            // SubCategory
            $subcategory = null;
            if (!empty($row['subcategory'])) {
                $subcategory = SubCategory::firstOrCreate(
                    ['name' => $row['subcategory'], 'category_id' => $category->id],
                    ['status' => 1, 'created_by' => auth()->user()->id]
                );
            }

            // Unit
            $unit = Unit::firstOrCreate(
                ['name' => $row['unit']],
                ['status' => 1, 'created_by' => auth()->user()->id]
            );

            // Brand
            $brand = null;
            if (!empty($row['brand'])) {
                $brand = Brand::firstOrCreate(
                    ['name' => $row['brand']],
                    ['status' => 1, 'created_by' => auth()->user()->id]
                );
            }

            // Image handling (optional)
            $imagePath =  null;

            // Product code if empty
            $product_code = $row['product_code'] ?? now()->format('ymdHis');

            DB::commit();

            return new Product([
                'product_code' => $product_code,
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id ?? null,
                'unit_id' => $unit->id,
                'brand_id' => $brand->id ?? null,
                'name' => $row['name'],
                'name_arabic' => $row['name_arabic'],
                'purchase_price' => $row['purchase_price'] ?? 0,
                'sale_price' => $row['sale_price'] ?? 0,
                'barcode' => $row['barcode'],
                'details' => $row['details'] ?? null,
                'image' => $imagePath,
                'status' => $row['status'] ?? 1,
                'created_by' => auth()->user()->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            'barcode' => 'required|unique:products,barcode',
            'name' => 'required',
        ];
    }


    public function customValidationMessages()
    {
        return [
            'barcode.unique' => 'The barcode ":input" already exists!',
            'barcode.required' => 'Barcode is required!',
            'name.required' => 'Product name is required!',
        ];
    }
}
