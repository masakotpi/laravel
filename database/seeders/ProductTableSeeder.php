<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = 
        [
            [
                'name' => "typeC-USBケーブル1.5m",
                'code' => 'usb1.5',
                'maker_id' => '1',
                'color' => 'ブラック',
                'size' => 1.5,
                'per_case' => 120,
                'purchase_price' => 1.20,
                'selling_price' => 1280,
            ],
       
            [
                'name' => "typeC-USBケーブル3.0m",
                'code' => 'usb3.0',
                'maker_id' => '1',
                'color' => 'ブラック',
                'size' => 3.0,
                'per_case' => 120,
                'purchase_price' => 1.80,
                'selling_price' => 1980,
            ],
       
          
        ];

        $makers =
        [

            [
                'name'=> 'HongKong Cable Company',
                'country'=> 'HongKong',
                'person_in_charge'=> 'wilson',
                'address'=> 'HongKong',
            ]
        ];

    
        DB::table('products')->insert($products);
        DB::table('makers')->insert($makers);
    }
}
