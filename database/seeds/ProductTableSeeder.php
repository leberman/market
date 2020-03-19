<?php

use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
//    public function run()
//    {
//        DB::table('products')->insert([
//            'seller_id' => 1,
//            "title" => "محصول شماره یک",
//            "slug" => "product one",
//            'description' => "لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته.",
//            'price' => "25000",
//            'status' => 1,
//        ]);
//
//        DB::table('products')->insert([
//            'seller_id' => 2,
//            "title" => "محصول شماره دو",
//            "slug" => "product two",
//            'description' => "لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته.",
//            'price' => "25000",
//            'status' => 1,
//        ]);
//    }

    public function run()
    {
        factory(Product::class, 10)->create()->make();
    }

}
