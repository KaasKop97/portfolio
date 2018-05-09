<?php
require_once 'vendor/autoload.php';
require_once 'helpers/dbHelper.php';
$db = new dbHelper();
$loader = new Twig_Loader_Filesystem("public");
$twig = new Twig_Environment($loader);

$test = $db->getFromDb("SELECT * FROM projecten")->fetchAll();

try {
    echo $twig->render('index.html.twig', array('projects' => $test));
} catch (Exception $e)  {
    echo $e->getMessage();
}

