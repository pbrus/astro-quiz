<?php

use Brus\Session;
use AstroQuiz\User;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$user = new User($_POST['name']);

if (!$user->validName()) {      // add method checking is a name is duplicated
    $error = $user->error();
    echo $twig->render('index.html.twig', array(
        'loaddata' => True,
        'validform' => True,
        'formerror' => $error
    ));
} else {
    Session::addVar(array(
        'user' => $user
    ));
    header('Location: question.php');
}
