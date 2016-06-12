<?php
	session_start();
	
	function runQuery($query_text) {
		// Define an output array
		$ret = array();
		// Connect to a database and run query
		$link = mysqli_connect("localhost", "zoey.yancy", "Circus123!", "student-database");
		$result = mysqli_query($link, $query_text);
		// Looping through results and creating our output array
		if($result) {
			while($data = mysqli_fetch_assoc($result)) {
				$ret[] = $data;
			}
		}
		// Return our output array
		return $ret;
	}
	
	if (!empty($_FILES)) {
			
		$source = $_FILES['fileUpload']['tmp_name'];
		$unique = date("ymdhis").rand(0,10000);
		$destination = __DIR__."/uploads/".$unique."_".$_FILES['fileUpload']['name'];
		
		if ($_FILES['fileUpload']['type'] == "image/jpeg") {
			move_uploaded_file($source, $destination);
			// uploaded file is in uploads folder
			$handler = imagecreatefromjpeg($destination);
			list($width, $height) = [imagesx($handler), imagesy($handler)];
			$new_width = 500;
			$new_height = round($height * ($new_width/$width));
			// create blank resource for thumbnail
			$new_handler = imagecreatetruecolor($new_width, $new_height);
			// resize from original to new 
			imagecopyresampled($new_handler, $handler, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($new_handler, __DIR__ . "/uploads/thumb_".$unique."_".$_FILES['fileUpload']['name']);
			
			$thumblink = "/uploads/thumb_".$unique."_".$_FILES['fileUpload']['name'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$username = $_SESSION['username'];
			$imagelink = "./uploads/".$unique."_".$_FILES['fileUpload']['name'];
			
			$link = mysqli_connect("localhost", "zoey.yancy", "Circus123!", "student-database");
			$query = "INSERT INTO urimg_photos (title, description, thumblink, imagelink, username, score) 
						VALUES ('$title', '$description', '$thumblink', '$imagelink', '$username', '1');";			
			mysqli_query($link, $query);
			$query2 = "SELECT id FROM urimg_photos WHERE imagelink = '$imagelink';";
			$getID = runQuery($query2);
			$photoID = $getID[0]['id'];
			echo $photoID;
			header("Location: photo.php?id=$photoID");
			
		} else {
			unlink($source);
			echo "please upload a jpeg";
		}
	}
	
?>