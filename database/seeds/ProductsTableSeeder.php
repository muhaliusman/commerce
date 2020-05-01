<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate(); // truncate data, avoid duplicate data

        $products = [
            [
                "name" => "Asus Vivobook",
                "image" => 'images/products/asus_vivobook.jpg', // only for technical test, i put image in public folder
                "price" => 929.27,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ],
            [
                "name" => "Lenovo ideapad",
                "image" => 'images/products/lenovo_ideapad.jpg', // only for technical test, i put image in public folder
                "price" => 899.56,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ],
            [
                "name" => "HP",
                "image" => 'images/products/hp.jpg', // only for technical test, i put image in public folder
                "price" => 999.12,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('products')->insert($products);
    }
}
