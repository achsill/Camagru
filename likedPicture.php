<?php
$servername = "mysql:dbname=camagru;host=localhost:3307";
$username = "root";
$password = "rootroot";

try {
	$db = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}

$usernameExist = $db->prepare("SELECT nbrOfLike FROM picture WHERE id = :id");
$usernameExist->bindParam('id', htmlspecialchars($_POST['id']));
$usernameExist->execute();
$newNbrOfLike = intval($usernameExist->fetch(PDO::FETCH_ASSOC)["nbrOfLike"]) + 1;

$usernameExist = $db->prepare("UPDATE picture SET nbrOfLike = :nbrOfLike WHERE id = :id");
$usernameExist->bindParam('id', htmlspecialchars($_POST['id']));
$usernameExist->bindParam('nbrOfLike', $newNbrOfLike);
$usernameExist->execute();
?>
