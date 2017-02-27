<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/php/model.php';
require_once __DIR__.'/php/session.php';
SimpleSession::start();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);


echo $twig->render('question.html.twig', array(

));
