## First Clone With Docker

- masuk ke project
- jalankan code berikut pada terminal untuk download vendor
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

- running migration
- running seeder sail artisan db:seed --class=UserSeeders
- running seeder sail artisan db:seed --class=PermissionSeeder

## First Clone Without Docker
- clone project in folder htdocs
- open project
- composer install
- running migration
- running seeder php artisan db:seed --class=UserSeeders
- running seeder php artisan db:seed --class=PermissionSeeder


## Unit Testing
- sail phpunit tests/Feature/Http/Controllers/Api/Auth/AuthController.php
- sail phpunit tests/Feature/Http/Controllers/Api/Candidate/CandidateController.php


