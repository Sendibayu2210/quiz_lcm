<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// == AUTH ==
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/login/check', 'AuthController::checkProcessLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register/check', 'AuthController::processRegisterUser');
$routes->get('/logout', 'AuthController::processLogout');

$routes->get('/dashboard', 'Home::dashboard');

$routes->post('/users/profile/change-foto', 'UsersController::changeFotoProfile');
$routes->post('/users/profile/update', 'UsersController::updateDataUser');
$routes->get('/users/profile', 'UsersController::detailUser');
// Manage Users or profile
$routes->get('/admin/users', 'UsersController::listUsers');
$routes->get('/admin/users/(:num)', 'UsersController::detailUser/$1');
$routes->post('/admin/users/change-password', 'UsersController::changePassword');
// Question, Quiz
$routes->get('/admin/periode', 'QuestionController::periodePage');
$routes->post('/admin/periode/save', 'QuestionController::savePeriode');
$routes->post('/admin/periode/delete', 'QuestionController::deletePeriode');

$routes->get('/admin/questions-periode/(:num)', 'QuestionController::questionsList/$1');
$routes->get('/admin/students-periode/(:num)', 'UsersController::studentPeriode/$1');

$routes->get('/admin/questions/data', 'QuestionController::dataQuestions'); // all
$routes->get('/admin/questions/data/(:num)', 'QuestionController::dataQuestions/$1'); // per id
$routes->get('/admin/questions/add', 'QuestionController::addQuestions');
$routes->post('/admin/questions/save', 'QuestionController::saveQuestions');
$routes->get('/admin/questions/edit/(:num)', 'QuestionController::editQuestions/$1');
$routes->post('/admin/questions/check-delete', 'QuestionController::checkQuestionProgressForDelete');
$routes->post('/admin/questions/delete', 'QuestionController::deleteQuestion');
$routes->post('/admin/multiple-choice/delete', 'QuestionController::deleteMultipleChoice');
$routes->get('/admin/history', 'QuizController::pageHistoryQuizForAdmin');
$routes->get('/admin/history/data-user', 'QuizController::dataHistoryQuiz');
$routes->post('/admin/history/create-level-user', 'QuizController::createLevel');
$routes->post('/admin/quiz/delete-progress', 'QuizController::deleteProgressQuizUser');
$routes->post('/admin/quiz/set-timing', 'QuizController::setTimingQuiz');


$routes->get('/quiz', 'QuizController::quiz');
$routes->get('/quiz/attention/(:num)', 'QuizController::attentionBeforeQuiz/$1');
$routes->get('/quiz/start', 'QuizController::historyBeforeQuiz');
$routes->get('/quiz/score', 'QuizController::historyBeforeQuiz');
$routes->get('/quiz/history', 'QuizController::historyBeforeQuiz');

$routes->get('/quiz/data', 'QuizController::dataQuiz');
$routes->get('/quiz/data/(:any)', 'QuizController::dataQuiz/$1');
$routes->post('/quiz/save-choice', 'QuizController::saveChoiceQuiz');
$routes->post('/quiz/finish', 'QuizController::finishQuiz');
$routes->get('/quiz/score/(:any)', 'QuizController::pageScore/$1');
// $routes->get('/quiz/data-user', 'QuizController::dataUserQuiz');
$routes->get('/quiz/data-user/(:any)', 'QuizController::dataUserQuiz/$1');
$routes->post('/quiz/manage-user', 'QuizController::manageUserQuiz');

// About
$routes->get('/about', 'Home::about');

