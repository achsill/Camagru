<?php
  require_once('connectDB.php');

  $dbh = new HandleDB();

  $sth = $dbh->get_instance()->prepare("SELECT * FROM account WHERE username = :username");
  $sth->bindParam(':username', $_POST['username']);
  $sth->execute();

  $result = $sth->fetch();
  echo json_encode($result);
?>
