
<?php
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
	session_start();
	$_SESSION['id'] = $result['id'];
 	$_SESSION['pseudo'] = $_POST['email'];
	echo "1";
}
else {
	echo "wrong password";
}
?>
