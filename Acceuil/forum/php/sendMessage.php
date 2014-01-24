<?php 
require 'config.php';
if(isset($_POST["idmsgsrc"]) && isset($_POST["titre"]) && isset($_POST["message"]) && isset($_POST["idthm"]) && isset($_POST["iduser"])){
	if($_POST["titre"]=="" || $_POST["message"]==""){
		header("location:../forum.php?idthm=" . $_POST["idthm"] . "&message=empty");
	}
	else{
		$Command = new MySqlCommand($Connection, "INSERT INTO message (titremsg, contenumsg, datemsg, idthmmsg, idmsgsrc, idusermsg, lat, lon) VALUES (?,?,NOW(),?,?,?,?,?)");
		$Command->AddParameter(ParamType::String, $_POST["titre"]);
		$Command->AddParameter(ParamType::String, $_POST["message"]);
		$Command->AddParameter(ParamType::String, $_POST["idthm"]);
		$Command->AddParameter(ParamType::String, $_POST["idmsgsrc"]);
		$Command->AddParameter(ParamType::String, $_POST["iduser"]);
		$Command->AddParameter(ParamType::Integer, $_POST["Latitude"]);
		$Command->AddParameter(ParamType::Integer, $_POST["Longitude"]);
		$res = $Command->ExecuteQuery();
		header("location:../forum.php?idthm=" . $_POST["idthm"] . "&message=sent");
	}
}



?>