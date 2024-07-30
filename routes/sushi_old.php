<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

Route::get('/old-db', function () {
    $categories_old = DB::connection('mysql_old')->table('categories')->get()->map(function ($category) {
        return [
            'id' => $category->cat_id,
            'name' => $category->cat_name,
            'slug' => $category->slug,
        ];
    });
    $sub_categories_old = DB::connection('mysql_old')->table('subcategories')->get()->map(function ($sub_category) {
        return [
            'name' => $sub_category->subcat_name,
            'parent_id' => $sub_category->cat_id,
            'slug'=>Str::slug($sub_category->subcat_name).'-'.substr(Str::uuid()->toString(8), 0, 10),
        ];
    });
    $products_old = DB::connection('mysql_old')->table('products')->get()->map(function ($product) {
        return [
            'id' => $product->prod_id,
            'name' => $product->prod_name,
            'composition' => $product->composition,
            'allergenes' => $product->allergenes,
            'sku' => $product->SKU,
            'price' => $product->price,
            'description' => $product->text,
            'category_id' => $product->subcat_id,
            'slug'=>Str::slug($product->prod_name).'-'.substr(Str::uuid()->toString(8), 0, 10),
        ];
    });
    Category::latest()->delete();
    Product::latest()->delete();

    foreach ($categories_old as $category) {
        Category::create($category);
    }
    foreach ($sub_categories_old as $subcategory) {
        Category::create($subcategory);
    }
    foreach ($products_old as $product) {
        Product::create($product);
    }
});