<?php

use Brus\Session;
use AstroQuiz\ConfigureFile;
use AstroQuiz\DatabaseFile;
require_once __DIR__.'/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$loadDataError = NULL;

try {
    $configureFile = new ConfigureFile("astroquiz.cfg");
    $password = $configureFile->getPassword();
} catch (AstroQuiz\WrongConfiguration $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileException $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileAccessException $err) {
    $loadDataError = $err->getMessage();
}

echo $twig->render('admin.html.twig', array(
    'loadDataError' => $loadDataError,
    'displayLoginForm' => TRUE,
    'typeAnotherPassword' => FALSE
));
