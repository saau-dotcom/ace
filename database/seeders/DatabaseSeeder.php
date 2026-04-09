<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Solar Sales Rep',
            'email' => 'sales@example.com',
            'role' => 'sales',
        ]);

        \App\Models\Lead::create([
            'user_id' => $user->id,
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@example.com',
            'phone' => '0412345678',
            'address' => '123 Solar Way, Sydney NSW 2000',
            'service_type' => 'Solar + Battery',
            'status' => 'New'
        ]);
    }
}
