<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="validation.css">
    <link rel="stylesheet" type="text/css" href="font.css">
    <meta charset="utf-8">
    <script type="text/javascript" src="login.js">
    </script>
    <title></title>
  </head>
  <body>
    <div class="modalConfirmation">
<?php
  require_once('connectDB.php');
  require_once('config/database.php');

  private $db = new HandleDB($database);

  $usernameExist = $db->get_instance()->prepare("SELECT accountKey FROM account WHERE username = :username");
  $usernameExist->bindParam('username', htmlspecialchars($_GET["log"]));
  $usernameExist->execute();
  $accountKey = ($usernameExist->fetch(PDO::FETCH_ASSOC)["accountKey"]);
  if ($accountKey == htmlspecialchars($_GET["cle"])) {
    $usernameExist = $db->get_instance()->prepare("UPDATE account SET activated='1' WHERE username = :username");
    $usernameExist->bindParam('username', htmlspecialchars($_GET["log"]));
    $usernameExist->execute();
    echo "<p class='sucess'>Your account has been successfully activated !</p>";
    }
  else {
    echo "<p class='error'>An error has occured, please check your url.</p>";
  }

?>
  <button onClick="gestionClic()" class="redirectButton">HOME</button>
  </div>
  </body>
</html>
