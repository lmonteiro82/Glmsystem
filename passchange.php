<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Gestor-GlmSystem</title>
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
	<link rel="stylesheet" type="text/css" href="backoffice/css/main.css?1.0.2">
<!--===============================================================================================-->
</head>
<body>

	<?php
		include ("bd.php");
		
		$msg = "";

		if(isset($_POST['but'])){

			if ($_POST['pass1'] == $_POST['pass2']){
                                
                $sq="select * from login";
                $results = $ms->query($sq);
                while($row = $results->fetch_array()) {
                    if($_POST["user1"] == $row["user"]){
                        $qr = "update login set password=? where user=?";
                        $p=password_hash($_POST['pass1'], PASSWORD_DEFAULT);
                        $ordem = $ms->prepare($qr);
                        $ordem->bind_param('ss', $p, $_POST["user1"]);
                        $password=$p;
                        if ($ordem->execute() && $ordem->affected_rows>0){

                            ?><script>window.open("backoffice/", "_self")</script><?php

                        }
                        else{
                            $msg='<p class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</p>';
                            $erro=1;
                        }
                        $ordem->close();
                    }
                }

            }
            else{
                $msg='<p>Palavras-passe diferentes, tente de novo</p>';
            }
		}

	?>

	<div class="limiter">
		<div class="container-login100 background">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title p-b-49">
						Palavra-Passe
					</span>

					<?php echo $msg; ?>

                    <form method="post">
                    <div class="wrap-input100 validate-input" data-validate="Este campo é obrigatório">
						<span class="label-input100">Insira o seu utilizador</span>
						<input class="input100" type="text" id="user1" name="user1" placeholder="Escreva o seu utilizador">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Este campo é obrigatório">
						<span class="label-input100">Nova Palavra-Passe</span>
						<input class="input100" type="password" id="pass1" name="pass1" placeholder="Escreva uma seu Palavra-Passe">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Este campo é obrigatório">
						<span class="label-input100">Repetir Palavra-Passe</span>
						<input class="input100" type="password" id="pass2" name="pass2" placeholder="Repita a Palavra-Passe">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					<br><br>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" id="but" name="but">
								Submeter
							</button>
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
	<script src="backoffice/vendor/bootstrap/js/popper.js"></script>
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