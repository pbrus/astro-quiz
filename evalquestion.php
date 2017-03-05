<?php

use Brus\Session;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

if (!isset($_POST['answer'])) {
    Session::updateVar('unselectedAnswer', True);
} else {
    Session::updateVar('unselectedAnswer', False);
    $currentQuestionIndex = Session::getVar('currentQuestionIndex');
    $currentQuestionIndex += 1;
    Session::updateVar('currentQuestionIndex', $currentQuestionIndex);
}
header('Location: question.php');
