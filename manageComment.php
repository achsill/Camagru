<?php
  echo $_POST['commentText'], $_POST['id'];

  $servername = "mysql:dbname=camagru;host=localhost:3307";
  $username = "root";
  $password = "rootroot";

  try {
    $dbh = new PDO($servername, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo 'Failed';
  }
  $req = $dbh->prepare('INSERT INTO comment (comment, pictureID, userID) VALUES (:commentText, :idPicture, :userId)');
  $req->bindParam(':commentText', $_POST['commentText']);
  $req->bindParam(':idPicture', $_POST['pictureId']);
  $req->bindParam(':userId', $_POST['userId']);
  $req->execute();
?>
