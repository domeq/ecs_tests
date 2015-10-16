<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app['redis'] = new Predis\Client(
    [
        'scheme' => 'tcp',
        'host'   => 'redis',
        'port'   => 6379,
    ]
);

$app->get('/', function() use($app) {
    $redis = $app['redis'];
    $redis->incr('hits');
    return printf('Hello World! I have been seen %d times.', $redis->get('hits'));
});

$app->run();
