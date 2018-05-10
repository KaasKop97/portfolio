<?php
require_once 'vendor/autoload.php';
require_once 'helpers/dbHelper.php';
$db = new dbHelper();
$loader = new Twig_Loader_Filesystem("public");
$twig = new Twig_Environment($loader);

$test = $db->getFromDb("SELECT ID, name, picture FROM projecten");

if($test->rowCount() != 0)  {
    try {
        echo $twig->render('index.html.twig', array('projects' => $test->fetchAll()));
    } catch (Exception $e)  {
        echo $e->getMessage();
    }
} else {
    try {
        echo $twig->render('index.html.twig', array('projects' => "ERROR: No projects found"));
    } catch (Exception $e)  {
        echo $e->getMessage();
    }

}

