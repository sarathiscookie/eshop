<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'lastname' => 'Eshop',
                'email' => 'admin@gmail.com',
                'alias' => str_slug('admin eshop '.$current = Carbon::now()),
                'created_at' => $current = Carbon::now(),
                'password' => bcrypt('123456'),
            ], [
                'name' => 'Jane',
                'lastname' => 'Doe',
                'email' => 'jane@gmail.com',
                'alias' => str_slug('jane doe '.$current = Carbon::now()),
                'created_at' => $current = Carbon::now(),
                'password' => bcrypt('123456'),
            ], [
                'name' => 'Maria',
                'lastname' => 'Declan',
                'email' => 'maria@gmail.com',
                'alias' => str_slug('maria declan '.$current = Carbon::now()),
                'created_at' => $current = Carbon::now(),
                'password' => bcrypt('123456'),
            ]
        ];
        User::insert($data);
    }
}
