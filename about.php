<?php
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem("public");
$twig = new Twig_Environment($loader);

try {
    echo $twig->render('about.html.twig');
} catch (Exception $e)  {
    echo $e->getMessage();
}
