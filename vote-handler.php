<?php
	session_start();
	
	$title = $_POST['title'];
	$currentScore = $_POST['score'];
	$direction = $_POST['direction'];
	$link = mysqli_connect("localhost", "zoey.yancy", "Circus123!", "student-database");
	
	if($direction == "up") {
		$score = $currentScore + 1;
		$query = "UPDATE urimg_photos SET score = score + 1 WHERE title='$title';";
		mysqli_query($link, $query);
		
	} else if ($direction == "down") {
		$score = $currentScore - 1;
		$query = "UPDATE urimg_photos SET score = score - 1 WHERE title='$title';";
		mysqli_query($link, $query);
	}
	
	$arr = [
		"score" => $score,
		"upvoted" => true
	];
	
	echo json_encode($arr);
?>