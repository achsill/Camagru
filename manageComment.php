<?php
  require_once('connectDB.php');
  require_once('config/database.php');

  $dbh = new HandleDB($database);

  $req = $dbh->get_instance()->prepare('SELECT * FROM account WHERE id = :id');
  $req->bindParam(':id', $_POST['userId']);
  $req->execute();
  $user = $req->fetch();

  $req = $dbh->get_instance()->prepare('INSERT INTO comment (comment, pictureID, userName) VALUES (:commentText, :idPicture, :userName)');
  $req->bindParam(':commentText', $_POST['commentText']);
  $req->bindParam(':idPicture', $_POST['pictureId']);
  $req->bindParam(':userName', $user['username']);
  $req->execute();

  $req = $dbh->get_instance()->prepare('SELECT * FROM picture WHERE id = :id');
  $req->bindParam(':id', $_POST['pictureId']);
  $req->execute();
  $getUser = $req->fetch();

  $userId = $getUser["userID"];

  $req = $dbh->get_instance()->prepare('SELECT * FROM account WHERE id = :id');
  $req->bindParam(':id', $userId);
  $req->execute();
  $getMail = $req->fetch();

  if ($getMail["emailOnCom"] == 1) {
    $email = $getMail["email"];

    // Send mail
    $destinataire = $email;
    $sujet = "Nouveau commentaire !" ;
    $entete = "From: activation@camagru.com" ;

    // Le lien d'activation est composé du login(log) et de la clé(cle)
    $message = 'Hi,

    Someone commented one of your pictures !.

    ---------------
    This is an automatic mail, please do not answer.';
    mail($destinataire, $sujet, $message, $entete) ;
  }

?>
