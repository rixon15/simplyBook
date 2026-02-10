# Project Overview

"SimplyBook" is a web-based appointment scheduling platform designed for service-based businesses (e.g., Barbers, Dentists, Consultants). It allows customers to browse services, view real-time availability, and book appointments, while providing administrators with a dashboard to manage employees, services, and schedules.
System Architecture (MVC Pattern)

    Model: Represents the database tables (User, Appointment, Service).

    View: The UI. We will use Blade Templates (standard Laravel) and Livewire for dynamic components (like the calendar).

    Controller: Handles incoming HTTP requests (AppointmentController).

    Service Layer: Contains the complex logic (e.g., AvailabilityService calculates free slots). This is the "Java" influence.

# Database Design
Entity Relationship Diagram
Schema Definition

1. users Table

    Purpose: Stores authentication details for both customers and admins.

    Columns:

        id (PK, BigInt)

        name (String)

        email (String, Unique)

        password (String, Hashed)

        role (Enum: 'admin', 'employee', 'customer')

2. services Table

    Purpose: Defines what the business sells.

    Columns:

        id (PK)

        name (String) - e.g., "Haircut"

        duration (Integer) - Minutes (e.g., 30, 60)

        price (Decimal)

3. schedules Table (The Logic Booster)

    Purpose: Defines when an employee works.

    Columns:

        id (PK)

        user_id (FK -> users)

        day_of_week (TinyInt) - 0 (Sunday) to 6 (Saturday)

        start_time (Time) - e.g., '09:00:00'

        end_time (Time) - e.g., '17:00:00'

4. appointments Table (The Transactional Table)

    Purpose: Records the actual booking.

    Columns:

        id (PK)

        user_id (FK -> users) - The Customer

        service_id (FK -> services)

        employee_id (FK -> users) - The Provider

        start_time (DateTime) - e.g., '2023-10-25 14:00:00'

        end_time (DateTime) - Calculated via Service Duration

        status (Enum: 'pending', 'confirmed', 'canceled')

# User Roles & Use Cases

Actor: Customer

    Browse Services: View list of services and prices.

    Check Availability: Select a date and see available time slots.

    Book Appointment: Secure a slot (requires login).

    Manage Bookings: View upcoming appointments or cancel them.

Actor: Admin / Employee

    Manage Services: CRUD (Create, Read, Update, Delete) services.

    Manage Schedule: Set working hours (e.g., "I don't work Mondays").

    View Calendar: A master view of all bookings.

    Cancel/Block: Admin can cancel a user's booking if needed.

# Key Algorithms
Algorithm: Slot Availability Calculation

Problem: A customer wants to book a 30-minute haircut on Tuesday.
Logic:

    Fetch Schedule: Get the employee's working hours for Tuesday (e.g., 09:00 - 17:00).

    Fetch Existing Bookings: Get all confirmed appointments for that employee on that date.

    Generate Slots: Break the day into 30-minute chunks.

    Filter: Remove any chunk that overlaps with an existing booking.

    Return: A JSON array of valid start times (e.g., ['09:00', '09:30', '11:00']).

# Technology Stack

    Backend Framework: Laravel 10/11.

    Database: PostgreSQL / MySQL.

    Admin Panel: Filament PHP.

    Frontend Interactivity: Laravel Livewire.

    Styling: Tailwind CSS.
