<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use \Interop\Container\ContainerInterface as ContainerInterface;

date_default_timezone_set('Asia/Manila'); //CDT

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([ //Init Slim App
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        //'addContentLengthHeader' => false,
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'hris',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]],
]); 

$container = $app->getContainer(); //Init Container

//$app->add(new \App\Middleware\AuthMiddleware($container));

require __DIR__ .'/dependencies.php';

$container['db'] = function($container) use ($capsule){
    return $capsule;
};

$container['jwt'] = function($container) {
    return new StdClass;
};

$container['logger'] = function($container) {
    $logger = new \Monolog\Logger('my_logger');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log'));
    return $logger;
};

$container['HomeController'] = function($container) {
    return new \App\Modules\Authorization\Controllers\HomeController($container); 
};

$container['AuthController'] = function($container) {
    return new \App\Modules\Authorization\Controllers\AuthController($container);
};

$container['EmployeeController'] = function($container) {
    return new \App\Modules\Employee\Controllers\EmployeeController($container);
};

$container['AttendanceController'] = function($container){
    return new \App\Modules\Attendance\Controllers\AttendanceController($container);
};

$container['ReportController'] = function($container){
    return new \App\Modules\Reports\Attendance\Controllers\ReportController;
};

$container['AttendancetypeController'] = function($container){
    return new \App\Modules\Attendancetype\Controllers\AttendancetypeController;
};

$container['validator'] = function($container){
    return new \App\Utils\Validator;
};

$container['AuthMiddleware'] = function($container){
    return new \App\Middleware\AuthMiddleware();
};

/* FOR TESTING MIDDLEWARE
$app->add(function ($request, $response, $next) {
    $response->getBody()->write('BEFORE');
	$response = $next($request, $response);
	$response->getBody()->write('AFTER');
	return $response;
});*/

//Adding Middleware

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->add(new \App\Middleware\Auth($container));

// $app->add(function ($request, $response, $next) {
//     $id = $request->getAttribute('route');
//     var_dump($id); die();
//     return $next($request, $response);
// });

require __DIR__ . '/../src/routes.php'; //Route Summary
//$app->add(new \App\Middleware\ValidationErrorsMiddleware()); 





