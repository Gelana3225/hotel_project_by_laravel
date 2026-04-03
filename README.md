# Hotel Management System – Laravel 9

Hotel Management System is a Laravel 9–based web application that provides a modern public website for guests and a secure back‑office dashboard for hotel staff. It streamlines the management of rooms, reservations, image galleries, and customer communication in a single, cohesive platform.

**This project is ready for deployment.** Point it at your production server: set `APP_ENV=production`, `APP_DEBUG=false`, configure database and mail in `.env`, run `php artisan migrate`, `npm run build`, and ensure web root points to `public/` (standard Laravel deployment).

<!--
Clarity note: This section should quickly explain what the project is and who it is for.
-->

## Overview

<!--
Clarity note: High‑level summary of the main user groups and typical usage scenarios.
-->
- **Public site (guests)**: Discover rooms, explore the hotel gallery, view detailed room information, check availability by date, and submit booking or contact requests.
- **Admin dashboard (staff)**: Maintain the room catalog, review and manage bookings, curate gallery images, and respond to guest messages directly via email.

This project is suitable as a **production-ready starter**, **portfolio piece**, or **learning resource** for Laravel and hotel/booking workflows.

---

## Core Features

<!--
Clarity note: Detailed breakdown of what the system can do for guests and administrators.
-->

### Guest-Facing Website

<!--
Clarity note: Pages and flows that are available publicly to hotel guests.
-->
- **Home page** (`/`)
  - Highlights selected rooms and gallery items.
  - Uses live data from the `rooms` and `galeries` tables.
- **Rooms listing** (`/our_rooms`)
  - Displays all available rooms with title, type, price, and Wi‑Fi availability.
- **Room details & booking** (`/room_details/{id}`)
  - Dedicated detail page for each room.
  - Booking form that captures guest details and stay dates.
  - Date‑range conflict checking to prevent double‑booking of the same room.
- **Gallery** (`/hotel_gallary`)
  - Visual overview of the hotel via administratively managed images.
- **Contact page** (`/hotel_contact` + POST `/contact`)
  - Contact form for general inquiries.
  - Stores messages in the `contacts` table and returns a success notification to the guest.

### Admin Dashboard

<!--
Clarity note: Management capabilities available only to authenticated admin users.
-->
- **Rooms management**
  - Create, update, and delete rooms, including:
    - Title, description, price, Wi‑Fi flag, room type.
    - Image upload with files stored in `public/room`.
  - View a tabular list of all rooms.
- **Bookings management**
  - View all bookings with guest details and date ranges.
  - Approve or reject bookings to control room allocation.
  - Delete bookings when necessary (e.g., test data or cancellations).
- **Gallery management**
  - Upload and remove images displayed on guest‑facing pages.
  - Files stored in `public/gallery`.
- **Contact messages & email replies**
  - View all messages submitted from the contact form.
  - Use a dedicated form to send email responses per contact record.
  - Leverages Laravel’s notification system (`SendEmailNotification`) for outbound email.

### Technology Stack

<!--
Clarity note: Key technologies and libraries used to build and run the application.
-->
- **Backend**
  - PHP **^8.0.2**
  - Laravel **^9.19**
  - Laravel Jetstream, Fortify, and Sanctum for authentication and security.
  - Livewire for reactive components where needed.
- **Frontend**
  - Blade templates for layouts and pages.
  - Tailwind CSS and Alpine.js for styling and lightweight interactivity.
  - Vite for asset bundling and hot reloading during development.
- **Database**
  - MySQL/MariaDB (or any Laravel‑supported database).
  - Core tables: `users`, `rooms`, `bookings`, `galeries`, `contacts`, plus Jetstream/Fortify support tables.
- **Authentication & Authorization**
  - Standard registration, login, password reset, and optional 2FA.
  - User roles via `usertype` field:
    - `user` – regular guest account.
    - `admin` – back‑office / dashboard access.

---

## Getting Started

<!--
Clarity note: How to set up the project locally for development or evaluation.
-->

### Prerequisites

<!--
Clarity note: Software and tools you must have installed before you can run the project.
-->
- PHP **>= 8.0.2**
- Composer
- MySQL or MariaDB
- Node.js (LTS) and npm (for frontend assets)

### Installation

<!--
Clarity note: Step‑by‑step commands to install dependencies, configure the environment, and start the server.
-->
```bash
git clone <REPOSITORY_URL> hotel_project_by_laravel
cd hotel_project_by_laravel

composer install

cp .env.example .env   # On Windows PowerShell: copy .env.example .env
php artisan key:generate

# Configure your database connection in .env:
# DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan migrate

npm install
npm run dev            # or: npm run build for production assets

php artisan serve
```

Then open `http://127.0.0.1:8000` in your browser.

### Creating an Admin User

<!--
Clarity note: How to promote a regular account to an admin so you can access the dashboard.
-->
1. Visit `/register` and create a user account.
2. In your database, update that user’s `usertype` field to `admin`.
3. Log in:
   - `admin` accounts are redirected to the admin dashboard.
   - `user` accounts are redirected to the public website.

---

## Project Structure (Key Components)

<!--
Clarity note: Orient yourself in the codebase and see where the main responsibilities live.
-->
- **Routes**
  - `routes/web.php` – public pages, booking actions, contact form, and admin endpoints.
- **Controllers**
  - `AdminController` – admin dashboard, rooms CRUD, bookings, gallery management, messages, and outbound email.
  - `HomeController` – guest‑facing workflows (room details, booking, contact form, public pages).
- **Models**
  - `Room`, `Booking`, `Galery`, `Contact`, `User` – encapsulate the domain for rooms, reservations, gallery images, contact messages, and users.
- **Views**
  - `resources/views/home/*` – guest‑facing pages and partials.
  - `resources/views/admin/*` – admin layout and management screens.
  - `resources/views/auth/*` – Jetstream/Fortify authentication views.

---

## License

<!--
Clarity note: Legal terms under which you are allowed to use and modify this project.
-->

This project is open‑source software licensed under the **MIT license** (see `composer.json` for details).
