<?php    
    $dbuser = "manny";
    $dbpass = "blackheart625";
    $database_host = "localhost";
    $database_name = "dilemma";
	try{
		// creates connection object with PDO library
    	$db = new PDO("mysql:host=$database_host;dbname=$database_name;charset=utf8", $dbuser, $dbpass); 
	}catch(PDOException $e){
		echo 'pdo exception' . '<br>';
		echo $e->getMessage();
	}
?>
