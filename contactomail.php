<?php include("bd.php") ?>

<?php

    $sucesso = false;

    $recaptcha_secret = "6LcShhwpAAAAAFHvfbLmdMU_R6DlytzkiIWoKh-8";
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);

    if ($result['success']) {
        $sucesso = true;
        if(isset($_POST['but']))
        {
            if(isset($_POST['nome1']) && isset($_POST['email1']) && isset($_POST['mensagem1']))
            {
            
                if($_POST['nome1']=='' || $_POST['email1']=='' || $_POST['mensagem1']==''){
                    $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
                }
                else{
                
                
                    $qr = "INSERT INTO contacto(nome,email,menssagem) VALUES(?,?,?)";		
                    
                    
                    
                    $ordem = $ms->prepare($qr);
                    
                    $ordem->bind_param('sss', $_POST["nome1"], $_POST["email1"], $_POST["mensagem1"]);
                    

                    // Executar o query (verificar se não dá erro e o número de registos afetados)
                    if ($ordem->execute() && $ordem->affected_rows>0){
                        
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
    } else {
        // O reCAPTCHA falhou, trate conforme necessário (por exemplo, exiba uma mensagem de erro).
    }

?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'backoffice/page/PHPMailer/src/Exception.php';
require 'backoffice/page/PHPMailer/src/PHPMailer.php';
require 'backoffice/page/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$menssagem = '

<h2>Tem mensagens por ler no seu site</h2>
<h3>Clique no link para ver as mensagens</h3>
<a href="https://Glmsystem.com/backoffice/">Ver mensagens</a>

';

try {
    if ($sucesso == true)
    {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'glmsystem.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'geral@glmsystem.com';                     //SMTP username
        $mail->Password   = 'Gabriela_2016';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('geral@glmsystem.com', 'Site GlmSystem');
        $mail->addAddress('jorgesmonteiro@hotmail.com', 'Jorge Monteiro');     //Add a recipient

        $mail->CharSet = 'UTF-8';

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Site GlmSystem';
        $mail->Body    = $menssagem;

        $mail->send();
        ?><script>window.open("contacto.php", "self")</script><?php
    }
    else
    {
        ?><script>window.open("contacto.php", "self")</script><?php
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}