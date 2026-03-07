# Hotel Management System (Laravel 9)

<!-- > **If the README doesn't show on GitHub:** Your repo's **default branch** might be `main` while your code is on `master`. In GitHub: **Settings → General → Default branch** → switch to `master` and save. The README at the repo root will then appear on the homepage. -->

---

Laravel-based hotel management application with a public booking website and an admin dashboard to manage rooms, reservations, gallery images, and customer messages.

## Key Goals

- **For guests**: Browse hotel rooms, view details and photos, check availability by date, and request bookings or send inquiries.
- **For admins**: Manage rooms, confirm or reject bookings, maintain a gallery, and respond to customer messages via email from a central dashboard.

---

## Features

### Guest-Facing Website

- **Home page** (`/`): Displays featured **rooms** and **gallery** images.
- **Room listing** (`/our_rooms`): Shows all available rooms with title, type, price, and Wi-Fi availability.
- **Room details & booking** (`/room_details/{id}`): Detailed view and booking form with date-range availability check to prevent double-booking.
- **Gallery** (`/hotel_gallary`): Hotel gallery images.
- **Contact** (`/hotel_contact`): Contact form; messages stored and reply-by-email from admin.

### Admin Dashboard

- **Rooms**: Create, edit, delete rooms; upload room images.
- **Bookings**: List, approve, reject, or delete bookings (protected by `auth` + `admin` middleware).
- **Gallery**: Upload and delete gallery images.
- **Messages**: View contact submissions and send email replies via Laravel notifications.

### Tech Stack

- **Backend**: PHP ^8.0.2, Laravel ^9.19, Jetstream, Sanctum, Livewire.
- **Frontend**: Blade, Tailwind CSS, Alpine.js, Vite.
- **Auth**: Registration, login, 2FA (Jetstream/Fortify). User roles: `user` | `admin` via `usertype` on `users` table.

---

## Getting Started

### Prerequisites

- PHP >= 8.0.2, Composer, MySQL/MariaDB, Node.js (for assets).

### Installation

```bash
git clone <repo-url> hotel_project_by_laravel
cd hotel_project_by_laravel
composer install
cp .env.example .env
php artisan key:generate
# Set DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env
php artisan migrate
npm install && npm run dev
php artisan serve
```

Open `http://127.0.0.1:8000`.

### Create an Admin

1. Register at `/register`.
2. In the database, set that user's `usertype` to `admin`.
3. Log in; admins are redirected to the dashboard, users to the public site.

---

## Project Structure (Key Parts)

- **Routes**: `routes/web.php` — all web routes.
- **Controllers**: `AdminController` (dashboard, rooms, bookings, gallery, messages, mail), `HomeController` (room details, booking, contact, public pages).
- **Models**: `Room`, `Booking`, `Galery`, `Contact`, `User`.
- **Views**: `resources/views/home/*` (public), `resources/views/admin/*` (dashboard), `resources/views/auth/*` (Jetstream).

---

## License

MIT (see `composer.json`).
