<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('products')->insert([
            [
                'name' => 'dark purple danshiki',
                'slug' => 'ty-001',
                'image' => 'products/purple_dashiki.jpg',
                'hover_image' => '',
                'description' => 'Top fashion dark purple danshiki for events like owanbe,naming ceremony e.t.c',
                'price' => 32000.78,
                'stock' => 40,
                'product_category' => 'Danshiki',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'brown danshiki',
                'slug' => 'ty-002',
                'image' => 'products/brown_dashiki.jpg',
                'hover_image' => '',
                'description' => 'Top fashion dark brown danshiki  sleevless for agile men',
                'price' => 52700.78,
                'stock' => 30,
                'product_category' => 'Danshiki',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'dark agbabda',
                'slug' => 'ty-006',
                'image' => 'products/dark_agbada.png',
                'hover_image' => '',
                'description' => 'Step out in timeless elegance with this well-tailored dark Agbada. Made from premium fabric with fine embroidery and a flawless fit, it delivers a perfect blend of tradition, class, and modern sophistication — ideal for weddings, cultural events, and special occasions.',
                'price' => 32000.78,
                'stock' => 40,
                'product_category' => 'Agbada',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
