## Hotel Management System (Laravel 9)

Laravel-based hotel management application with a public booking website and an admin dashboard to manage rooms, reservations, gallery images, and customer messages.

### Key Goals

- **For guests**: Browse hotel rooms, view details and photos, check availability by date, and request bookings or send inquiries.
- **For admins**: Manage rooms, confirm or reject bookings, maintain a gallery, and respond to customer messages via email from a central dashboard.

---

## Features

### Guest-Facing Website

- **Home page** (`/`):
  - Displays featured **rooms** and **gallery** images.
  - Uses data from the `rooms` and `galeries` tables.
- **Room listing** (`/our_rooms`):
  - Shows all available rooms with title, type, price, and Wi-Fi availability.
- **Room details & booking** (`/room_details/{id}`):
  - Detailed view for a single room.
  - **Booking form** with:
    - Guest name, email, phone.
    - Check-in (`startDate`) and check-out (`endDate`) dates.
    - Validation that `endDate` is after `startDate`.
    - **Availability check** that prevents double-booking a room if existing bookings overlap the requested date range.
- **Gallery** (`/hotel_gallary`):
  - Displays hotel gallery images managed from the admin panel.
- **Contact page** (`/hotel_contact` + `/contact` POST):
  - Contact form for guests to send inquiries.
  - Stores messages in the database and shows a success flash message.

### Admin Dashboard

Authenticated admins are routed to the **admin dashboard** (`/home`) where they can:

- **Rooms management**
  - `GET /create_room` – form to create a new room.
  - `POST /add_room` – create a room with:
    - `room_title`, `description`, `room_price`, `wifi`, `room_type`.
    - Image upload (stored in the `public/room` directory).
  - `GET /view_room` – list all rooms.
  - `GET /room_update/{id}` – edit a room.
  - `POST /edit_room/{id}` – update room details and image.
  - `GET /room_delete/{id}` – delete a room.

- **Bookings management**
  - `GET /bookings` – list all bookings (**protected by** `auth` + `admin` middleware).
  - `GET /approve_book/{id}` – mark booking as **approved**.
  - `GET /reject_book/{id}` – mark booking as **rejected**.
  - `GET /delete_booking/{id}` – delete a booking.

- **Gallery management**
  - `GET /view_gallery` – view all gallery images.
  - `POST /upload_gallery` – upload new images (stored in `public/gallery`).
  - `GET /delete_gallery/{id}` – remove an image.

- **Contact messages & email replies**
  - `GET /all_messages` – list all messages submitted from the contact form.
  - `GET /send_mail/{id}` – open a form to send a reply email to a specific contact.
  - `POST /mail/{id}` – send an email using Laravel's notification system (`SendEmailNotification`).

### Authentication, Authorization & Security

- **Authentication & sessions** powered by **Laravel Jetstream**, **Fortify**, and **Sanctum**:
  - Registration, login, password reset, email verification, and optional two-factor authentication are available out of the box.
- **User roles**
  - Users are distinguished via the `usertype` field on the `users` table:
    - `user` – regular guest user (redirected to the public website with rooms and gallery).
    - `admin` – admin user (redirected to the admin dashboard).
- **Middleware protection**
  - Bookings listing (`/bookings`) is protected with `auth` and `admin` middleware (see `AdminController@index` and route definitions).

---

## Tech Stack

- **Backend**
  - PHP **^8.0.2**
  - Laravel **^9.19**
  - Laravel Jetstream **^3.0**
  - Laravel Sanctum **^3.0**
  - Livewire **^2.11**
- **Frontend**
  - Blade templates (guest and admin layouts).
  - Tailwind CSS 3 (Jetstream stack) + custom styles.
  - Alpine.js 3 for lightweight interactivity.
  - Vite 4 for asset bundling.
- **Database**
  - MySQL/MariaDB (or any database supported by Laravel).
  - Key tables: `users`, `rooms`, `bookings`, `galeries`, `contacts`, `notifications`, and standard Laravel support tables.

---

## Domain Model Overview

- **Room** (`App\Models\Room`)
  - Fields: `room_title`, `image`, `description`, `room_price`, `wifi`, `room_type`.
  - Managed through admin routes (`/create_room`, `/add_room`, `/view_room`, `/room_update/{id}`, `/edit_room/{id}`, `/room_delete/{id}`).

- **Booking** (`App\Models\Booking`)
  - Fields: `room_id`, `name`, `email`, `phone`, `start_date`, `end_date`, plus a `status` field (via `add_status_field_to_bookings` migration).
  - Relationships:
    - `Booking::room()` – each booking is linked to a `Room`.
  - Availability logic:
    - When a booking is created, the system checks if there is any existing booking for the same `room_id` where
      \(`start_date` <= requested `endDate` AND `end_date` >= requested `startDate`\).
    - If such a booking exists, the system rejects the request with a flash message: *"Room is already booked please try different date"*.

- **Galery** (`App\Models\Galery`)
  - Simple model storing gallery images.
  - Managed via admin to maintain hotel gallery displayed on both home and gallery pages.

- **Contact** (`App\Models\Contact`)
  - Stores contact form submissions (guest name, email, phone, message).
  - Marked as `Notifiable` so admins can send email responses using notification classes.

