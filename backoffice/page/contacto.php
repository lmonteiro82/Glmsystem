<?php include ("header.php"); ?>

<?php

    include ("../../bd.php");

    $msg = "";

    $t="";
    
    if(isset($_POST["pesq"])){
        $t = $_POST["pesq"];
    }
    
?>

<?php

    if (isset($_POST['eliminar']))
    {

        if($_POST['id']==''){
            $msg="ERRO, tem de preencher o campop número";
        }
        else
        {
            $qr = "delete from contacto where id=?";
            $ordem = $ms->prepare($qr);				
            $ordem->bind_param('i', $_POST["id"]);
            if ($ordem->execute() && $ordem->affected_rows>0){
                $msg='<h3 class="sucesso">O contacto foi Eliminado!</h3>';
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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Emails Recebidos</h6>
                            <form method="post">
                                <p><i class="fa-sharp fa-solid fa-magnifying-glass fa-xl" style="float: left; margin-top: 18px;"></i><input class="form-control" type="text" id="pesq" name="pesq" placeholder="<?php echo $t ?>" style="width: 200px; margin-left: 30px; padding-right: 35px;"><button type="submit" id="xmark"><i class="fa-sharp fa-solid fa-xmark"></i></button></p>
                            </form>
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                    $d="";
                                    if (isset($_POST['pesq']))
                                    {
                                        if($_POST['pesq']==''){
                                            $msg="Tem de preencher o campo pesquisar";
                                        }
                                        else
                                        {
                                            $d = "where nome='".$_POST["pesq"]."'";
                                        }
                                    }
                                $sq='select * from contacto '. $d;
                                $results = $ms->query($sq);
                                echo '<table class="table table-bordered" id="dataTable" style="width: 1055px; overflow-x: scroll;" cellspacing="0"';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th style="text-align: center;"><b>Data</b></th>';
                                echo '<th style="text-align: center;"><b>Nome</b></th>';
                                echo '<th style="text-align: center;"><b>Email</b></th>';
                                echo '<th style="text-align: center;"><b>Texto</b></th>';
                                echo '<th></th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tfoot>';
                                echo '<tr>';
                                echo '<th style="text-align: center;"><b>Data</b></th>';
                                echo '<th style="text-align: center;"><b>Nome</b></th>';
                                echo '<th style="text-align: center;"><b>Email</b></th>';
                                echo '<th style="text-align: center;"><b>Texto</b></th>';
                                echo '<th></th>';
                                echo '</tr>';
                                echo '</tfoot>';
                                while($row = $results->fetch_array()) {
                                    echo'<tbody>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;">'.$row["data"].'</th>';
                                    echo '<th style="text-align: center;">'.$row["nome"].'</th>';
                                    echo '<th style="text-align: center;">'.$row["email"].'</th>';
                                    echo '<th style="text-align: center;">'.$row["menssagem"].'</th>';
                                    ?>
                                    <form method="post">
                                    <?php
                                    echo '<input type="hidden" id="id" name="id" value="' . $row["id"] . '">';
                                    echo '<th colspan="2"><input class="btn button" type="submit" id="eliminar" name="eliminar" value="Eliminar" style="width: -webkit-fill-available;"></th>';
                                    ?>
                                    </form>
                                    <?php
                                    echo '</tr>';
                                    }
                                
                                echo'</tbody>';
                                print '</table>';
                                    // Frees the memory associated with a result
                                    $results->free();
                                    $ms->close();
                                
                                ?>
                            </div>
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