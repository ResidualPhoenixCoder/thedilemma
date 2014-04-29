<form name = "register" action= "register.php" method = "post">
    username: <input type = "text" name = "username"/><br/>
	clan tag: <input type = "text" name = "clan_tag"/><br/>
	email: <input type = "email" name = "email"/><br/>
    password: <input type = "password" name = "password1"/><br/>
    repeat password: <input type = "password" name = "password2"/>
    <input type = "submit" value = "register" />
</form>
<?php
	require("database.php");

	function checkUsername($username, $db){
		$command = "SELECT username FROM Players WHERE username=:value";
		$stmt = $db->prepare($command);
		$stmt->bindParam(':value', $username);				
		if(!$stmt->execute()){
			echo "database is down";
			exit;
		}
		$results = $stmt->fetchAll();
		if(count($results)==0){
			return true;
		}
		echo '</br>';
		echo 'name is taken';
		return false;
	}

	function printPlayers($db){
		$command = "SELECT * FROM Players";
		$stmt = $db->prepare($command);
		if(!$stmt->execute()){
			echo 'database is down';		
			exit;
		}
		$results = $stmt->fetchAll();
		for($i = 0; $i < count($results); $i++){
			echo '</br>';
			echo $results[$i]['username'] . '</br>';
		}
	}

	function registerUser($username,$password, $email, $clan_tag, $db){
		//$command = "INSERT INTO Players  (username, password, email, clan_tag, daily, monthly, lifetime, hide, lie, share, correct) VALUES(:username, :password, :email, :clan_tag, 0, 0, 0, 0, 0, 0, 0)";
		$command = "INSERT INTO Players (username, password, email, clantag, daily, weekly, monthly, lifetime, hide, lie, share, correct) VALUES(:username, :password, :email, :clan_tag, 0, 0, 0, 0, 0 ,0 ,0, 0)";
		$stmt = $db->prepare($command);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':clan_tag', $clan_tag);
		$stmt->bindParam(':email', $email);
		if(!$stmt->execute()){
			echo "database is down. try again later";
			exit;
		}
			echo "registered";
		return true;
	}

	if(isset($_POST["username"]) && isset($_POST["password1"]) && isset($_POST["password2"])){
		$username = $_POST["username"];
		$password1 = $_POST["password1"];
		$password2 = $_POST["password2"];
		$email = $_POST["email"];
		$clan_tag = $_POST["clan_tag"];
			
		if($password1 != $password2){
			echo "Your passwords entered do not match. Try again";
			exit;
		}
		$hash = md5($password1);
		global $db;
		if(checkUsername($username, $db)){
			registerUser($username, $hash, $email, $clan_tag, $db); 
			printPlayers($db);
		}else{
			echo "failed to register";
		}
	}
?>
