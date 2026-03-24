<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create our primary employee (The Barber/Provider)
        $employee = User::create([
            'name' => 'John The Barber',
            'email' => 'john@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // Create dummy user

        User::create([
            'name' => 'Jane Doe',
            'email' => 'test@test.com',
            'password' => Hash::make('password')
        ]);
        // 2. Create the Services Menu
        $services = [
            ['name' => 'Signature Haircut', 'duration' => 30, 'price' => 35.00],
            ['name' => 'Beard Trim & Shape', 'duration' => 15, 'price' => 15.00],
            ['name' => 'Haircut & Beard Combo', 'duration' => 45, 'price' => 45.00],
            ['name' => 'Luxury Hot Towel Shave', 'duration' => 30, 'price' => 40.00],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // 3. Set the Employee's Schedule (Monday to Friday, 9 AM to 5 PM)
        // Note: 0 is Sunday, 1 is Monday... 6 is Saturday
        for ($day = 1; $day <= 5; $day++) {
            Schedule::create([
                'user_id' => $employee->id,
                'day_of_week' => $day,
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
            ]);
        }
    }
}
