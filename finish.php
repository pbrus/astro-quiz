<?php

use Brus\Session;
use AstroQuiz\DatabaseFile;
require_once __DIR__.'/vendor/autoload.php';
Session::start();
$user = @Session::getVar('user');
if (isset($user) === FALSE) {
    header('Location: index.php');
    exit;
}

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$accessDatabaseError = NULL;
$allQuestions = Session::getVar('allQuestions');

try {
    $databaseFile = new DatabaseFile("database/database", "a");
    $databaseFile->saveUserData($user, $allQuestions);
} catch (AstroQuiz\FailureDataSavingException $err) {
    $accessDatabaseError = $err->getMessage();
} catch (Brus\NoFileException $err) {
    $accessDatabaseError = $err->getMessage();
} catch (Brus\NoFileAccessException $err) {
    $accessDatabaseError = $err->getMessage();
}

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
        'perQuestions' => $perQuestions,
        'accessDatabaseError' => $accessDatabaseError
));

Session::stop();
