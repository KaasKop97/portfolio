<?php
require_once 'vendor/autoload.php';
require_once 'helpers/dbHelper.php';

$db = new dbHelper();
$loader = new Twig_Loader_Filesystem("public");
$twig = new Twig_Environment($loader);

session_start();
if (!empty($_SESSION) and $_SESSION["loggedin"] == 1) {
    if (!empty($_POST)) {
        if (count($_POST) == 5 and isset($_FILES["projectpicture"])) {
            $validPostValues = ["projectname", "projectteam", "projectfinished", "projectfiles", "projectdescription"];
            $error = false;
            foreach ($validPostValues as $validValues)  {
                if(empty($_POST[$validValues]))  {
                    $error = true;
                }
            }
            if ($error) {
                print("ERROR: All fields are required");
            } else {
                if($_FILES["projectpicture"]["type"] == "image/jpeg" or $_FILES["projectpicture"]["type"] == "image/png" and $_FILES["projectpicture"]["error"] == 0)   {
                    $file_extension = pathinfo($_FILES["projectpicture"]["name"])["extension"];
                    move_uploaded_file($_FILES["projectpicture"]["tmp_name"], "public/img/projects/" . $_POST["projectname"] . "." . $file_extension);
                    $db->queryDb("INSERT INTO projecten
                (name, team, description, date_started, date_completed, picture, url)
                VALUES(" . $db->conn->quote($_POST['projectname']) . ", " . $db->conn->quote($_POST['projectteam']) . ", " . $db->conn->quote($_POST['projectdescription']) . ", " . $db->conn->quote($_POST['projectfinished']) . ", " . $db->conn->quote($_POST['projectfinished']) . ", " . $db->conn->quote("public/img/projects/" . $_POST["projectname"] . "." . $file_extension) . ", " . $db->conn->quote($_POST['projectfiles']) . ");");
                print("Insertion succesfull. ( ͡° ͜ʖ ͡°)");
                }
            }
        } else {
            print("ERROR: Not enough values. Did you forget to enter one or more?");
        }

    }
    try {
        echo $twig->render('admin.html.twig');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "Go away";
}
