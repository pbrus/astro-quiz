<?php

use Brus\Session;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

echo $twig->render('question.html.twig', array(
    'user' => Session::getVar('user'),
    'amountQuestions' => Session::getVar('amountQuestions'),
    'allQuestions' => Session::getVar('allQuestions'),
    'currentQuestionIndex' => Session::getVar('currentQuestionIndex'),
    'unselectedAnswer' => Session::getVar('unselectedAnswer'),
    'imageWidth' => Session::getVar('imageWidth')
));
