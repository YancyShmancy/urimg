<?php 

	// print_r($_POST);
	// echo "<br>"; 	
	echo "thanks for uploading";
	print_r($_FILES['fileUpload']['tmp_name']);
	
	if (!empty($_FILES)) {
			
		$source = $_FILES['fileUpload']['tmp_name'];
		$destination = __DIR__ . "/uploads/" . "_" . $_FILES['fileUpload']['name'];
		
		if ($_FILES['fileUpload']['type'] == "image/jpeg") {
			echo "we have a jpeg!";
			move_uploaded_file($source, $destination);
			// uploaded file is in uploads folder
			$handler = imagecreatefromjpeg($destination);
			list($width, $height) = [imagesx($handler), imagesy($handler)];
			$new_width = 100;
			$new_height = round($height * ($new_width/$width));
			// create blank resource for thumbnail
			$new_handler = imagecreatetruecolor($new_width, $new_height);
			// resize from original to new 
			imagecopyresampled($new_handler, $handler, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($new_handler, __DIR__ . "./uploads/thumb_" . "_" . $_FILES['fileUpload']['name']); 
			
		} else {
			unlink($source);
			echo "please upload a jpeg";
		}
	}
?>
