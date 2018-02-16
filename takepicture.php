<?php
  // define('UPLOAD_DIR', 'img/');
	// $img = $_POST['image'];
	// $img = str_replace('data:image/png;base64,', '', $img);
	// $img = str_replace(' ', '+', $img);
	// $data = base64_decode($img);
	// $file = UPLOAD_DIR . uniqid() . '.png';
	// $success = file_put_contents($file, $data);
	// print $success ? $file : 'Unable to save the file.';
  //


  $png = imagecreatefrompng('./savedImages/Goku.png');
  $jpeg = imagecreatefrompng('./img/exempleTof.png');

  // list($width, $height) = getimagesize('./img/exempleTof.png');
  // list($newwidth, $newheight) = getimagesize('./savedImages/Goku.png');
  // $out = imagecreatetruecolor($newwidth, $newheight);
  // imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
  // imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
  // imagejpeg($out, 'out.jpg', 100);
?>
