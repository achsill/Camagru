<?php

session_start();
$servername = "mysql:dbname=camagru;host=localhost:3307";
$username = "root";
$password = "rootroot";

try {
  $dbh = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
  echo 'Connexion échouée : ' . $e->getMessage();
}

if ($_POST["email"] != "") {
  $req = $dbh->prepare("SELECT * FROM account WHERE email = :email");
  $req->bindParam("email", $_POST["email"]);
  $req->execute();
  $row = $req->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    echo "This email is already used";
    // return ;
  }

  $req = $dbh->prepare("UPDATE account SET email = :email WHERE username = :actualUser");
  $req->bindParam(':email', $_POST["email"]);
  $req->bindParam(':actualUser', $_POST["actualUsername"]);
  $req->execute();
}

if ($_POST["username"] != "") {
  $req = $dbh->prepare("SELECT * FROM account WHERE username = :username");
  $req->bindParam("username", $_POST["username"]);
  $req->execute();
  $row = $req->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    echo "This username is already used";
    // return ;
  }

  $req = $dbh->prepare("UPDATE account SET username = :username WHERE username = :actualUser");
  $req->bindParam(':username', $_POST["username"]);
  $req->bindParam(':actualUser', $_POST["actualUsername"]);
  $req->execute();
  $_SESSION["pseudo"] = $_POST["username"];
}

echo $_POST["oldPassword"];
echo  $_POST["newPassword"];

if ($_POST["oldPassword"] != "" && $_POST["newPassword"] != ""){
  echo "hein";
  $req = $dbh->prepare("SELECT * FROM account WHERE username = :username");
  $req->bindParam("username", $_POST["username"]);
  $req->execute();
  $row = $req->fetch(PDO::FETCH_ASSOC);

  $hash_newpassword = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
  echo $row["password"];
  if (!password_verify($_POST["oldPassword"], $row["password"])) {
    echo "Wrong password";
    return ;
  }
  else {
    echo "ca passe ici";
    $req = $dbh->prepare("UPDATE account SET password = :password WHERE username = :username");
    $req->bindParam(':password', $hash_newpassword);
    $req->bindParam(':username', $_POST["username"]);
    $req->execute();
  }
}



echo $_POST["username"];
?>
