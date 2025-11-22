<?php include ("header.php"); ?>

<?php include ("bd.php"); ?>

<header id="home" class="header">
    <div class="overlay"></div>

    <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">  
        <div class="container">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="carousel-title">Veja todos <br> os nossos Produtos </h1>
                        <a class="btn btn-primary btn-rounded" href="#shop">Descer</a>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="infos container mb-4 mb-md-2">
        <div class="title" style="margin-top: -40px;">
            <h6 class="subtitle font-weight-normal">Procura trabalho qualificado?</h6>
            <h5 id="shop">Chegou ao sitio certo</h5>
            <p class="font-small">Na GlmSystem encontra trabalho de confiança</p>
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

<section id="navs">

    <!-- ============= COMPONENT ============== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation" id="toggler">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
            <?php
            $sq="select * from titulos";
            $results = $ms->query($sq);
            while($row = $results->fetch_array()) {
                if ($row['dropdown'] == "sim"){
                    $aa = $row["nome"]; ?>
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><?php echo $row["nome"] ?></a>
                        <div class="dropdown-menu megamenu" role="menu">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <div class="col-megamenu">
                                        <ul class="list-unstyled">
                                        <?php
                                        $qs="select * from categorias";
                                        $result = $ms->query($qs);
                                        while($row = $result->fetch_array()) {
                                            if ($row["correspondente"] == $aa){?>
                                                <li><form method="post"><input type="submit" id="bbb" name="bbb" value="<?php echo $row["nome"] ?>"></form></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </ul>
                                    </div>  <!-- col-megamenu.// -->
                                </div><!-- end col-3 -->
                            </div><!-- end row --> 
                        </div> <!-- dropdown-mega-menu.// -->
                    </li>
                    <?php
                }
            }

            $sq="select * from titulos";
            $results = $ms->query($sq);
            while($row = $results->fetch_array()) {
                if ($row['dropdown'] == "nao"){?>
                    <li><form method="post"><input type="submit" id="aaa" name="bbb" value="<?php echo $row["nome"] ?>"></form></li>
                <?php
                }
            }
            ?>

        </div> <!-- navbar-collapse.// -->
    </div> <!-- container-fluid.// -->
</nav>
    

    <div class="container" id="main">
        <?php

            if (isset($_POST["bbb"])){?>

                <div id="div_controladoras" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    <?php
                        $sq="select * from produtos";
                        $results = $ms->query($sq);
                        while($row = $results->fetch_array()) {
                            if ($row["categoria"] == $_POST["bbb"]){ ?>
                                <div class="col">
                                    <div class="card cards">
                                        <img src="backoffice/page/<?php echo $row["imagem"] ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $row["nome"] ?></h5>
                                            <p class="card-text"><?php echo $row["texto"] ?></p>
                                            <a href="<?php echo $row["link"] ?>" class="btn btn-primary" target="_blank" style="float: left;">Ver Mais</a>
                                            <h4 style="margin-left: 80%;"><?php echo $row["preco"] ?>€</h4>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
                <?php
            }
        
        ?>

    </div>
</section>

<?php include ("footer.php"); ?>