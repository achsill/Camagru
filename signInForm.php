<?php

class User {
	private $db;

	function __construct($db) {
		$this->db = $db;
  }
}

$servername = "mysql:dbname=camagru;host=localhost:3306";
$username = "root";
$password = "root";

try {
	$db = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}
// TO CHANGE

$newUser = new User($db);
echo $newUser->CreateUser($_POST['username'],$_POST['password'], $_POST['confirmPassword'], $_POST['email']);
