<?php
session_start();
$session_user = $_SESSION['username'];

$getuser = $_GET["u"];

$num;

function runQuery($query_text) {
	global $num;
	// Define a return array
	$ret = array();
	// Connect to database and run query
	$link = mysqli_connect("localhost", "ryan.rodd", "Circus123!", "student-database");
	$result = mysqli_query($link, $query_text);
	$num = mysqli_num_rows($result);
	// Looping through results and creating our output array
	if ($result) {
		while ($data = @mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$ret[] = $data;
		}
	}
	return $ret;
}

$userquery = "SELECT * FROM urimg_photos WHERE username='" . $getuser . "'";

$userarr = runQuery($userquery);

?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <title>urimg | <?php echo $getuser; ?></title>
	    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
	    <link rel="stylesheet" href="./main.css">
	</head>
	
	<body>
		<header class="header row z-depth-1 teal p-b-3">
	        <div class="col s6 offset-s3">
	             <a href="index.php"><h1 class="white-text center-align">URIMG</h1></a>
	        </div>
	        <div class="col s3 center-align">
	        	<?php echo "<a href='./user.php?u=$session_user' class='red-text text-lighten-3'>$session_user</a>"; ?><br/>
	    		<a href="logout.php" class="white-text">Logout</a>
	        </div>
	    </header>
		<div class="container">
			
			<h1><?php echo $getuser; ?></h1>
			<div id="photo-list" class="row">
				<?php 
				if(empty($userarr)) {
					echo "- But nobody came.";
				}
				for($i=0; $i < $num; $i++) {
					global $userarr;
					$array = $userarr[$i];
					$title = $array['title'];
					$link = $array['thumblink'];
					$user = $array['username'];
					$photoID = $array['id'];
					$score = $array['score'];
					
					echo "<div class='card-panel home-card hoverable col s10 offset-s1 m6 l3'><div class='card-content'>
							<h2 class='card-title flow-text' value='$title'>$title</h2>
							<a href='photo.php?id=$photoID' class='photo-link valign-wrapper'>
							<img class='thumbnail responsive-img valign' src='./$link'>
						</a>
						<p class='score-text teal-text center-align'>
						<i class='material-icons grey-text downvote'>call_received</i> <span class='score' value='$score'>$score</span> <i class='material-icons grey-text upvote'>call_made</i>
						</p>
						<p>Posted by <a class='teal-text' href='./user.php?u=$user'>$user</span></p>
						</div></div>";
				} 
				?>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
	</body>
</html>