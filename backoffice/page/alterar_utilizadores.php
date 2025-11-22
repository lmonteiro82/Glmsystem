<?php include ("header.php"); ?>

<?php

    if (isset($_POST['btn_registar']))
    {

        if($_POST['nome_registar']=='' && $_POST['email_registar']=='' && $_POST['numero_registar']==''&& $_POST['nivel_registar']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
            if ($_FILES['foto']['error'] == 4 || $_FILES['foto']['size'] == 0 && $_FILES['foto']['error'] == 0){
                // $p=password_hash($_POST['newpass'], PASSWORD_DEFAULT);
                $qr = "update login set user=?, email=?, numero=?, nivel=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('ssii',$_POST["nome_registar"], $_POST["email_registar"], $_POST["numero_registar"], $_POST["nivel_registar"]);
            }
            else{

                $destino =  "fotos/a" . uniqid() . ".jpg" ;

                    if($_FILES["foto"]["type"]=="image/jpeg"){
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $qr = "update login set imagem=?, user=?, email=?, numero=?, nivel=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('sssii', $destino, $_POST["nome_registar"], $_POST["email_registar"], $_POST["numero_registar"], $_POST["nivel_registar"]);
                }
                }

            }
            if ($ordem->execute() && $ordem->affected_rows>0){
                if (isset($_POST['nome_registar'])){
                    ?> <script>window.open("tbl_utilizadores.php", "_self");</script> <?php
                }
        
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
        }
    }

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 style="text-align: center;">Editar o seu perfil</h1>

                    <div class="container" id="cont_registar">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <input class="form-control" type="file" id="foto_registar" name="foto">
                                    <?php
                                        $sq="select * from login";
                                        $results = $ms->query($sq);
                                        while($row = $results->fetch_array()) {
                                            if ($_POST["id_hidden"] == $row["id"]){
                                                if ($row["imagem"] == ""){?>
                                                    <img src="../../assets/imgs/notfound.jpg" id="imagem1_registar" alt="Imagem de perfil">
                                                    <?php
                                                }
                                                else{?>
                                                    <img src="<?php echo $row["imagem"] ?>" id="imagem1_registar" alt="Imagem de perfil">
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>

                                <div class="col-12 col-lg-4">
                                <?php
                                    $sq="select * from login";
                                    $results = $ms->query($sq);
                                    while($row = $results->fetch_array()) {
                                        if ($_POST["id_hidden"] == $row["id"]){?>
                                            <input class="form-control" type="hidden" id="id" name="id" value="<?php echo $row["id"] ?>">
                                            <input class="form-control" type="text" id="nome_registar" name="nome_registar" value="<?php echo $row["user"] ?>">
                                            <input class="form-control inputs-registar" type="email" id="email_registar" name="email_registar" value="<?php echo $row["email"] ?>">
                                            <input class="form-control inputs-registar" type="number" id="numero_registar" name="numero_registar" value="<?php echo $row["numero"] ?>">
                                            <input class="btn button" type="submit" id="btn_registar" name="btn_registar" value="Alterar">
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="col-12 col-lg-4">
                                <?php
                                    $sq="select * from login";
                                    $results = $ms->query($sq);
                                    while($row = $results->fetch_array()) {
                                        if ($_POST["id_hidden"] == $row["id"]){?>
                                            <input class="form-control" type="number" id="nivel_registar" name="nivel_registar" value="<?php echo $row["nivel"] ?>" min="1" max="3">
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
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