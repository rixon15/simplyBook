# AGENTS Guide

## Project Snapshot
- Stack: Laravel 13 (PHP 8.3), Livewire 3, Volt, Tailwind + Vite.
- Main domain: appointment booking with roles (`admin`, `employee`, `customer`) in `users.role`.
- Primary app shell is Livewire page components rendered through `config/livewire.php` layout `layouts.app`.

## Architecture Map
- HTTP entry: `bootstrap/app.php` -> `routes/web.php` + `routes/auth.php`.
- Class-based Livewire pages live in `app/Livewire/*` and render Blade files under `resources/views/livewire/pages/**`.
  - Example: `App\Livewire\CustomerBooking` -> `livewire.pages.landing.customer-booking`.
- Volt is still used for auth pages via `Volt::route(...)` in `routes/auth.php` and inline components like `resources/views/livewire/notification-dropdown.blade.php`.
- Providers: `bootstrap/providers.php` registers `AppServiceProvider` and `VoltServiceProvider` (mounts Volt directories).

## Booking Data Flow (Critical)
- `CustomerBooking` loads all `Service` rows and users with role `employee` on mount.
- Availability is computed from `schedules` + existing `appointments`:
  - slots are generated every 30 minutes;
  - overlap check uses `[start < existing_end] && [end > existing_start]`;
  - slot must also end before schedule `end_time`.
- Confirming a booking writes one `appointments` row with status `confirmed` and notifies current user via `AppNotification`.
- Reschedule/cancel logic is in `UserBookings`; both paths send role-aware notifications and then clear Livewire computed caches with `unset(...)`.

## Domain & Persistence Conventions
- Core tables: `services`, `schedules`, `appointments`, `notifications` (+ extended `users`).
- `day_of_week` follows Carbon convention `0=Sunday ... 6=Saturday` (`database/seeders/DatabaseSeeder.php`).
- Appointment status constants are in `app/Models/Appointment.php`; reuse those instead of raw strings.
- Notifications are database-only (`AppNotification::via()` returns `['database']`).

## UI & Interaction Patterns
- Global nav/footer live in `resources/views/layouts/app.blade.php` with role-based footer/navbar behavior.
- UI feedback often uses Livewire browser events: `$this->dispatch('notify', ['message' => ...])`.
- Notification UX has two surfaces:
  - dropdown (`livewire:notification-dropdown`, polled every 10s),
  - full page (`App\Livewire\Pages\Notifications\Notifications`).

## Developer Workflows
- First-time setup uses Composer script `setup` (`composer install`, `.env` copy, key generate, migrate, npm install, Vite build).
- Full local dev loop: `composer dev` (serves app, queue listener, pail logs, Vite concurrently).
- Tests: `composer test` (Laravel test runner, sqlite in-memory configured by `phpunit.xml`).

## Known Codebase Gotchas (Verify Before Refactors)
- `routes/web.php` defines `/profile` twice (a view route in auth+verified group and a Livewire route with same name).
- `resources/views/components/navbar.blade.php` labels "Bookings" but links to `route('dashboard')` while underline condition checks `routeIs('bookings')`.
- `resources/views/components/bottom-navbar.blade.php` uses `route('notifications')` but active checks `routeIs('alerts')`.
- `tests/Feature/ProfileTest.php` still expects Breeze/Volt profile components, while `/profile` is currently wired to `App\Livewire\UserProfile`.

