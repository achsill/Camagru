<?php
include "config.php";

function SecurityCheck($username, $password, $email) {
  /* CHECK EMAIL */
  if (!(preg_match('/[@]/', $email))) {
    return "<p>Error MAIL</p>";
  }

  /* CHECK USERNAME */
  if (strlen($username) < 3) {
    return "<p>You're username need to have at least 3 caracters</p>";
  }

  /* CHECK PASSWORD */
  if (!$username || !$password || !$email) {
    return "Please complete all the fields";
  }
  if (!(preg_match('/[A-Z]/', $password))) {
    return "<p>You're password need an UNPPERCASE letter</p>";
  }
  if (!(preg_match('/[0-9]/', $password))) {
    return "<p>You're password need a number</p>";
  }
  if (strlen($password) < 5) {
    return "<p>You're password need to have at least 5 caracters</p>";
  }
  return "OK";
}

function AlreadyExistCheck($db, $username, $email) {
  echo "SELECT id FROM account WHERE username = '" . $username . "'";
  $usernameExist = $db->query("SELECT id FROM account WHERE username = '" . $username . "'");
  $emailExist = $db->query("SELECT id FROM account WHERE email = '"  . $email . "'");

  if($emailExist->num_rows > 0) {
    return "<p>Email already used</p>";
  }

  if ($usernameExist->num_rows > 0) {
    return "<p>Username already exist</p>";
  }
  return "OK";
}

$userEmail = $_POST['email'];
$userName = $_POST['username'];
$userPassword = $_POST['password'];


if (AlreadyExistCheck($db, $userName, $userEmail) != "OK")
  return -1;
if (SecurityCheck($userName, $userPassword, $userEmail) != "OK")
  return -1;
$userPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "INSERT INTO Account (username, password, email)
VALUES (" . "'" . $userName . "','" . $userPassword . "','" . $userEmail . "')";


if ($db->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

$db->close();
?>
