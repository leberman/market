<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoordinateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seller_coordinates')->insert([
            'seller_id' => 1,
            "latitude" => "37.219512",
            'longitude' => '48.374369',
            'address' => "Tehran",
        ]);
    }
}
