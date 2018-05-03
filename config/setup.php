<?php

include(realpath(dirname(__FILE__) . '/../connectDB.php'));
include(realpath(dirname(__FILE__) . '/database.php'));

$dbh = new HandleDB($database);

$dbh->get_instance()->exec("CREATE DATABASE IF NOT EXISTS camagru;");
$dbh->get_instance()->exec("USE camagru;");
$dbh->get_instance()->exec("CREATE TABLE IF NOT EXISTS account(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  accountKey VARCHAR(255) NOT NULL,
  profilPicture VARCHAR(255) NULL,
  resetToken VARCHAR(255) NULL,
  emailOnCom INT(1) unsigned DEFAULT 1,
  activated INT(1) unsigned DEFAULT 0
  );
  ");
$dbh->get_instance()->exec("CREATE TABLE IF NOT EXISTS comment(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pictureID INT(11) UNSIGNED NOT NULL,
  userName VARCHAR(255) NOT NULL,
  comment VARCHAR(255) NOT NULL
  );
  ");
$dbh->get_instance()->exec("CREATE TABLE IF NOT EXISTS picture(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nbrOfLike INT(11) UNSIGNED NOT NULL,
  userID INT(11) UNSIGNED NOT NULL,
  name varchar(255) NOT NULL
  );
  ");
$dbh->get_instance()->exec("CREATE TABLE IF NOT EXISTS likes(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pictureID INT(11) UNSIGNED NOT NULL,
  userID INT(11) UNSIGNED NOT NULL
  );
  ");
?>
