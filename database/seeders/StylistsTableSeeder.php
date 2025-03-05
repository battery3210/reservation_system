<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stylist;

class StylistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Stylist::create(['name' => 'HANAKO']);
        Stylist::create(['name' => 'JOHN']);
        Stylist::create(['name' => '島田美恵子']);
    }
}
