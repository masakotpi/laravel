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
        $products = [
            [
                'name' => "typeC-USB cable 1.5m",
                'code' => 'usb1.5',
                'maker_id' => '1',
                'color' => 'ブラック',
                'per_case' => 120,
                'purchase_price' => 1.20,
                'selling_price' => 1280,
            ],
       
            [
                'name' => "typeC-USB cable 3.0m",
                'code' => 'usb3.0',
                'maker_id' => '1',
                'color' => 'ブラック',
                'per_case' => 120,
                'purchase_price' => 1.80,
                'selling_price' => 1980,
            ],
            [
                'name' => "Smart Phone Case Ver1",
                'code' => 'spcase-001',
                'maker_id' => '1',
                'color' => 'ブラック',
                'per_case' => 120,
                'purchase_price' => 1.80,
                'selling_price' => 1980,
            ],
            [
                'name' => "Smart Phone Case Ver2",
                'code' => 'spcase-002',
                'maker_id' => '1',
                'color' => 'ホワイト',
                'per_case' => 120,
                'purchase_price' => 1.80,
                'selling_price' => 1980,
            ],
            [
                'name' => "Smart Phone Case Ver2",
                'code' => 'spcase-003',
                'maker_id' => '1',
                'color' => 'ブラック',
                'per_case' => 120,
                'purchase_price' => 1.80,
                'selling_price' => 1980,
            ],
       
          
        ];

        $makers =[
            [
                'name'=> 'HongKong Cable Company',
                'country'=> 'HongKong',
                'person_in_charge'=> 'Wilson Ho',
                'address'=> 'HongKong',
                'tel' => '852-0000-0000'
            ],
            [
                'name'=> 'China Plastic Assemble Factory',
                'country'=> 'China',
                'person_in_charge'=> 'David Li',
                'address'=> 'Dongguan Shenzhen China',
                'tel' => '86-000-0000-0000'
            ],
            [
                'name'=> 'China Package Factory',
                'country'=> 'China',
                'person_in_charge'=> 'Sunny Fu',
                'address'=> 'Dongguan Shenzhen China',
                'tel' =>  '86-000-1111-1111'
            ],
            [
                'name'=> 'Korea Plastic Design Ltd',
                'country'=> 'Korea',
                'person_in_charge'=> 'Jason Kim',
                'address'=> 'Seoul Korea',
                'tel' => '82-0000-0000'
            ],
            [
                'name'=> 'US Cable Company',
                'country'=> 'US',
                'person_in_charge'=> 'Kevin ',
                'address'=> 'LA US',
                'tel' => '01-00-0000-0000'
            ],
        ];

    
        DB::table('products')->insert($products);
        DB::table('makers')->insert($makers);
    }
}
