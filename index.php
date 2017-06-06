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

$loadDataCorrectly = TRUE;
$loadDataError = NULL;

try {
    $configureFile = new ConfigureFile("astroquiz.cfg");
    $fileWithQuestions = $configureFile->getFilenameWithQuestions();
    $questionFile = new QuestionFile("files/" . $fileWithQuestions);
    $databaseFile = new DatabaseFile("database/database", "r+");
} catch (AstroQuiz\Exception\WrongConfiguration $err) {
    $loadDataCorrectly = FALSE;
    $loadDataError = $err->getMessage();
} catch (Brus\Exception\NoFileException $err) {
    $loadDataCorrectly = FALSE;
    $loadDataError = $err->getMessage();
} catch (Brus\Exception\NoFileAccessException $err) {
    $loadDataCorrectly = FALSE;
    $loadDataError = $err->getMessage();
}

if ($loadDataCorrectly === FALSE) {
    echo $twig->render('index.html.twig', array(
        'loadDataError' => $loadDataError
    ));
    exit;
}

if ($questionFile->properSize() === FALSE) {
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
        'imageWidth' => $configureFile->getImagesWidth()
    ));
}

echo $twig->render('index.html.twig', array(
        'loadDataError' => $loadDataError
));
