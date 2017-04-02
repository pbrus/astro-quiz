<?php

use Brus\Session;
use AstroQuiz\ConfigureFile;
use AstroQuiz\QuestionFile;
use AstroQuiz\DatabaseFile;
use AstroQuiz\Question;
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
    $fileWithQuestions = $configureFile->getFilenameWithQuestions();
    $questionFile = new QuestionFile("files/" . $fileWithQuestions);
    $databaseFile = new DatabaseFile("database/database");
} catch (AstroQuiz\WrongConfiguration $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileException $err) {
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileAccessException $err) {
    $loadDataError = $err->getMessage();
}

if ($loadDataError == NULL && $databaseFile->isEmpty() === TRUE) {
    $loadDataError = "Database is empty. Nothing to study";
}

if (isset($password) && ($password != $formPassword)) {
    $loadDataError = NULL;
    $displayLoginForm = TRUE;
    $typeAnotherPassword = TRUE;
    echo $twig->render('admin.html.twig', array(
        'loadDataError' => $loadDataError,
        'displayLoginForm' => $displayLoginForm,
        'typeAnotherPassword' => $typeAnotherPassword
    ));
    exit;
}

if ($loadDataError == NULL) {
    if ($questionFile->properSize() === FALSE) {
        $loadDataError = $questionFile->error();
    } else {
        $database = $databaseFile->getDatabaseSortedByResults("DESC");
        $amountUsers = $databaseFile->amountUsers();
        $amountQuestions = $questionFile->amountQuestions();
        $allQuestions = array();
        $percentCorrectAnswers = array();

        for ($i = 0; $i < $amountQuestions; $i++) {
            $allQuestions[$i] = new Question($questionFile->readQuestion());
            $amountCorrectQuestions = 0;

            foreach ($database as $row) {
                if ($row[$i + 1] != 0) {
                    $amountCorrectQuestions += 1;
                }
            }

            $percentCorrectAnswers[$i] = 100*$amountCorrectQuestions/$amountUsers;
        }

        echo $twig->render('admin.html.twig', array(
            'loadDataError' => $loadDataError,
            'displayLoginForm' => $displayLoginForm,
            'typeAnotherPassword' => $typeAnotherPassword,
            'allQuestions' => $allQuestions,
            'database' => $database,
            'percentCorrectAnswers' => $percentCorrectAnswers
        ));
        exit;
    }
}

echo $twig->render('admin.html.twig', array(
    'loadDataError' => $loadDataError,
    'displayLoginForm' => $displayLoginForm,
    'typeAnotherPassword' => $typeAnotherPassword,
));
