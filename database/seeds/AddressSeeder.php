<?php

use App\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::truncate();
        $address =  [
            [
                'street' => "Rattles Road",
                'street_number' => "123",
                'zip' => 'A0A4G0',
                'city' => 'Vancouver',
                'state' => 'BC',
                'country' => 'AU',
            ],
            [
                'street' => "PO BOX",
                'street_number' => "1392",
                'zip' => 'B0P1N0',
                'city' => 'Victoria',
                'state' => 'BC',
                'country' => 'AU',
            ]
  
        ];
        Address::insert($address);
    }
}
