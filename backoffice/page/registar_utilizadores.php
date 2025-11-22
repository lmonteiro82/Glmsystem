<?php include ("header.php"); ?>

<?php

    // if(isset($_POST['btn_registar']))
    // {
    //     if(isset($_POST['nome_registar']) && isset($_POST['email_registar']) && isset($_POST['numero_registar']) && isset($_POST['nivel_registar']))
    //     {
        
    //         if($_POST['nome_registar']=='' || $_POST['email_registar']=='' || $_POST['numero_registar']=='' || $_POST['nivel_registar']==''){
    //             $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
    //         }
    //         else{
    //             $p=password_hash($_POST['dfpass'], PASSWORD_DEFAULT);
            
    //             $qr = "INSERT INTO login(user,email,numero,password,nivel) VALUES(?,?,?,?,?)";
                
                
    //             $ordem = $ms->prepare($qr);
                
    //             $ordem->bind_param('ssisi', $_POST["nome_registar"], $_POST["email_registar"], $_POST["numero_registar"], $p, $_POST["nivel_registar"]);
                

    //             // Executar o query (verificar se não dá erro e o número de registos afetados)
    //             if ($ordem->execute() && $ordem->affected_rows>0){
    //                 $msg='<h3 class="sucesso">O Utilizador foi inserido!</h3>';
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


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 style="text-align: center;">Centro de gestão de utilizadores</h1>

                    <!-- <form method="post">
                        <input class="form-control" type="file" id="foto1" name="foto">
                        <img src="..\..\assets\imgs\img-9.jpg" id="imagem" alt="Imagem de perfil">
                        <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome">
                        <input class="form-control" type="text" id="email" name="email" placeholder="Email">
                    </form> -->

                    <!-- Desktop------------------------------------------------------------------------------------------------ -->

                    <div class="container" id="cont_registar_desktop">
                        <form method="POST" action="mail.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <img src="../../assets/imgs/notfound.jpg" id="imagem_registar" alt="Imagem de perfil">
                                </div>

                                <div class="col-12 col-lg-4">
                                    <input class="form-control" type="text" id="nome_registar" name="nome_registar" placeholder="Nome">
                                    <input class="form-control inputs-registar" type="email" id="email_registar" name="email_registar" placeholder="Email">
                                    <input class="form-control inputs-registar" type="number" id="numero_registar" name="numero_registar" placeholder="Número">
                                    <input class="form-control" type="hidden" id="dfpass" name="dfpass" value="admin5002">
                                    <input class="btn button" type="submit" id="btn_registar" name="btn_registar" value="Inserir">
                                </div>

                                <div class="col-12 col-lg-4">
                                    <input class="form-control" type="number" id="nivel_registar" name="nivel_registar" min="1" max="3">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- mobile------------------------------------------------------------------------------------------------- -->

                    <div class="container" id="cont_registar_mobile">
                        <form method="POST" action="mail.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <img src="../../assets/imgs/notfound.jpg" id="imagem_registar" alt="Imagem de perfil">
                                </div>

                                <div class="col-12 col-lg-4">
                                    <input class="form-control espaco" type="text" id="nome_registar" name="nome_registar" placeholder="Nome">
                                    <input class="form-control inputs-registar espaco" type="email" id="email_registar" name="email_registar" placeholder="Email">
                                    <input class="form-control inputs-registar espaco" type="number" id="numero_registar" name="numero_registar" placeholder="Número">
                                    <input class="form-control espaco" type="hidden" id="dfpass" name="dfpass" value="admin5002">
                                    <input class="form-control espaco" type="number" id="nivel_registar" name="nivel_registar" min="1" max="3">
                                </div>

                                <div class="col-12 col-lg-4">
                                    <input class="btn button" type="submit" id="btn_registar" name="btn_registar" value="Inserir">
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