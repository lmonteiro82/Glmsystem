<?php include ("header.php"); ?>

<?php

    include ("../../bd.php");
    
    if (isset($_POST['eliminar']))
    {

        if($_POST['id']==''){
            $msg="ERRO, Ocorreu um problema da nossa parte! Tente mais tarde!";
        }
        else
        {

            $sq="select * from orcamento where id='" . $_POST["id"] . "'";
            $results = $ms->query($sq);
            while($row = $results->fetch_array()) {
                $precotemp1 = $row["preco"] * ($row["dsc"]/100);
                $precotemp2 = $row["preco"] - $precotemp1;
                $precotemp3 = $precotemp2 * $row["quantidade"];
                $_SESSION["totalpreco"] = $_SESSION["totalpreco"] - $precotemp3;

                $ivatemp = $precotemp3 * ($row["iva"]/100);

                $_SESSION["totaliva"] = $_SESSION["totaliva"] - $ivatemp;

                $_SESSION["total"] = $_SESSION["totalpreco"] + $_SESSION["totaliva"];
            }

            $qr = "delete from orcamento where id=?";		
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
		if(isset($_POST['inserir1']) && isset($_POST['inserir4']) && isset($_POST['inserir2']) && isset($_POST['inserir3']))
		{
		
			if($_POST['inserir1']=='' || $_POST['inserir4']=='' || $_POST['inserir2']=='' || $_POST['inserir3']==''){
				$msg='<h3 class="erro">Erro, Existem campos por preencher!</h3>';
			}
			else{

                $sq="select preco from produtos where nome='" . $_POST["inserir1"] . "'";
                $results = $ms->query($sq);
                while($row = $results->fetch_array()) {
                    $precotemp1 = $row["preco"] * ($_POST["inserir2"]/100);
                    $precotemp2 = $row["preco"] - $precotemp1;
                    $precotemp3 = $precotemp2 * $_POST["inserir4"];
                    $_SESSION["totalpreco"] = $_SESSION["totalpreco"] + $precotemp3;
                }

                $ivatemp = $precotemp3 * ($_POST["inserir3"]/100);

                $_SESSION["totaliva"] = $_SESSION["totaliva"] + $ivatemp;

                
                $_SESSION["total"] = $_SESSION["totalpreco"] + $_SESSION["totaliva"];

                $sq="select * from produtos";
                $results = $ms->query($sq);
                while($row = $results->fetch_array()) {
                    if ($row["nome"] == $_POST["inserir1"]){
                        $preco1 = $row["preco"];
                    }
                }

                $userid1 = $_SESSION["globaluserid"];
			
				$qr = "INSERT INTO orcamento(userid,produto,quantidade,preco,dsc,iva) VALUES(?,?,?,?,?,?)";
				
				$ordem = $ms->prepare($qr);
				
				$ordem->bind_param('isiiii', $userid1, $_POST["inserir1"], $_POST["inserir4"], $preco1, $_POST["inserir2"], $_POST["inserir3"]);
				
	
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

    if(isset($_POST['reniciar'])){

            $qr = "delete from orcamento where userid='" . $_SESSION["globaluserid"] . "'";
            $ordem = $ms->query($qr);

            $_SESSION["totalpreco"] = 0;
            $_SESSION["totaliva"] = 0;
            $_SESSION["total"] = 0;

    }

    if(isset($_POST['btn2'])){

        if(isset($_POST["inserir5"])){

            if($_POST["inserir5"]==''){

            }
            else{

                $_SESSION["maoobra"] = $_POST["inserir5"];

                ?> <script>window.open("pdf.php", "self");</script> <?php
                
            }

        }

}

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Criar Orçamento</h6>

                            <div>
                                <!-- Pôr botão aqui -->
                                <form method="post">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="border-radius: 10px;">
                                        Terminar
                                    </button>
                                    <input class="btn button" type="submit" id="reniciar" name="reniciar" value="Reniciar" style="width: 8%;">
                                </form>
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
                                    echo '<table class="table table-bordered" id="dataTable" style="width: 800px; overflow-x: scroll;" cellspacing="0"';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Produto</b></th>';
                                    echo '<th style="text-align: center;"><b>Quantidade</b></th>';
                                    echo '<th style="text-align: center;"><b>Preço</b></th>';
                                    echo '<th style="text-align: center;"><b>Dsc (%)</b></th>';
                                    echo '<th style="text-align: center;"><b>Iva (%)</b></th>';
                                    echo '<th colspan="2"></th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tfoot>';
                                    echo '<tr>';
                                    echo '<th style="text-align: center;"><b>Produto</b></th>';
                                    echo '<th style="text-align: center;"><b>Quantidade</b></th>';
                                    echo '<th style="text-align: center;"><b>Preço</b></th>';
                                    echo '<th style="text-align: center;"><b>Dsc (%)</b></th>';
                                    echo '<th style="text-align: center;"><b>Iva (%)</b></th>';
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
                                    echo '<th>'?>

                                        <select class="form-select" aria-label="Default select example" id="inserir1" name="inserir1">
                                        <option value="selecionar" selected>Selecionar</option>
                                        <?php

                                        $sq="select * from produtos";
                                        $results = $ms->query($sq);
                                        while($row = $results->fetch_array()) {?>
                                            <option value="<?php echo $row["nome"] ?>"><?php echo $row["nome"] ?></option>
                                            <?php
                                        }
                                    
                                    echo'</th>';
                                    echo '<th style="width: 15%;"><input class="form-control" type="number" id="inserir4" name="inserir4" style="width: 100%;"></th>';
                                    echo '<th style="width: 15%;"><input class="form-control" type="number" id="nada" name="nada" style="width: 100%;" disabled></th>';
                                    echo '<th style="width: 15%;"><input class="form-control" type="number" id="inserir2" name="inserir2" style="width: 100%;" min=0 max=100></th>';
                                    echo '<th>'?>

                                        <select class="form-select" aria-label="Default select example" id="inserir3" name="inserir3">
                                        <option value="0" selected>0</option>
                                        <option value="23">23</option>
                                        <?php
                                    echo'</th>';

                                    if(!empty($_POST["pro"])){
                                        if($_POST["pro"]=="20") $d="";
                                        else $d="where categoria='".$_POST["pro"]."'";
                                    }
                                    else $d="";
                                        $sq='select * from orcamento '.$d.'';
                                        $results = $ms->query($sq);

                                    echo '<th colspan="2"><input class="btn button" type="submit" id="inserir" name="inserir" value="Inserir" style="width: -webkit-fill-available;">';
                                    echo '</form>';
                                    echo '</tr>';
                                    while($row = $results->fetch_array()) {
                                        $id = $row["id"];
                                        $v++;
                                        $b++;
                                        echo'<tbody>';
                                        echo '<tr>';
                                        ?>
                                        <form method="POST" enctype="multipart/form-data" name="lista<?php echo $v ?>">
                                        <?php

                                        echo'<input type="hidden" id="id" name="id" value="'.$row["id"].'">';
                                        echo '<th><input class="form-control" type="text" id="nome1" name="nome1" value="'.$row["produto"].'" style="width: 100%; text-align: center;" disabled></th>';
                                        echo '<th style="width: 15%;"><input class="form-control" type="number" id="quantidade1" name="quantidade1" value="'.$row["quantidade"].'" style="width: 100%; text-align: center;" disabled></th>';
                                        echo '<th style="width: 15%;"><input class="form-control" type="number" id="preco1" name="preco1" value="'.$row["preco"] * $row["quantidade"].'" style="width: 100%; text-align: center;" disabled></th>';
                                        echo '<th style="width: 15%;"><input class="form-control" type="number" id="dsc1" name="dsc1" value="'.$row["dsc"].'" style="width: 100%; text-align: center;" disabled></th>';
                                        echo '<th style="width: 15%;"><input class="form-control" type="number" id="iva1" name="iva1" value="'.$row["iva"].'" style="width: 100%; text-align: center;" disabled></th>';

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

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Mão de obra</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
            <input class="form-control" type="number" id="inserir5" name="inserir5">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" id="btn2" name="btn2" value="Seguinte">
        </form>
      </div>
    </div>
  </div>
</div>

    <?php include ("footer.php"); ?>