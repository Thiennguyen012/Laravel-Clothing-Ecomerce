<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SlugSeeder extends Seeder
{
    public function run()
    {
        // Update slug for products
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $slug = Str::slug($product->product_name);
            DB::table('products')->where('product_id', $product->product_id)->update(['slug' => $slug]);
        }

        // Update slug for categories
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            $slug = Str::slug($category->category_name);
            DB::table('categories')->where('category_id', $category->category_id)->update(['slug' => $slug]);
        }
    }
}
