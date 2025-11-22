<?php include ("header.php"); ?>

<?php

    if(isset($_POST['inserir']))
    {
        if(isset($_POST['inserir1']) && isset($_POST['inserir2']) && isset($_POST['inserir4']) && isset($_POST['inserir5']) && isset($_POST['inserir6']))
        {
        
            if($_POST['inserir1']=='' || $_POST['inserir2']=='' || $_POST['inserir4']=='' || $_POST['inserir5']=='' || $_POST['inserir6']==''){
                $msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
            }
            else{
                $destino =  "fotos/a" . uniqid() . ".jpg" ;

                    if($_FILES["foto"]["type"]=="image/jpeg"){
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            
                $qr = "INSERT INTO blog(dia,mes,imagem,titulo,texto,tema) VALUES(?,?,?,?,?,?)";
                
                $ordem = $ms->prepare($qr);
                
                $ordem->bind_param('isssss', $_POST["inserir1"], $_POST["inserir2"], $destino, $_POST["inserir4"], $_POST["inserir5"], $_POST["inserir6"]);
                

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

    if (isset($_POST['eliminar']))
    {

        if($_POST['id']==''){
            $msg="ERRO, tem de preencher o campo número";
        }
        else
        {
            $qr = "delete from blog where id=?";	
            $ordem = $ms->prepare($qr);
            $ordem->bind_param('i', $_POST["id"]);
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
<div class="container-fluid" id="container-blog">
    <h1>Criar Notícia</h1>
    
    <!-- Desktop -->

    <div id="desktop">
        <form method="post" enctype="multipart/form-data">
            <div class="row" style="margin-top: 50px;">
                <div class="col">
                    <input class="form-control form-style" type="number" id="inserir1" name="inserir1" placeholder="Dia">
                </div>

                <div class="col">
                    <input class="form-control form-style" type="text" id="inserir2" name="inserir2" placeholder="Mês">
                </div>
            </div>
            <div class="row" style="margin-top: 80px;">
                <div class="col">
                    <input class="form-control form-style" type="file" id="foto" name="foto" placeholder="Imagem">
                </div>

                <div class="col">
                    <input class="form-control form-style" type="text" id="inserir4" name="inserir4" placeholder="Titulo">
                </div>
            </div>
            <div class="row" style="margin-top: 80px;">
                <div class="col">
                    <textarea class="form-control form-textarea" rows="2" cols="30" id="inserir5" name="inserir5" placeholder="Texto"></textarea>
                </div>

                <div class="col">
                    <input class="form-control form-style" type="text" id="inserir6" name="inserir6" placeholder="Tema">
                </div>
            </div>
            <input class="btn button" type="submit" id="inserir" name="inserir" value="Criar" style="margin-top: 50px;">
        </form>
        </div>

    <!-- smartphone -->

    <div id="smartphone">
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <input class="form-control form-style" type="number" id="inserir1" name="inserir1" style="margin-top: 20px;" placeholder="Dia">
            </div><div class="row">
                <input class="form-control form-style" type="text" id="inserir2" name="inserir2" style="margin-top: 30px;" placeholder="Mês">
            </div>
            <div class="row">
                <input class="form-control form-style" type="file" id="foto" name="foto" style="margin-top: 30px;" placeholder="Imagem">
            </div>
            <div class="row">
                <input class="form-control form-style" type="text" id="inserir4" name="inserir4" style="margin-top: 30px;" placeholder="Titulo">
            </div>
            <div class="row" style="margin-top: 10%;">
                <div class="col">
                    <textarea class="form-control form-textarea" rows="1" cols="30" id="inserir5" name="inserir5" placeholder="Texto"></textarea>
                </div>
            </div>
            <div class="row">
                <input class="form-control form-style" type="text" id="inserir6" name="inserir6" style="margin-top: 30px;" placeholder="Tema">
            </div>
            <input class="btn button" type="submit" id="inserir" name="inserir" value="Criar" style="margin-top: 20px;">
        </form>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4" style="margin-top: 50px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Tabela de Emails recebidos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                    $sq='select * from blog';
                    $results = $ms->query($sq);
                    echo '<table class="table table-bordered" id="dataTable_blog" style="width: 1300px; overflow-x: scroll;" cellspacing="0"';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th><b>Dia</b></th>';
                    echo '<th><b>Mês</b></th>';
                    echo '<th><b>Imagem</b></th>';
                    echo '<th><b>Titulo</b></th>';
                    echo '<th><b>Texto</b></th>';
                    echo '<th><b>Tema</b></th>';
                    echo '<th></th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tfoot>';
                    echo '<tr>';
                    echo '<th><b>Dia</b></th>';
                    echo '<th><b>Mês</b></th>';
                    echo '<th><b>Imagem</b></th>';
                    echo '<th><b>Titulo</b></th>';
                    echo '<th><b>Texto</b></th>';
                    echo '<th><b>Tema</b></th>';
                    echo '<th></th>';
                    echo '</tr>';
                    echo '</tfoot>';
                    $v=0;
                    while($row = $results->fetch_array()) {
                        $v++;
                        echo'<tbody>';
                        echo '<tr>';
                        ?>
                        <form method="POST" name="lista<?php echo $v ?>">
                        <?php
                        echo '<input class="form-control" type="hidden" id="id" name="id" value="'.$row["id"].'">';
                        echo '<th><input class="form-control" type="number" id="dia1" name="dia1" value="'.$row["dia"].'" style="width: 100%;" disabled></th>';
                        echo '<th><input class="form-control" type="text" id="mes1" name="mes1" value="'.$row["mes"].'" style="width: 100%;" disabled></th>';
                        echo '<th><input class="form-control" type="text" id="imagem1" name="imagem1" value="'.$row["imagem"].'" style="width: 100%;" disabled></th>';
                        echo '<th style="width: 20%;"><input class="form-control" type="text" id="titulo1" name="titulo1" value="'.$row["titulo"].'" style="width: 100%;" disabled></th>';
                        echo '<th style="width: 30%;"><input class="form-control" type="text" id="texto1" name="texto1" value="'.$row["texto"].'" style="width: 100%;" disabled></th>';
                        echo '<th><input class="form-control" type="text" id="tema1" name="tema1" value="'.$row["tema"].'" style="width: 100%;" disabled></th>';
                        echo '<th><input class="btn button" type="submit" id="eliminar" name="eliminar" value="Eliminar" style="width: -webkit-fill-available;">';
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