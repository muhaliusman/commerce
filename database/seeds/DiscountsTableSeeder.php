<?php

use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->truncate(); // truncate data, avoid duplicate data

        $discounts = [
            [
                "discount_code" => "BERKAH RAMADHAN",
                "discount_percentage" => 8,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ],
            [
                "discount_code" => "COVID19",
                "discount_percentage" => 10,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('discounts')->insert($discounts);
    }
}
