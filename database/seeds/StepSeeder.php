<?php

use App\Step;
use Illuminate\Database\Seeder;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Step::truncate();
        $options = [
            [
                'title' => 'Budget',
                'service_id' => 1,
             
            ],
            [
                'title' => 'Time',
                'service_d' => 1,
             
            ],
            [
                'title' => 'location',
                'service_d' => 1,
             
            ]
     
        ];
        Step::insert($options);
    }
}
