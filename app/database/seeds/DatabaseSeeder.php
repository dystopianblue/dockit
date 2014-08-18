<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('UsersTableSeeder');
        $this->command->info('Legs table seeded successfully.');

        $this->call('StationsTableSeeder');
        $this->command->info('Stations table seeded successfully.');

        $this->call('LegsTableSeeder');
        $this->command->info('Legs table seeded successfully.');
        $this->command->info('Steps table seeded successfully.');

        $this->call('TripsTableSeeder');
        $this->command->info('Trips table seeded successfully.');

        $this->call('BadgesTableSeeder');
        $this->command->info('Badges table seeded successfully.');
    }

}
