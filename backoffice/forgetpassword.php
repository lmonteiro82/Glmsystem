<?php include ("../bd.php") ?>

<?php

    if(isset($_POST['but'])){
        $sq="select * from login";
        $results = $ms->query($sq);
        while($row = $results->fetch_array()) {
            if ($_POST['email1'] == $row["email"]) {

                $utilizador = $row['user'];

                ?>

                <script>window.open("../", "_self");</script><?php

            } else {

                    $msg = "<p style='text-align: center;'><b>Utilizador ou Palavra-Passe erradas!</b></p>";

            }
        }
    }

?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'page/PHPMailer/src/Exception.php';
require 'page/PHPMailer/src/PHPMailer.php';
require 'page/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$menssagem = '
<h2>Reparamos que está com problemas no seu login</h2>
<h3>Abra o link abaixo para mudar a sua Password</h3>
<a href="https://glmsystem.com/passchange.php">Abrir link</a>
';

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'glmsystem.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'geral@glmsystem.com';                     //SMTP username
    $mail->Password   = 'Gabriela_2016';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('geral@glmsystem.com', 'GlmSystem');
    $mail->addAddress($_POST['email1'], $utilizador);              //Add a recipient

    $mail->CharSet = 'UTF-8';

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Site GlmSystem';
    $mail->Body    = $menssagem;

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}