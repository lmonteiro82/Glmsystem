<?php 
    error_reporting(0);
    @ini_set('display_errors', 0);
    include ("header.php"); 
?>

<?php
    include ("../../bd.php");

    if (isset($_POST['alterar']))
    {
        if($_POST['nome1']=='' && $_POST['preco1']=='' && $_POST['texto1']=='' && $_POST['link1']=='' && $_POST['categoria1']==''){
            $msg="ERRO, tem de preencher algum campo!";
        }
        else
        {
            // Verificar se foi enviada uma nova imagem
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 && !empty($_FILES['foto']['name'])){
                $tipoImagem = $_FILES["foto"]["type"];
                $extensao = "";
                
                // Aceitar diferentes formatos de imagem
                if($tipoImagem == "image/jpeg" || $tipoImagem == "image/jpg"){
                    $extensao = ".jpg";
                } elseif($tipoImagem == "image/png"){
                    $extensao = ".png";
                } elseif($tipoImagem == "image/gif"){
                    $extensao = ".gif";
                } elseif($tipoImagem == "image/webp"){
                    $extensao = ".webp";
                }
                
                if($extensao != ""){
                    $destino = "fotos/a" . uniqid() . $extensao;
                    if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                        // Atualizar COM nova imagem
                        $qr = "update produtos set imagem=?, nome=?, preco=?, texto=?, link=?, categoria=? where id=?";
                        $ordem = $ms->prepare($qr);
                        $ordem->bind_param('ssisssi', $destino, $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $_POST["id"]);
                    } else {
                        // Se falhar o upload, atualizar sem imagem
                        $qr = "update produtos set nome=?, preco=?, texto=?, link=?, categoria=? where id=?";
                        $ordem = $ms->prepare($qr);
                        $ordem->bind_param('sisssi', $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $_POST["id"]);
                        $msg='<h3 class="erro">Erro ao fazer upload da imagem!</h3>';
                    }
                } else {
                    // Formato não suportado
                    $qr = "update produtos set nome=?, preco=?, texto=?, link=?, categoria=? where id=?";
                    $ordem = $ms->prepare($qr);
                    $ordem->bind_param('sisssi', $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $_POST["id"]);
                    $msg='<h3 class="erro">Formato não suportado. Use JPG, PNG, GIF ou WEBP</h3>';
                }
            }
            else{
                // Sem nova imagem, atualizar apenas os outros campos
                $qr = "update produtos set nome=?, preco=?, texto=?, link=?, categoria=? where id=?";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param('sisssi', $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $_POST["id"]);
            }
            
            if ($ordem->execute()){
                if($ordem->affected_rows > 0){
                    if(!isset($msg)) $msg='<h3 class="sucesso">Produto atualizado com sucesso!</h3>';
                }
                // Não mostrar mensagem se não houver alterações
            }
            else{
                if($ms->error){
                    $msg='<h3 class="erro">Erro ao atualizar: '. $ms->error . '</h3>';
                }
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
            $qr = "delete from produtos where id=?";		
            $ordem = $ms->prepare($qr);
            $ordem->bind_param('i', $_POST["id"]);
            if ($ordem->execute()){
                if($ordem->affected_rows > 0){
                    $msg='<h3 class="sucesso">Produto eliminado com sucesso!</h3>';
                }
            }
            else{
                if($ms->error){
                    $msg='<h3 class="erro">Erro ao eliminar: '. $ms->error . '</h3>';
                }
            }
            $ordem->close();
        }
    }

    if (isset($_POST['duplicar']))
    {
        if($_POST['id']==''){
            $msg='<h3 class="erro">ERRO, Ocorreu um problema da nossa parte! Tente mais tarde!</h3>';
        }
        else
        {
            // Buscar dados do produto original
            $qr = "SELECT * FROM produtos WHERE id=?";
            $ordem = $ms->prepare($qr);
            $ordem->bind_param('i', $_POST["id"]);
            $ordem->execute();
            $result = $ordem->get_result();
            
            if($row = $result->fetch_array()){
                // Inserir cópia do produto
                $qr = "INSERT INTO produtos(imagem,nome,preco,texto,link,categoria) VALUES(?,?,?,?,?,?)";
                $ordem2 = $ms->prepare($qr);
                $nomeCopia = $row["nome"] . " (Cópia)";
                $ordem2->bind_param('ssisss', $row["imagem"], $nomeCopia, $row["preco"], $row["texto"], $row["link"], $row["categoria"]);
                
                if ($ordem2->execute() && $ordem2->affected_rows>0){
                    $msg='<h3 class="sucesso">Produto duplicado com sucesso!</h3>';
                }
                else{
                    $msg='<h3 class="erro">Erro ao duplicar: ('. $ms->errno .') '. $ms->error . '</h3>';
                    $erro=1;
                }
                $ordem2->close();
            }
            $ordem->close();
        }
    }

    if(isset($_POST['inserir']))
	{
		// Validar campos obrigatórios e mostrar quais faltam
		$camposFaltando = array();
		
		if(!isset($_FILES["foto"]) || $_FILES["foto"]["error"] != 0){
			$camposFaltando[] = "Imagem";
		}
		if(empty($_POST['inserir2'])){
			$camposFaltando[] = "Nome";
		}
		if(empty($_POST['inserir5']) || $_POST['inserir5'] == 'selecionar'){
			$camposFaltando[] = "Categoria";
		}
		
		if(count($camposFaltando) > 0){
			$msg='<h3 class="erro">Erro! Campos obrigatórios faltando: ' . implode(', ', $camposFaltando) . '</h3>';
		}
		else{
			$destino = "";
			
			// Verificar se foi enviada uma imagem
			if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0){
					$tipoImagem = $_FILES["foto"]["type"];
					$extensao = "";
					
					// Aceitar diferentes formatos de imagem
					if($tipoImagem == "image/jpeg" || $tipoImagem == "image/jpg"){
						$extensao = ".jpg";
					} elseif($tipoImagem == "image/png"){
						$extensao = ".png";
					} elseif($tipoImagem == "image/gif"){
						$extensao = ".gif";
					} elseif($tipoImagem == "image/webp"){
						$extensao = ".webp";
					}
					
					if($extensao != ""){
						$destino = "fotos/a" . uniqid() . $extensao;
						if(!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
							$destino = ""; // Se falhar o upload, deixa vazio
							$msg='<h3 class="erro">Erro ao fazer upload da imagem!</h3>';
						}
					} else {
						$msg='<h3 class="erro">Formato não suportado. Use JPG, PNG, GIF ou WEBP</h3>';
					}
				}
				
			// Inserir produto (com ou sem imagem)
			if(!isset($msg) || $destino != ""){
				$qr = "INSERT INTO produtos(imagem,nome,preco,texto,link,categoria) VALUES(?,?,?,?,?,?)";		
				
				$ordem = $ms->prepare($qr);
				
				$ordem->bind_param('ssisss', $destino, $_POST["inserir2"], $_POST["inserir3"], $_POST["inserir6"], $_POST["inserir4"], $_POST["inserir5"]);
				
	
				// Executar o query (verificar se não dá erro e o número de registos afetados)
				if ($ordem->execute()){
					if($ordem->affected_rows > 0){
						$msg='<h3 class="sucesso">O produto foi inserido!</h3>';
					}
				}
				else{
					if($ms->error){
						$msg='<h3 class="erro">Erro ao inserir: '. $ms->error . '</h3>';
					}
				}
				$ordem->close();
			}
		}
	}

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php 
                    // Exibir mensagem de erro ou sucesso
                    if(isset($msg) && !empty($msg)){
                        $alertClass = (strpos($msg, 'sucesso') !== false) ? 'alert-success' : 'alert-danger';
                        echo '<div class="alert '.$alertClass.' alert-dismissible fade show" role="alert" style="text-align: center;">';
                        echo $msg;
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                    }
                    ?>

                    <!-- Estilos para os cards de produtos -->
                    <style>
                        .product-card {
                            background: white;
                            border-radius: 12px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                            padding: 20px;
                            margin-bottom: 20px;
                            transition: all 0.3s;
                        }
                        .product-card:hover {
                            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
                        }
                        .product-image-preview {
                            width: 100%;
                            max-width: 200px;
                            height: 200px;
                            object-fit: cover;
                            border-radius: 8px;
                            border: 2px solid #e0e0e0;
                            display: block;
                            margin: 0 auto 10px;
                        }
                        .product-grid {
                            display: flex;
                            flex-direction: column;
                            gap: 20px;
                            margin-top: 20px;
                        }
                        .form-label-custom {
                            font-weight: 600;
                            color: #555;
                            font-size: 13px;
                            margin-bottom: 5px;
                            display: block;
                        }
                        .btn-action {
                            margin: 5px;
                        }
                        .insert-card {
                            background: #f8f9fa;
                            border: 2px solid #9E3223;
                            border-left: 5px solid #9E3223;
                        }
                        .insert-card h5 {
                            color: #9E3223;
                        }
                        .insert-card .form-label-custom {
                            color: #333;
                        }
                        .product-info-section {
                            flex: 1;
                        }
                        .product-image-section {
                            min-width: 220px;
                            text-align: center;
                        }
                    </style>

                    <!-- Header com filtros -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Gestão de Produtos</h6>
                            <div class="d-flex gap-2">
                                <form name="listagem" id="listagem" method="post" action="" class="me-2">
                                    <select class="form-select" name="pro" style="width: 210px;" onchange="this.form.submit()">
                                        <option value="-1">Filtrar por categoria</option>
                                        <?php
                                        $sql="select * from categorias ORDER BY nome";
                                        $st=$ms->query($sql);
                                        echo '<option value="20">Todas as categorias</option>';
                                        while ($linha=$st->fetch_array()) {
                                            echo '<option value="'. $linha["nome"] . '">' .$linha["nome"]. '</option>';
                                        }
                                        $st->close(); 
                                        ?>
                                    </select>
                                </form>
                                <a class="btn button" href="alterar_categorias.php">Gerir Categorias</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            if(!empty($_POST["pro"])){
                                if($_POST["pro"]=="20") $d="";
                                else $d="where categoria='".$_POST["pro"]."'";
                            }
                            else $d="";
                            
                            $sq='select * from produtos '.$d.' ORDER BY id DESC';
                            $results = $ms->query($sq);
                            
                            if(!$results) {
                                echo '<div class="alert alert-danger">Erro ao carregar produtos: ' . $ms->error . '</div>';
                                $results = $ms->query('select * from produtos ORDER BY id DESC');
                            }
                            ?>
                            
                            <!-- Card para Inserir Novo Produto -->
                            <div class="product-card insert-card">
                                <h5 class="mb-3"><i class="fas fa-plus-circle"></i> Adicionar Novo Produto</h5>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label-custom">Imagem *</label>
                                            <input class="form-control" type="file" name="foto" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label-custom">Nome *</label>
                                            <input class="form-control" type="text" name="inserir2" placeholder="Nome do produto" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label-custom">Preço</label>
                                            <input class="form-control" type="number" name="inserir3" placeholder="0.00" step="0.01">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label-custom">Link</label>
                                            <input class="form-control" type="text" name="inserir4" placeholder="URL do produto">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label-custom">Categoria *</label>
                                            <select class="form-select" name="inserir5" required>
                                                <option value="selecionar">Selecionar</option>
                                                <?php
                                                $sq_cat="select * from categorias ORDER BY nome";
                                                $results_cat = $ms->query($sq_cat);
                                                while($row_cat = $results_cat->fetch_array()) {
                                                    echo '<option value="'.$row_cat["nome"].'">'.$row_cat["nome"].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label-custom">Descrição</label>
                                            <textarea class="form-control" name="inserir6" rows="2" placeholder="Descrição do produto"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-light btn-lg w-100" type="submit" name="inserir">
                                                <i class="fas fa-plus"></i> Inserir Produto
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Grid de Produtos Existentes -->
                            <div class="product-grid">
                                <?php
                                while($row = $results->fetch_array()) {
                                    $imagemPath = !empty($row["imagem"]) ? $row["imagem"] : "https://via.placeholder.com/150?text=Sem+Imagem";
                                ?>
                                <div class="product-card">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                        
                                        <div class="row g-3">
                                            <!-- Coluna da Imagem -->
                                            <div class="col-lg-3 col-md-4 product-image-section">
                                                <img src="<?php echo $imagemPath; ?>" class="product-image-preview" alt="Preview">
                                                <input class="form-control form-control-sm" type="file" name="foto">
                                                <small class="text-muted d-block mt-1">Alterar imagem</small>
                                            </div>
                                            
                                            <!-- Coluna dos Dados -->
                                            <div class="col-lg-9 col-md-8 product-info-section">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="form-label-custom">Nome</label>
                                                        <input class="form-control" type="text" name="nome1" value="<?php echo htmlspecialchars($row["nome"]); ?>">
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Preço</label>
                                                        <input class="form-control" type="number" name="preco1" value="<?php echo $row["preco"]; ?>" step="0.01">
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Categoria</label>
                                                        <select class="form-select" name="categoria1">
                                                            <option value="<?php echo $row["categoria"]; ?>" selected><?php echo $row["categoria"]; ?></option>
                                                            <?php
                                                            $qs="select * from categorias ORDER BY nome";
                                                            $result_cat = $ms->query($qs);
                                                            while($rowCat = $result_cat->fetch_array()) {
                                                                if($rowCat["nome"] != $row["categoria"]) {
                                                                    echo '<option value="'.$rowCat["nome"].'">'.$rowCat["nome"].'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                        <label class="form-label-custom">Descrição</label>
                                                        <textarea class="form-control" name="texto1" rows="2"><?php echo htmlspecialchars($row["texto"]); ?></textarea>
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                        <label class="form-label-custom">Link</label>
                                                        <input class="form-control" type="text" name="link1" value="<?php echo htmlspecialchars($row["link"]); ?>">
                                                    </div>
                                                    
                                                    <!-- Botões de Ação -->
                                                    <div class="col-12">
                                                        <div class="d-flex justify-content-end flex-wrap gap-2">
                                                            <button class="btn button" type="submit" name="alterar">
                                                                <i class="fas fa-save"></i> Salvar
                                                            </button>
                                                            <button class="btn rounded-circle" type="submit" name="duplicar" title="Duplicar produto" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; background-color: #9E3223; border: none;">
                                                                <i class="fas fa-copy" style="color: white;"></i>
                                                            </button>
                                                            <button class="btn button" type="submit" name="eliminar" onclick="return confirm('Tem certeza que deseja eliminar este produto?')">
                                                                <i class="fas fa-trash"></i> Eliminar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            // Frees the memory associated with a result
                            $results->free();
                            $ms->close();
                            ?>
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