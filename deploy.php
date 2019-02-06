<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'DJC-DTP');

// Project repository
set('repository', 'git@github.com:Pridestalker/mijn.doedejaarsma.nl.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('141.105.127.47')
	->port('33')
	->user('djc')
    ->set('deploy_path', '~/domains/mijn.doedejaarsma.nl/public_html');
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

