<?php include ("header.php"); ?>

<?php

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

    if (isset($_POST['but_estatisticas']))
    {

        if($_POST['servicos1']=='' && $_POST['produtos1']=='' && $_POST['trabalho1']=='' && $_POST['clientes1']==''){
            $msg="ERRO, tem de preencher pelo menos um campo!";
        }
        else
        {
            $qr = "update textos set texto=? where nome='servicos'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["servicos1"]);
            $servicos=$_POST["servicos1"];
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }

            $qr = "update textos set texto=? where nome='produtos'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["produtos1"]);
            $produtos=$_POST["produtos1"];
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }

            $qr = "update textos set texto=? where nome='trabalho'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["trabalho1"]);
            $trabalho=$_POST["trabalho1"];
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }

            $qr = "update textos set texto=? where nome='clientes'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["clientes1"]);
            $clientes=$_POST["clientes1"];
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
        }
    }

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 style="text-align: center;">Editar Estatísticas</h1>

                    <section class="section">

                        <div class="container">
                            <form method="POST">
                                <div class="row align-items-center mr-auto">
                                    <div class="col-sm-6 col-md-6 col-lg-6 ml-auto">
                                        <div class="widget">
                                            <div class="icon-wrapper">
                                                <i class="ti-star"></i>
                                            </div>
                                            <div class="infos-wrapper">
                                                <h4 class="text-primary"><input type="text" class="form-control" id="servicos1" name="servicos1" value="<?php echo $servicos ?>" style="width: 59px;"></h4>
                                                <p>Serviços</p>
                                            </div>
                                        </div>
                                        <div class="widget">    
                                            <div class="icon-wrapper">
                                                <i class="ti-shopping-cart"></i>
                                            </div>
                                            <div class="infos-wrapper">
                                                <h4 class="text-primary"><input type="text" class="form-control" id="produtos1" name="produtos1" value="<?php echo $produtos ?>" style="width: 59px;"></h4>
                                                <p>Produtos</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="widget">
                                            <div class="icon-wrapper">
                                                <i class="ti-map-alt"></i>
                                            </div>
                                            <div class="infos-wrapper">
                                                <h4 class="text-primary"><input type="text" class="form-control" id="trabalho1" name="trabalho1" value="<?php echo $trabalho ?>" style="width: 90px;"></h4>
                                                <p>Trabalho</p>
                                            </div>
                                        </div>
                                        <div class="widget">
                                            <div class="icon-wrapper">
                                                <i class="ti-user"></i>
                                            </div>
                                            <div class="infos-wrapper">
                                                <h4 class="text-primary"><input type="text" class="form-control" id="clientes1" name="clientes1" value="<?php echo $clientes ?>" style="width: 59px;"></h4>
                                                <p>Clientes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input class="btn button" type="submit" id="but_estatisticas" name="but_estatisticas" value="Salvar">
                            </form>
                        </div>
                    </section>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include ("footer.php"); ?>