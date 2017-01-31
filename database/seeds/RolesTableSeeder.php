<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'id' => 1,
            'role' => 'admin'
        ], [
            'id' => 2,
            'role' => 'buyer'
        ], [
            'id' => 3,
            'role' => 'seller'
        ],];
        Role::insert($data);
    }
}
