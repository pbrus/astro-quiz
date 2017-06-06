<?php

use Brus\Session;
use AstroQuiz\ConfigureFile;
use AstroQuiz\DatabaseFile;
require_once __DIR__.'/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$loadDataError = NULL;
$displayLoginForm = NULL;
$formPassword = $_POST['admin_password'];

try {
    $configureFile = new ConfigureFile("astroquiz.cfg");
    $password = $configureFile->getPassword();
    $databaseFile = new DatabaseFile("database/database");
} catch (AstroQuiz\Exception\WrongConfiguration $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\Exception\NoFileException $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\Exception\NoFileAccessException $err) {
    $loadDataError = $err->getMessage();
}

if (isset($password) && ($password != $formPassword)) {
    $loadDataError = NULL;
    $displayLoginForm = TRUE;
    echo $twig->render('clean.html.twig', array(
        'loadDataError' => $loadDataError,
        'displayLoginForm' => $displayLoginForm
    ));
    exit;
}

if ($loadDataError == NULL) {
    try {
        $databaseFile->clean();
    } catch (AstroQuiz\FailureCleanDataException $err) {
        $loadDataError = $err->getMessage();
    }
}

echo $twig->render('clean.html.twig', array(
    'loadDataError' => $loadDataError,
    'displayLoginForm' => $displayLoginForm
));
