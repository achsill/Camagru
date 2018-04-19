<?php
  require_once('connectDB.php');

  $dbh = new HandleDB();

  $req = $dbh->get_instance()->prepare('SELECT username FROM account WHERE id = :id');
  $req->bindParam(':id', $_POST['userId']);
  $req->execute();
  $user = $req->fetch();

  $req = $dbh->get_instance()->prepare('INSERT INTO comment (comment, pictureID, userName) VALUES (:commentText, :idPicture, :userName)');
  $req->bindParam(':commentText', $_POST['commentText']);
  $req->bindParam(':idPicture', $_POST['pictureId']);
  $req->bindParam(':userName', $user['username']);
  $req->execute();
?>
