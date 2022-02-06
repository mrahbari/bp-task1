        1- Installation Via Composer
            $ composer global require laravel/installer
            $ laravel new bp_test_2022
            copy all cloned files[.git , readme] into bp_test_2022 folder
            $ cd bp_test_2022
        
        ---------------------------------------------------
        2- 
            A) Setup DB connections in .env
                DB_CONNECTION=mysql
                DB_HOST=mysql
                DB_PORT=3306
                DB_DATABASE=bp_task1_db
                DB_USERNAME=root
                DB_PASSWORD=root
                DB_PREFIX=tbl_
                ####DB_SOCKET=/var/mysql/mysql.sock
        
        
            B) Add Prefix Constant to config/database.php mysql array
                'prefix' => env('DB_PREFIX', ''),
        
            C)  make connection in docker and create db
        
        ---------------------------------------------------
        3- A little changes in app/Providers/AppServiceProvider.php

            use Illuminate\Support\Facades\Schema;

            public function boot()
            {
                Schema::defaultStringLength(191);
            }
        
        
        ---------------------------------------------------
        5- Add custom helper to composer.json
        "autoload": {
            "files": [
                "helpers/app.php"
            ],
            "psr-4": {
                ...
                ...

        ---------------------------------------------------
        5- setup sail or laradoc to handle docker

           A)  rm composer.lock
                composer require laravel/sail
            
           B) php artisan sail:install --with=mysql

           C) Optional. make specific custom for sail in your profile
                nano ~/.zshrc

                    alias sail="vendor/bin/sail"
                    alias phpunit="vendor/bin/phpunit"
                    export PATH="/usr/sbin:/sbin:/bin:/usr/bin:/usr/local/bin:$PATH"
                    export PATH="$HOME/.composer/vendor/bin:$PATH"
                    export PATH="$HOME/.composer/vendor/bin/sail:$PATH"

           D) .env
                FORWARD_DB_PORT=33060
                APP_PORT=8000

            After that, try running the command up command again:

                vendor/bin/sail up -d
                sail up -d
                    

                
        
        ---------------------------------------------------
        6- Add Custom Response and Exception Traits


        7- Add basic versioning for routes \App\Providers\RouteServiceProvider
                public function boot()
                {
                    ....
                    ....
                    ....
            
                    //Add basic version for routes
                    $this->manipulateRouteRequirements();
                }
            
                /**
                 * set default value routs
                 */
                private function manipulateRouteRequirements()
                {
                    //Step 1: set default values
                    URL::defaults([
                        'api_version' => 'v1',  //config('base.settings.app_api_version'),
                    ]);
            
                    //Step 2: Set route patterns
                    Route::pattern('api_version', 'v1');    //config('base.settings.app_api_version'),
                }
        
        ---------------------------------------------------
        7- Fo first commit
            $ git add .
            $ git commit -m "WIP-000-Installation & Basic requirements"
            $ git checkout -b development
            ----- $ git push origin development

            ---------------------------------------------------
            8- 
                A) Add new column to user migration file [Permitted to publish]
                   ///// $ php artisan make:migration add_active_to_users_table --table=users

                B) Update UserSeeder.php for sample requested & modify DatabaseSeeder.php
                    php artisan make:seeder UserSeeder

                    php artisan db:seed --class=UserSeeder
                    php artisan db:seed --class=CountrySeeder
                    php artisan db:seed --class=UserDetailSeeder


                    php artisan migrate:fresh --seed
                    php artisan db:seed

---------------------------------------------------
9- 
    A) Generating Model Classes
        $ php artisan make:model User --all
        $ php artisan make:model Country --all
        $ php artisan make:model UserDetail --all

    C) New Controllers Must be extends from BaseApiController

---------------------------------------------------
10- 
    A) Define model's fields in related migrate files
    B) Define Factories & modify DatabaseSeeder.php
    C) Define Seeds & modify DatabaseSeeder.php
    D) Run related commands  
        $ php artisan migrate     
        $ php artisan db:seed

---------------------------------------------------
---------------------------------------------------
11- Do second commit
    $ git add .
    $ git commit -m "WIP-001-Basic CRUDs Requirements, migrations, factories, ..."

---------------------------------------------------



php artisan make:test UserTest

php artisan make:test UserTest --unit


---------------------------------------------------
composer require vinkla/hashids
---------------------------------------------------


add in config\app.php
App\Providers\RepositoryServiceProvider::class,


------------------
app/Http/Kernel.php

    protected $middlewareGroups = [
        'web' => [
...

            //Set Default Parameters Allocating
            DefaultParametersAllocating::class
        ],

        'api' => [
...
            //Set Default Parameters Allocating
            DefaultParametersAllocating::class
        ],







---------------------------------------------------

        //DB::enableQueryLog(); // Enable query log
        $params = ['country_iso2' => $this::DEFAULT_COUNTRY_ISO2, 'active' => $this::DEFAULT_ACTIVE];
        $AustrianUsers = $this->repository->listUsers($params);
        //dd(DB::getQueryLog()); // Show results of log



---------------------------------------------------
http://bp.local
http://bp.local:8081      phpmyadmin

---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
