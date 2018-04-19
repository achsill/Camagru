<?php
  $database = new stdClass();
  $database->servername = "mysql:dbname=camagru;host=localhost:3307";
  $database->username = "root";
  $database->password = "rootroot";
  $database->options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
?>
