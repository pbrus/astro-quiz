<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/model.php';
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);
$state = True;
$error = "None";

$questfile = new File("questions.txt");
if (!$questfile->readable())
{
	$state = False;
	$error = $questfile->error();
}

echo $twig->render('index.html.twig', array(
		'state' => $state,
		'error' => $error
));
