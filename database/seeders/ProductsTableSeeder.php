<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'Product_name' => 'البطاقات الائتمانية',
            'section_id' => '1',
            'description' => 'عشوائي'
        ]);
    }
}
