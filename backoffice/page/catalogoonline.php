<?php include ("header.php"); ?>

<?php

    include ("../../bd.php");

    if (isset($_POST['alterar']))
    {

        if($_POST['nome1']=='' && $_POST['preco1']=='' && $_POST['texto1']=='' && $_POST['link1']=='' && $_POST['categoria1']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
            if (isset($_POST['foto'])){
                $destino =  "fotos/a" . uniqid() . ".jpg" ;

                    if($_FILES["foto"]["type"]=="image/jpeg"){
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $qr = "update produtos set imagem=?, nome=?, preco=?, link=?, categoria=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('ssisss', $destino, $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"]);
                $imagem=$destino;
                $nome=$_POST["nome1"];
                $preco=$_POST["preco1"];
                $texto=$_POST["texto1"];
                $link=$_POST["link1"];
                $categoria=$_POST["categoria1"];
                }
                }
            
            }
            else{
                    $qr = "update produtos set nome=?, preco=?, texto=?, link=?, categoria=? where id='".$_POST["id"]."'";
                    $ordem = $ms->prepare($qr);
                    $ordem->bind_param('sisss', $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"]);
                    $nome=$_POST["nome1"];
                    $preco=$_POST["preco1"];
                    $texto=$_POST["texto1"];
                    $link=$_POST["link1"];
                    $categoria=$_POST["categoria1"];
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
    
    if (isset($_POST['eliminar']))
    {

        if($_POST['id']==''){
            $msg="ERRO, Ocorreu um problema da nossa parte! Tente mais tarde!";
        }
        else
        {
            $qr = "delete from produtos where id=?";		
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

    if(isset($_POST['inserir']))
	{
		if(isset($_POST['inserir3']) && isset($_POST['inserir4']) && isset($_POST['inserir5']) && isset($_POST['inserir6']))
		{
		
			if($_POST['inserir3']=='' || $_POST['inserir4']=='' || $_POST['inserir5']=='' || $_POST['inserir6']==''){
				$msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
			}
			else{

                $destino =  "fotos/a" . uniqid() . ".jpg" ; 

                if($_FILES["foto"]["type"]=="image/jpeg"){
                    if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
			
			
				$qr = "INSERT INTO produtos(imagem,nome,preco,texto,link,categoria) VALUES(?,?,?,?,?,?)";		
				
				$ordem = $ms->prepare($qr);
				
				$ordem->bind_param('ssisss', $destino, $_POST["inserir2"], $_POST["inserir3"], $_POST["inserir6"], $_POST["inserir4"], $_POST["inserir5"]);
				
	
				// Executar o query (verificar se não dá erro e o número de registos afetados)
				if ($ordem->execute() && $ordem->affected_rows>0){
					$msg='<h3 class="sucesso">O produto foi inserido!</h3>';
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

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Tabela dos Produtos</h6>
                            <div style="float: left;">
                                <form name="listagem" id="listagem" method="post" action="">
            
                                    <select class="form-select" name="pro" style="width: 210px;" onchange="this.form.submit()">
                                            <option value="-1">Selecione a categoria</option>
                                            <?php
                                            $sql="select * from pesquisa";
                                            /*$st=$liga->prepare($sql);
                                            $st->execute();
                                            $st->bind_result($id,$nome,$tipo);
                                            
                                            while ($st->fetch()) {
                                            echo '<option value="'. $id . '">' .$nome. '</option>';
                                    */
                                            $st=$ms->query($sql);
                                            echo '<option value="20">todos</option>';
                                            while ($linha=$st->fetch_array()) {
                                            echo '<option value="'. $linha["nome"] . '">' .$linha["nome"]. '</option>';
                                        }
                                        
                                        $st->close(); 
                                        
                                        ?>
                                    </select>
                                </form>
                            </div>

                            <div>
                                <!-- Pôr botão aqui -->
                                <a class="btn button" href="alterar_categorias.php" id="alterar_categorias">Gerir Categorias</a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                if(!empty($_POST["pro"])){
                                    if($_POST["pro"]=="20") $d="";
                                    else $d="where categoria='".$_POST["pro"]."'";
                                }
                                else $d="";
                                    $sq='select * from produtos '.$d.'';
                                    $results = $ms->query($sq);
                                    echo '<table class="table table-bordered" id="dataTable" style="width: 1055px; overflow-x: scroll;" cellspacing="0"';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th><b>Imagem</b></th>';
                                    echo '<th><b>Nome</b></th>';
                                    echo '<th><b>Preço</b></th>';
                                    echo '<th><b>Texto</b></th>';
                                    echo '<th><b>Link</b></th>';
                                    echo '<th><b>Categoria</b></th>';
                                    echo '<th colspan="2"></th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tfoot>';
                                    echo '<tr>';
                                    echo '<th><b>Imagem</b></th>';
                                    echo '<th><b>Nome</b></th>';
                                    echo '<th><b>Preco</b></th>';
                                    echo '<th><b>Texto</b></th>';
                                    echo '<th><b>Link</b></th>';
                                    echo '<th><b>Categoria</b></th>';
                                    echo '<th colspan="2"></th>';
                                    echo '</tr>';
                                    echo '</tfoot>';
                                    $v=0;
                                    $b=0;
                                    echo '<tr>';
                                    ?>
                                    <form method="POST" enctype="multipart/form-data" name="lista<?php echo $b ?>">
                                    <?php
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '<th><input class="form-control" type="file" id="foto" name="foto" style="width: 100%;"></th>';
                                    echo '<th><input class="form-control" type="text" id="inserir2" name="inserir2" style="width: 100%;"></th>';
                                    echo '<th><input class="form-control" type="number" id="inserir3" name="inserir3" style="width: 100%;"></th>';
                                    echo '<th><input class="form-control" type="text" id="inserir6" name="inserir6" style="width: 100%;"></th>';
                                    echo '<th><input class="form-control" type="text" id="inserir4" name="inserir4" style="width: 100%;"></th>';
                                    echo '<th>'?>

                                        <select class="form-select" aria-label="Default select example" id="inserir5" name="inserir5">
                                        <option value="selecionar" selected>Selecionar</option>
                                        <?php

                                        $sq="select * from pesquisa";
                                        $results = $ms->query($sq);
                                        while($row = $results->fetch_array()) {?>
                                            <option value="<?php echo $row["nome"] ?>"><?php echo $row["nome"] ?></option>
                                            <?php
                                        }
                                    
                                    echo'</th>';

                                    
                                    if(!empty($_POST["pro"])){
                                        if($_POST["pro"]=="20") $d="";
                                        else $d="where categoria='".$_POST["pro"]."'";
                                    }
                                    else $d="";
                                        $sq='select * from produtos '.$d.'';
                                        $results = $ms->query($sq);

                                    echo '<th colspan="2"><input class="btn button" type="submit" id="inserir" name="inserir" value="Inserir" style="width: -webkit-fill-available;">';
                                    echo '</form>';
                                    echo '</tr>';
                                    while($row = $results->fetch_array()) {
                                        $v++;
                                        $b++;
                                        echo'<tbody>';
                                        echo '<tr>';
                                        ?>
                                        <form method="POST" enctype="multipart/form-data" name="lista<?php echo $v ?>">
                                        <?php
                                        echo '<input class="form-control" type="hidden" id="id" name="id" value="'.$row["id"].'">';
                                        echo '<th><input class="form-control" type="file" id="foto" name="foto" value="'.$row["imagem"].'" style="width: 100%; text-align: center;"></th>';
                                        echo '<th><input class="form-control" type="text" id="nome1" name="nome1" value="'.$row["nome"].'" style="width: 100%; text-align: center"></th>';
                                        echo '<th style="width: 10%;"><input class="form-control" type="number" id="preco1" name="preco1" value="'.$row["preco"].'" style="width: 100%; text-align: center;"></th>';
                                        echo '<th><input class="form-control" type="text" id="texto1" name="texto1" value="'.$row["texto"].'" style="width: 100%; text-align: center"></th>';
                                        echo '<th><input class="form-control" type="text" id="link1" name="link1" value="'.$row["link"].'" style="width: 100%; text-align: center;"></th>';
                                        echo '<th>'
                                        ?>

                                        <select class="form-select" aria-label="Default select example" id="categoria1" name="categoria1">

                                        <option value="<?php echo $row["categoria"] ?>">---<?php echo $row["categoria"] ?>---</option>

                                        <?php
                                        

                                        $qs="select * from pesquisa";
                                        $result = $ms->query($sq);
                                        while($row = $result->fetch_array()) {?>
                                            <option value="<?php echo $row["nome"] ?>">---<?php echo $row["nome"] ?>---</option>
                                            <?php
                                        }
                                        

                                        ?>
                                        

                                        <?php
                                        echo'</th>';
                                        echo '<th><input class="btn button" type="submit" id="alterar" name="alterar" value="Alterar" style="width: -webkit-fill-available;">';
                                        echo '<th><input class="btn button" type="submit" id="eliminar" name="eliminar" value="Eliminar" style="width: -webkit-fill-available;">';
                                        ?>
                                        </form>
                                        <?php
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