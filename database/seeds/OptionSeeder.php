<?php

use App\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::truncate();
        $options = [
            [
                'title' => 'Emergency',
                'step_id' => 2,
                'service_id'   => 1,
             
            ],
            [
                'title' => 'ASAP',
                'step_id' => 2,
                'service_id'   => 1,
             
            ],
            [
                'title' => 'Emergency',
                'step_id' => 3,
                'service_id'   => 1,
             
            ],
            [
                'title' => 'ASAP',
                'step_id' => 3,
                'service_id'   => 1,
             
            ],
            [
                'title' => 'Emergency',
                'step_id' => 6,
                'service_id'   => 2,
             
            ],
            [
                'title' => 'ASAP',
                'step_id' => 6,
                'service_id'   => 2,
             
            ],
            [
                'title' => 'Emergency',
                'step_id' => 7,
                'service_id'   => 2,
             
            ],
            [
                'title' => 'ASAP',
                'step_id' => 7,
                'service_id'   => 2,
             
            ]

     
        ];
        Option::insert($options);
    
    }
}
