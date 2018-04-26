<?php
  require_once('connectDB.php');
  require_once('config/database.php');

  define('UPLOAD_DIR', 'user_pictures/');
  session_start();


	$db = new HandleDB($database);

  if ($_SESSION['pseudo'] == '') {
    echo "-1";
    return 1;
  }
	$img = $_POST['image'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);

  if ($_POST['filter'] == "lunettes_filter") {
    $sourceImage = './filters_images/lunettes.png';
  }
  else if ($_POST['filter'] == "hat_filter"){
    $sourceImage = './filters_images/hat.png';
  }
  else {
    $sourceImage = './filters_images/sayan.png';
  }

  $destImage = $file;

  //get the size of the source image, needed for imagecopy()
  list($srcWidth, $srcHeight) = getimagesize($sourceImage);

  //create a new image from the source image
  $src = imagecreatefrompng($sourceImage);

  //create a new image from the destination image
  $dest = imagecreatefrompng($destImage);

  //set the x and y positions of the source image on top of the destination image
  $src_xPosition = 250 - 82; //75 pixels from the left
  $src_yPosition = 94.5 - 82; //50 pixels from the top

  //set the x and y positions of the source image to be copied to the destination image
  $src_cropXposition = 0; //do not crop at the side
  $src_cropYposition = 0; //do not crop on the top

  //merge the source and destination images
  imagecopy($dest,$src,$src_xPosition,$src_yPosition,$src_cropXposition,$src_cropYposition,$srcWidth,$srcHeight);

  //output the merged images to a file
  /*
   * '100' is an optional parameter,
   * it represents the quality of the image to be created,
   * if not set, the default is about '75'
   */

  imagejpeg($dest, $file,100);

  $tmp = $db->get_instance()->prepare('SELECT id FROM account WHERE username = :username');
  $tmp->bindParam(':username', $_SESSION['pseudo']);
  $tmp->execute();
  $user = $tmp->fetch();

  $req = $db->get_instance()->prepare('INSERT INTO picture (nbrOfLike, userID, name) VALUES ("0", :userID, :filename)');
  $req->bindParam(':filename', $file);
  $req->bindParam(':userID', $user["id"]);
  $req->execute();
  print $file;
?>
