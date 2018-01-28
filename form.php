<?php
include "config.php";

class User {
  // private $username;
  // private $email;
  // private $password;

  // function __construct($username, $email) {
  //   $this->username = $username;
  //   $this->email = $email;
  // }

  function createUser($usr, $password, $email) {
    $hash_password = password_hash($password, PASSWORD_BCRYPT);
    $req = $db->prepare('INSERT INTO account (username, password, email) VALUES (:username, :password, :email)');
    $req->bindParam(':username', $usr);
    $req->bindParam(':password', $hash_password);
    $req->bindParam(':email', $email);
    $req->execute();
  }
}


$newUser = new User();
$newUser->createUser($_POST['username'],$_POST['password'],$_POST['email'])
?>
