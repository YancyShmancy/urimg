<?php
$getphotoid = $_GET["id"];

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

$query = "SELECT * FROM urimg_photos WHERE id='" . $getphotoid . "'";

$photoarr = runQuery($query);


?>

<!DOCTYPE html>
<html>
	<head>
		<title>urimg</title>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
	</head>
	<body>
		<header class="teal">
			<div class="container">
				<h1 style="margin:0; color:white; line-height:8rem">This is the header</h1>
			</div>
		</header>
		<div class="container">
			<h2><?php echo @$photoarr[0][title]; ?></h2>
			<div class="row">
				<div class="col m8 s12">
					<?php echo "<img class='responsive-img' src='".@$photoarr[0][imagelink]."' />"?>
				</div>
				<div class="col m4 s12">
					<p><?php echo @$photoarr[0][description]; ?></p>
				</div>
			</div>
			<div class="row">
				<form id="add-comment-form" class="col s12" onsubmit="return false;">
					<div class="row">
						<div class="input-field col s6">
							<input id="add-comment-name" type="text" class="validate"></textarea>
							<label for="add-comment-name">Name</label>
						</div>
					</div>
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
			<div class="row">
				<div class="col s12">
					<div id="comment-list"></div>
				</div>
			</div>
		</div>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
	<script>
		$(document).ready(function() {
			console.log('oshit')
			$('#add-comment-form').on('submit', function(e) {
				var name = $('#add-comment-name').val();
				var text = $('#add-comment-text').val();
				var $name = $('<p>').addClass('comment-name').append(name);
				var $text = $('<p>').addClass('comment-text').append(text);
				var $newcomment = $('<div>').append($name).append($text).css('border', '1px solid black');
				// var postData = {
				// 	"name": name,
				// 	"text": text
				// };
				// $.post("handle_comment.php", postData, function(result) {
					
				// })
				$('#comment-list').append($newcomment);
				$('#add-comment-form').trigger('reset');
				
			});
		});
	</script>
	</body>
</html>

<!--
	
4. Create a page that displays the details for each photo (photo.php) that:

	a. Displays only the photo that was clicked on including it's title and description (+$1000)

	b. Has an HTML form to submit a comment on a photo (+$500)

	c. Display's comments submitted for that photo (+$500)

	d. Allow user to click a button to like/upvote the photo (+$500)
	
-->