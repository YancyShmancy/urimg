<?php 
session_start();
?>

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
    <header class="header row z-depth-1 teal">
        <div class="col s6 offset-s3">
             <a href="index.php"><h1 class="white-text center-align">URIMG</h1></a>
        </div>
    </header>
    
    <div class="container">
        <div class="row">
            <div class="card-panel container col m6 s10 offset-m3 offset-s1 p-b-3" id="loginContainer">
            	<?php if (!isset($_GET['register'])) { ?>
                <h3 class="small center-align" id="loginTitle">Log In</h3>
                <form method="post" action="">
                	<?php 
                	if(isset($_POST['submit'])) 
					{								
						$posteduser = $_POST['username'];
						$postedpassword = $_POST['password'];
						
						// validation - adds all errors to an array.
						if(empty($posteduser)) {
							$error[] = 'Name is required <br>';
						}
						if(empty($postedpassword)) {
							$error[] = 'Last name is required<br>';
						}
						
						if(!isset($error)){
							
							sleep(2);
							function login($username, $password) 
							{
								
							    $link = mysqli_connect("localhost", "zoey.yancy", "Circus123!", "student-database");
							    $query = mysqli_query($link, "SELECT * FROM zoey_registered_users WHERE username = '$username'");
							    $data = mysqli_fetch_assoc($query);
							
							    if($username == $data['email'] && $password == $data['password']) {
							    		
							        $_SESSION['isuser'] = true;
							        $_SESSION['username'] = $data['username'];
									$_SESSION['email'] = $data['email'];
							        $_SESSION['name'] = $data['name'];
			
									return true;
							    } else if ($username == $data['username'] && $password == $data['password']){
							    	$_SESSION['isuser'] = true;
							        $_SESSION['username'] = $data['username'];
									$_SESSION['email'] = $data['email'];
							        $_SESSION['name'] = $data['name'];
			
									return true;
							    } else {
							    	return false;
							    }
							}
							$success = login($posteduser, $postedpassword);
							
							if($success) {
								header("Location: index.php");
							} else {
								echo "<p class='red-text'>Login information incorrect. Please try again.</p>";
							}
						}
						
						if(isset($error)){
						    foreach($error as $error){
						        echo "<p class='red-text'>$error</p>";
						    }
						}
					}
					?>
                    <div class="input-field col s12">
                        <input id="username" name="username" class="center-align" required="true" type="text" placeholder="username">
                    </div>
                    <div class="input-field col s12">
                        <input id="password" name="password" class="center-align" required="true" type="password" placeholder="password">
                    </div>
                    <input class="btn-large" type="submit" id="loginButton" name="submit">
                </form>
                <p class="p-l-1">Don't have an account? <a href="login.php?register">Register Here</a></p>
                <?php } else { ?>
                <h3 class="small center-align" id="registerTitle">Register</h3>
                <form method="post" action="">
                	<?php 
                	if(isset($_POST['submit'])) 
					{								
						$posteduser = $_POST['username'];
						$postedemail = $_POST['email'];
						$postedpassword = $_POST['password'];
						$postedname = $_POST['name'];
						
						// validation - adds all errors to an array.
						if(!filter_var($postedemail, FILTER_VALIDATE_EMAIL)) {
							$error[] = 'Name is required <br>';
						}
						if(empty($postedpassword)) {
							$error[] = 'Password is required<br>';
						}
						if(empty($postedname)) {
							$error[] = 'Name is required<br>';
						}
						if(empty($posteduser)) {
							$error[] = 'Username is required<br>';
						}
						
						if(!isset($error)){
							// $filename = 'guests.csv';
							sleep(2);
							$link = mysqli_connect("localhost", "zoey.yancy", "Circus123!", "student-database");
							$userQuery = mysqli_query($link, "SELECT username FROM zoey_registered_users WHERE username='$posteduser';");
							$userResults = mysqli_fetch_assoc($userQuery);
							if($userResults[0]['username'] == $posteduser) {
								echo "<p class='red-text'>Please choose a different username</p>";
							} else {
								$query = mysqli_query($link, "INSERT INTO zoey_registered_users (name, username, password, email) VALUES ('$postedname', '$posteduser', '$postedpassword', '$postedemail')");
								$data = mysqli_fetch_assoc($query);
								
								header("Location: login.php");
							}
						}
						
						if(isset($error)){
						    foreach($error as $error){
						        echo "<p class='red-text'>$error</p>";
						    }
						}
					}
					?>
                    <div class="input-field col s12">
                        <input id="username" name="username" class="center-align" required="true" type="text" placeholder="username">
                    </div>
                    <div class="input-field col s12">
                        <input id="password" name="password" class="center-align" required="true" type="password" placeholder="password">
                    </div>
                    <div class="input-field col s12">
                        <input id="email" name="email" class="center-align" required="true" type="email" placeholder="your email">
                    </div>
                    <div class="input-field col s12">
                        <input id="name" name="name" class="center-align" required="true" type="text" placeholder="your name">
                    </div>
                    <input class="btn-large" type="submit" id="loginButton" name="submit">
                </form>
                <p class="p-l-1">Already have an account? <a href="login.php">Login</a></p>
                <?php } ?>
            </div>
        </div>
    </div>
   
    <script   src="https://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
	<!-- <script>
	$(document).ready(function(){
		
		// Add login functionality to login button
		$('#loginButton').on('click', function() {
			
			$("#loginTitle").html("Logging in, please wait...");
			$("#loginContainer").fadeTo("fast", "0.2");
			
			var username = $('#username').val();
			var password = $('#password').val();
			var postData = {
				'username': username,
				'password': password
			}
			
			$.post('login-handler.php', postData, function(result){
				
				if(result.loggedin) {
					$("body").css({"background": "green"});
					$('#myName').html("Welcome "+result.name);
					// setTimeout(function() {
						// location.reload();
					// }, 5000);
					
				} else {
					$("#loginTitle").html("Log In");
					$("#loginContainer").fadeTo("fast", "1");
					alert("Bad username or password, please try again!");
				}
				
			}, "json");
		});
	})
	</script> -->
</body>
</html>