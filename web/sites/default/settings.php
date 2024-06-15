<?php

// phpcs:ignoreFile

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 *
 * This variable will be set to a random value by the installer. All one-time
 * login links will be invalidated if the value is changed. Note that if your
 * site is deployed on a cluster of web servers, you must ensure that this
 * variable has the same value on each server.
 *
 * For enhanced security, you may set this variable to the contents of a file
 * outside your document root, and vary the value across environments (like
 * production and development); you should also ensure that this file is not
 * stored with backups of your database.
 *
 * Example:
 * @code
 *   $settings['hash_salt'] = file_get_contents('/home/example/salt.txt');
 * @endcode
 */
$settings['hash_salt'] = getenv('HASH_SALT');

/**
 * Access control for update.php script.
 *
 * If you are updating your Drupal installation using the update.php script but
 * are not logged in using either an account with the "Administer software
 * updates" permission or the site maintenance account (the account that was
 * created during installation), you will need to modify the access check
 * statement below. Change the false to a true to disable the access check.
 * After finishing the upgrade, be sure to open this file again and change the
 * true back to a false!
 */
$settings['update_free_access'] = false;

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

/**
 * The default list of directories that will be ignored by Drupal's file API.
 *
 * By default ignore node_modules and bower_components folders to avoid issues
 * with common frontend tools and recursive scanning of directories looking for
 * extensions.
 *
 * @see \Drupal\Core\File\FileSystemInterface::scanDirectory()
 * @see \Drupal\Core\Extension\ExtensionDiscovery::scanDirectory()
 */
$settings['file_scan_ignore_directories'] = [
    'node_modules',
    'bower_components',
];

/**
 * The default number of entities to update in a batch process.
 *
 * This is used by update and post-update functions that need to go through and
 * change all the entities on a site, so it is useful to increase this number
 * if your hosting configuration (i.e. RAM allocation, CPU speed) allows for a
 * larger number of entities to be processed in a single batch run.
 */
$settings['entity_update_batch_size'] = 50;

/**
 * Entity update backup.
 *
 * This is used to inform the entity storage handler that the backup tables as
 * well as the original entity type and field storage definitions should be
 * retained after a successful entity update process.
 */
$settings['entity_update_backup'] = true;

/**
 * Node migration type.
 *
 * This is used to force the migration system to use the classic node migrations
 * instead of the default complete node migrations. The migration system will
 * use the classic node migration only if there are existing migrate_map tables
 * for the classic node migrations and they contain data. These tables may not
 * exist if you are developing custom migrations and do not want to use the
 * complete node migrations. Set this to true to force the use of the classic
 * node migrations.
 */
$settings['migrate_node_migrate_type_classic'] = false;

/**
 * Load local development override configuration, if available.
 *
 * Create a settings.local.php file to override variables on secondary (staging,
 * development, etc.) installations of this site.
 *
 * Typical uses of settings.local.php include:
 * - Disabling caching.
 * - Disabling JavaScript/CSS compression.
 * - Rerouting outgoing emails.
 *
 * Keep this code block at the end of this file to take full effect.
 */
if (getenv('APP_ENV') == 'local' && file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
    include $app_root . '/' . $site_path . '/settings.local.php';
}

$databases['default']['default'] = [
    'database' => getenv('DB_NAME') ?: 'drupal',
    'username' => getenv('DB_USERNAME') ?: 'drupal',
    'password' => getenv('DB_PASSWORD') ?: 'drupal',
    'prefix' => '',
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '3306',
    'isolation_level' => 'READ COMMITTED',
    'driver' => getenv('DB_DRIVER') ?: 'mysql',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
];

$databases['d7']['default'] = [
    'database' => 'drupal',
    'username' => 'drupal',
    'password' => 'drupal',
    'prefix' => '',
    'host' => 'host.docker.internal',
    'port' => '13306',
    'driver' => getenv('DB_DRIVER') ?: 'mysql',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
];

$settings['config_sync_directory'] = '../config/sync';

$settings['file_private_path'] = getenv('FILE_PRIVATE_PATH', '../private');
