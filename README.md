<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# BP PHP Technical Test #1

## APP Demo Videos
[API Test Via Postman Video](https://www.loom.com/share/c499f5f23df24bffbd238f90cd2a796a)

[API Test in PHPUnit Video](https://www.loom.com/share/7cadf50755804241980bac7b92eedba8)

[API Documentation](https://github.com/mrahbari/bp-task1/blob/main/public/docs/)


## Requirements
Test to demonstrate skills and mastery in PHP.
* Create a call which will return all the users which are `active` (users table) and have an Austrian citizenship.
* Create a call which will allow you to edit user details just if the user details are there already.
* Create a call which will allow you to delete a user just if no user details exist yet.
* Write a feature test for 3. with valid and invalid data

## Technology Stack

- Laravel 8.x with php 8.x
- Mysql
- TDD. All endpoints [PHPUnit and FeatureTest]
- RESTFul API
- API Versioning
- Dockerize by LaraDoc
- Eloquent and Suitable Relations
- Migrations 
- Seeders and Factories
- Laravel ApiDoc Generator
- Laravel Api Resources
- Country Api Just for more clarify

## TDD [PHPUnit and FeatureTest]
Different forms of writing the test unit had been written with comments.

## Installation

### Manually
1- Modify .env file according to the database settings

        DB_HOST=localhost
        DB_PORT=3306
        DB_DATABASE=bp_task1_db
        DB_USERNAME=root
        DB_PASSWORD=root
        DB_PREFIX=tbl_
        DB_SOCKET=/var/mysql/mysql.sock
   
    
2- Migrations && seeds and factories files work perfectly, but I suggest you import your database instead.

        a) manually 
            a1) create your database        
                    bp_task1_db
            a2) import your sql database from below address
                database/sql/bp_task1_db.sql.zip
                

        -------------------------------------------------

        b) or run related commands instead
            b1) create your database        
                    bp_task1_db
            b2) run commands
                $ php artisan migrate:fresh --seed
                $ php artisan db:seed
    
3- Import POSTMAN collection, so you can easily see all the tested apis:

[Postman Collection](https://github.com/mrahbari/bp-task1/blob/main/docs/postman/bp-task1.postman_collection.json)


# Via Docker

### Clone the project
```
git clone https://github.com/mrahbari/bp-task1.git
cd bp-task1
```

### Create .env file

```
cp .env.example .env
```

### Run Docker
I recommend you to set up the laradock based on their website documentation.

[LaraDock Demonstration](https://laradock.io/documentation).

```
git clone https://github.com/Laradock/laradock.git
cd laradock
cp env.docker .env
docker-compose up -d nginx mysql workspace 
```


### Configure the project

```
docker-compose exec -ti bp-task1 composer install
docker-compose exec -ti bp-task1 php artisan migrate:fresh --seed
docker-compose exec -ti bp-task1 php artisan test
```

### Run the project and phpmyadmin
[For Postman Url] (http://bp.local)

[PHPMyAdmin Url] (http://bp.local:8081)


### Route lists In Project
```
    +-------------------+--------------------------------------------------+-------------------------+
    |  http://bp.local  |  GET|HEAD | api/{api_version}/countries          | Countries List          |
    |  http://bp.local  |  GET|HEAD | api/{api_version}/countries/{id}     | Country Show            |
    |  http://bp.local  |  GET|HEAD | api/{api_version}/users              | Users List With Filters |
    |  http://bp.local  |  GET|HEAD | api/{api_version}/users/country      | Users List [Austrian]   |
    |  http://bp.local  |  DELETE   | api/{api_version}/users/{id}         | Users Deelete           |
    |  http://bp.local  |  GET|HEAD | api/{api_version}/users/{id}         | Users Show one          |
    |  http://bp.local  |  PUT      | api/{api_version}/users/{id}/details | Users Details Update    |
    |  http://bp.local  |  GET|HEAD | openapi                              | Api Docs                |
    +-------------------+--------------------------------------------------+-------------------------+
```

## Thanks For Your Patience and attention :)