- **User** (`App\Models\User`)
  - Uses Jetstream/Fortify traits: profile photos, two-factor auth, API tokens, etc.
  - Additional fields: `phone`, `usertype` (`user` or `admin`).

---

## Project Structure (Relevant Parts)

- **Routes**
  - `routes/web.php` – All web routes for:
    - Home, rooms, bookings, gallery, contact form.
    - Admin dashboard routes.

- **Controllers**
  - `app/Http/Controllers/AdminController.php`
    - Handles admin dashboard, rooms CRUD, bookings management, gallery management, contact messages, and sending email notifications.
  - `app/Http/Controllers/HomeController.php`
    - Handles guest-facing flows: room details, booking requests, contact form submissions, and public pages for rooms and gallery.

- **Models**
  - `app/Models/Room.php`, `Booking.php`, `Galery.php`, `Contact.php`, `User.php`.

- **Views**
  - `resources/views/home/*` – Public website (home, rooms, room details, gallery, contact, blog, etc.).
  - `resources/views/admin/*` – Admin dashboard (layout, rooms management, gallery, bookings, messages, send_mail form).
  - `resources/views/auth/*` – Login, register, password reset, 2FA, etc. from Jetstream.

- **Database Migrations**
  - `database/migrations/2014_10_12_000000_create_users_table.php`
  - `database/migrations/2025_12_02_120533_create_rooms_table.php`
  - `database/migrations/2025_12_06_131546_create_bookings_table.php`
  - `database/migrations/2025_12_08_103807_add_status_field_to_bookings.php`
  - `database/migrations/2025_12_10_050353_create_galeries_table.php`
  - `database/migrations/2025_12_10_105754_create_contacts_table.php`
  - Plus standard Laravel tables (password resets, personal access tokens, sessions, failed jobs, notifications).

---

## Getting Started

### Prerequisites

- PHP **>= 8.0.2**
- Composer
- MySQL or MariaDB
- Node.js (LTS) and npm (for compiling frontend assets via Vite)

### Installation

1. **Clone or download the project**

   ```bash
   git clone <this-repo-url> hotel_project_by_laravel-main
   cd hotel_project_by_laravel-main
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Copy environment file and generate app key**

   ```bash
   cp .env.example .env    # On Windows (PowerShell):
   # copy .env.example .env
   php artisan key:generate
   ```

4. **Configure database**

   - Open `.env` and set:
     - `DB_DATABASE`
     - `DB_USERNAME`
     - `DB_PASSWORD`

5. **Run migrations**

   ```bash
   php artisan migrate
   ```

6. **Install frontend dependencies & build assets (optional but recommended)**

   ```bash
   npm install
   npm run dev    # For development
   # or
   npm run build  # For production build
   ```

7. **Run the development server**

   ```bash
   php artisan serve
   ```

   The application will be available at `http://127.0.0.1:8000`.

### Creating an Admin User

1. Visit the registration page (usually `/register`) and create a user account.
2. In your database (e.g. via phpMyAdmin or a database client), update that user's `usertype` field to:

   - `admin` – to grant admin access.
   - `user` – for a normal guest account.

3. After logging in:
   - Users with `usertype = 'admin'` are redirected to the **admin dashboard**.
   - Users with `usertype = 'user'` are redirected to the **public website**.

---

## Usage Guide

### As a Guest

- Visit the home page `/` to see featured rooms and gallery images.
- Navigate to `/our_rooms` to browse all rooms.
- Click on a room to view `/room_details/{id}` and see:
  - Full description.
  - Price.
  - Room type and Wi-Fi availability.
- Use the booking form on the room details page:
  - Choose check-in and check-out dates.
  - Submit your info; if the room is already booked for that period, you will see a message asking you to choose different dates.
- Visit the gallery `/hotel_gallary` to see hotel photos.
- Use the contact page `/hotel_contact` to send messages to the hotel.

### As an Admin

- Log in with an account whose `usertype` is set to `admin`.
- From the dashboard you can:
  - **Manage rooms** – create, edit, and delete rooms, including uploading room images.
  - **Manage bookings** – view all bookings, approve/reject them, or delete if needed.
  - **Manage gallery** – upload and delete images displayed on the public website.
  - **View messages** – read all contact form submissions.
  - **Send emails** – respond to specific contacts via an email form, powered by Laravel notifications.

---

## Running Tests

This project includes the standard Laravel and Jetstream test setup.

Run all tests with:

```bash
php artisan test
```

or:

```bash
vendor/bin/phpunit
```

---

## Extending the Project

Here are some ideas for extending this hotel management system:

- **Payments integration** – connect to Stripe, PayPal, or another gateway to take online payments for bookings.
- **Room availability calendar** – add a visual calendar per room to show booked and available dates.
- **Advanced pricing** – support seasonal pricing, discounts, and promo codes.
- **Multi-language support** – use Laravel's localization features to support multiple languages.
- **Reporting** – add admin reports for occupancy rate, revenue, and booking statistics.

---

## License

This project is open-sourced software licensed under the **MIT license** (as defined in `composer.json`).
