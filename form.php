<?php
// include "config.php";

class User {
	private $db;

	function __construct($db) {
		$this->db = $db;
  }

  function CreateUser($username, $password, $confirmPassword, $email) {
    $securityErr = $this->SecurityInputChecks($username, $password, $confirmPassword, $email);
    if ($securityErr != "OK")
      return $securityErr;
	  $hash_password = password_hash($password, PASSWORD_BCRYPT);
	  $req = $this->db->prepare('INSERT INTO account (username, password, email) VALUES (:username, :password, :email)');
	  $req->bindParam(':username', $username);
	  $req->bindParam(':password', $hash_password);
	  $req->bindParam(':email', $email);
	  $req->execute();
  }


  function AlreadyExistCheck($username, $email) {
    $emailValue = 0;
    $usernameValue = 0;

	  $usernameExist = $this->db->prepare("SELECT id FROM account WHERE username = :username");
	  $usernameExist->bindParam('username', $username);
	  $usernameExist->execute();
    $usernameValue = ($usernameExist->fetch(PDO::FETCH_ASSOC)["id"]);

	  $emailExist = $this->db->prepare("SELECT id FROM account WHERE email = :email");
	  $emailExist->bindParam('email', $email);
	  $emailExist->execute();
    $emailValue = ($emailExist->fetch(PDO::FETCH_ASSOC)["id"]);
	  if($emailValue > 0) {
		  return "Email already used";
	 }

	 if ($usernameValue > 0) {
		 return "Username already exist";
	 }
	 return "OK";
   }

  function SecurityInputChecks($username, $password, $confirmPassword, $email) {
    $userAlreadyExist = $this->AlreadyExistCheck($username, $email);
    if ($userAlreadyExist != "OK")
      return $userAlreadyExist;
    // need to check if all fields are fill
	  // if (!$username || !$password || $confirmPassword || !$email)
	  //   return -1;
	  /* CHECK EMAIL */
	  if (!(preg_match('/[@]/', $email)))
		  return "You need an @ in your email adress";

	  /* CHECK USERNAME */
	  if (strlen($username) < 3)
		  return "You're username need to have at least 3 caracters";

	  /* CHECK PASSWORD */
	  if ($password != $confirmPassword)
		  return "The password do not match";

	  if (!(preg_match('/[A-Z]/', $password)))
		  return "The password need an uppercase";

	  if (!(preg_match('/[0-9]/', $password)))
		  return "The password need a number";

	  if (strlen($password) < 5)
		  return "The password need to have at least 5 caracters";
	  return "OK";
   }
}



// TO CHANGE
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
?>
