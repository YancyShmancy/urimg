<?php
	if(isset($_POST["text"]) && isset($_POST["username"]) && isset($_POST["photoid"])) {
		$comment = addslashes($_POST["text"]);
		$username = $_POST["username"];
		$photoid = $_POST["photoid"];
		$mysqltime = date ("Y-m-d H:i:s");
		$link = mysqli_connect("localhost", "ryan.rodd", "Circus123!", "student-database");
		$insert = mysqli_query($link, "INSERT INTO urimg_comments (photo_id, username, text, created) VALUES ('$photoid', '$username', '$comment', '$mysqltime')");
		
		$select = mysqli_query($link, "SELECT * FROM urimg_comments WHERE username = '$username' and text = '$comment' and photo_id='$photoid' and created = '$mysqltime'");
		// echo "<pre";
		// echo "</pre>";
		if($row=mysqli_fetch_array($select, MYSQLI_ASSOC))
		  {
			  $name=$row['username'];
			  $comment=$row['text'];
		      $time=$row['created'];
		  ?>
		      <div class="comment-item col s12 z-depth-1 tofade" style="display:none">
			    <p>Posted By:<?php echo $name; ?></p>
		        <p><?php echo $comment; ?></p>	
			    <p><?php echo $time; ?></p>
			  </div>
		  <?php
		}
		exit;

	}
?>