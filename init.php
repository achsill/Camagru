<?php
$servername = "mysql:host=localhost:3306";
$username = "root";
$password = "root";

// Verifier si la db n'existe pas, si oui pas besoin de la créer !!!!
try {
  $dbh = new PDO($servername, $username, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Failed';
}
$dbh->exec("CREATE DATABASE camagru;");
$dbh->exec("USE camagru;");
$dbh->exec("CREATE TABLE account(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
  );
  ");
?>
