<?php




$servername = "mysql:dbname=camagru;host=localhost:3306";
$username = "root";
$password = "root";


try {
    $db = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

function getDatabase() {
  return $db;
}

// Verifier si la db n'existe pas, si oui pas besoin de la créer !!!!
// $dbh = new PDO("mysql:host=localhost:3306", $username, $password);
// $dbh->exec("CREATE DATABASE camagru;");
// try
// {
// 	// On se connecte à MySQL
//   // Verifier si la table n'existe pas, si oui pas besoin de la créer !!!!
//   $db = new PDO($servername, $username, $password);
//   // $db->setAttribute(PDO::ERRMODE_EXCEPTION);
//
// }
// catch(Exception $e)
// {
// 	// En cas d'erreur, on affiche un message et on arrête tout
//   die('Erreur : '.$e->getMessage());
// }

?>
