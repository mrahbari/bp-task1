https://vyuldashev.github.io/laravel-openapi/


composer require vyuldashev/laravel-openapi
php artisan vendor:publish --provider="Vyuldashev\LaravelOpenApi\OpenApiServiceProvider" --tag="openapi-config"
php artisan openapi:generate
