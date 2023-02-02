## Configuration of the Application

1. Copy env.example to .env
2. Go to workbench or phpmyadmin and create database schema starter
- import database dump from dev server [OPTIONAL for ongoing projects]

## Build Application

### Install PHP Dependencies
```shell
sudo docker exec -it app /bin/bash
```
inside of the docker container run
```shell
composer install && php artisan config:cache && php artisan view:clear && php artisan route:clear && composer dump-autoload && php artisan vue-i18n-custom:generate && php artisan migrate
```

### Install Javascript Dependencies
```shell
sudo docker exec -it node /bin/bash
```
inside of the docker container run
```shell
yarn && yarn watch
```

### Tips

(OPTIONAL only first time) Go to website/ outside of docker and run:
```shell
sudo chown -R www-data. . && sudo setfacl -R -m u:$USER:rwx .
```

## Useful commands:

Get a list of all running or failed containers
```shell
docker ps -a
```
To execute commands inside a container
```shell
docker exec -it app /bin/bash
```
Run a container for a service defined in the docker-compose.yaml file. You will have to execute this command from the dev_env folder
```shell
docker-compose run node /bin/bash
```
Clear all docker cache containers networks etc ... This will remove docker containers for other projects too not just starter
```shell
docker system prune -a
```

