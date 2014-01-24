<!DOCTYPE html>
<html lang="fr">
<head>
<?php
require 'php/config.php';
require 'contents/header.html';
?>	
</head>
<body>
	<!-- Conteneur principal -->
	<div class="container">

		<?php include 'contents/navbar.php'; ?>
    
		<!-- fluid container -->
	    <div class="container-fluid">
	      <div class="row-fluid">

	        <div class="span3">
	          <div class="well sidebar-nav">
	            <ul class="nav nav-list">
	            <?php 			           
		            /*
		             * Sous Thèmes (récursif)
		             */			
					function printSousCategorie($Connection, $iduser, $iduserthm){
						$idthm = -1;
						if(isset($_GET["idthm"]))
	            			$idthm = $_GET["idthm"];
	            			
						$Command = new MySqlCommand($Connection, "SELECT theme.idthm, theme.libthm, usrthm.loginuser AS loginusrthm, usr.loginuser FROM ((((theme INNER JOIN accessthm ON theme.idthm=accessthm.idthm) INNER JOIN groupe ON accessthm.idgrp=groupe.idgrp) INNER JOIN usr ON groupe.idgrp=usr.idgrp) INNER JOIN usr AS usrthm ON theme.iduserthm=usrthm.iduser) WHERE usr.iduser=? && idsuperthm=?");
						$Command->AddParameter(ParamType::String, $iduser);
						$Command->AddParameter(ParamType::String, $iduserthm);
						$res = $Command->ExecuteQuery();
						foreach($res as $row)
						{
							echo "<li " . ($idthm==$row['idthm']?"class='active'":"") . "><a href='?idthm=$row[idthm]'><b>$row[libthm]</b> ($row[loginusrthm])</a></li><ul class='nav nav-list'>";
							printSousCategorie($Connection, $iduser, $row["idthm"]);
							echo "</ul>";
						}
					}
					
					$idthm = -1;
					if(isset($_GET["idthm"]))
	            		$idthm = $_GET["idthm"];
	            		
					/*	
					 * Thème principaux (correspondant au l'user)
					 */
					$Command = new MySqlCommand($Connection, "SELECT theme.idthm, theme.libthm, usrthm.loginuser AS loginusrthm, usr.loginuser FROM ((((theme INNER JOIN accessthm ON theme.idthm=accessthm.idthm) INNER JOIN groupe ON accessthm.idgrp=groupe.idgrp) INNER JOIN usr ON groupe.idgrp=usr.idgrp) INNER JOIN usr AS usrthm ON theme.iduserthm=usrthm.iduser) WHERE usr.iduser=? && idsuperthm is NULL");
					$Command->AddParameter(ParamType::String, $_SESSION["iduser"]);
					$res = $Command->ExecuteQuery();
					foreach($res as $row)
					{
						echo "<li " . ($idthm==$row['idthm']?"class='active'":"") . "><a href='?idthm=$row[idthm]'><b>$row[libthm]</b> ($row[loginusrthm])</a></li><ul class='nav nav-list'>";
						printSousCategorie($Connection, $_SESSION["iduser"], $row["idthm"]);
						echo "</ul>";
					}				
	            ?>
	            </ul>
	          </div><!--/.well -->
	        </div><!--/span-->
	        
	        <div class="span9">
	        	<?php 
		        	if(isset($_GET["message"])){
		        		if($_GET["message"]=="empty"){
							echo "<div class='alert alert-error' >";
				        	echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
							echo "<h4>Alert:</h4> votre message ne peut pas être vide!";
							echo "</div>";	
						}
						else if($_GET["message"]=="sent"){
							echo "<div class='alert alert-success' >";
							echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
							echo "<h4>Succès:</h4> votre message à été envoyé";
							echo "</div>";
						}
					}
				?>
	          <div class="hero-unit">
	            <h1>Welcome <?php echo $_SESSION["username"] ?>!</h1>
	            <p>Forum développé dans le cadre d'un TP noté de Web.</p>
	            
	            <!-- Button to trigger modal -->
				<a href="#myModal" role="button" class="btn" data-toggle="modal" >Géolocalisation des messages</a>
 
				<!-- Modal -->
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    <h3 id="myModalLabel">Modal header</h3>
				  </div>
				  <div class="modal-body">
				    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
				    <style type="text/css">
				      html { height: 100% }
				      body { height: 100%; margin: 0; padding: 0 }
				      #map-canvas { height: 400px; width: 540px }
				    </style>
				    <div id="map-canvas"></div>
				    
				  </div>
				  <div class="modal-footer">
				    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				  </div>
				</div>
	          </div>
	          
			  <ul class='thumbnails'>
	            	<?php 
	            		$localisations = array();
						$index=0;
		            	/*
		            	 * Les sous messages (récursif)
		            	 */
		            	 function printSousMessage($Connection, $idmsgsrc, $idthm, $iduser){
							$idthm = -1;
							if(isset($_GET["idthm"]))
		            			$idthm = $_GET["idthm"];
		            			
							$Command = new MySqlCommand($Connection, "SELECT idmsg, titremsg, contenumsg, datemsg, usr.loginuser, lat, lon FROM (message INNER JOIN usr ON message.idusermsg=usr.iduser) WHERE idmsgsrc=? ORDER BY idmsg DESC");
							$Command->AddParameter(ParamType::String, $idmsgsrc);
							$res = $Command->ExecuteQuery();
							foreach($res as $row)
							{
								echo "<div class='well well-small'>";
								printmessage($Connection, $row["titremsg"], $row["contenumsg"], $row["idmsg"], $idthm, $iduser, $row["datemsg"]);
								echo "</div><!--/thumbnails-->";
								global $index, $localisations;
								$localisations[$index] = array("lat" => $row["lat"], "lon" => $row["lon"], "title" => $row["titremsg"]);
								$index++;
							}
						}
						
						/*
						 * Un seul message
						 */
						function printMessage($Connection, $titremsg, $contenumsg, $idmsg, $idthm, $iduser, $datemsg){
							echo "<div class='row-fluid'>";
							echo "<div class='span6'><a class='brand' href='#'>$titremsg</a></div>";
							echo "<p class='text-right'>$datemsg</p>";
							echo "</div>";
							echo "<p>$contenumsg</p>";
							echo "<form method='POST' id='form_$idmsg' action='php/sendMessage.php' style='display:none'>";
							echo "<input type='text' name='titre' placeholder='titre'/><br/>";
							echo "<textarea name='message' rows='3' placeholder='message'></textarea><br/>";
							echo "<input type='hidden' name='idmsgsrc' value='$idmsg'/>";
							echo "<input type='hidden' name='idthm' value='$idthm'/>";
							echo "<input type='hidden' name='iduser' value='$iduser'/>";
							echo "<input type='hidden' id='Latitude' name='Latitude' value=''>";
							echo "<input type='hidden' id='Longitude' name='Longitude' value=''>";
							echo "<button type='submit' class='btn' onclick='getLocationConstant()'>Envoyer</button>";
							echo "</form>";
							echo "<p><a class='btn' id='bouton_$idmsg' onclick='displayTextArea($idmsg)'>Répondre</a></p>";
							printSousMessage($Connection, $idmsg, $idthm, $iduser);
						}
	            	 
	            	 	/*
	            	 	 * 	Les messages principaux
	            	 	 */	            	 
	            		$idthm = -1;
	         	        if(isset($_GET["idthm"]))
	            			$idthm = $_GET["idthm"];
	            				
	            		$Command = new MySqlCommand($Connection, "SELECT idmsg, titremsg, contenumsg, datemsg, usr.loginuser, lat, lon FROM (message INNER JOIN usr ON message.idusermsg=usr.iduser) WHERE idthmmsg=? && idmsgsrc is NULL");
						$Command->AddParameter(ParamType::String, $idthm);
						$res = $Command->ExecuteQuery();
						foreach($res as $row)
						{
							echo "<div class='span12'>";
							echo "<div class='well well-small'>";
							printmessage($Connection, $row["titremsg"], $row["contenumsg"], $row["idmsg"], $idthm, $_SESSION["iduser"], $row["datemsg"]);
							echo "</div><!--/thumbnails-->";
							echo "</div><!--/span-->";
							$localisations[$index] = array("lat" => $row["lat"], "lon" => $row["lon"], "title" => $row["titremsg"]);
							$index++;
						}
					?>              
		    	<ul><!--/thumbnails-->
	        </div><!--/span-->
	      </div><!--/row-->
		</div><!--/.fluid-container-->
	</div>
	
	<script type='text/javascript'> 
		function getLocationConstant()
		{
		    if(navigator.geolocation)
		    {
		    	var options = {
				  enableHighAccuracy: true,
				  timeout: 5000,
				  maximumAge: 0
				};
		        navigator.geolocation.getCurrentPosition(onGeoSuccess,onGeoError, options);  
		    } else {
		        alert("Your browser or device doesn't support Geolocation");
		    }
		}
		
		// If we have a successful location update
		function onGeoSuccess(event)
		{
		    document.getElementById("Latitude").value =  event.coords.latitude; 
		    document.getElementById("Longitude").value = event.coords.longitude;			    		        
		}
		
		// If something has gone wrong with the geolocation request
		function onGeoError(event)
		{
		    alert("Error code " + event.code + ". " + event.message);
		}
	
		function initialize() {
		  	var mapOptions = {
		    zoom: 8,
		    center: new google.maps.LatLng(48.83913, 2.58642),
		    mapTypeId: google.maps.MapTypeId.ROADMAP
	 		};
	
	  		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	  		$('#myModal').on('shown', function () {
   				google.maps.event.trigger(map, "resize");
			});
			
			var myarray = <?php echo JSON_encode($localisations); ?>;
    		var length = myarray.length;
    		for (var i = 0; i < length; i++) {
  				element = myarray[i];
  				var myLatlng = new google.maps.LatLng(element["lat"], element["lon"]);
  				var marker = new google.maps.Marker({
    			position: myLatlng,
    			title:element['title']
				});
				marker.setMap(map);
			}
			
		}
	
		function loadScript() {
		  var script = document.createElement('script');
		  script.type = 'text/javascript';
		  script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAlNmylDGQGTnBbZlBEMo2TDTYqcZYEzLY&sensor=true&callback=initialize';
		  document.body.appendChild(script);
		}
	
		window.onload = loadScript;
		
		function displayTextArea(id){
			$("#form_"+id).show();
			$("#bouton_"+id).hide();
			return false;
		}
	</script>
	<?php include 'contents/footer.html'; ?>
</body>
</html>