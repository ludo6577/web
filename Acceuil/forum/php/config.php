<?php
header ( 'Content-Type: text/html; charset=utf-8' );
session_start();
if(!isset($_SESSION["username"]) && basename($_SERVER['REQUEST_URI'])!="login.php"){
	header("location:login.php");
}


require 'MySql/MySqlConnection.php';
require 'MySql/MySqlCommand.php';

$Connection = new MySqlConnection();
$Command = new MySqlCommand($Connection, "SELECT * FROM usr WHERE loginuser=?");
$Command->AddParameter(ParamType::String, "admin");
$res = $Command->ExecuteQuery();
?>