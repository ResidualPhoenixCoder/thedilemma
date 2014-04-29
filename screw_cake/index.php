<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8">
<title>The Dilemma | A game to drive you mad...</title>
<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.10.4.css" />
<script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<?php
	require_once("common.php");
	echo '</br>';
?>
</head>
<body>
<div id="main">
	<script>
		$(function(){
			$("#btn_login")
				.button()
				.click(function(event){
					window.location="./login.php";
				});
			$("#btn_register")
				.button()
				.click(function(event){
					window.location="./register.php";
				});

		});
	</script>
	<style>
	#main{
		margin-top: -150px;
	}
	</style>
	<?php
		session_start();	
		if(isset($_SESSION['username'])){
			echo "Helllo " . $_SESSION['username'];
	?>
	<form name = "logout" action= "login.php" method = "post"> 
	<input type = "submit" name = "logoutButton" value = "logout" />
	<?php
		}else{
			if(isset($_SESSION['loginFail'])){
				echo $_SESSION['loginFail'] . "<br/>";
				echo "login fail";
				unset($_SESSION['loginFail']);
			}	
	?>
	</br>
	<h1>PLAYER LOGIN</h1>
	<form name = "login" action= "login.php" method = "post">
	<div style="margin:10px; text-align:center;"> Username: <input type = "text" name = "username"/></br> </div>
	<div style="margin:10px; text-align:center"> Password: <input type = "password" name = "password"/></br></div>
	<div style="text-align:center;">
	<button id="btn_login" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role"button" aria-disabled="false">
	<span class="ui-button-text">Login</span></button>
	</form>
	<form name = "login" action="register.php" method = "post">
	<button id="btn_register" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role"button" aria-disabled="false">
	<span class="ui-button-text">Register</span></button>
	</form>
	</div>
	<?php
			}
	?>
</div>
</body>
</html>
