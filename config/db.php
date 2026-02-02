<?php
//using pdo to connect to my mysql database 
$server = "localhost";
$username = "np03cs4s250093";
$password = "RyOonWURc7";
$database = "np03cs4s250093";

try {
    $pdo = new pdo("mysql:host=$server;dbname=$database", $username, $password);
    //set the pdo error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>