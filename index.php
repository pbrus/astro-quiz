<?php

use Brus\Session;
use AstroQuiz\QuestionFile;
use AstroQuiz\Question;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$loadDataStatus = True;
$loadDataError = "None";

try {
    $questionFile = new QuestionFile("files/questions.txt");
} catch (Brus\NoFileException $err) {
    $loadDataStatus = False;
    $loadDataError = $err->getMessage();
} catch (Brus\NoFileAccessException $err) {
    $loadDataStatus = False;
    $loadDataError = $err->getMessage();
}

if (!$loadDataStatus) {
    echo $twig->render('index.html.twig', array(
        'loadDataStatus' => $loadDataStatus,
        'loadDataError' => $loadDataError
    ));
    exit;
}

if (!$questionFile->properSize()) {
    $loadDataStatus = False;
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
        'currentQuestionIndex' => $currentQuestionIndex
    ));
}

echo $twig->render('index.html.twig', array(
        'loadDataStatus' => $loadDataStatus,
        'loadDataError' => $loadDataError
));
