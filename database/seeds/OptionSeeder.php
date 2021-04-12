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
                'times' => 'Emergency',
                'services' => 'New installation',
                'needs' => 'Benchtop',
                'budgets' => 'Under $500',
                'status' => 'Ready to hire',
                'categories' => 'Plumbers',
                'icon' => 'home',
            ],
            [
                'times' => 'ASAP',
                'services' => 'Repair existing',
                'needs' => 'Flooring',
                'budgets' => '$500 - $2,000',
                'status' => 'Planning $ budgeting',
                'categories' => 'Cleaners',
                'icon' => 'home',
            ],
            [
                'times' => 'Next few days',
                'services' => 'Replace existing',
                'needs' => 'Other',
                'budgets' => '$2,000 - $5,000',
                'status' => '',
                'categories' => 'Builders',
                'icon' => 'home',
            ],
            [
                'times' => 'I am flexible',
                'services' => 'Other',
                'needs' => '',
                'budgets' => 'More than $5,000',
                'status' => '',
                'categories' => 'Painters',
                'icon' => 'home',
            ],
            [
                'times' => 'Next few weeks',
                'services' => '',
                'needs' => '',
                'budgets' => 'Not sure',
                'status' => '',
                'categories' => 'Handyman',
                'icon' => 'home',
            ],
            [
                'times' => '',
                'services' => '',
                'needs' => '',
                'budgets' => '',
                'status' => '',
                'categories' => 'Lighting',
                'icon' => 'home',
            ],
            [
                'times' => '',
                'services' => '',
                'needs' => '',
                'budgets' => '',
                'status' => '',
                'categories' => 'Guardners',
                'icon' => 'home',
            ],
            [
                'times' => '',
                'services' => '',
                'needs' => '',
                'budgets' => '',
                'status' => '',
                'categories' => 'Electricians',
                'icon' => 'home',
            ]
     
        ];
        Option::insert($options);
    
    }
}
