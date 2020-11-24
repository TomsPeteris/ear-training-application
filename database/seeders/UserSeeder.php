<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'username' => 'super.admin',
            'full_name' => 'Super Admin',
            'email' => 'suadmin@test.lv',
            'password' => Hash::make('password'),
            'role' => User::SUPER_ADMIN_ROLE,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
