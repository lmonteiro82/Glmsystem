<?php include ("header.php"); ?>

<?php

    include("bd.php");

    $qr = "select texto from textos where nome='sobrenos'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($sobrenos);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='servicos'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($servicos);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='produtos'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($produtos);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='trabalho'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($trabalho);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='clientes'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($clientes);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='jorge'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($jorge);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='marcio'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($marcio);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='leandro'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($leandro);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='lucia'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($lucia);
    $ordem->fetch();
    $ordem->close();

    // -----------------------------------------------------

    $qr = "select texto from textos where nome='cjorge'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($cjorge);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='cmarcio'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($cmarcio);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='cleandro'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($cleandro);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='clucia'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($clucia);
    $ordem->fetch();
    $ordem->close();

?>

    <header id="first-header" class="header-video">
        <div class="overlay"></div>
        <div id="start-video">
            <video autoplay muted loop id="bg-video" preload="none">
                <source src="assets/video/video_glmsystem.mp4" type="video/mp4">
            </video>
        </div>

        <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">  
            <div class="container">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="carousel-caption d-none d-md-block">
                            <h1 class="carousel-title">Escolha <br> Bom trabalho </h1>
                            <a class="btn btn-primary btn-rounded" href="index.php#sobre">Sobre Nós</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-caption d-none d-md-block">
                            <h1 class="carousel-title">Escolha <br> Mais eficaz </h1>
                            <a class="btn btn-primary btn-rounded" href="index.php#sobre">Sobre Nós</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-caption d-none d-md-block">
                            <h1 class="carousel-title">Escolha <br> GlmSystem  </h1>
                            <a class="btn btn-primary btn-rounded" href="#sobre">Sobre Nós</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="infos container mb-4 mb-md-2">
            <div class="title" style="margin-top: -40px;">
                <h6 class="subtitle font-weight-normal">Procura trabalho qualificado?</h6>
                <h5>Chegou ao sitio certo</h5>
                <p class="font-small" id="sobre">Na GlmSystem encontra trabalho de confiança</p>
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

    <section class="section">

        <div class="container">

            <div class="row align-items-center mr-auto">
                <div class="col-md-4">
                    <h6 class="xs-font mb-0">Para mais informações contacte a nossa empresa!</h6>
                    <h3 class="section-title">Sobre Nós</h3>
                    <p>
                        <?php echo $sobrenos; ?>
                    </p>
                </div>
                <div class="col-sm-6 col-md-4 ml-auto">
                    <div class="widget">
                        <div class="icon-wrapper">
                            <i class="ti-star"></i>
                        </div>
                        <div class="infos-wrapper">
                            <h4 class="text-primary"><?php echo $servicos; ?></h4>
                            <p>Serviços</p>
                        </div>
                    </div>
                    <div class="widget">    
                        <div class="icon-wrapper">
                            <i class="ti-shopping-cart"></i>
                        </div>
                        <div class="infos-wrapper">
                            <h4 class="text-primary"><?php echo $produtos; ?></h4>
                            <p>Produtos</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="widget">
                        <div class="icon-wrapper">
                            <i class="ti-map-alt"></i>
                        </div>
                        <div class="infos-wrapper">
                            <h4 class="text-primary"><?php echo $trabalho; ?></h4>
                            <p>Trabalho</p>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="icon-wrapper">
                            <i class="ti-user"></i>
                        </div>
                        <div class="infos-wrapper">
                            <h4 class="text-primary"><?php echo $clientes; ?></h4>
                            <p>Clientes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="portfolio">
        <div class="container">
            <h3 class="section-title pb-4">Nossos Serviços</h3>
            <h6 class="xs-font mb-0">Categorias:</h6>
        </div>

        <div id="owl-portfolio" class="owl-carousel owl-theme mt-4">
        <?php
        $sq="select * from servicos";
        $results = $ms->query($sq);
        while($row = $results->fetch_array()) { ?>
            <a href="javascript:void(0)" class="item expertises-item">
                <img src="backoffice/page/<?php echo $row["imagem"] ?>"alt="imagem" class="box-shadow image-center" style="width: 50%;">
                <h6 class="mt-3 mb-2" style="text-align: center;"><?php echo $row["titulo"] ?></h6>
                <p class="xs-font" style="text-align: center;"><?php echo $row["texto"] ?></p>
            </a>
            <?php
        }
        ?>
        <div>
    </section>


    <section class="section" id="testmonial">
        <div class="container">
            <h3 class="section-title">Nossa equipa:</h3>

            <div id="owl-testmonial" class="owl-carousel owl-theme mt-4">
                <div class="item">
                    <div class="textmonial-item">
                        <img src="assets/imgs/jorge.jpg" class="avatar" alt="Jorge">
                        <div class="des">
                            <p><?php echo $jorge; ?></p>

                            <div class="line"></div>
                            <h6 class="name">Jorge Monteiro</h6>
                            <h6 class="xs-font"><?php echo $cjorge; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="textmonial-item">
                        <img src="assets/imgs/marcio.jpg" class="avatar" alt="Marcio">
                        <div class="des">
                            <p><?php echo $marcio; ?></p>

                            <div class="line"></div>
                            <h6 class="name">Marcio Silva</h6>
                            <h6 class="xs-font"><?php echo $cmarcio; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="textmonial-item">
                        <img src="assets/imgs/leandro.png" class="avatar" alt="leandro">
                        <div class="des">
                            <p><?php echo $leandro; ?></p>

                            <div class="line"></div>
                            <h6 class="name">Leandro Monteiro</h6>
                            <h6 class="xs-font"><?php echo $cleandro; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="textmonial-item">
                        <img src="assets/imgs/marcio.jpg" class="avatar" alt="leandro">
                        <div class="des">
                            <p><?php echo $lucia; ?></p>

                            <div class="line"></div>
                            <h6 class="name">Lúcia Monteiro</h6>
                            <h6 class="xs-font"><?php echo $clucia; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include ("footer.php"); ?>

</body>
</html>