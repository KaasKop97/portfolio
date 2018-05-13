<?php
require_once 'vendor/autoload.php';
require_once 'helpers/dbHelper.php';

$db = new dbHelper();
$loader = new Twig_Loader_Filesystem("public");
$twig = new Twig_Environment($loader);

try {
    echo $twig->render('login.html.twig');
} catch (Exception $e) {
    echo $e->getMessage();
}

if (isset($_POST["username"]) and isset($_POST["password"])) {
    $cleanUsername = $db->conn->quote($_POST["username"]);
    $userDb = $db->queryDb("SELECT * FROM users WHERE username=" . $cleanUsername)->fetchAll();

    if (!empty($userDb)) {
        if ($userDb[0][1] == $_POST["username"]) {
            if (password_verify($_POST["password"], $userDb[0][2]) and $_POST["password"]) {
                session_start();
                $_SESSION["loggedin"] = true;
                header("Location: admin.php");
            }
        } else {
            echo "Credentials incorrect";
        }
    }
}
//$test = password_hash("Kaas123!", PASSWORD_DEFAULT);
//
//echo $test . "\n\n\n\n";
//
//if(password_verify("Kaas123!", $test))  {
//    echo "koelio";
//} else {
//    echo "nietkoelio";
//}
