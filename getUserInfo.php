<?php
  $servername = "mysql:dbname=camagru;host=localhost:3307";
  $username = "root";
  $password = "rootroot";

  try {
    $dbh = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
  }

  $sth = $dbh->prepare("SELECT * FROM account WHERE username = :username");
  $sth->bindParam(':username', $_POST['username']);
  $sth->execute();

  $result = $sth->fetch();
  echo json_encode($result);
?>
