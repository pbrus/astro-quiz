<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/php/model.php';
if (!isset($_SESSION)) {
    session_start();
}
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$questions = $_SESSION['questions'];
$user = new User($_POST['name']);

if (!$user->validName()) {
    $error = $user->error();
    echo $twig->render('index.html.twig', array(
        'loaddata' => True,
        'validform' => True,
        'formerror' => $error
    ));
}
