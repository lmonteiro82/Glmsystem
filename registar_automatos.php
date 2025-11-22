<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Autómatos-GlmSystem</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="backoffice/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="backoffice/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="backoffice/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="backoffice/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="backoffice/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="backoffice/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="backoffice/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="backoffice/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="backoffice/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="backoffice/css/util.css">
	<link rel="stylesheet" type="text/css" href="backoffice/css/main.css?1.0.3">
<!--===============================================================================================-->
</head>
<body>

	<?php
		include ("bd.php");
		
		$msg = "";

        // inserção dos dados do utilizador para a BD com encriptação da palavra pass se forem iguais

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

                    <div class="wrap-input100 validate-input" data-validate="Este campo é obrigatório">
						<span class="label-input100">Repitir Palavra-Passe</span>
						<input class="input100" type="password" id="pass2" name="pass2" placeholder="Repita a Palavra-Passe">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					<br><br>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" id="but" name="but">
								Registar
							</button>
							<form action="forgetpassword.php" method="post">                            
                        </form>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="backoffice/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="backoffice/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vvendor/bootstrap/js/popper.js"></script>
	<script src="backoffice/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="backoffice/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="backoffice/vendor/daterangepicker/moment.min.js"></script>
	<script src="backoffice/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="backoffice/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="backoffice/js/main.js"></script>

</body>
</html>