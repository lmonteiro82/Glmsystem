<?php

include ("header.php");

?>

<?php

    $qr = "select texto from textos where nome='sobrenos'";		
    $ordem = $ms->prepare($qr);
    $ordem->execute();
    $ordem->bind_result($texto);
    $ordem->fetch();
    $ordem->close();

    if (isset($_POST['but_sobrenos']))
    {

        if($_POST['textarea']==''){
            $msg="ERRO, tem de preencher o campo de texto!";
        }
        else
        {
            $qr = "update textos set texto=? where nome='sobrenos'";	
            $ordem = $ms->prepare($qr);			
            $ordem->bind_param('s', $_POST["textarea"]);
            $texto=$_POST["textarea"];
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

                    <h1 style="text-align: center;">Editar Texto</h1>

                    <div class="row">
                        <div class="col">
                            
                        </div>

                        <div class="col-xl-8">
                            <form method="POST">
                                <textarea class="padding-select" rows="10" cols="40" id="textarea" name="textarea"><?php echo $texto ?></textarea>
                                <br><br>

                                <input class="btn button" type="submit" id="but_sobrenos" name="but_sobrenos" value="Salvar">
                            </form>
                        </div>
                        <div class="col">
                            
                        </div>
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