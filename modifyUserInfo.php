<?php

session_start();
$servername = "mysql:dbname=camagru;host=localhost:3307";
$username = "root";
$password = "rootroot";

try {
  $dbh = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
  echo 'Connexion échouée : ' . $e->getMessage();
}


if ($_POST["email"] != "") {
  $req = $dbh->prepare("UPDATE account SET email = :email WHERE username = :actualUser");
  $req->bindParam(':email', $_POST["email"]);
  $req->bindParam(':actualUser', $_POST["actualUsername"]);
  $req->execute();
}

if ($_POST["username"] != "") {
  $req = $dbh->prepare("UPDATE account SET username = :username WHERE username = :actualUser");
  $req->bindParam(':username', $_POST["username"]);
  $req->bindParam(':actualUser', $_POST["actualUsername"]);
  $req->execute();
  $_SESSION["pseudo"] = $_POST["username"];
}


echo $_POST["username"];

?>
