<?php include ("header.php"); ?>

<?php

    include ("../../bd.php");

    if (isset($_POST['alterar']))
    {

        if($_POST['categoria3']=='' || $_POST['categoria4']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
                $qr = "update categorias set nome=?, correspondente=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('ss', $_POST["categoria3"], $_POST["categoria4"]);
        }
        if ($ordem->execute() && $ordem->affected_rows>0){
            
        }
        else{
            $msg='<h3 class="erro" >Erro: ('. $ms->errno .') '. $ms->error . '</h3>';
            $erro=1;
        }
        $ordem->close();
    }

    if (isset($_POST['alterar']))
    {

        if($_POST['categoria3']=='' || $_POST['categoria4']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
                $qr = "update pesquisa set nome=? where id='".$_POST["id"]."'";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('s', $_POST["categoria3"]);
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
            $qr = "delete from categorias where id=?";
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

    if (isset($_POST['eliminar']))
    {

        if($_POST['categoria3']==''){
            $msg="ERRO, Ocorreu um problema da nossa parte! Tente mais tarde!";
        }
        else
        {
            $qr = "delete from pesquisa where nome=?";
            $ordem = $ms->prepare($qr);
            $ordem->bind_param('s', $_POST["categoria3"]);
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
		if(isset($_POST['categoria1']) && isset($_POST['categoria2']))
		{
		
			if($_POST['categoria1']==''|| $_POST['categoria2']==''){
				$msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
			}
			else{
			
				$qr = "INSERT INTO categorias(nome, correspondente) VALUES(?,?)";
				
				$ordem = $ms->prepare($qr);
				
				$ordem->bind_param('ss', $_POST["categoria1"], $_POST["categoria2"]);
				
	
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
		else{
			$msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
			$erro=1;
		}
			
	}

    if(isset($_POST['inserir']))
	{
		if(isset($_POST['categoria1']) && isset($_POST['categoria2']))
		{
		
			if($_POST['categoria1']==''|| $_POST['categoria2']==''){
				$msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
			}
			else{
			
				$qr = "INSERT INTO pesquisa(nome) VALUES(?)";
				
				$ordem = $ms->prepare($qr);
				
				$ordem->bind_param('s', $_POST["categoria1"]);
				
	
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
                                    echo '<th style="text-align: center;"><b>Categoria</b></th>';
                                    echo '<th style="text-align: center;">Correspondente</th>';
                                    echo '<th colspan="2"></th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tfoot>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Categoria</b></th>';
                                    echo '<th style="text-align: center;">Correspondente</th>';
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
                                    echo '<th><input class="form-control" type="text" id="categoria1" name="categoria1" style="width: 100%;"></th>';
                                    ?>
                                        <th>
                                            <select class="form-select" name="categoria2" style="width: 210px; margin: auto;">
                                                    <option value="vazio">Selecione a categoria</option>
                                                    <?php
                                                    $sql="select * from titulos where dropdown='sim'";
                                                    /*$st=$liga->prepare($sql);
                                                    $st->execute();
                                                    $st->bind_result($id,$nome,$tipo);
                                                    
                                                    while ($st->fetch()) {
                                                    echo '<option value="'. $id . '">' .$nome. '</option>';
                                            */
                                                    $st=$ms->query($sql);
                                                    while ($linha=$st->fetch_array()) {
                                                    echo '<option value="'. $linha["nome"] . '">' .$linha["nome"]. '</option>';
                                                }
                                                
                                                $st->close();
                                                
                                                ?>
                                            </select>
                                        </th>
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
                                        echo '<th><input class="form-control" type="text" id="categoria3" name="categoria3" value="'.$row["nome"].'" style="width: 100%;"></th>';
                                        ?>
                                            <th>
                                                <select class="form-select" name="categoria4" style="width: 210px; margin: auto;">
                                                        <option value="<?php echo $row["correspondente"]; ?>">Selecione a categoria</option>
                                                        <?php
                                                        $sql="select * from titulos where dropdown='sim'";
                                                        /*$st=$liga->prepare($sql);
                                                        $st->execute();
                                                        $st->bind_result($id,$nome,$tipo);
                                                        
                                                        while ($st->fetch()) {
                                                        echo '<option value="'. $id . '">' .$nome. '</option>';
                                                */
                                                        $st=$ms->query($sql);
                                                        while ($linha=$st->fetch_array()) {
                                                        echo '<option value="'. $linha["nome"] . '">' .$linha["nome"]. '</option>';
                                                    }
                                                    
                                                    $st->close(); 
                                                    
                                                    ?>
                                                </select>
                                        </th>
                                        <?php
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