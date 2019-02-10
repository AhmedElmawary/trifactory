<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project repository
set('repository', 'git@gitlab.com:breadcrumbsegypt/trifactory_backend.git');

set('http_user', 'www-data');
set('writable_mode', 'chmod');
set('use_relative_symlink', false);

localhost()
    ->stage('prod')
    ->user('gitlabci')
    ->identityFile('~/.ssh/id_rsa')
    ->set('branch', 'develop')
    ->set('deploy_path', '/code');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
