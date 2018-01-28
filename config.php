<?php

$servername = "mysql:host=localhost:3306;dbname=camagru;charset=utf8";
$username = "root";
$password = "root";

try
{
	// On se connecte à MySQL
  $db = new PDO($servername, $username, $password);
  // $db->setAttribute(PDO::ERRMODE_EXCEPTION);

}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
  echo "toto";
  die('Erreur : '.$e->getMessage());
}

?>
