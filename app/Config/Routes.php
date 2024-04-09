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
$routes->get('/admin/questions/data', 'QuestionController::dataQuestions'); // all
$routes->get('/admin/questions/data/(:num)', 'QuestionController::dataQuestions/$1'); // per id
$routes->get('/admin/questions/add', 'QuestionController::addQuestions');
$routes->post('/admin/questions/save', 'QuestionController::saveQuestions');
$routes->get('/admin/questions/edit/(:num)', 'QuestionController::editQuestions/$1');

$routes->post('/admin/multiple-choice/delete', 'QuestionController::deleteMultipleChoice');

$routes->get('/quiz', 'QuizController::quiz');
$routes->get('/quiz/attention', 'QuizController::attentionBeforeQuiz');
$routes->get('/quiz/data', 'QuizController::dataQuiz');
$routes->post('/quiz/save-choice', 'QuizController::saveChoiceQuiz');
$routes->post('/quiz/finish', 'QuizController::finishQuiz');
$routes->get('/quiz/score', 'QuizController::pageScore');


// About
$routes->get('/about', 'Home::about');

