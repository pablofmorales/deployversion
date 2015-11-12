<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

define("APP_NAME", getenv('APP_NAME'));
define("APP_ENV", getenv('APP_ENV'));
define("BASE_DIR", __DIR__ . '/../');

\date_default_timezone_set('America/Los_Angeles');

include BASE_DIR . 'vendor/autoload.php';

$app = new Silex\Application();

if (in_array(APP_ENV, array('dev', 'staging'))) {
    $app['debug'] = true;
}

$app->register(new Silex\Provider\DoctrineServiceProvider(),
    ['db.options' => include sprintf(
        '%s/src/Config/credentials.%s.php', BASE_DIR, APP_NAME
    )]
);

$app['guzzle'] = $app->share(function () use ($app) {
    return new Guzzle\Http\Client();
});

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app['home'] = $app->share(function () use ($app) {
    return new Controllers\Home();
});

$app['versions'] = $app->share(function () use ($app) {
    $versions = new Models\Versions($app['db']);
    return new Controllers\Versions($versions);
});

$app->before(function (Request $request, Silex\Application $app) {
    if (extension_loaded('newrelic')) {
        newrelic_name_transaction(current(explode('?', $_SERVER['REQUEST_URI'])));
    }
});

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,HEAD,DELETE,PUT,OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
    if ($response->getStatusCode() == 200) {
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
    }
});

$app->match("{url}", function($url) use ($app) { return "OK"; })->assert('url', '.*')->method("OPTIONS");
$app->get('/projects/{project}/latest', 'versions:latest');
$app->get('/', 'home:index');
$app->run();
