<?php

use Brus\Session;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

if (isset($_POST['answer']) === FALSE) {
    Session::updateVar('unselectedAnswer', TRUE);
} else {
    Session::updateVar('unselectedAnswer', FALSE);
    $allQuestions = Session::getVar('allQuestions');
    $currentQuestionIndex = Session::getVar('currentQuestionIndex');
    $allQuestions[$currentQuestionIndex]->saveUserAnswer($_POST['answer']);
    $allQuestions = Session::updateVar('allQuestions', $allQuestions);

    if (($currentQuestionIndex + 1) == Session::getVar('amountQuestions')) {
        header('Location: finish.php');
        exit;
    } else {
        Session::updateVar('currentQuestionIndex', $currentQuestionIndex + 1);
    }
}
header('Location: question.php');
