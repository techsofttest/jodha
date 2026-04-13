<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Collection;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\Color;
use App\Models\ProductImage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection as LaravelCollection;
use Illuminate\Support\Str;

class ProductsImport implements ToCollection, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Assuming the first row is headings
    }

    /**
     * @param LaravelCollection $collection
     */
    public function collection(LaravelCollection $rows)
    {
        foreach ($rows as $index => $row) {
            // Trim names to handle extra spaces
            $categoryName    = trim($row[0] ?? '');
            $subcategoryName = trim($row[1] ?? '');
            $collectionName  = trim($row[2] ?? '');
            $productName     = trim($row[3] ?? '');

            // Skip empty rows
            if (empty($productName) && empty($categoryName)) {
                continue;
            }

            if (empty($productName)) {
                throw new \Exception("Product name is missing on row " . ($index + 2));
            }

            // Map IDs based on names (case-insensitive)
            $catId = null;
            if ($categoryName) {
                $catId = Category::whereRaw('LOWER(name) = ?', [strtolower($categoryName)])->value('id');
            }

            if (!$catId) {
                throw new \Exception("Category '{$categoryName}' not found on row " . ($index + 2));
            }

            $subcatId = null;
            if ($subcategoryName) {
                $subcatId = Subcategory::whereRaw('LOWER(subcat_name) = ?', [strtolower($subcategoryName)])
                    ->where('subcat_cat_id', $catId)
                    ->value('id');
                
                if (!$subcatId) {
                    throw new \Exception("Subcategory '{$subcategoryName}' for Category '{$categoryName}' not found on row " . ($index + 2));
                }
            } else {
                throw new \Exception("Subcategory Name is missing on row " . ($index + 2) . ". It is required.");
            }

            $colId = null;
            if ($collectionName && $subcatId) {
                $colId = Collection::whereRaw('LOWER(col_name) = ?', [strtolower($collectionName)])
                    //->where('col_subcat_id', $subcatId)
                    ->value('id');
                
                if (!$colId) {
                    throw new \Exception("Collection '{$collectionName}' for Subcategory '{$subcategoryName}' not found on row " . ($index + 2));
                }
            } else {
                throw new \Exception("Collection Name is missing on row " . ($index + 2) . ". It is required by the database structure.");
            }

            // Identify product (update or create)
            $productData = [
                'prod_cat_id'            => $catId,
                'prod_subcat_id'         => $subcatId,
                'prod_col_id'            => $colId,
                'prod_price'             => $row[4] ?? 0,
                'prod_sale_price'        => $row[5] ?? null,
                'prod_expected_delivery' => $row[6] ?? null,
                'prod_description'       => $row[11] ?? null,
                'prod_material'          => $row[12] ?? null,
                'prod_measurements'      => $row[13] ?? null,
                'prod_image'             => $row[9] ?? null,
                'meta_title'             => $row[14] ?? null,
                'meta_description'       => $row[15] ?? null,
                'meta_keywords'          => $row[16] ?? null,
                'prod_isactive'          => true,
            ];

            // If it's a new product, we need a slug
            $product = Product::where('prod_name', $productName)->first();
            if ($product) {
                $product->update($productData);
            } else {
                $productData['prod_name'] = $productName;
                $productData['prod_slug'] = Str::slug($productName);
                $product = Product::create($productData);
            }

            // Handle Size (Column H -> 7)
            $sizeValue = trim($row[7] ?? '');
            if ($sizeValue) {
                ProductSize::updateOrCreate(
                    ['product_id' => $product->id, 'size' => $sizeValue],
                    [
                        'price'       => (float)($row[5] ?? $row[4] ?? 0),
                        'stock'       => 100, // Default stock
                    ]
                );
            }

            // Handle Color (Column I -> 8, comma separated)
            $colorValue = trim($row[8] ?? '');
            if ($colorValue) {
                $colors = array_filter(array_map('trim', explode(',', $colorValue)));
                foreach ($colors as $colorName) {
                    $colorCode = Color::whereRaw('LOWER(name) = ?', [strtolower($colorName)])->value('color_code') ?? '#000000';
                    ProductColor::updateOrCreate(
                        ['product_id' => $product->id, 'color_name' => $colorName],
                        [
                            'color_code' => $colorCode,
                        ]
                    );
                }
            }

            // Handle Gallery Images (Column K -> 10, comma separated)
            $galleryValue = trim($row[10] ?? '');
            if ($galleryValue) {
                $images = array_filter(array_map('trim', explode(',', $galleryValue)));
                // Keep adding/checking images
                foreach ($images as $img) {
                    ProductImage::updateOrCreate([
                        'product_id' => $product->id,
                        'image_path' => $img
                    ]);
                }
            }
        }
    }
}
