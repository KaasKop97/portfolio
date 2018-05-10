<?php
require_once 'vendor/autoload.php';
require_once 'helpers/dbHelper.php';

$db = new dbHelper();
$loader = new Twig_Loader_Filesystem("public");
$twig = new Twig_Environment($loader);

$rowCount = $db->getFromDb("SELECT id FROM projecten")->rowCount();

if($_GET["id"] <= $rowCount) {
    $test = $db->getFromDb("SELECT * FROM projecten WHERE id=" . htmlspecialchars($_GET["id"]))->fetchAll();
    try {
        echo $twig->render('project-details.html.twig', array('project' => $test[0]));
    } catch (Exception $e)  {
        echo $e->getMessage();
    }
} else {
    try {
        echo $twig->render('error.html.twig', array('error_description' => "ID Out of bounds."));
    } catch (Exception $e)  {
        echo $e->getMessage();
    }
}
