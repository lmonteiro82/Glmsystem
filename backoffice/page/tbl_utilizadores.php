<?php include ("header.php"); ?>

<?php

    // if (isset($_POST['alterar']))
    // {
    //     $sq="select * from login";
    //     $results = $ms->query($sq);
    //     while($row = $results->fetch_array()) {
    //         if ($_POST["id"] == $row['id']){
    //             $qr = "update login set nivel=? where id='". $row["id"] ."'";
    //             $ordem = $ms->prepare($qr);		
    //             $ordem->bind_param('i', $_POST["nivel1"]);
    //             $nivel=$_POST["nivel1"];
    //             if ($ordem->execute() && $ordem->affected_rows>0){
    //                 $msg='<h3 class="sucesso">O utilizador foi alterado!</h3>';
    //             }
    //             else{
    //                 $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
    //                 $erro=1;
    //             }
    //             $ordem->close();
    //         }
    //     }
    // }

    if (isset($_POST['eliminar']))
        {
            $sq="select * from login";
            $results = $ms->query($sq);
            while($row = $results->fetch_array()) {
                if ($_POST["id"] == $row['id']){
                    $qr = "delete from login where id='". $row["id"] ."'";
                    $ordem = $ms->prepare($qr);
                    if ($ordem->execute() && $ordem->affected_rows>0){
                        $msg='<h3 class="sucesso">O utilizador foi eliminado!</h3>';
                    }
                    else{
                        $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                        $erro=1;
                    }
                    $ordem->close();
                }
            }
        }

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 style="text-align: center;">Centro de gestão de utilizadores</h1>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4" style="margin-top: 50px;">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Tabela de utilizadores</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <?php
                                        $sq='select * from login';
                                        $results = $ms->query($sq);
                                        echo '<table class="table table-bordered" id="dataTable_users" style="width: 600px; overflow-x: scroll; margin: auto;" cellspacing="0"';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th style="text-align: center;"><b>Nome</b></th>';
                                        echo '<th style="text-align: center;"><b>Nivel</b></th>';
                                        echo '<th colspan="2"></th>';
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tfoot>';
                                        echo '<tr>';
                                        echo '<th style="text-align: center;"><b>Nome</b></th>';
                                        echo '<th style="text-align: center;"><b>Nivel</b></th>';
                                        echo '<th colspan="2"></th>';
                                        echo '</tr>';
                                        echo '</tfoot>';
                                        $v=0;
                                        echo '<tr>';
                                        ?>
                                        <form method="POST" name="lista<?php echo $b ?>">
                                            <?php
                                        while($row = $results->fetch_array()) {
                                            if ($row["id"] == 1){
                                                $v++;
                                                echo'<tbody>';
                                                echo '<tr>';
                                                ?>
                                                <form method="POST" name="lista<?php echo $v ?>">
                                                <?php
                                                echo '<th><input class="form-control" type="text" id="user1" name="user1" value="'.$row["user"].'" style="width: 100%; text-align: center" disabled></th>';
                                                echo '<th style="width: 15%;"><input class="form-control" type="number" id="nivel1" name="nivel1" value="'.$row["nivel"].'" style="width: 100%; text-align: center;" min="1" max="2" disabled></th>';
                                                echo '<th colspan="2"></th>';
                                                ?>
                                                </form>
                                                <?php
                                            }
                                            else{
                                                $v++;
                                                echo'<tbody>';
                                                echo '<tr>';
                                                ?>
                                                <form method="POST" name="lista<?php echo $v ?>">
                                                <?php
                                                echo '<input class="form-control" type="hidden" id="id" name="id" value="'.$row["id"].'">';
                                                echo '<th><input class="form-control" type="text" id="user1" name="user1" value="'.$row["user"].'" style="width: 100%; text-align: center;" disabled></th>';
                                                echo '<th style="width: 15%;"><input class="form-control" type="number" id="nivel1" name="nivel1" value="'.$row["nivel"].'" style="width: 100%; text-align: center;" min="1" max="3" disabled></th>';
                                                echo '<th><input class="btn button" type="submit" id="eliminar" name="eliminar" value="Eliminar" style="width: -webkit-fill-available;"></th>';
                                                ?>
                                                </form>

                                                <form action="alterar_utilizadores.php" method="POST">
                                                <?php
                                                echo '<input type="hidden" id="id_hidden" name="id_hidden" value="'.$row["id"].'">';
                                                echo '<th><input class="btn button" type="submit" id="alterar" name="alterar" value="Alterar" style="width: -webkit-fill-available;"></th>';
                                                ?>
                                                </form>
                                                <?php
                                            }
                                        }
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