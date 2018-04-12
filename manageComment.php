<?php
  $servername = "mysql:dbname=camagru;host=localhost:3307";
  $username = "root";
  $password = "rootroot";

  try {
    $dbh = new PDO($servername, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo 'Failed';
  }

  $req = $dbh->prepare('SELECT username FROM account WHERE id = :id');
  $req->bindParam(':id', $_POST['userId']);
  $req->execute();
  $user = $req->fetch();

  $req = $dbh->prepare('INSERT INTO comment (comment, pictureID, userName) VALUES (:commentText, :idPicture, :userName)');
  $req->bindParam(':commentText', $_POST['commentText']);
  $req->bindParam(':idPicture', $_POST['pictureId']);
  $req->bindParam(':userName', $user['username']);
  $req->execute();
?>
