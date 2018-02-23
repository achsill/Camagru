
<?php
// include "init.php";
$servername = "mysql:dbname=camagru;host=localhost:3307";
$username = "root";
$password = "rootroot";

try {
	$db = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}

$req = $db->prepare('SELECT id, password FROM account WHERE username = :username');
$req->bindParam(':username', $_POST['email']);
$req->execute();
$result = $req->fetch();


$isValid = password_verify($_POST['password'], $result['password']);
if ($isValid) {
	$_SESSION['id'] = $resultat['id'];
 	$_SESSION['pseudo'] = $pseudo;
	echo "1";
}
else {
	echo "wrong password";
}
?>
