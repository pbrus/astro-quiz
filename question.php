<?php

use Brus\Session;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$questions = Session::getVar('questions');

echo $twig->render('question.html.twig', array(
    'user' => Session::getVar('nick'),
    'nqst' => Session::getVar('numquests'),
    'questions' => $questions
));
