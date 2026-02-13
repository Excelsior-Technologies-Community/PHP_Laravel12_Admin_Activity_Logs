# PHP_Laravel12_Admin_Activity_Logs
## Project Overview

This project is a complete **Admin Activity Logs System** built using Laravel 12.
It allows administrators to monitor all important actions performed inside the application such as create, update, delete, login, and logout.

The system records user activity, model changes, IP address, user agent, and timestamps, then displays them in a professional admin dashboard with filtering and export features.

This project is ideal for learning **Audit Logs, Middleware, Traits, Admin Panels, and Security Tracking** in Laravel.

---

## Features

* Admin authentication using Laravel Breeze
* Role‑based access control (Admin / User)
* Automatic activity logging via Trait
* Admin middleware protection
* Advanced log filtering
* CSV export functionality
* Clear logs with confirmation
* Activity charts (last 7 days)
* IP address and user agent tracking
* Pagination support
* Responsive Bootstrap 5 UI
* User CRUD management
* Old vs New value comparison

---

## Technology Stack

* PHP 8+
* Laravel 12
* MySQL
* Bootstrap 5
* Chart.js
* JavaScript
* Blade Templates

---

## Project Structure

```
admin-activity-logs/
├── app/
│   ├── Http/
│   │   ├── Controllers/Admin/
│   │   └── Middleware/
│   ├── Models/
│   └── Traits/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/
│   └── admin/
└── routes/web.php
```

---

## Installation Steps

### Step 1: Create Project

```
composer create-project laravel/laravel admin-activity-logs
cd admin-activity-logs
```

### Step 2: Database Setup

Update `.env`

```
DB_DATABASE=admin_activity_logs
DB_USERNAME=root
DB_PASSWORD=
```

Create database manually in MySQL or phpMyAdmin.

### Step 3: Install Breeze Authentication

```
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
```

### Step 4: Create Activity Logs Migration

```
php artisan make:migration create_activity_logs_table
```

Add fields:

* user_id
* action
* model
* model_id
* description
* ip_address
* user_agent
* old_values
* new_values
* url
* method
* timestamps

### Step 5: Add Admin Column to Users

```
php artisan make:migration add_is_admin_to_users_table
```

Field:

```
boolean is_admin default false
```

### Step 6: Run Migrations

```
php artisan migrate
```

---

## Core Components

### Models

* **User** – handles admin role and relations
* **ActivityLog** – stores all logs

### Trait

* **LogsActivity** – automatically records model changes

### Middleware

* **AdminMiddleware** – restricts admin routes
* **LogAdminActivity** – logs admin HTTP actions

### Controllers

* AdminController – dashboard and statistics
* ActivityLogController – filtering, viewing, export, clear
* UserController – CRUD with logging

---

## Routes

```
/admin/dashboard
/admin/activity-logs
/admin/users
```

Protected with:

```
auth + admin + log.admin middleware
```

---

## Admin Seeder

Create default admin user.

```
php artisan db:seed --class=AdminUserSeeder
```

Default Credentials:

```
Email: admin@example.com
Password: password
```

---

## Running the Application

```
php artisan serve
```

Visit:

```
http://127.0.0.1:8000/admin/dashboard

```

<img width="1919" height="971" alt="image" src="https://github.com/user-attachments/assets/8f8f7750-ecd8-4d71-a8c2-b9f477a73d40" />

---

## How It Works

1. User performs action
2. Trait or Middleware captures event
3. Data stored in `activity_logs` table
4. Admin dashboard displays logs
5. Filters allow searching and sorting
6. CSV export generates downloadable report

---

## Activity Log Table Fields

* id
* user_id
* action
* model
* model_id
* description
* ip_address
* user_agent
* old_values
* new_values
* url
* method
* created_at
* updated_at

---

## Use Cases

* Admin audit systems
* Employee monitoring tools
* Security tracking
* Product change history
* Legal compliance logs

---

## Optional Enhancements

* WebSocket live updates
* Multi‑role permissions
* Dark theme admin panel
* Email alerts for suspicious activity
* API logging support

---

## Requirements

* PHP 8 or higher
* Composer
* MySQL
* Node.js & NPM
* Internet connection

---

## Author

Mihir Mehta

---

## License

Open Source

