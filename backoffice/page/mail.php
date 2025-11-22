<?php include("../../bd.php") ?>

<?php

    if(isset($_POST['btn_registar']))
    {
        if(isset($_POST['nome_registar']) && isset($_POST['email_registar']) && isset($_POST['numero_registar']) && isset($_POST['nivel_registar']))
        {
        
            if($_POST['nome_registar']=='' || $_POST['email_registar']=='' || $_POST['numero_registar']=='' || $_POST['nivel_registar']==''){
                $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
            }
            else{
                $p=password_hash($_POST['dfpass'], PASSWORD_DEFAULT);
            
                $qr = "INSERT INTO login(user,email,numero,password,nivel) VALUES(?,?,?,?,?)";
                
                
                $ordem = $ms->prepare($qr);
                
                $ordem->bind_param('ssisi', $_POST["nome_registar"], $_POST["email_registar"], $_POST["numero_registar"], $p, $_POST["nivel_registar"]);
                

                // Executar o query (verificar se não dá erro e o número de registos afetados)
                if ($ordem->execute() && $ordem->affected_rows>0){
                    $msg='<h3 class="sucesso">O Utilizador foi inserido!</h3>';
                }
                else{
                    $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                    $erro=1;
                }
                $ordem->close();
            }
        }
        else{
            $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
            $erro=1;
        }
            
        
    }

?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$menssagem = '
<h3>Ola '. $_POST['nome_registar'] .'</h3>
<p>Você foi registado com o nivel '. $_POST['nivel_registar'] .' no site da GlmSystem.</p>
<p>As suas credências para entrar no BackOffice do nosso site são as seguintes.</p>

<table>
    <tr>
        <td>Username:</td>
        <td>'. $_POST['nome_registar'] .'</td>
    </tr>
    <tr>
        <td>Password:</td>
        <td>admin5002</td>
    </tr>
</table>

<p><b>Aviso:</b> Pode mudar a Password no nosso site.</p>

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
    $mail->addAddress($_POST['email_registar'], $_POST['nome_registar']);     //Add a recipient
    $mail->addAddress('jorgesmonteiro@hotmail.com');               //Name is optional

    $mail->CharSet = 'UTF-8';

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Site GlmSystem';
    $mail->Body    = $menssagem;

    $mail->send();
    ?><script>window.open("registar_utilizadores.php", "_self")</script><?php
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}