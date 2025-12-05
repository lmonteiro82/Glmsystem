<?php include ("header.php"); ?>

<?php

    include ("bd.php");

    // if(isset($_POST['but']))
    // {
    //     if(isset($_POST['nome1']) && isset($_POST['email1']) && isset($_POST['mensagem1']))
    //     {
        
    //         if($_POST['nome1']=='' || $_POST['email1']=='' || $_POST['mensagem1']==''){
    //             $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
    //         }
    //         else{
            
            
    //             $qr = "INSERT INTO contacto(nome,email,menssagem) VALUES(?,?,?)";		
                
                
                
    //             $ordem = $ms->prepare($qr);
                
    //             $ordem->bind_param('sss', $_POST["nome1"], $_POST["email1"], $_POST["mensagem1"]);
                

    //             // Executar o query (verificar se não dá erro e o número de registos afetados)
    //             if ($ordem->execute() && $ordem->affected_rows>0){
                    
    //             }
    //             else{
    //                 $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
    //                 $erro=1;
    //             }
    //             $ordem->close();
    //         }
    //     }
    //     else{
    //         $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
    //         $erro=1;
    //     }
            
        
    // }

?>

    <header id="home" class="header">
        <div class="overlay"></div>

        <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">  
            <div class="container">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="carousel-caption d-none d-md-block">
                            <h1 class="carousel-title">Contacte-nos <br>aqui</h1>
                            <a class="btn btn-primary btn-rounded" href="#blog">Descer</a>
                        </div>
                    </div>
                </div>
            </div>        
        </div>

        <div class="infos container mb-4 mb-md-2">
            <div class="title"  style="margin-top: -40px;">
                <h6 class="subtitle font-weight-normal">Procura trabalho qualificado?</h6>
                <h5>Chegou ao sitio certo</h5>
                <p class="font-small" id="blog">Na GlmSystem encontra trabalho de confiança</p>
            </div>
            <div class="socials text-right">
                <div class="row justify-content-between">
                    <div class="col">
                        <a class="d-block subtitle"><i class="ti-microphone pr-2"></i>(+351)&nbsp;&nbsp; 9 3 5 9 1 4 6 8 1</a>
                        <a class="d-block subtitle"><b>(Chamada para a rede móvel nacional)</b></a>
                        <a class="d-block subtitle" href="mailto: geral@glmsystem.com" style="color: white;"><i class="ti-email pr-2"></i>geral@glmsystem.com</a>
                    </div>
                    <div class="col">
                        <h6 class="subtitle font-weight-normal mb-2">Social Media</h6>
                        <div class="social-links">
                            <a href="https://www.facebook.com/glmsystem" class="link pr-1"><i class="ti-facebook"></i></a>
                            <a href="https://www.linkedin.com/in/jorge-monteiro-a2183b45/" class="link pr-1"><i class="ti-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="contact" class="section pb-0">
        <div class="container">
            <h3 class="section-title mb-5">Suporte</h3>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-8 col-lg-7">
                    <form class="contact-form" action="contactomail.php" method="POST">
                        <div class="form-row">
                            <div class="col form-group">
                                <input type="text" class="form-control" id="nome1" name="nome1" placeholder="Nome">
                            </div>
                            <div class="col form-group">
                                <input type="email" class="form-control" id="email1" name="email1" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea cols="30" rows="5" class="form-control" id="mensagem1" name="mensagem1" placeholder="Mensagem"></textarea>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6LcShhwpAAAAAEzNqbPWVpeZTRyOb99nhOppbzvK" id="recaptcha"></div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" id="but" name="but" value="Enviar Mensagem">
                        </div>
                    </form>
                </div>
                <div class="col-md-4 d-md-block order-1 info-top">
                    <ul class="list">
                        <li class="list-head">
                            <h6>SUPORTE INFO</h6>
                        </li>
                        <li class="list-body">
                            <p class="py-2">Envie-nos mensagem e receberá uma resposta em 24 horas.</p>
                            <a class="py-2" href="mailto: geral@glmsystem.com">geral@glmsystem.com</a>
                            <p class="py-2">(+351) 966702326</p>
                            <p class="py-2">(Chamada para a rede móvel nacional)</p>
                        </li>
                    </ul> 
                </div>
            </div>
        </div>
    </section>

    <?php
        include ("googlemaps/gmaps.php")
    ?>

<?php include ("footer.php"); ?>