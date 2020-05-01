<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // disable mysql foreign check
        $this->call(DiscountsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // enable mysql foreign check
    }
}
