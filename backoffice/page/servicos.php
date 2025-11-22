<?php include ("header.php"); ?>

<?php

    if(isset($_POST['inserir']))
    {
        if(isset($_POST['inserir1']) && isset($_POST['inserir2']))
        {
        
            if($_POST['inserir1']=='' || $_POST['inserir2']==''){
                $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
            }
            else{
                $destino =  "fotos/a" . uniqid() . "jpg" ;

                    if($_FILES["foto"]["type"]=="image/jpeg"){
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            
                $qr = "INSERT INTO servicos(imagem, titulo, texto) VALUES(?,?,?)";
                
                $ordem = $ms->prepare($qr);
                
                $ordem->bind_param('sss',$destino, $_POST["inserir1"], $_POST["inserir2"]);
                

                // Executar o query (verificar se não dá erro e o número de registos afetados)
                if ($ordem->execute() && $ordem->affected_rows>0){
                    
                }
                else{
                    $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                    $erro=1;
                }
                $ordem->close();
            }
            }
            }
        }
        else{
            $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
            $erro=1;
        }
    }

    if (isset($_GET['eliminar']))
    {

        if($_GET['id']==''){
            $msg="ERRO, tem de preencher o campo número";
        }
        else
        {
            $qr = "delete from servicos where id=?";	
            $ordem = $ms->prepare($qr);
            $ordem->bind_param('i', $_GET["id"]);
            if ($ordem->execute() && $ordem->affected_rows>0){
                
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
        }
    }

    // -----------------------------------------------------

    if (isset($_POST['alterar']))
    {

        if($_POST['titulo1']=='' && $_POST['texto1']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
            if ($_FILES['foto']['error'] == 4 || $_FILES['foto']['size'] == 0 && $_FILES['foto']['error'] == 0){

                $qr = "update servicos set titulo=?, texto=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('ss',$_POST["titulo1"], $_POST["texto1"]);
                $titulo=$_POST["titulo1"];
                $texto=$_POST["texto1"];
            
            }
            else{

                    $destino =  "fotos/a" . uniqid() . ".jpg" ;

                    if($_FILES["foto"]["type"]=="image/jpeg"){
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $qr = "update servicos set imagem=?, titulo=?, texto=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('sss', $destino, $_POST["titulo1"], $_POST["texto1"]);
                $imagem=$destino;
                $titulo=$_POST["titulo1"];
                $texto=$_POST["texto1"];
                }
                }
                }
        }
        if ($ordem->execute() && $ordem->affected_rows>0){
            
        }
        else{
            $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
            $erro=1;
        }
        $ordem->close();
    }

?>

<!-- Begin Page Content -->
<div class="container-fluid" id="container-blog">
    <h1>Criar Serviço</h1>
    
    <!-- Desktop -->

    <div id="desktop">
        <form method="post" enctype="multipart/form-data">
            <div class="row" style="margin-top: 80px;">
                <div class="col">
                    <input class="form-control form-style" type="file" id="foto" name="foto" placeholder="Imagem">
                </div>

                <div class="col">
                    <input class="form-control form-style" type="text" id="inserir1" name="inserir1" placeholder="Titulo">
                </div>
            </div>
            <div class="row" style="margin-top: 80px;">
                <div class="col">
                    <textarea class="form-control form-textarea" rows="3" cols="30" id="inserir2" name="inserir2" placeholder="Texto"></textarea>
                </div>
            </div>
            <input class="btn button" type="submit" id="inserir" name="inserir" value="Criar" style="margin-top: 50px;">
        </form>
        </div>

    <!-- smartphone -->

    <div id="smartphone">
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <input class="form-control form-style" type="file" id="foto" name="foto" style="margin-top: 30px;" placeholder="Imagem">
            </div>
            <div class="row">
                <input class="form-control form-style" type="text" id="inserir1" name="inserir2" style="margin-top: 30px;" placeholder="Titulo">
            </div>
            <div class="row" style="margin-top: 50px;">
                <div class="col">
                    <textarea class="form-control form-textarea" rows="2" cols="30" id="inserir2" name="inserir2" placeholder="Texto"></textarea>
                </div>
            </div>
            <input class="btn button" type="submit" id="inserir" name="inserir" value="Criar" style="margin-top: 20px;">
        </form>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4" style="margin-top: 50px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Tabela dos Serviços</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                    $sq='select * from servicos';
                    $results = $ms->query($sq);
                    echo '<table class="table table-bordered" id="dataTable_blog" style="width: 1300px; overflow-x: scroll;" cellspacing="0"';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th><b>Foto</b></th>';
                    echo '<th><b>Titulo</b></th>';
                    echo '<th><b>Texto</b></th>';
                    echo '<th colspan=2></th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tfoot>';
                    echo '<tr>';
                    echo '<th><b>Foto</b></th>';
                    echo '<th><b>Titulo</b></th>';
                    echo '<th><b>Texto</b></th>';
                    echo '<th colspan=2></th>';
                    echo '</tr>';
                    echo '</tfoot>';
                    $ac=0;
                    while($row = $results->fetch_array()) {
                        $ac++;
                        echo'<tbody>';
                        echo '<tr>'; 
                        ?>
                        <form method="POST" enctype="multipart/form-data" name="form<?php echo $ac ?>">
                        <?php
                        echo '<input class="form-control" type="hidden" id="id" name="id" value="'.$row["id"].'">';
                        echo '<th style="width: 13%;"><input class="form-control" type="file" id="foto" name="foto" style="width: 100%;"></th>';
                        echo '<th style="width: 17%;"><input class="form-control" type="text" id="titulo1" name="titulo1" value="'.$row["titulo"].'" style="width: 100%;"></th>';
                        echo '<th><input class="form-control" type="text" id="texto1" name="texto1" value="'.$row["texto"].'" style="width: 100%;"></th>';
                        echo '<th><input class="btn button" type="submit" id="alterar" name="alterar" value="Editar" style="width: 80%;"></th>';
                        echo '<th><input class="btn button" type="submit" id="eliminar" name="eliminar" value="Eliminar" style="width: 80%;"></th>';
                        ?>
                        </form>
                        <?php
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

<?php include ("footer.php"); ?>