<?php include ("header.php"); ?>

<?php

    include ("../../bd.php");

    if (isset($_POST['alterar']))
    {
        if($_POST['categoria3']==''){
            $msg="ERRO, tem de preencher o nome da categoria!";
        }
        else
        {
            if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0){
                $destino = "uploads/cat_" . uniqid() . ".jpg";
                if($_FILES["foto"]["type"]=="image/jpeg" || $_FILES["foto"]["type"]=="image/jpg" || $_FILES["foto"]["type"]=="image/png"){
                    if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                        $qr = "update categorias set nome=?, imagem=?, descricao=? where id='".$_POST["id"]."'";
                        $ordem = $ms->prepare($qr);
                        $ordem->bind_param('sss', $_POST["categoria3"], $destino, $_POST["descricao3"]);
                    }
                }
            }
            else{
                $qr = "update categorias set nome=?, descricao=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('ss', $_POST["categoria3"], $_POST["descricao3"]);
            }
            
            if ($ordem->execute() && $ordem->affected_rows>0){
                $msg='<h3 class="sucesso">Categoria atualizada!</h3>';
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
            
            // Atualizar também tabela pesquisa
            $qr2 = "update pesquisa set nome=? where nome='".$_POST["nome_antigo"]."'";
            $ordem2 = $ms->prepare($qr2);
            $ordem2->bind_param('s', $_POST["categoria3"]);
            $ordem2->execute();
            $ordem2->close();
        }
    }
    
    if (isset($_POST['eliminar']))
    {
        if($_POST['id']==''){
            $msg="ERRO, Ocorreu um problema da nossa parte! Tente mais tarde!";
        }
        else
        {
            // Eliminar da tabela categorias
            $qr = "delete from categorias where id=?";
            $ordem = $ms->prepare($qr);
            $ordem->bind_param('i', $_POST["id"]);
            if ($ordem->execute() && $ordem->affected_rows>0){
                $msg='<h3 class="sucesso">Categoria eliminada!</h3>';
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
            
            // Eliminar também da tabela pesquisa
            if(!empty($_POST['categoria3'])){
                $qr2 = "delete from pesquisa where nome=?";
                $ordem2 = $ms->prepare($qr2);
                $ordem2->bind_param('s', $_POST["categoria3"]);
                $ordem2->execute();
                $ordem2->close();
            }
        }
    }

    if(isset($_POST['inserir']))
	{
		if(isset($_POST['categoria1']))
		{
			if($_POST['categoria1']==''){
				$msg='<h3 class="erro">Erro, Preencha o nome da categoria!</h3>';
			}
			else{
				$destino = "";
				
				// Upload de imagem
				if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0){
					$destino = "uploads/cat_" . uniqid() . ".jpg";
					if($_FILES["foto"]["type"]=="image/jpeg" || $_FILES["foto"]["type"]=="image/jpg" || $_FILES["foto"]["type"]=="image/png"){
						move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
					}
				}
				
				// Inserir na tabela categorias
				$qr = "INSERT INTO categorias(nome, imagem, descricao) VALUES(?,?,?)";
				$ordem = $ms->prepare($qr);
				$ordem->bind_param('sss', $_POST["categoria1"], $destino, $_POST["descricao1"]);
				
				if ($ordem->execute() && $ordem->affected_rows>0){
					$msg='<h3 class="sucesso">A categoria foi inserida!</h3>';
					
					// Inserir também na tabela pesquisa
					$qr2 = "INSERT INTO pesquisa(nome) VALUES(?)";
					$ordem2 = $ms->prepare($qr2);
					$ordem2->bind_param('s', $_POST["categoria1"]);
					$ordem2->execute();
					$ordem2->close();
				}
				else{
					$msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
					$erro=1;
				}
				$ordem->close();
            }
		}
		else{
			$msg='<h3 class="erro">Erro, Preencha o nome da categoria!</h3>';
			$erro=1;
		}
	}

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Tabela de categorias</h6>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                    $sq='select * from categorias';
                                    $results = $ms->query($sq);
                                    echo '<table class="table table-bordered" id="dataTable1" style="width: 1000px; overflow-x: scroll;" cellspacing="0"';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Imagem</b></th>';
                                    echo '<th style="text-align: center;"><b>Nome da Categoria</b></th>';
                                    echo '<th style="text-align: center;"><b>Descrição</b></th>';
                                    echo '<th colspan="2"></th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tfoot>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Imagem</b></th>';
                                    echo '<th style="text-align: center;"><b>Nome da Categoria</b></th>';
                                    echo '<th style="text-align: center;"><b>Descrição</b></th>';
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
                                    echo '<th><input class="form-control" type="file" id="foto" name="foto" accept="image/*" style="width: 100%;"></th>';
                                    echo '<th><input class="form-control" type="text" id="categoria1" name="categoria1" placeholder="Nome da categoria" style="width: 100%;"></th>';
                                    echo '<th><textarea class="form-control" id="descricao1" name="descricao1" placeholder="Descrição da categoria" rows="2" style="width: 100%;"></textarea></th>';
                                    ?>
                                    <?php
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
                                        echo '<input type="hidden" id="id" name="id" value="'.$row["id"].'">';
                                        echo '<input type="hidden" id="nome_antigo" name="nome_antigo" value="'.$row["nome"].'">';
                                        echo '<th><input class="form-control" type="file" id="foto" name="foto" accept="image/*" style="width: 100%;">';
                                        if(!empty($row["imagem"])){
                                            echo '<small>Atual: '.basename($row["imagem"]).'</small>';
                                        }
                                        echo '</th>';
                                        echo '<th><input class="form-control" type="text" id="categoria3" name="categoria3" value="'.$row["nome"].'" style="width: 100%;"></th>';
                                        $descricao = isset($row["descricao"]) ? $row["descricao"] : '';
                                        echo '<th><textarea class="form-control" id="descricao3" name="descricao3" rows="2" style="width: 100%;">'.$descricao.'</textarea></th>';
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