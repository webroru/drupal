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

Migrate drush migrate-import upgrade_d7_menu_links
Rollback drush migrate-rollback upgrade_d7_menu_links

drush migrate:upgrade --legacy-db-key=d7 --configure-only
drush migrate-reset-status d7_views_migration

drush cex --destination=sites/default/files/export

drush pm:uninstall ntb_migration
drush pm:enable ntb_migration

drush migrate-import d7_views_migration

drush config-delete migrate_plus.migration.d7_views_migration
drush config:import --partial --source=modules/custom/ntb_migration/config/install/tmp

mysqldump -u root -h mysql drupal | gzip > `date +web/sites/default/files/drupal.sql.%Y%m%d.%H%M%S.gz`
