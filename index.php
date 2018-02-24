<?php session_start();
    if ($_SESSION['id'] == '' || $_SESSION['pseudo'] == '') {
      echo '-1';
    }
    else {
       echo json_encode(array('id' => $_SESSION['id'], 'username' => $_SESSION['pseudo']));
    }
?>
