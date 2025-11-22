<?php include ("header.php"); ?>

<?php

    $qr = "select texto from textos where nome='cjorge'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($jorge);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='cmarcio'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($marcio);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='cleandro'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($leandro);
    $ordem->fetch();
    $ordem->close();

    $qr = "select texto from textos where nome='clucia'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($lucia);
    $ordem->fetch();
    $ordem->close();

    if (isset($_POST['but_jorge']))
    {

        if($_POST['textarea_jorge']==''){
            $msg="ERRO, tem de preencher o campo de texto!";
        }
        else
        {
            $qr = "update textos set texto=? where nome='cjorge'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["textarea_jorge"]);
            $jorge=$_POST["textarea_jorge"];
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
        }
    }

    if (isset($_POST['but_marcio']))
    {

        if($_POST['textarea_marcio']==''){
            $msg="ERRO, tem de preencher o campo de texto!";
        }
        else
        {
            $qr = "update textos set texto=? where nome='cmarcio'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["textarea_marcio"]);
            $marcio=$_POST["textarea_marcio"];
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
        }
    }

    if (isset($_POST['but_leandro']))
    {

        if($_POST['textarea_leandro']==''){
            $msg="ERRO, tem de preencher o campo de texto!";
        }
        else
        {
            $qr = "update textos set texto=? where nome='cleandro'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["textarea_leandro"]);
            $leandro=$_POST["textarea_leandro"];
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
        }
    }

    if (isset($_POST['but_lucia']))
    {

        if($_POST['textarea_lucia']==''){
            $msg="ERRO, tem de preencher o campo de texto!";
        }
        else
        {
            $qr = "update textos set texto=? where nome='clucia'";		
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('s', $_POST["textarea_lucia"]);
            $lucia=$_POST["textarea_lucia"];
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

                    <h1 style="text-align: center; margin-bottom: 3%;">Editar Equipa</h1>

                    <div class="row">
                    <div class="col"></div>
                    <div class="col-xl-8">
                        <select onchange="go(h=this.value)" class="form-select" aria-label="Default select example" id="home3_select">
                            <option value="jorge" selected>jorge Monteiro</option>
                            <option value="marcio">Marcio Silva</option>
                            <option value="leandro">Leandro Monteiro</option>
                            <option value="lucia">Lúcia Monteiro</option>
                        </select>
                        <div id="form_jorge">
                            <form method="POST">
                                <textarea class="padding-select style-textarea" rows="10" cols="40" id="textarea_jorge" name="textarea_jorge"><?php echo $jorge ?></textarea>
                                <br><br>

                                <input class="btn button" type="submit" id="but_jorge" name="but_jorge" value="Salvar">
                            </form>
                        </div>

                        <div id="form_marcio">
                            <form method="POST">
                                <textarea class="padding-select style-textarea" rows="10" cols="40" id="textarea_marcio" name="textarea_marcio"><?php echo $marcio ?></textarea>
                                <br><br>

                                <input class="btn button" type="submit" id="but_marcio" name="but_marcio" value="Salvar">
                            </form>
                        </div>

                        <div id="form_leandro">
                            <form method="POST">
                                <textarea class="padding-select style-textarea" rows="10" cols="40" id="textarea_leandro" name="textarea_leandro"><?php echo $leandro ?></textarea>
                                <br><br>

                                <input class="btn button" type="submit" id="but_leandro" name="but_leandro" value="Salvar">
                            </form>
                        </div>

                        <div id="form_lucia">
                            <form method="POST">
                                <textarea class="padding-select style-textarea" rows="10" cols="40" id="textarea_lucia" name="textarea_lucia"><?php echo $lucia ?></textarea>
                                <br><br>

                                <input class="btn button" type="submit" id="but_lucia" name="but_lucia" value="Salvar">
                            </form>
                        </div>
                        
                    </div>
                    <div class="col"></div>
                    </div>

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