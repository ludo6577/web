<!DOCTYPE html>
<html lang="fr">
<head>
<?php
require 'php/config.php';
require 'contents/header.html';

?>	
<style type="text/css">
      .form-signin {
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
</head>
<body>
	<!-- Conteneur principal -->
	<div class="container">

		<?php include 'contents/navbar.php'; ?>
    
			<div class="container">
			
			<form action="" class="form-signin" method="POST">
				<h2 class="form-signin-heading">Please sign in</h2>
				<?php 
					if(isset($_POST["username"]) && !isAuthentifiedUser($Connection, $_POST["username"], $_POST["password"])){
						echo "<div class='alert alert-error'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
      							Error: incorrect username or password
							  </div>";
					}
					if(isset($_POST['username']))
						$username = $_POST['username'];
					else
						$username = "";
					if(isset($_POST['password']))
						$password = $_POST['password'];
					else 
						$password = "";
					echo "<input name='username' id='user_username' type='text' class='input-block-level' value='" . $username . "' placeholder='Username'>";
					echo "<input name='password' id='user_password' type='password' class='input-block-level' value='" . $password . "' placeholder='Password'>";
				?>
				<label class="checkbox"> 
					<input name="rememberme" id="user_remember_me" type="checkbox" value="remember-me"> Remember me
				</label>
				<button class="btn btn-large btn-primary" type="submit">Sign in</button>
			</form>

		</div>
		<!--/.fluid-container-->
	</div>
	
	<?php 
		function isAuthentifiedUser($Connection, $userName, $password){
			$Command = new MySqlCommand($Connection, "SELECT iduser, emailuser, dateinsuser, idgrp FROM usr WHERE loginuser=? && passwduser=?");
			$Command->AddParameter(ParamType::String, $userName);
			$Command->AddParameter(ParamType::String, $password);
			$res = $Command->ExecuteQuery();
			
			if(sizeof($res)==1){
				$_SESSION["username"] = $userName;
				$_SESSION["password"] = $password;
				$_SESSION["iduser"] = $res[0]["iduser"];
				$_SESSION["emailuser"] = $res[0]["emailuser"];
				$_SESSION["dateinsuser"] = $res[0]["dateinsuser"];
				$_SESSION["idgrp"] = $res[0]["idgrp"];
				header("location:forum.php");
			}
			else{
				unset($_SESSION["username"]);
				unset($_SESSION["password"]);
				unset($_SESSION["emailuser"]);
				unset($_SESSION["dateinsuser"]);
				unset($_SESSION["idgrp"]);
				return false;
			}
		}
	?>
	
	<?php include 'contents/footer.html'; ?>
</body>
</html>