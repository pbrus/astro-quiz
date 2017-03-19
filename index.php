<?php

use Brus\Session;
use AstroQuiz\ConfigureFile;
use AstroQuiz\QuestionFile;
use AstroQuiz\DatabaseFile;
use AstroQuiz\Question;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$loadDataStatus = TRUE;
$loadDataError = "None";

try {
    $configureFile = new ConfigureFile("astroquiz.cfg");
    $fileWithQuestions = $configureFile->getFilenameWithQuestions();
    $questionFile = new QuestionFile("files/" . $fileWithQuestions);
    $databaseFile = new DatabaseFile("database/database", "r+");
} catch (AstroQuiz\WrongConfiguration $err) {
    $loadDataStatus = FALSE;
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileException $err) {
    $loadDataStatus = FALSE;
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileAccessException $err) {
    $loadDataStatus = FALSE;
    $loadDataError = $err->getMessage();
}

if ($loadDataStatus === FALSE) {
    echo $twig->render('index.html.twig', array(
        'loadDataStatus' => $loadDataStatus,
        'loadDataError' => $loadDataError
    ));
    exit;
}

if (!$questionFile->properSize()) {
    $loadDataStatus = FALSE;
    $loadDataError = $questionFile->error();
} else {
    $amountQuestions = $questionFile->amountQuestions();
    $allQuestions = array();
    $currentQuestionIndex = 0;

    for ($i = 0; $i < $amountQuestions; $i++) {
        $allQuestions[$i] = new Question($questionFile->readQuestion());
    }

    Session::addVar(array(
        'amountQuestions' => $amountQuestions,
        'allQuestions' => $allQuestions,
        'currentQuestionIndex' => $currentQuestionIndex,
        'databaseFile' => $databaseFile,
        'imageWidth' => $configureFile->getImagesWidth()
    ));
}

echo $twig->render('index.html.twig', array(
        'loadDataStatus' => $loadDataStatus,
        'loadDataError' => $loadDataError
));
