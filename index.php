<?php
  require_once('connectDB.php');
  session_start();

  $dir    = 'user_pictures';
  $files = scandir($dir);
  $dbh = new HandleDB();


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
  while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    $tmp = $dbh->get_instance()->prepare("SELECT * FROM comment WHERE pictureID = :pictureID");
    $tmp->bindParam(':pictureID', $row['id']);
    $tmp->execute();
    $picture = new stdClass();
    $picture->id = $row['id'];
    $picture->name = $row['name'];
    $picture->nbrLikes = GetNbrOfLikes($row['id'], $dbh);
    $tmpCom = array();
    while ($pictureCom = $tmp->fetch(PDO::FETCH_ASSOC)) {
      array_push($tmpCom, $pictureCom);
    }
    $picture->com = $tmpCom;
    array_push($pictureEnd, $picture);
  }

  if ($_SESSION['id'] == '' || $_SESSION['pseudo'] == '') {
    echo json_encode(array('connected' => "-1", 'files' => json_encode($pictureEnd)));
  }
  else {
     echo json_encode(array('connected' => '1', 'id' => $_SESSION['id'], 'username' => $_SESSION['pseudo'], 'files' => json_encode($pictureEnd)));
  }
?>
