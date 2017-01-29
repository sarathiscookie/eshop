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
        User::insert([
            'name' => 'admin',
            'lastname' => 'eshop',
            'email' => 'admin@gmail.com',
            'alias' => str_slug('admin eshop '.$current = Carbon::now()),
            'created_at' => $current = Carbon::now(),
            'password' => bcrypt('12345'),
        ]);
    }
}
