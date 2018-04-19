<?php
require_once('connectDB.php');

class User {

	private $db;

	function __construct($dbh) {
		$this->db = $dbh;
  }

  function CreateUser($username, $password, $confirmPassword, $email) {
    $securityErr = $this->SecurityInputChecks($username, $password, $confirmPassword, $email);
    if ($securityErr != "Your account has been created, check your email.")
      return $securityErr;
	  $hash_password = password_hash($password, PASSWORD_BCRYPT);
		$accountKey = password_hash(microtime(TRUE)*100000 / rand(0, 100), PASSWORD_BCRYPT);
	  $req = $this->db->get_instance()->prepare('INSERT INTO account (username, password, email, accountKey) VALUES (:username, :password, :email, :accountKey)');
	  $req->bindParam(':username', $username);
	  $req->bindParam(':password', $hash_password);
		$req->bindParam(':email', $email);
	  $req->bindParam(':accountKey', $accountKey);
	  $req->execute();


		// Send mail
		$destinataire = $email;
		$sujet = "Activer votre compte" ;
		$entete = "From: activation@camagru.com" ;

		// Le lien d'activation est composé du login(log) et de la clé(cle)
		$message = 'Hi,

		Activate your account you foool.

		http://localhost:8080/validation.php?log='.urlencode($username).'&cle='.urlencode($accountKey).'


		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
		mail($destinataire, $sujet, $message, $entete) ;
		return $securityErr;
  }


  function AlreadyExistCheck($username, $email) {
    $emailValue = 0;
    $usernameValue = 0;

	  $usernameExist = $this->db->get_instance()->prepare("SELECT id FROM account WHERE username = :username");
	  $usernameExist->bindParam('username', $username);
	  $usernameExist->execute();
    $usernameValue = ($usernameExist->fetch(PDO::FETCH_ASSOC)["id"]);

	  $emailExist = $this->db->get_instance()->prepare("SELECT id FROM account WHERE email = :email");
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
	  return "Your account has been created, check your email.";
   }
}

$dbh = new HandleDB();
$newUser = new User($dbh);
echo $newUser->CreateUser($_POST['username'],$_POST['password'], $_POST['confirmPassword'], $_POST['email']);
?>
