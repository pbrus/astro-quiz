<?php

use Brus\Session;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$allQuestions = Session::getVar('allQuestions');
$amountQuestions = Session::getVar('amountQuestions');
$score = 0;
$numberCorrectQuestions = 0;

for ($i = 0; $i < $amountQuestions; $i++) {
    if ($allQuestions[$i]->evaluate() != 0) {
        $score += $allQuestions[$i]->evaluate();
        $numberCorrectQuestions++;
    }
}

echo $twig->render('finish.html.twig', array(
        'user' => Session::getVar('user'),
        'score' => $score,
        'numberCorrectQuestions' => $numberCorrectQuestions,
        'amountQuestions' => $amountQuestions
));
