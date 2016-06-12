<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Urimg Home</title>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
    <link rel="stylesheet" href="./main.css">
</head>
<body>
    <?php session_start(); 
    	$num;
		
		function runQuery($query_text) {
		// Define an output array
			global $num;
			$ret = array();
			// Connect to a database and run query
			$link = mysqli_connect("localhost", "zoey.yancy", "Circus123!", "student-database");
			$result = mysqli_query($link, $query_text);
			$num = mysqli_num_rows($result);
			// Looping through results and creating our output array
			if($result) {
				while($data = mysqli_fetch_assoc($result)) {
					$ret[] = $data;
				}
			}
			// Return our output array
			return $ret;
		} 
		
		$userArr = runQuery("SELECT * FROM urimg_photos ORDER BY score");
	?>
    
    <header class="header row z-depth-1 teal p-b-3">
        <div class="col s6 offset-s3">
             <a href="index.php"><h1 class="white-text center-align">URIMG</h1></a>
        </div>
        <div class="col s3 center-align">
    		<a href="logout.php" class="white-text">Logout</a>
        </div>
        <div class="col s12 center-align">
        	<a href="upload.html" class="white-text btn btn-large">Upload a File <i class="material-icons right">play_for_work</i></a>
    	</div>
    </header>

    <section class="section">
        <div class="row">
            <?php 
            if (isset($_SESSION['isuser'])) { 
				for($i=0; $i < $num; $i++) {
					global $userArr;
					$array = $userArr[$i];
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
						<p>Posted by <span class='teal-text'>$user</span></p>
						</div></div>";
				} 
			} else {
				header("Location: login.php");
			}
			?>
		</div>
	</section>
   	
    <script src="https://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
    <script>
    	$(document).ready(function(){
    		
    		$('.downvote').on('click', function() {
    			var clicked;
    			if (!clicked) {
	    			$(this).removeClass('grey-text').addClass('teal-text');
	    			var score = $(this).parent().children('.score');
	    			var postData = {
	    				'direction': 'down',
	    				'score': score.attr('value'),
	    				'title': $(this).parent().parent().children('.card-title').attr('value')
	    			}
	    			console.log(postData.score, postData.title);
	    			$.post("vote-handler.php", postData, function(result){	    				
	    				console.log(result);
	    				console.log(result.score);
	    				$(score).html(result.score);
	    			}, "json");
	    			
	    			clicked = true;
    			} else {
    				return false;
    			}
    		});
    		
    		$('.upvote').on('click', function() {
    			var clicked;
    			if (!clicked) {
	    			$(this).removeClass('grey-text').addClass('teal-text');
	    			var score = $(this).parent().children('.score');
	    			var postData = {
	    				'direction': 'up',
	    				'score': score.attr('value'),
	    				'title': $(this).parent().parent().children('.card-title').attr('value')
	    			}
	    			console.log(postData.score, postData.title);
	    			$.post("vote-handler.php", postData, function(result){	    				
	    				console.log(result);
	    				console.log(result.score);
	    				$(score).html(result.score);
	    			}, "json");
	    			
	    			clicked = true;
    			} else {
    				return false;
    			}
    		})
    	})
    </script>
</body>
</html>