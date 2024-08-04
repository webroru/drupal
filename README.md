## Installation

### DEV env

1. Setup [Docker](https://docs.docker.com/engine/installation/linux/ubuntu/)
2. setup [Docker Compose](https://docs.docker.com/compose/install/)
3. cp .env.example .env
4. `docker compose up -d`

### PROD env

1. Setup [Docker](https://docs.docker.com/engine/installation/linux/ubuntu/)
2. setup [Docker Compose](https://docs.docker.com/compose/install/)
3. cp .env.example .env
4. Set strong MYSQL password
5. `docker compose -f docker-compose-prod.yml up -d`

## Migration

Migrate `drush migrate-import upgrade_d7_menu_links`
Rollback `drush migrate-rollback upgrade_d7_menu_links`

drush migrate:upgrade --legacy-db-key=d7 --configure-only
drush migrate-reset-status d7_views_migration

drush cex --destination=sites/default/files/export

drush pm:uninstall ntb_migration
drush pm:enable ntb_migration

drush migrate-import d7_views_migration

drush config-delete migrate_plus.migration.d7_views_migration
drush config:import --partial --source=modules/custom/ntb_migration/config/install/tmp

## MySQL Dump

`mysqldump -u root -h mysql drupal | gzip > `date +web/sites/default/files/drupal.sql.%Y%m%d.%H%M%S.gz``

