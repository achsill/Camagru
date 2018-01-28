<?php
include "config.php";

$initDB = $db->query("CREATE TABLE account(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
  );
  ");


if ($db->query($initDB) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
?>
