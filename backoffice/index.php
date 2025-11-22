<?php
// Start the session
session_start();

$_SESSION["totalpreco"] = 0;

$_SESSION["totaliva"] = 0;

$_SESSION["total"] = 0;

?>

<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Gestor-GlmSystem</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css?1.0.2">
<!--===============================================================================================-->
</head>
<body>

	<?php
		include ("../bd.php");
		
		$msg = "";

		if(isset($_POST['but'])){
			$sq="select * from login";
			$results = $ms->query($sq);
			while($row = $results->fetch_array()) {
				if ($_POST['user1'] == $row["user"] && password_verify($_POST['pass1'], $row["password"])) {?>

					<script>window.open("page", "_self");</script><?php

					$_SESSION["globaluser"] = $row["user"];
					$_SESSION["globalnivel"] = $row["nivel"];
					$_SESSION["globaluserid"] = $row["id"];

				} else {
		
						$msg = "<p style='text-align: center;'><b>Utilizador ou Palavra-Passe erradas!</b></p>";
		
				}
			}
		}

	?>

	<div class="limiter">
		<div class="container-login100 background">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title p-b-49">
						Login
					</span>

					<?php echo $msg; ?>

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Este campo é obrigatório">
						<span class="label-input100">Utilizador</span>
						<input class="input100" type="text" id="user1" name="user1" placeholder="Escreva o seu utilizador">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Este campo é obrigatório">
						<span class="label-input100">Palavra-Passe</span>
						<input class="input100" type="password" id="pass1" name="pass1" placeholder="Introduza a Palavra-Passe">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					<br><br>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" id="but" name="but">
								Login
							</button>
							<form action="forgetpassword.php" method="post">                            
                        </form>
						</div>
					</div>
				</form>
				<p style="margin-top: 5%; text-align: center;">Esqueceu da Password? <a href="changepassword.php" id="clique">Clique aqui</a></p>
			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>