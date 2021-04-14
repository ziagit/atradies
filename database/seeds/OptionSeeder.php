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
                'step_id' => 1,
             
            ],
            [
                'title' => 'ASAP',
                'step_id' => 1,
             
            ]
     
        ];
        Option::insert($options);
    
    }
}
