<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'takeda_admin',
            'password' => bcrypt('xEEEivS92fUN'),
            'created_at' => Carbon::now(),
        ]);
    }
}
