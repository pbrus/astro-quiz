<?php

use Brus\Session;
use AstroQuiz\User;
use AstroQuiz\DatabaseFile;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$user = new User($_POST['name']);
$databaseFile = new DatabaseFile("database/database", "r+");

if ($user->validName() === FALSE) {
    $validFormError = $user->error();
} else if ($databaseFile->isNameDuplicated($user->name())) {
    $validFormError = $databaseFile->error();
} else {
    Session::addVar(array(
        'user' => $user,
        'unselectedAnswer' => FALSE
    ));
    header('Location: question.php');
    exit;
}

echo $twig->render('index.html.twig', array(
    'validFormError' => $validFormError
));
