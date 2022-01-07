<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =[
            [
                'name' => 'Tomat',
                'price' => 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kentang',
                'price' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cabai',
                'price' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('products')->insert($data);
    }
}
