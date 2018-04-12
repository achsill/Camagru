<?php
$servername = "mysql:host=localhost:3307";
$username = "root";
$password = "rootroot";

// Verifier si la db n'existe pas, si oui pas besoin de la créer !!!!
try {
  $dbh = new PDO($servername, $username, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Failed';
}

$dbh->exec("CREATE DATABASE IF NOT EXISTS camagru;");
$dbh->exec("USE camagru;");
$dbh->exec("CREATE TABLE IF NOT EXISTS account(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  accountKey VARCHAR(255) NOT NULL,
  activated INT(1) unsigned DEFAULT 0
  );
  ");
$dbh->exec("CREATE TABLE IF NOT EXISTS comment(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pictureID INT(11) UNSIGNED NOT NULL,
  userName VARCHAR(255) NOT NULL,
  comment VARCHAR(255) NOT NULL
  );
  ");
$dbh->exec("CREATE TABLE IF NOT EXISTS picture(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nbrOfLike INT(11) UNSIGNED NOT NULL,
  nbrOfComments INT(11) UNSIGNED NOT NULL,
  name varchar(255) NOT NULL
  );
  ");
$dbh->exec("CREATE TABLE IF NOT EXISTS likes(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pictureID INT(11) UNSIGNED NOT NULL,
  userID INT(11) UNSIGNED NOT NULL
  );
  ");
?>
