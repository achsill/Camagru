<?php
require_once('connectDB.php');
require_once('config/database.php');
session_start();

$dbh = new HandleDB($database);

echo $_POST["pictureName"];

$req = $dbh->get_instance()->prepare('UPDATE account SET profilPicture = :profilPicture WHERE username = :username');
$req->bindParam(':profilPicture', $_POST["pictureName"]);
$req->bindParam(':username', $_SESSION["pseudo"]);
$req->execute();

?>
