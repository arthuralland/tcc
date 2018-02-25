<?php 
	$host = "mysql.hostinger.com.br";
	$dbname = "u340489791_conta";
	$username = "u340489791_artur";
	$password = "PhLLQhvE6DhZ";		

  	$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password,   array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));	 
  	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>