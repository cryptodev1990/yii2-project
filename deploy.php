<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace Deployer;

// Include configuration files
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/deployer/deployer/recipe/common.php';

// Custom dependencies
use Dotenv\Dotenv;

// Load environments configuration
$env = Dotenv::create(dirname(__DIR__));
$env->load();

/**
 * Project settings
 */
set('repository', env('DEPLOY_REPOSITORY'));
set('hostname', env('DEPLOY_HOST'));
set('user', env('DEPLOY_USER'));

/**
 * Hosts
 */
host('production')
    ->hostname(get('hostname'))
    ->user(get('user'))
    ->identityFile('~/.ssh/id_rsa')
    ->port(22)
    ->set('root_path', env('DEPLOY_ROOT_PATH'))
    ->set('deploy_path', env('DEPLOY_PROJECT_PATH'))
    ->set('public_path', env('DEPLOY_PUBLIC_PATH'));

/**
 * Deployment settings
 */
set('allow_anonymous_stats', false);
set('application', env('DEPLOY_APPLICATION_NAME'));
set('ssh_multiplexing', true);
set('keep_releases', 2);
set('git_tty', true);

/**
 * Shared files/dirs between deploys
 */
set('shared_files', [
    '.env',
]);

set('shared_dirs', [
    'runtime',
    'public/storage',
]);

/**
 * Writable dirs by web server
 */
set('writable_dirs', ['runtime']);

/**
 * Tasks
 */
desc('Stop supervisor service');
task('supervisor:stop', function () {
    run('sudo supervisorctl stop all');
});

desc('Start supervisor service');
task('supervisor:start', function () {
    run('sudo supervisorctl start all');
});

desc('Install NPM packages');
task('npm:install', function () {
    run('cd {{release_path}} && npm install');
});

desc('Build NPM assets');
task('npm:build', function () {
    run('cd {{release_path}} && npm run production');
});

desc('Apply database migrations');
task('deploy:migrate', function () {
    run('php {{release_path}}/yii migrate --interactive=0');
});

desc('Creating symlink to release');
task('deploy:symlink', function () {
    // remove older public directory
    run('rm {{public_path}} -rf');

    // create custom symlink
    run("cd {{deploy_path}} && {{bin/symlink}} {{release_path}} {{public_path}}");
    run("cd {{deploy_path}} && rm release"); // Remove release link.
});

// Use 'dep deploy'
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'supervisor:stop',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'npm:install',
    'deploy:clear_paths',
    'deploy:migrate',
    'npm:build',
    'deploy:symlink',
    'deploy:unlock',
    'supervisor:start',
    'cleanup',
    'success',
]);

// Use 'dep local'
desc('Local deploy (Docker preferred)');
task('local', function () {
    run('supervisorctl stop all');

    run('composer install');
    run('npm install');

    run('php yii migrate --interactive=0');
    run('npm run build');

    run('supervisorctl start all');
})->local();

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');