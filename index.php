<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/php/model.php';
if (!isset($_SESSION)) {
    session_start();
}
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$loaddata = True;
$error = "None";

try {
    $questfile = new QuestionFile("files/questions.txt");
} catch (NoFileException $e) {
    $loaddata = False;
    $error = $e->getMessage();
} catch (NoFileAccessException $e) {
    $loaddata = False;
    $error = $e->getMessage();
}

if (!$loaddata) {
    echo $twig->render('index.html.twig', array(
        'loaddata' => $loaddata,
        'dataerror' => $error
    ));
    exit;
}

if (!$questfile->properSize()) {
    $loaddata = False;
    $error = $questfile->error();
} else {
    $nqst = $questfile->amountQuestions();
    $questions = array();

    for ($i = 0; $i < $nqst; $i++) {
        $questions[$i] = new Question($questfile->readQuestion());
    }

    $_SESSION['questions'] = $questions;
}

echo $twig->render('index.html.twig', array(
        'loaddata' => $loaddata,
        'dataerror' => $error
));
