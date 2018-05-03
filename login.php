
<?php
require_once('connectDB.php');
require_once('config/database.php');

$db = new HandleDB($database);
$req = $db->get_instance()->prepare('SELECT id, password, activated FROM account WHERE username = :username');
$req->bindParam(':username', $_POST['email']);
$req->execute();
$result = $req->fetch();


$isValid = password_verify($_POST['password'], $result['password']);
if ($isValid) {
	if (intval($result["activated"]) == 0) {
		echo "-1";
		return 1;
	}
	session_start();
	$_SESSION['id'] = $result['id'];
 	$_SESSION['pseudo'] = htmlspecialchars($_POST['email']);
	echo "1";
}
else {
	echo "wrong password";
}
?>
