# Login with API, Sanctum Authentication and CSV-Import

## about
This project is: a showcase of ideas, a playground, and a gathering point for new technologies. Here, I’m experimenting, tinkering, and more. There’s no fixed development goal—feel free to throw ideas, feedback, and anything else my way!

To-Do
- install pipeline and a showcase Version in Github
- add more validators
- add automated tests
- add registration
- add Facebook-, Google- and GitHub-Login
- add 2fa
- make domain driven structure
- create composer packages (for Login/Registration + for csvimport (maybe fileimport with different types?))

## Overview

### Server Requirements

To run the Application we recommend your host supports:

* PHP version 8.3 or greater.
* MariaDB version 10.6 or greater.

#### Required PHP extensions

* PDO/MySQL

## Development

### Requirements

- Docker - [Install](https://docs.docker.com/get-docker/)
- npm

### Installation - this Installation was tested on windows
1. checkout the repo
2. run "docker network create laravel-network"
3. run "docker volume create --name mariadb_data"
4. run "docker run -d --name mariadb --env ALLOW_EMPTY_PASSWORD=yes --env MARIADB_USER=bn_myapp --env MARIADB_DATABASE=bitnami_myapp --network laravel-network --volume mariadb_data:/bitnami/mariadb bitnami/mariadb:latest"
5. run "docker run -d --name laravel -p 8000:8000 --env DB_HOST=mariadb --env DB_PORT=3306 --env DB_USERNAME=bn_myapp --env DB_DATABASE=bitnami_myapp  --network laravel-network --volume [bind-mount-point]:/app bitnami/laravel:latest"
6. run "docker run -d --name laravelAPI -p 8001:8000 --env DB_HOST=mariadb --env DB_PORT=3306 --env DB_USERNAME=bn_myapp --env DB_DATABASE=bitnami_myapp  --network laravel-network --volume [bind-mount-point]:/app bitnami/laravel:latest"
7. run "npx mix watch" this will compile your sass-files automatically and it will also open a map of js dependencies

#### for phpdocs (optional)
1. run "docker run --rm -v "[bind-mount-point]:/data" "phpdoc/phpdoc:3"
2. run "phpdoc run -d . -t ./storage/phpdocs" in container
3. run "php artisan storage:link" in container
4. run "chmod -R 755 storage/phpdocs"

### Testing ###
1. run php artisan migrate
2. run php artisan db:seed
3. get password of seeded user from laravel.log there will be an entry, which looks like "local.INFO: Password for [...]"
4. you can use the .csv files inside testdata/ to have an example of the needed structure

### additional information ###
1. I know that curl-requests are incredibly slow sometimes, I used them because one of my goals was to use Laravel