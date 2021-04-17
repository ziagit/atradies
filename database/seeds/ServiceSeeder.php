<?php

use App\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::truncate();
        $options = [
            [
                'name' => 'Cleanning',
                'icon' => '1618318023',
                'type_id'=>1
            ],
            [
                'name' => 'Painting',
                'icon' => '1618318023',
                'type_id'=>1
            ]
     
        ];
        Service::insert($options);
    }
}
