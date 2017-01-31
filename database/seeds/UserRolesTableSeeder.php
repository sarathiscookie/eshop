<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Userrole;

class UserRolesTableSeeder extends Seeder
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
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => Carbon::now(),
            ],[
                'user_id' => 2,
                'role_id' => 2,
                'created_at' => Carbon::now(),
            ],[
                'user_id' => 3,
                'role_id' => 3,
                'created_at' => Carbon::now(),
            ]
        ];

        Userrole::insert($data);
    }
}
