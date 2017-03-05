<?php

use Brus\Session;
use AstroQuiz\User;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$user = new User($_POST['name']);

if (!$user->validName()) {      // add method checking is a name is duplicated
    $validFormError = $user->error();
    echo $twig->render('index.html.twig', array(
        'loadDataStatus' => True,
        'validFormStatus' => True,
        'validFormError' => $validFormError
    ));
} else {
    Session::addVar(array(
        'user' => $user,
        'unselectedAnswer' => False
    ));
    header('Location: question.php');
}
