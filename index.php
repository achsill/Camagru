<?php
  session_start();
  $dir    = 'user_pictures';
  $files = scandir($dir);

  $servername = "mysql:dbname=camagru;host=localhost:3307";
  $username = "root";
  $password = "rootroot";

  try {
  	$dbh = new PDO($servername, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (PDOException $e) {
  	echo 'Connexion échouée : ' . $e->getMessage();
  }

  $sth = $dbh->prepare("SELECT * FROM picture");
  $sth->execute();

  // $infoPicture = $sth->fetchAll(PDO::FETCH_ASSOC);
  // $jsonPicture = (array)json_encode($infoPicture);
  // $comList = $sth->fetchAll(PDO::FETCH_ASSOC);
  //
  // $jsonPicture = (array)$jsonPicture[0];
  // echo $picture[0];
  // foreach ($jsonPicture as $picture) {
  //   // echo $picture . "\n\n\n";
  // }

  $pictureEnd = array();
  while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    $tmp = $dbh->prepare("SELECT * FROM comment WHERE pictureID = :pictureID");
    $tmp->bindParam(':pictureID', $row['id']);
    $tmp->execute();
    $picture = new stdClass();
    $picture->id = $row['id'];
    $picture->name = $row['name'];
    $tmpCom = array();
    while ($pictureCom = $tmp->fetch(PDO::FETCH_ASSOC)) {
      array_push($tmpCom, $pictureCom);
    }
    $picture->com = $tmpCom;
    array_push($pictureEnd, $picture);
  }

  
  if ($_SESSION['id'] == '' || $_SESSION['pseudo'] == '') {
    echo json_encode(array('connected' => "-1", 'files' => json_encode($infoPicture)));
  }
  else {
     echo json_encode(array('connected' => '1', 'id' => $_SESSION['id'], 'username' => $_SESSION['pseudo'], 'files' => json_encode($pictureEnd)));
  }
?>
