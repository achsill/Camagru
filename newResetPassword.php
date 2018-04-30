<?php
require_once('connectDB.php');
require_once('config/database.php');

$db = new HandleDB($database);

$usernameExist = $db->get_instance()->prepare("SELECT * FROM account WHERE email = :email");
$newLog = htmlspecialchars($_POST["log"]);
$usernameExist->bindParam('email', $newLog);
$usernameExist->execute();
$accountKey = $usernameExist->fetch();
$newPassword = $_POST["resetPassword"];
$newConfirmPassword = $_POST["resetConfirmPassword"];

if (strcmp($accountKey["resetToken"], htmlspecialchars($_POST["cle"])) == 0) {
  if (strcmp($newPassword, $newConfirmPassword) == 0) {
      if (!(preg_match('/[A-Z]/', $newPassword))) {
        echo "The password need an uppercase";
        return;
      }
      if (!(preg_match('/[0-9]/', $newPassword))) {
        echo "The password need a number";
        return;
      }
      if (strlen($newPassword) < 5) {
        echo "The password need to have at least 5 caracters";
        return;
      }
    $usernameExist = $db->get_instance()->prepare("UPDATE account SET password = :password WHERE email = :email");
    $hash_password = password_hash($newPassword, PASSWORD_BCRYPT);
    $usernameExist->bindParam('password', $hash_password);
    $usernameExist->bindParam('email', htmlspecialchars($newLog));
    $usernameExist->execute();
    echo "password changes";
    return;
  }
  else {
    echo "Password do not match";
    return 1;
  }
}

?>
