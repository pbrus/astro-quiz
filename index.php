<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/model.php';
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);
$state = True;
$error = "None";

$questfile = new QuestionFile("questions.txt");

if (!($questfile->readable() && $questfile->properSize())) {
    $state = False;
    $error = $questfile->error();
} else {
    $nqst = $questfile->amountQuestions();
    $questions = array();
    
    for ($i = 0; $i < $nqst; $i++) {
        $questions[$i] = new Question($questfile->readQuestion());
    }
}

echo $twig->render('index.html.twig', array(
        'state' => $state,
        'error' => $error
));
