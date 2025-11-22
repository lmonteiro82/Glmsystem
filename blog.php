<?php include ("header.php"); ?>

<?php include ("bd.php"); ?>

<header id="home" class="header">
    <div class="overlay"></div>

    <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">  
        <div class="container">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="carousel-title">Leia todas <br> as publicções aqui</h1>
                        <a class="btn btn-primary btn-rounded" href="#blog">Descer</a>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="infos container mb-4 mb-md-2">
        <div class="title" style="margin-top: -40px;">
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

<section class="section">

    <div class="container mb-3">
        <h6 class="xs-font mb-0">Todas as noticias apareceram nesta página!</h6>
        <h3 class="section-title mb-5">Nosso Blog</h3>

        <?php
        $sq="select * from blog";
        $results = $ms->query($sq);
        while($row = $results->fetch_array()) { ?>
            <div class="blog-wrapper">
                <div class="img-wrapper">
                    <img src="backoffice/page/<?php echo $row["imagem"] ?>" alt="Thumbnail">
                    <div class="date-container">
                        <h6 class="day"><?php echo $row["dia"] ?></h6>
                        <h6 class="mun"><?php echo $row["mes"] ?></h6> 
                    </div>
                </div>
                <div class="txt-wrapper">
                    <h4 class="blog-title"><?php echo $row["titulo"] ?></h4>
                    <p><?php echo $row["texto"] ?></p>

                    <a class="badge badge-info" style="color: #ffffff; background-color: #9E3223"><?php echo $row["tema"] ?></a>
                </div>
            </div>
            <?php
        }
        ?>

    </div>
</section>

<?php include ("footer.php"); ?>