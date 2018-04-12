<?php
$servername = "mysql:dbname=camagru;host=localhost:3307";
$username = "root";
$password = "rootroot";

try {
	$dbh = new PDO($servername, $username, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Failed';
}


$req = $dbh->prepare("SELECT * FROM likes WHERE pictureID = :pictureID AND userID = :userID");
$req->bindParam(':pictureID', $_POST['pictureID']);
$req->bindParam(':userID', $_POST['userID']);
$req->execute();

$like = $req->fetch();
if (is_null($like["pictureID"]) && is_null($like["userID"])) {
	$req = $dbh->prepare("INSERT INTO likes (pictureID, userID) VALUES (:pictureID, :userID)");
	$req->bindParam(':pictureID', $_POST['pictureID']);
	$req->bindParam(':userID', $_POST['userID']);
	$req->execute();
	$req = null;
}
else {
	$req = $dbh->prepare("DELETE FROM likes WHERE id = :id");
	$req->bindParam(':id', $like['id']);
	$req->execute();
	$req = null;
}

echo json_encode($likes);
?>
