<?php
	require("database.php");
	session_start();
	if(isset($_POST["logoutButton"])){
        unset($_SESSION["username"]);
        unset($_SESSION['loginFail']);
        unset($_POST['logoutButton']);
        header("Location: http://mannyjl625.info/thedilemma/screw_cake/index.php");
	}
	if(!isset($_POST["username"])){
		header("Location: http://mannyjl625.info/thedilemma/screw_cake/index.php");
	}else{
        $command = "SELECT username FROM Players WHERE username=:value AND password=:hashword";
        $stmt = $db->prepare($command); 
		$stmt->bindParam(':value', $_POST["username"]);
        $stmt->bindParam(':hashword', md5($_POST["password"]));
        //echo md5($_POST["password"]);
        if (!$stmt->execute()) {  
            echo "Database is down. Try again later";
            exit;
        }
        $results = $stmt->fetchAll();  

        if(count($results) == 1){ 
            $_SESSION['username'] = $_POST['username'];
        }else{
            $_SESSION['loginFail'] = "Incorrect login information";
        }
        header("Location: http://mannyjl625.info/thedilemma/screw_cake/lobby.php");
	}
?>
