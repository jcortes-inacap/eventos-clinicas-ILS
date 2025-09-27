git clone https://github.com/Vicente-Alejandro/laravel-vue-base.git
cd laravel-vue-base

cp .env.example .env
php artisan key:generate
php artisan migrate
