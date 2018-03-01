<?php session_start();
  $dir    = 'user_pictures';
  $files = scandir($dir);
  if ($_SESSION['id'] == '' || $_SESSION['pseudo'] == '') {
    echo json_encode(array('connected' => "-1", 'files' => json_encode($files)));
  }
  else {
     echo json_encode(array('connected' => '1', 'id' => $_SESSION['id'], 'username' => $_SESSION['pseudo'], 'files' => json_encode($files)));
  }
?>
