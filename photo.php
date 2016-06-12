<?php
session_start();
$getphotoid = $_GET["id"];
$session_user = $_SESSION['username'];

function runQuery($query_text) {
	// Define a return array
	$ret = array();
	// Connect to database and run query
	$link = mysqli_connect("localhost", "ryan.rodd", "Circus123!", "student-database");
	$result = mysqli_query($link, $query_text);
	// Looping through results and creating our output array
	if ($result) {
		while ($data = @mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$ret[] = $data;
		}
	}
	return $ret;
}

$photoquery = "SELECT * FROM urimg_photos WHERE id='" . $getphotoid . "'";

$photoarr = runQuery($photoquery);

$photo_user = $photoarr[0]['username'];
$photo_title = $photoarr[0]['title'];
$photo_date = $photoarr[0]['created'];
$photo_desc = $photoarr[0]['description'];
$photo_link = $photoarr[0]['imagelink'];


?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <title>urimg | <?php echo $photo_title; ?></title>
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
	        	<?php echo "<a href='./user.php?u=$session_user' class='red-text text-lighten-3'>$session_user</a>"; ?>
	        	<br />
	    		<a href="logout.php" class="white-text">Logout</a>
	        </div>
	    </header>
		<div class="container">
			<h2><?php echo $photo_title; ?></h2>
			<div class="row z-depth-1">
				<div class="col m8 s12">
					<?php echo "<p><img class='responsive-img' src='$photo_link' /></p>"; ?>
				</div>
				<div class="col m4 s12">
					<p><?php echo $photo_desc; ?></p>
					<p><?php echo "<a class='teal-text' href='./user.php?u=$photo_user'>$photo_user</a>"; ?></p>
					
				</div>
			</div>
			<div class="row">
				<form id="add-comment-form" class="col s12 z-depth-1" onsubmit="return false;">
					<div class="row">
						<div class="input-field col s12">
							<textarea id="add-comment-text" class="materialize-textarea"></textarea>
							<label for="add-comment-text">Comment</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<button id="add-comment-submit" class="btn waves-effect waves-light" type="submit" name="action">Submit</button>	
						</div>
					</div>
				</form>
			</div>
			<div id="comment-list" class="row">
				
				
				<?php
					// get all comments from db
					
					$commentquery = "SELECT * FROM urimg_comments WHERE photo_id='" . $getphotoid . "' ORDER BY created DESC";
					$conn = mysqli_connect("localhost", "ryan.rodd", "Circus123!", "student-database");
					$commentresult = mysqli_query($conn, $commentquery);
						
					while($commentrow = mysqli_fetch_array($commentresult, MYSQLI_ASSOC))
				    {
					  $commenter=$commentrow['username'];
					  $comment=$commentrow['text'];
				      $time=$commentrow['created'];
						echo "
					    <div class='comment-item col s12 z-depth-1'>
						  <p class='teal-text'><a class='teal-text' href='./user.php?u=$commenter'>$commenter</a></p>
						  <p class=''>$time</p>
					      <p>$comment</p>	
						</div>";
					}
				?>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
		<script>
			$(document).ready(function() {
				$('#add-comment-form').on('submit', function(e) {
					var username = "<?php echo $session_user ?>";
					var text = $('#add-comment-text').val();
					var photoid = <?php echo $getphotoid ?>;
					var postData = {
					'username': username,
					'text': text,
					'photoid': photoid
					};
					$.post('handle_comment.php', postData, function(result) {
						$('#comment-list').prepend(result);
						$('.tofade').fadeIn(1000);
						$('#add-comment-form')[0].reset();
					});
				});
			});
		</script>
	</body>
</html>