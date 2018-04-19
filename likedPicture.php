<?php

require_once('connectDB.php');

$dbh = new HandleDB();

$req = $dbh->get_instance()->prepare("SELECT * FROM likes WHERE pictureID = :pictureID AND userID = :userID");
$req->bindParam(':pictureID', $_POST['pictureID']);
$req->bindParam(':userID', $_POST['userID']);
$req->execute();

$like = $req->fetch();
if (is_null($like["pictureID"]) && is_null($like["userID"])) {
	$req = $dbh->get_instance()->prepare("INSERT INTO likes (pictureID, userID) VALUES (:pictureID, :userID)");
	$req->bindParam(':pictureID', $_POST['pictureID']);
	$req->bindParam(':userID', $_POST['userID']);
	$req->execute();
	$req = null;
}
else {
	$req = $dbh->get_instance()->prepare("DELETE FROM likes WHERE id = :id");
	$req->bindParam(':id', $like['id']);
	$req->execute();
	$req = null;
}

echo json_encode($likes);
?>
