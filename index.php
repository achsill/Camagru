<?php
  require_once('connectDB.php');
  require_once('config/database.php');
  session_start();

  $dir    = 'user_pictures';
  $files = scandir($dir);
  $dbh = new HandleDB($database);

function GetNbrOfLikes($id, $dbh) {
  $likes = array();
  $sth = $dbh->get_instance()->prepare("SELECT * FROM likes");
  $sth->execute();

  while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
  	$thelike = new stdClass();
  	if (!is_null($row["pictureID"])) {
  		$reqTmp = $dbh->get_instance()->prepare("SELECT * FROM likes WHERE pictureID = :pictureID");
  		$reqTmp->bindParam(":pictureID", $id);
  		$reqTmp->execute();
  		$count = 0;
  		while ($data = $reqTmp->fetch()) {
  			$count = $count+1;
  		}
      return $count;
  	}
    else {
      return 0;
    }
  }
}

  $sth = $dbh->get_instance()->prepare("SELECT * FROM picture");
  $sth->execute();
  $pictureEnd = array();

  $userIDrequest = $dbh->get_instance()->prepare("SELECT * FROM account WHERE username = :username");
  $userIDrequest->bindParam(':username', $_SESSION["pseudo"]);
  $userIDrequest->execute();
  $userID = $userIDrequest->fetch();



  while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    $tmp = $dbh->get_instance()->prepare("SELECT * FROM comment WHERE pictureID = :pictureID");
    $tmp->bindParam(':pictureID', $row['id']);
    $tmp->execute();

    $userRqt = $dbh->get_instance()->prepare('SELECT username FROM account WHERE id = :id');
    $userRqt->bindParam(':id', $row['userID']);
    $userRqt->execute();
    $user = $userRqt->fetch();

    $picture = new stdClass();
    if ($userID["id"] == $row["userID"])
      $picture->canDelete = 1;
    else
      $picture->canDelete = 0;
    $picture->id = $row['id'];
    $picture->name = $row['name'];
    $picture->username = htmlspecialchars($user["username"]);
    $picture->nbrLikes = GetNbrOfLikes($row['id'], $dbh);
    $tmpCom = array();
    while ($pictureCom = $tmp->fetch(PDO::FETCH_ASSOC)) {
      $newCom = new stdClass();
      $newCom->id = $pictureCom["id"];
      $newCom->pictureID = $pictureCom["pictureID"];
      $newCom->userName = htmlspecialchars($pictureCom["userName"]);
      $newCom->comment = htmlspecialchars($pictureCom["comment"]);
      array_push($tmpCom, $newCom);
    }
    $picture->com = $tmpCom;
    array_push($pictureEnd, $picture);
  }

  $filePath = realpath($userID["profilPicture"]);
  if ($filePath) {
    $userPic = $userID["profilPicture"];
  }
  else {
    $userPic = NULL;
  }

  if ($_SESSION['id'] == '' || $_SESSION['pseudo'] == '') {
    echo json_encode(array('connected' => "-1", 'files' => json_encode($pictureEnd)));
  }
  else {
     echo json_encode(array('connected' => '1', 'id' => $_SESSION['id'], 'username' => htmlspecialchars($_SESSION['pseudo']), "profilPicture" => $userPic, 'files' => json_encode($pictureEnd)));
  }
?>
