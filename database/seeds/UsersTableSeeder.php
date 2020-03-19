<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "محمدرضا",
            'family' => "شهبازی",
            'verify' => 1,
            'email' => 'leberman12@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        factory(\App\User::class, 10)->create()->make();

        Artisan::call('passport:client --name=leberman --no-interaction --personal');
    }
}
