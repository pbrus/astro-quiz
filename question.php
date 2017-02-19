<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/php/model.php';
if (!isset($_SESSION)) {
    session_start();
}
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$questions = $_SESSION['questions'];
try {
    $user = new User($_POST['name']);
} catch (Exception $e) {
    $_SESSION['exception'] = $e->getMessage();
    header("Location: index.php");
    exit;
}
