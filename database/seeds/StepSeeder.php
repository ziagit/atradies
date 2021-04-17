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
                'title' => 'Where is the job?',
                'service_id' => 1,
                'route'=>'location'
            ],
            [
                'title' => 'When the job should be started?',
                'service_d' => 1,
                'route'=>'time'
            ],
            [
                'title' => 'Budget for cleaning',
                'service_d' => 1,
                'route'=>'budget'
            ],
            [
                'title' => 'Budget for service 2',
                'service_d' => 2,
                'route'=>'budget'
            ]
        ];
        Step::insert($options);
    }
}
