<?php
require_once('connectDB.php');
require_once('config/database.php');
session_start();

$dir    = 'user_pictures';
$dbh = new HandleDB($database);

$tmp = $dbh->get_instance()->prepare("SELECT * FROM picture WHERE id = :id");
$tmp->bindParam('id', $_POST["pictureId"]);
$tmp->execute();
$user = $tmp->fetch();

$tmp = $dbh->get_instance()->prepare("SELECT * FROM account WHERE id = :id");
$tmp->bindParam('id', $user["userID"]);
$tmp->execute();
$username = $tmp->fetch();

if (strcasecmp($username["username"], $_SESSION["pseudo"]) == 0) {
  $tmp = $dbh->get_instance()->prepare("DELETE FROM picture WHERE id = :id");
  $tmp->bindParam('id', $_POST["pictureId"]);
  $tmp->execute();
}

?>
