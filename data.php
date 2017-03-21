<?php

use Brus\Session;
use AstroQuiz\ConfigureFile;
use AstroQuiz\DatabaseFile;
require_once __DIR__.'/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$loadDataError = NULL;
$displayLoginForm = NULL;
$typeAnotherPassword = NULL;
$formPassword = $_POST['admin_password'];

try {
    $configureFile = new ConfigureFile("astroquiz.cfg");
    $password = $configureFile->getPassword();
    $databaseFile = new DatabaseFile("database/database");
} catch (AstroQuiz\WrongConfiguration $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileException $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileAccessException $err) {
    $loadDataError = $err->getMessage();
}

if (isset($password) && ($password != $formPassword)) {
    $displayLoginForm = TRUE;
    $typeAnotherPassword = TRUE;
    $loadDataError = NULL;
}

echo $twig->render('admin.html.twig', array(
    'loadDataError' => $loadDataError,
    'displayLoginForm' => $displayLoginForm,
    'typeAnotherPassword' => $typeAnotherPassword
));
