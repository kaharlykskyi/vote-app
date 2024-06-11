## Installation

1. Clone the repo and cd into it
2. Run `composer install`
3. Rename or copy `.env.example` file to `.env`
4. Run `php artisan key:generate`
5. Setup a database and add your database credentials in your `.env` file. Or just use SQLite
6. `php artisan migrate` or `php artisan migrate --seed` if you want seed data
7. Run `npm install` to install frontend dependencies
8. Run `npm run dev` or `npm run build`
9. `php artisan serve` or use Laravel Herd
10. Open your hosted page in browser ⭐
