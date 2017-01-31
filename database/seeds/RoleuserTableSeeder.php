<?php

use Illuminate\Database\Seeder;
use App\Roleuser;

class RoleuserTableSeeder extends Seeder
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
            ],[
                'user_id' => 2,
                'role_id' => 2,
            ],[
                'user_id' => 3,
                'role_id' => 3,
            ]
        ];

        Roleuser::insert($data);
    }
}
