<?php
$email = $_POST["email"];


require_once('connectDB.php');
require_once('config/database.php');

$dbh = new HandleDB($database);

// Send mail
$destinataire = $email;
$sujet = "Password forgot !" ;
$entete = "From: activation@camagru.com" ;
$accountKey = htmlspecialchars(password_hash(microtime(TRUE)*100000 / rand(1, 100), PASSWORD_BCRYPT));

$req = $dbh->get_instance()->prepare("SELECT * FROM account WHERE email = :email");
$req->bindParam(':email', $email);
$req->execute();
$checkErr = $req->fetch();

if (strcmp($checkErr["username"], "") == 0) {
  echo "This email adress does not exist";
  return 1;
}


$req = $dbh->get_instance()->prepare("UPDATE account SET resetToken = :resetToken WHERE email = :email");
$req->bindParam(':resetToken', $accountKey);
$req->bindParam(':email', $email);
$req->execute();

// Le lien d'activation est composé du login(log) et de la clé(cle)
$message = 'Hi,

Here is a link to change your password.

http://localhost:8080/resetPassword.php?log='.urlencode($email).'&cle='.urlencode($accountKey).'
---------------
This is an automatic mail, please do not answer.';
mail($destinataire, $sujet, $message, $entete) ;

echo "An email has been sent !";
?>
