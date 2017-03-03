<?php

use Brus\Session;
use AstroQuiz\User;
use AstroQuiz\Question;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$idx = Session::getVar('idx');

echo $twig->render('question.html.twig', array(
    'user' => Session::getVar('user'),
    'nquest' => Session::getVar('nquest'),
    'arrquest' => Session::getVar('arrquest'),
    'idx' => $idx
));
