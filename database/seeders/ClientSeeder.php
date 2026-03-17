<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('email', 'manager@gmail.com')->first();
        $manager1 = User::where('email', 'manager1@gmail.com')->first();
        $clients = [
            ['name' => 'Tom Cruise', 'email' => 'cruise@gmail.com', 'created_by' => $manager->id],
            ['name' => 'Jack Sparrow', 'email' => 'sparrow@gmail.com', 'created_by' => $manager->id],
            ['name' => 'Black Widow', 'email' => 'widow@gmail.com', 'created_by'=> $manager1->id],
            ['name' => 'Tony Stark', 'email' => 'stark@gmail.com', 'created_by'=> $manager1->id],
            ['name' => 'Will Byers', 'email' => 'byers@gmail.com', 'created_by'=> $manager1->id],
            ];
            foreach ($clients as $client) {
                Client::create($client);
            }
    }
}
