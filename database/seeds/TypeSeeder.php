<?php

use App\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::truncate();
        $options = [
            [
                'title' => 'Office Cleaning',
            ],
            [
                'title' => 'House Cleaning',
            ]
     
        ];
        Type::insert($options);
    }
}
