<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// == AUTH ==
$routes->get('/login', 'AuthController::login');
$routes->post('/login/check', 'AuthController::checkProcessLogin');
$routes->get('/masuk', 'AuthController::login');

$routes->get('/register', 'AuthController::register');
$routes->post('/register/check', 'AuthController::processRegisterUser');
$routes->get('/daftar', 'AuthController::register');

$routes->get('/logout', 'AuthController::processLogout');

$routes->get('/dashboard', 'Home::dashboard');


// Quiz
$routes->get('/quiz', 'QuizController::quiz');

// About
$routes->get('/about', 'Home::about');

