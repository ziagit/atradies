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
                'icon' => '',
                'description' => 'This job is for cleanning the like home,shop and another',
                'type_id'=>1
            ],
            [
                'name' => 'Painting',
                'icon' => '',
                'description' => 'This job is for cleanning the like home,shop and another',
                'type_id'=>1
            ]
     
        ];
        Service::insert($options);
    }
}
