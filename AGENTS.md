# Developer Guide & Agent Instructions

## Core Setup & Environment
- **PHP Environment Requirement**: System PHP (`/usr/bin/php8.3`) is missing `php-mbstring` and `pdo_sqlite`. Running `php artisan` commands that trigger Termwind or running `phpunit` directly on system CLI fails.
- **Composer Setup**: Setup script in `composer.json`: `composer run setup` (runs `composer install`, copies `.env.example`, generates key, runs migrations, `npm install --ignore-scripts`, and `npm run build`).
- **Database**: Configured for MySQL in `.env` (`DB_CONNECTION=mysql`, `DB_DATABASE=helpdesk-kampus`, `DB_USERNAME=root`). Note: `phpunit.xml` defaults to SQLite `:memory:`, which requires `pdo_sqlite` if executing tests via CLI.

## Key Developer Commands
- **Frontend Build**: `npm run build` (Vite 8 build targeting `public/build`).
- **Vite Dev Server**: `npm run dev` (starts Vite asset server).
- **Format Code**: `vendor/bin/pint` (Laravel Pint PHP code formatter).
- **Run Tests**: `vendor/bin/phpunit` or `php artisan test` (requires PHP `mbstring` & `dom` extensions installed).

## Routing & Role Conventions
- **User Roles**: Extended `users.role` enum (`mahasiswa`, `dosen`, `admin`), with default `mahasiswa`.
- **Role Dashboard Routes**: Single controller entry point `DashboardController@index` renders role-specific Blade views:
  - `GET /dashboard` -> generic dashboard entry
  - `GET /dashboard/mahasiswa` -> `dashboard.mahasiswa`
  - `GET /dashboard/dosen` -> `dashboard.dosen`
  - `GET /dashboard/admin` -> `dashboard.admin`
- **Ticket Specific Routes**:
  - `GET /tickets/create/mahasiswa` -> `tickets.create_mahasiswa` (explicit route before resource)
  - `GET /tickets/create/dosen` -> `tickets.create_dosen` (explicit route before resource)
  - Resource routes: `tickets.index`, `tickets.store`, `tickets.show`, `tickets.update`, `tickets.destroy`.

## Architecture & Storage Notes
- **Ticket Model**: Contains `category` (`academic`, `technical`, `administrative`), `priority` (`low`, `medium`, `high`), and `status` (`pending`, `accepted`, `implemented`, `closed`).
- **File Uploads**: `TicketController@store` saves attachments to `storage/app/public/attachments`. Requires active storage symlink (`public/storage` -> `storage/app/public`).
- **Frontend Setup**: Tailwind CSS v3 with `@tailwindcss/forms` and Alpine.js bound globally on `window.Alpine`.
