<?php

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
    return "<p>You're password need an UPPERCASE letter</p>";
  }
  if (!(preg_match('/[0-9]/', $password))) {
    return "<p>You're password need a number</p>";
  }
  if (strlen($password) < 5) {
    return "<p>You're password need to have at least 5 caracters</p>";
  }
  return "OK";
}

?>
