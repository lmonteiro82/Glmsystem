<?php include ("header.php"); ?>

<?php

    include ("../../bd.php");

    if (isset($_POST['alterar']))
    {
        if($_POST['subcategoria3']==''){
            $msg="ERRO, tem de preencher o nome da subcategoria!";
        }
        else
        {
            if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0){
                $destino = "uploads/subcat_" . uniqid() . ".jpg";
                if($_FILES["foto"]["type"]=="image/jpeg" || $_FILES["foto"]["type"]=="image/jpg" || $_FILES["foto"]["type"]=="image/png"){
                    if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                        $qr = "update subcategorias set nome=?, categoria_id=?, imagem=?, descricao=? where id='".$_POST["id"]."'";
                        $ordem = $ms->prepare($qr);
                        $ordem->bind_param('siss', $_POST["subcategoria3"], $_POST["categoria_id3"], $destino, $_POST["descricao3"]);
                    }
                }
            }
            else{
                $qr = "update subcategorias set nome=?, categoria_id=?, descricao=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('sis', $_POST["subcategoria3"], $_POST["categoria_id3"], $_POST["descricao3"]);
            }
            
            if ($ordem->execute() && $ordem->affected_rows>0){
                $msg='<h3 class="sucesso">Subcategoria atualizada!</h3>';
            }
            else{
                $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
                $erro=1;
            }
            $ordem->close();
        }
    }
    
    if (isset($_POST['eliminar']))
    {
        if($_POST['id']==''){
            $msg="ERRO, Ocorreu um problema da nossa parte! Tente mais tarde!";
        }
        else
        {
            $qr = "delete from subcategorias where id=?";
            $ordem = $ms->prepare($qr);
            $ordem->bind_param('i', $_POST["id"]);
            if ($ordem->execute() && $ordem->affected_rows>0){
                $msg='<h3 class="sucesso">Subcategoria eliminada!</h3>';
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
		if(isset($_POST['subcategoria1']))
		{
			if($_POST['subcategoria1']=='' || $_POST['categoria_id1']==''){
				$msg='<h3 class="erro">Erro, Preencha o nome da subcategoria e selecione a categoria!</h3>';
			}
			else{
				$destino = "";
				
				if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0){
					$destino = "uploads/subcat_" . uniqid() . ".jpg";
					if($_FILES["foto"]["type"]=="image/jpeg" || $_FILES["foto"]["type"]=="image/jpg" || $_FILES["foto"]["type"]=="image/png"){
						move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
					}
				}
				
				$qr = "INSERT INTO subcategorias(nome, categoria_id, imagem, descricao) VALUES(?,?,?,?)";
				$ordem = $ms->prepare($qr);
				$ordem->bind_param('siss', $_POST["subcategoria1"], $_POST["categoria_id1"], $destino, $_POST["descricao1"]);
				
				if ($ordem->execute() && $ordem->affected_rows>0){
					$msg='<h3 class="sucesso">A subcategoria foi inserida!</h3>';
				}
				else{
					$msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
					$erro=1;
				}
				$ordem->close();
            }
		}
		else{
			$msg='<h3 class="erro">Erro, Preencha o nome da subcategoria!</h3>';
			$erro=1;
		}
	}

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Tabela de Subcategorias</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <a href="alterar_categorias.php" class="btn button">← Voltar para Categorias</a>
                            </div>
                            <div class="table-responsive">
                                <?php
                                    $sq='SELECT s.*, c.nome as categoria_nome 
                                         FROM subcategorias s 
                                         LEFT JOIN categorias c ON s.categoria_id = c.id 
                                         ORDER BY c.nome, s.nome';
                                    $results = $ms->query($sq);
                                    echo '<table class="table table-bordered" id="dataTable1" style="width: 1000px; overflow-x: scroll;" cellspacing="0"';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Imagem</b></th>';
                                    echo '<th style="text-align: center;"><b>Nome da Subcategoria</b></th>';
                                    echo '<th style="text-align: center;"><b>Categoria Pai</b></th>';
                                    echo '<th style="text-align: center;"><b>Descrição</b></th>';
                                    echo '<th colspan="2"></th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tfoot>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Imagem</b></th>';
                                    echo '<th style="text-align: center;"><b>Nome da Subcategoria</b></th>';
                                    echo '<th style="text-align: center;"><b>Categoria Pai</b></th>';
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
                                    echo '<th><input class="form-control" type="text" id="subcategoria1" name="subcategoria1" placeholder="Nome da subcategoria" style="width: 100%;"></th>';
                                    echo '<th><select class="form-control" id="categoria_id1" name="categoria_id1" style="width: 100%;">';
                                    echo '<option value="">Selecione a categoria</option>';
                                    $sq_cat="select * from categorias ORDER BY nome";
                                    $results_cat = $ms->query($sq_cat);
                                    while($row_cat = $results_cat->fetch_array()) {
                                        echo '<option value="'.$row_cat["id"].'">'.$row_cat["nome"].'</option>';
                                    }
                                    echo '</select></th>';
                                    echo '<th><textarea class="form-control" id="descricao1" name="descricao1" placeholder="Descrição da subcategoria" rows="2" style="width: 100%;"></textarea></th>';
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
                                        echo '<th><input class="form-control" type="file" id="foto" name="foto" accept="image/*" style="width: 100%;">';
                                        if(!empty($row["imagem"])){
                                            echo '<small>Atual: '.basename($row["imagem"]).'</small>';
                                        }
                                        echo '</th>';
                                        echo '<th><input class="form-control" type="text" id="subcategoria3" name="subcategoria3" value="'.$row["nome"].'" style="width: 100%;"></th>';
                                        echo '<th><select class="form-control" id="categoria_id3" name="categoria_id3" style="width: 100%;">';
                                        $sq_cat2="select * from categorias ORDER BY nome";
                                        $results_cat2 = $ms->query($sq_cat2);
                                        while($row_cat2 = $results_cat2->fetch_array()) {
                                            $selected = ($row_cat2["id"] == $row["categoria_id"]) ? 'selected' : '';
                                            echo '<option value="'.$row_cat2["id"].'" '.$selected.'>'.$row_cat2["nome"].'</option>';
                                        }
                                        echo '</select></th>';
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
                                    
                                    
                                    $results->free();
                                    $ms->close();
                                
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>

    </div>

    

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include ("footer.php"); ?>
