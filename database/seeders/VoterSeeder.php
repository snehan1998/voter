<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_IN');
        $locations = [
            'Tamil Nadu' => [
                'Chennai' => ['Tondiarpet', 'Aminjikarai', 'Mylapore'],
                'Coimbatore' => ['Pollachi', 'Mettupalayam', 'Annur'],
            ],
            'Kerala' => [
                'Ernakulam' => ['Aluva', 'Kochi', 'Kothamangalam'],
                'Thiruvananthapuram' => ['Neyyattinkara', 'Kattakada', 'Varkala'],
            ],
            'Karnataka' => [
                'Bangalore' => ['Yelahanka', 'Anekal', 'KR Puram'],
                'Mysore' => ['Nanjangud', 'Hunsur', 'T Narasipur'],
            ],
            'Maharashtra' => [
                'Mumbai' => ['Andheri', 'Bandra', 'Dadar'],
                'Pune' => ['Hinjewadi', 'Shivaji Nagar', 'Kothrud'],
            ],
            'Uttar Pradesh' => [
                'Lucknow' => ['Alambagh', 'Chowk', 'Aminabad'],
                'Kanpur' => ['Kidwai Nagar', 'Swaroop Nagar', 'Arya Nagar'],
            ],
            'West Bengal' => [
                'Kolkata' => ['Salt Lake', 'Dum Dum', 'Howrah'],
                'Durgapur' => ['Bidhannagar', 'Benachity', 'City Centre'],
            ],
            'Gujarat' => [
                'Ahmedabad' => ['Navrangpura', 'Bopal', 'Gota'],
                'Surat' => ['Varachha', 'Adajan', 'Athwalines'],
            ]
        ];

        for ($i = 0; $i < 20; $i++) {
            $state = array_rand($locations);
            $district = array_rand($locations[$state]);
            $taluk = $locations[$state][$district][array_rand($locations[$state][$district])];

            Voter::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'dob' => $faker->date('Y-m-d', '2002-12-31'),
                'mobile' => $faker->unique()->numerify('##########'),
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->streetAddress . ', ' . $taluk . ', ' . $district . ', ' . $state,
                'taluk' => $taluk,
                'district' => $district,
                'state' => $state,
                'registration_id' => $faker->uuid
            ]);
        }

    }
}
