# Requirement

PHP 8.0 ++
REDIS
MONGODB

# How to install

1. Clone this repository
2. `composer install`
3. `cp .env_example .env` and configure your database in .env file.
4. `php artisan key:generate`
5. `php artisan jwt:secret` 
6. `php artisan db:seed` seeding sample user data.
7. `php artisan serve` or use laravel [Valet](https://laravel.com/docs/10.x/valet)

# Demo User
demo@user.test
1q2w3e++2023ABC

# Test
`vendor/bin/phpunit tests/Feature/AuthJwtTest.php`
`vendor/bin/phpunit tests/Feature/MotorCycleTest.php`
`vendor/bin/phpunit tests/Feature/CarTest.php`
`vendor/bin/phpunit tests/Feature/VechileTest.php`
`vendor/bin/phpunit tests/Feature/SaleTest.php`

# Documentation
[API documentation](https://www.postman.com/speeding-resonance-5236/workspace/vechilstock/collection/2692371-7d717c64-eb74-49f2-8888-6e0e194c17e5?action=share&creator=2692371)
[Laravel documentation](https://laravel.com/docs)
