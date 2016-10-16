<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/setup.php';

require_once __DIR__ . '/../app/recaptchalib.php';



use Nourhan\Controllers;
use Nourhan\Router;

$router = new Router\Router();



$router->get('/', 'MainController', 'index');
$router->get('/login', 'MainController', 'login');

$router->get('/calendar', 'MainController', 'calendar');
$router->get('/fitnessProgram', 'MainController', 'fitnessProgram');
$router->get('/profile', 'MainController', 'profile');

/********ADMIN**********/

$router->post('/admin/login', 'MainController', 'adminLogin');
$router->get('/editschedule', 'MainController', 'editSchedule');
$router->get('/editclass', 'MainController', 'editClass');

////See inside $router
//echo "<pre>";
//print_r($router);

$router->submit();


