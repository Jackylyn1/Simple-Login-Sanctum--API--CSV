# Login with API, Sanctum Authentication and CSV-Import

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

### Installation
1. checkout the repo
2. run "docker network create laravel-network"
3. run "docker volume create --name mariadb_data"
4. run "docker run -d --name mariadb --env ALLOW_EMPTY_PASSWORD=yes --env MARIADB_USER=bn_myapp --env MARIADB_DATABASE=bitnami_myapp --network laravel-network --volume mariadb_data:/bitnami/mariadb bitnami/mariadb:latest"
5. run "docker run -d --name laravel -p 8000:8000 --env DB_HOST=mariadb --env DB_PORT=3306 --env DB_USERNAME=bn_myapp --env DB_DATABASE=bitnami_myapp  --network laravel-network --volume [project path on local for bin-mount]:/app bitnami/laravel:latest"
6. run "docker run -d --name laravelAPI -p 8001:8000 --env DB_HOST=mariadb --env DB_PORT=3306 --env DB_USERNAME=bn_myapp --env DB_DATABASE=bitnami_myapp  --network laravel-network --volume [project path on local machine for bin-mount]:/app bitnami/laravel:latest"

### Testing ###
1. run php artisan migrate
2. run php artisan db:seed
3. get password of seeded user from laravel.log there will be an entry, which looks like "local.INFO: Password for [...]"
4. you can use the .csv files inside testdata/ to have an example of the needed structure