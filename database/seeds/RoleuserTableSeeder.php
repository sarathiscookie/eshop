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
            ]
        ];

        Roleuser::insert($data);
    }
}
