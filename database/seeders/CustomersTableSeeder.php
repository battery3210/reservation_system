<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Customer::create(['name' => '山田太郎','email' => 'test1@test.com']);
        Customer::create(['name' => '桜台裕一','email' => 'test123@rrr.com']);
        Customer::create(['name' => '練馬幸太郎','email' => 'game123@user.com']);
        Customer::create(['name' => '中野一太郎','email' => 'okok@esp.net']);
        Customer::create(['name' => '高円寺恵子','email' => 'aaaokoe@ukdk.jp']);
        
    }
}
