https://vyuldashev.github.io/laravel-openapi/


composer require vyuldashev/laravel-openapi
php artisan vendor:publish --provider="Vyuldashev\LaravelOpenApi\OpenApiServiceProvider" --tag="openapi-config"
php artisan openapi:generate



|        | GET|HEAD | openapi                              | openapi.default.specification | Vyuldashev\LaravelOpenApi\Http\OpenApiController@show                                |            |



http://127.0.0.1:8000/openapi



php artisan openapi:create

php artisan openapi:make-parameters ListUsers


-----------------------------

        "php": "^7.4|^8.0",


-----------------------------
