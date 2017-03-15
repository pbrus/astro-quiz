<?php

use Brus\Session;
require_once __DIR__.'/vendor/autoload.php';
Session::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$user = Session::getVar('user');
$allQuestions = Session::getVar('allQuestions');
$amountQuestions = Session::getVar('amountQuestions');
$score = 0;
$numberCorrectQuestions = 0;
$maxScore = 0;

for ($i = 0; $i < $amountQuestions; $i++) {
    $maxScore += $allQuestions[$i]->weight();
    if ($allQuestions[$i]->evaluate() != 0) {
        $score += $allQuestions[$i]->evaluate();
        $numberCorrectQuestions++;
    }
}

$perScore = (int)(100 * $score / $maxScore);
$perQuestions = (int)(100 * $numberCorrectQuestions / $amountQuestions);

echo $twig->render('finish.html.twig', array(
        'user' => $user,
        'score' => $score,
        'maxScore' => $maxScore,
        'perScore' => $perScore,
        'numberCorrectQuestions' => $numberCorrectQuestions,
        'amountQuestions' => $amountQuestions,
        'perQuestions' => $perQuestions
));

use AstroQuiz\DatabaseFile;
$databaseFile = new DatabaseFile("database/database");
$databaseFile->saveUserData($user, $allQuestions);

//Session::stop();
