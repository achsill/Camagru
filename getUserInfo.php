<?php
  require_once('config/database.php');
  require_once('connectDB.php');

  $dbh = new HandleDB($database);

  $sth = $dbh->get_instance()->prepare("SELECT * FROM account WHERE username = :username");
  $sth->bindParam(':username', $_POST['username']);
  $sth->execute();

  $result = $sth->fetch();
  echo json_encode($result);
?>
