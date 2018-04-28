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

echo strcmp(trim($accountKey["resetToken"]), trim(htmlspecialchars($_POST["cle"]))) . "\n";
echo "db = " .trim($accountKey["resetToken"]) . "\n";
echo "pas db = " . trim($_POST["cle"]) . "\n";
if (strcmp($accountKey["resetToken"], htmlspecialchars($_POST["cle"])) == 0) {
  echo $newPassword . " - " . $newConfirmPassword;
  if (strcmp($newPassword, $newConfirmPassword) == 0) {
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

echo $newPassword . " - " . $newConfirmPassword;
echo "HEINNN";
?>
