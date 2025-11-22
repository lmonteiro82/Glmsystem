<?php include ("header.php"); ?>

<?php

    include ("../../bd.php");

    $prev = "";

    if(isset($_POST['inserir'])){
        $prev = $_POST["categoria2"];
    }

    if (isset($_POST['alterar']))
    {

        if($_POST['categoria3']=='' || $_POST['categoria4']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
                $qr = "update titulos set nome=?, dropdown=? where id='".$_POST["id"]."'";
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

        if($_POST['categoria3']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
                $qr = "update titulos set nome=? where nome='".$_POST["categoria3"]."'";
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
            $qr = "delete from titulos where id=?";
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

        if($_POST['id']==''){
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
			
				$qr = "INSERT INTO titulos(nome, dropdown) VALUES(?,?)";
				
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

    if ($prev == "nao"){

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
    }

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Tabela de Titulos</h6>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                    $sq='select * from titulos';
                                    $results = $ms->query($sq);
                                    echo '<table class="table table-bordered" id="dataTable1" style="width: 700px; overflow-x: scroll;" cellspacing="0"';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Categoria</b></th>';
                                    echo '<th style="text-align: center;">Dropdown</th>';
                                    echo '<th></th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tfoot>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Categoria</b></th>';
                                    echo '<th style="text-align: center;">Dropdown</th>';
                                    echo '<th></th>';
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
                                    echo '<th>
                                        <select class="form-select" aria-label="Default select example" id="categoria2" name="categoria2">
                                        <option value="nao" selected>Selecionar</option>
                                        <option value="sim">Sim</option>
                                        <option value="nao">Não</option>
                                        </th>';
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
                                            <select class="form-select" aria-label="Default select example" id="categoria4" name="categoria4"><?php
                                            if($row["dropdown"] == "sim"){?>
                                                <option value="sim" selected>Sim</option>
                                                <option value="nao">Não</option>
                                                <?php
                                            }
                                            else{?>
                                                <option value="nao" selected>Não</option>
                                                <option value="sim">Sim</option>
                                                <?php
                                            }
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