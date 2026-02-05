# Task Manager with Laravel 11

## Project Overview
<img width="3017" height="1913" alt="Screenshot 2026-02-04 173418" src="./Screenshot 2026-02-04 173418.png" />

## Requirements
- PHP 8.3+
- Laravel 11+
- MySQL
- Node.js & npm

## Setup
1. Clone the repo.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and update DB credentials.
4. Run `php artisan migrate`.
4. Run `php artisan key:generate`.
5. Install front-end dependencies: `npm install && npm run dev`.
6. Serve the app: `php artisan serve`.

## Features
- Create, edit, delete tasks.
- Drag & drop to reorder tasks (priority updates automatically).
- Tasks associated with projects (optional project filter).
- All tasks saved in MySQL.

## Author
    Daniel James