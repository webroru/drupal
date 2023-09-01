## Installation

1. Setup [Docker](https://docs.docker.com/engine/installation/linux/ubuntu/)
2. setup [Docker Compose](https://docs.docker.com/compose/install/)
3. `docker compose up -d`
4. `docker compose exec php composer i`
5. `docker compose exec php drush site:install --yes --account-pass=admin`
6. `docker compose exec php drush pm:enable location_finder`
7. `docker compose exec php drush cache:rebuild`

## Admin panel

1. Goto http://localhost:8081/admin
2. Login: admin, password: admin

## Location finder form

http://localhost:8081/dhl-location-finder/location

## Run tests

`docker compose exec php phpunit web/modules/custom/location_finder`
