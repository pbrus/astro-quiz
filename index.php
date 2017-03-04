<?php

use Brus\Session;
use AstroQuiz\QuestionFile;
use AstroQuiz\Question;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$loadData = True;
$error = "None";

try {
    $questFile = new QuestionFile("files/questions.txt");
} catch (Brus\NoFileException $e) {
    $loadData = False;
    $error = $e->getMessage();
} catch (Brus\NoFileAccessException $e) {
    $loadData = False;
    $error = $e->getMessage();
}

if (!$loadData) {
    echo $twig->render('index.html.twig', array(
        'loadData' => $loadData,
        'dataError' => $error
    ));
    exit;
}

if (!$questFile->properSize()) {
    $loadData = False;
    $error = $questFile->error();
} else {
    $nQuest = $questFile->amountQuestions();
    $arrQuest = array();
    $idx = 0;

    for ($i = 0; $i < $nQuest; $i++) {
        $arrQuest[$i] = new Question($questFile->readQuestion());
    }

    Session::addVar(array(
        'nQuest' => $nQuest,
        'arrQuest' => $arrQuest,
        'idx' => $idx
    ));
}

echo $twig->render('index.html.twig', array(
        'loadData' => $loadData,
        'dataError' => $error
));
