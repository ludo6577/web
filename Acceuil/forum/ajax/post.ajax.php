
<?php 
	$db = mysql_connect("sqletud.univ­mlv.fr", [user], [mdp]) or die("Impossible de se connecter : " . mysql_error()); 
	mysql_select_db("nom_db"); 
	$sql = 'INSERT INTO ...'; 
	$result = mysql_query($sql); 
	mysql_close($db); 
?> 

