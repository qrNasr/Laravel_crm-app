<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\Interaction;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CrmDataSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
       $faker = Faker::create();

        // Create 100 customers
        for ($i = 0; $i < 100; $i++) {
            $customer = Customer::create([
                'name' => $faker->company,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);

            //Create 1-5 contacts for each customer
            $numberOfContacts = random_int(1,5);
            for ($j = 0; $j < $numberOfContacts; $j++) {
               Contact::create([
                    'customer_id' => $customer->id,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                   'phone' => $faker->phoneNumber,
                    'job_title' => $faker->jobTitle,
               ]);
            }

            //Create 1-3 interactions for each customer
            $numberOfInteractions = random_int(1,3);
            for($k = 0; $k < $numberOfInteractions; $k++) {
               Interaction::create([
                    'customer_id' => $customer->id,
                    'type' => $faker->randomElement(['call','email','meeting']),
                   'notes' => $faker->paragraph,
                    'interaction_date' => $faker->dateTimeThisMonth()
                ]);
             }
        }
    }
}