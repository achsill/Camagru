
<?php
require_once('connectDB.php');

$db = new HandleDB();
$req = $db->get_instance()->prepare('SELECT id, password FROM account WHERE username = :username');
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
