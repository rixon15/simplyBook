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

        // Employee 1: John (Active)
        $employee1 = User::create([
            'name' => 'John The Barber',
            'email' => 'john@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'title' => 'Master Barber',
            'status' => 'active',
            'working_days' => 'Mon - Fri',
            'working_hours' => '09:00 - 17:00'
        ]);

        // Employee 2: Marcus (Active)
        $employee2 = User::create([
            'name' => 'Marcus L.',
            'email' => 'marcus@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'title' => 'Senior Stylist',
            'status' => 'active',
            'working_days' => 'Mon - Fri',
            'working_hours' => '09:00 - 17:00'
        ]);

        // Employee 3: Novius (On Leave)
        $employee3 = User::create([
            'name' => 'Novius L.',
            'email' => 'novius@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'title' => 'Junior Barber',
            'status' => 'leave',
            'working_days' => 'Tue - Sat',
            'working_hours' => '10:00 - 18:00'
        ]);

        // Employee 4: Peter (Off Duty)
        $employee4 = User::create([
            'name' => 'Peter L.',
            'email' => 'peters@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'title' => 'Color Specialist',
            'status' => 'off',
            'working_days' => 'Wed - Sun',
            'working_hours' => '08:00 - 16:00'
        ]);

        // Employee 5: Simon (Active)
        $employee5 = User::create([
            'name' => 'Simon L.',
            'email' => 'simon@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'title' => 'Stylist',
            'status' => 'active',
            'working_days' => 'Mon - Fri',
            'working_hours' => '09:00 - 17:00'
        ]);

        // CREATE ONE SOFT-DELETED EMPLOYEE (For testing your archived logic)
        User::create([
            'name' => 'Old Staff Member',
            'email' => 'old@simplybook.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'title' => 'Retired Barber',
            'deleted_at' => now(), // This makes them "Soft Deleted"
        ]);

        // Create 20 random customers
        $customers = User::factory(20)->create(['role' => 'customer']);

        $testCustomer = User::create([
            'name' => 'Jane Doe',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer'
        ]);

        // --- 2. SERVICES (Adding descriptions to match your new UI) ---

        $services = [
            ['name' => 'Signature Haircut', 'description' => 'Precision cut with styling.', 'duration' => 30, 'price' => 35.00],
            ['name' => 'Beard Trim & Shape', 'description' => 'Professional sculpting and hot towel.', 'duration' => 15, 'price' => 15.00],
            ['name' => 'Haircut & Beard Combo', 'description' => 'The full works.', 'duration' => 45, 'price' => 45.00],
            ['name' => 'Luxury Hot Towel Shave', 'description' => 'Traditional straight razor shave.', 'duration' => 30, 'price' => 40.00],
            ['name' => 'Coloring', 'description' => 'Full head permanent color.', 'duration' => 60, 'price' => 75.00],
        ];

        $serviceModels = collect();
        foreach ($services as $s) {
            $serviceModels->push(Service::create($s));
        }

        // --- 3. SCHEDULES (Keeping your existing logic) ---

        $employees = [$employee1, $employee2, $employee3, $employee4, $employee5];
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

        // --- 4. APPOINTMENTS ---

        // Past Appointments
        for ($i = 1; $i <= 20; $i++) {
            $start = Carbon::yesterday()->setHour(rand(9, 15))->setMinute(0);
            $service = $serviceModels->random();

            Appointment::create([
                'user_id' => $customers->random()->id,
                'service_id' => $service->id,
                'employee_id' => collect($employees)->random()->id,
                'start_time' => $start,
                'end_time' => (clone $start)->addMinutes($service->duration),
                'status' => 'completed'
            ]);
        }

        // Today's Appointments
        $todayTimes = ['09:00', '10:30', '13:00', '14:30', '16:00'];
        foreach ($todayTimes as $index => $time) {
            $start = Carbon::today()->setTimeFromTimeString($time);
            $service = $serviceModels->random();

            Appointment::create([
                'user_id' => $customers->random()->id,
                'service_id' => $service->id,
                'employee_id' => collect($employees)->random()->id,
                'start_time' => $start,
                'end_time' => (clone $start)->addMinutes($service->duration),
                'status' => ($index == 1) ? 'pending' : 'confirmed'
            ]);
        }

        // Notifications
        foreach ($customers->take(3) as $customer) {
            $admin->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\AppNotification',
                'data' => [
                    'type' => 'booking',
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
