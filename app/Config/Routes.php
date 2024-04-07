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


// Manage Users or profile
$routes->get('/admin/users', 'UsersController::listUsers');
$routes->get('/admin/users/(:num)', 'UsersController::detailUser/$1');

$routes->post('/users/profile/change-foto', 'UsersController::changeFotoProfile');
$routes->post('/users/profile/update', 'UsersController::updateDataUser');

// Question, Quiz
$routes->get('/admin/questions', 'QuestionController::questionsList');
$routes->get('/admin/questions/add', 'QuestionController::addQuestions');
$routes->post('/admin/questions/save', 'QuestionController::saveQuestions');
$routes->get('/quiz', 'QuizController::quiz');


// About
$routes->get('/about', 'Home::about');

