<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        Eloquent::unguard();

        DB::table('users')->delete();

        $faker = Faker::create();

        $bikeTrips = fopen('/var/www/dockit/HackBikeShareTO-Trips.csv', 'r');
        if ($bikeTrips !== false) {
            $firstRow = true;
            while (!feof($bikeTrips)) {
                $bikeTrip = fgetcsv($bikeTrips, 1000, ",");

                if ($firstRow) {
                    $firstRow = false;
                    continue;
                }

                if (count($bikeTrip) == 11 && !empty($bikeTrip[10]) && User::where('zipCode', $bikeTrip[10])->count() == 0) {
                    do {
                        $gender = $faker->randomElement(array('male', 'female'));
                        $firstName = $faker->firstName($gender);
                        $lastName = $faker->lastName;
                    } while (User::where('firstName', $firstName)->where('lastName', $lastName)->count() > 0);

                    User::create([
                        'username' => strtolower($firstName . '.' . $lastName),
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'zipCode' => $bikeTrip[10],
                        'gender' => $gender[0],
                        'weight' => ($gender[0] == 'm') ? $faker->numberBetween(140, 190) : $faker->numberBetween(100, 160),
                        'membershipType' => $bikeTrip[9] == 'Registered' ? 'Registered' : 'Casual',
                        'image' => '',
                        'dockIt' => true
                    ]);
                }
            }
        }
        fclose($bikeTrips);
    }

}