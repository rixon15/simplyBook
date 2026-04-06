<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. CORE USERS ---

        $admin = User::create([
            'name' => 'Admin Doe',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        $employee1 = User::create([
            'name' => 'John The Barber',
            'email' => 'john@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $employee2 = User::create([
            'name' => 'Marcus L.',
            'email' => 'marcus@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $employee3 = User::create([
            'name' => 'Novius L.',
            'email' => 'novius@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $employee4 = User::create([
            'name' => 'Peter L.',
            'email' => 'peters@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $employee4 = User::create([
            'name' => 'Peter L.',
            'email' => 'peters@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // Create 20 random customers for the database
        $customers = User::factory(20)->create(['role' => 'customer']);

        // Add your specific test customer
        $testCustomer = User::create([
            'name' => 'Jane Doe',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer'
        ]);

        // --- 2. SERVICES ---

        $services = [
            ['name' => 'Signature Haircut', 'duration' => 30, 'price' => 35.00],
            ['name' => 'Beard Trim & Shape', 'duration' => 15, 'price' => 15.00],
            ['name' => 'Haircut & Beard Combo', 'duration' => 45, 'price' => 45.00],
            ['name' => 'Luxury Hot Towel Shave', 'duration' => 30, 'price' => 40.00],
            ['name' => 'Coloring', 'duration' => 60, 'price' => 75.00],
        ];

        $serviceModels = collect();
        foreach ($services as $s) {
            $serviceModels->push(Service::create($s));
        }

        // --- 3. SCHEDULES ---

        $employees = [$employee1, $employee2, $employee3, $employee4];
        foreach ($employees as $emp) {
            for ($day = 1; $day <= 5; $day++) {
                Schedule::create([
                    'user_id' => $emp->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                ]);
            }
        }

        // --- 4. APPOINTMENTS (The Dashboard Meat) ---

        // A. Past Appointments (for KPI Trends)
        for ($i = 1; $i <= 20; $i++) {
            Appointment::create([
                'user_id' => $customers->random()->id,
                'service_id' => $serviceModels->random()->id,
                'employee_id' => collect($employees)->random()->id,
                'start_time' => Carbon::yesterday()->setHour(rand(9, 16)),
                'end_time' => Carbon::yesterday()->setHour(17),
                'status' => 'confirmed'
            ]);
        }

        // B. Today's Appointments (for "Today's Schedule")
        $todayTimes = ['09:00', '10:30', '13:00', '14:30', '16:00'];
        foreach ($todayTimes as $index => $time) {
            $status = ($index == 1) ? 'pending' : 'confirmed'; // Make one pending for variety

            $start = Carbon::today()->setTimeFromTimeString($time);
            $service = $serviceModels->random();

            Appointment::create([
                'user_id' => $customers->random()->id,
                'service_id' => $service->id,
                'employee_id' => collect($employees)->random()->id,
                'start_time' => $start,
                'end_time' => (clone $start)->addMinutes($service->duration),
                'status' => $status
            ]);
        }

        // C. Recent Activity Feed (Create notifications manually if you don't have the logic yet)
        // This assumes you have the 'notifications' table setup
        // Inside DatabaseSeeder.php
        // Inside DatabaseSeeder.php
        foreach ($customers->take(3) as $customer) {
            $admin->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\AppNotification',
                'data' => [
                    'type' => 'booking', // Change 'success' to 'booking'
                    'user' => $customer->name,
                    'action' => 'booked a',
                    'subject' => 'Signature Haircut',
                    'extra' => 'for tomorrow',
                    'title' => 'New Booking',
                    'message' => "{$customer->name} scheduled a haircut.",
                ],
                'created_at' => now()->subMinutes(rand(1, 60))
            ]);
        }
    }
}
