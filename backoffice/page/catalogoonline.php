<?php 
    error_reporting(0);
    @ini_set('display_errors', 0);
    include ("header.php"); 
?>

<?php
    include ("../../bd.php");

    // Mover produto para cima
    if (isset($_POST['mover_cima'])) {
        $produto_id = $_POST['produto_id'];
        $categoria = $_POST['categoria_atual'];
        $subcategoria_id = !empty($_POST['subcategoria_atual']) ? $_POST['subcategoria_atual'] : null;
        
        // Buscar ordem atual do produto
        $qr = "SELECT ordem_exibicao FROM produtos WHERE id = ?";
        $stmt = $ms->prepare($qr);
        $stmt->bind_param('i', $produto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produto = $result->fetch_array();
        $ordem_atual = $produto['ordem_exibicao'];
        $stmt->close();
        
        // Buscar produto anterior (com ordem menor)
        if($subcategoria_id) {
            $qr = "SELECT id, ordem_exibicao FROM produtos WHERE subcategoria_id = ? AND ordem_exibicao < ? ORDER BY ordem_exibicao DESC LIMIT 1";
            $stmt = $ms->prepare($qr);
            $stmt->bind_param('ii', $subcategoria_id, $ordem_atual);
        } else {
            $qr = "SELECT id, ordem_exibicao FROM produtos WHERE categoria = ? AND (subcategoria_id IS NULL OR subcategoria_id = 0) AND ordem_exibicao < ? ORDER BY ordem_exibicao DESC LIMIT 1";
            $stmt = $ms->prepare($qr);
            $stmt->bind_param('si', $categoria, $ordem_atual);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($produto_anterior = $result->fetch_array()) {
            // Trocar ordens
            $ordem_anterior = $produto_anterior['ordem_exibicao'];
            $id_anterior = $produto_anterior['id'];
            
            $qr1 = "UPDATE produtos SET ordem_exibicao = ? WHERE id = ?";
            $stmt1 = $ms->prepare($qr1);
            $stmt1->bind_param('ii', $ordem_anterior, $produto_id);
            $stmt1->execute();
            $stmt1->close();
            
            $qr2 = "UPDATE produtos SET ordem_exibicao = ? WHERE id = ?";
            $stmt2 = $ms->prepare($qr2);
            $stmt2->bind_param('ii', $ordem_atual, $id_anterior);
            $stmt2->execute();
            $stmt2->close();
            
            $msg='<h3 class="sucesso">Ordem alterada com sucesso!</h3>';
        }
        $stmt->close();
    }
    
    // Mover produto para baixo
    if (isset($_POST['mover_baixo'])) {
        $produto_id = $_POST['produto_id'];
        $categoria = $_POST['categoria_atual'];
        $subcategoria_id = !empty($_POST['subcategoria_atual']) ? $_POST['subcategoria_atual'] : null;
        
        // Buscar ordem atual do produto
        $qr = "SELECT ordem_exibicao FROM produtos WHERE id = ?";
        $stmt = $ms->prepare($qr);
        $stmt->bind_param('i', $produto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produto = $result->fetch_array();
        $ordem_atual = $produto['ordem_exibicao'];
        $stmt->close();
        
        // Buscar produto seguinte (com ordem maior)
        if($subcategoria_id) {
            $qr = "SELECT id, ordem_exibicao FROM produtos WHERE subcategoria_id = ? AND ordem_exibicao > ? ORDER BY ordem_exibicao ASC LIMIT 1";
            $stmt = $ms->prepare($qr);
            $stmt->bind_param('ii', $subcategoria_id, $ordem_atual);
        } else {
            $qr = "SELECT id, ordem_exibicao FROM produtos WHERE categoria = ? AND (subcategoria_id IS NULL OR subcategoria_id = 0) AND ordem_exibicao > ? ORDER BY ordem_exibicao ASC LIMIT 1";
            $stmt = $ms->prepare($qr);
            $stmt->bind_param('si', $categoria, $ordem_atual);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($produto_seguinte = $result->fetch_array()) {
            // Trocar ordens
            $ordem_seguinte = $produto_seguinte['ordem_exibicao'];
            $id_seguinte = $produto_seguinte['id'];
            
            $qr1 = "UPDATE produtos SET ordem_exibicao = ? WHERE id = ?";
            $stmt1 = $ms->prepare($qr1);
            $stmt1->bind_param('ii', $ordem_seguinte, $produto_id);
            $stmt1->execute();
            $stmt1->close();
            
            $qr2 = "UPDATE produtos SET ordem_exibicao = ? WHERE id = ?";
            $stmt2 = $ms->prepare($qr2);
            $stmt2->bind_param('ii', $ordem_atual, $id_seguinte);
            $stmt2->execute();
            $stmt2->close();
            
            $msg='<h3 class="sucesso">Ordem alterada com sucesso!</h3>';
        }
        $stmt->close();
    }

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
                        $qr = "update produtos set imagem=?, nome=?, preco=?, texto=?, link=?, categoria=?, subcategoria_id=? where id=?";
                        $ordem = $ms->prepare($qr);
                        $subcategoria_val = !empty($_POST["subcategoria1"]) ? $_POST["subcategoria1"] : null;
                        $ordem->bind_param('ssisssii', $destino, $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $subcategoria_val, $_POST["id"]);
                    } else {
                        // Se falhar o upload, atualizar sem imagem
                        $qr = "update produtos set nome=?, preco=?, texto=?, link=?, categoria=?, subcategoria_id=? where id=?";
                        $ordem = $ms->prepare($qr);
                        $subcategoria_val = !empty($_POST["subcategoria1"]) ? $_POST["subcategoria1"] : null;
                        $ordem->bind_param('sisssii', $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $subcategoria_val, $_POST["id"]);
                        $msg='<h3 class="erro">Erro ao fazer upload da imagem!</h3>';
                    }
                } else {
                    // Formato não suportado
                    $qr = "update produtos set nome=?, preco=?, texto=?, link=?, categoria=?, subcategoria_id=? where id=?";
                    $ordem = $ms->prepare($qr);
                    $subcategoria_val = !empty($_POST["subcategoria1"]) ? $_POST["subcategoria1"] : null;
                    $ordem->bind_param('sisssii', $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $subcategoria_val, $_POST["id"]);
                    $msg='<h3 class="erro">Formato não suportado. Use JPG, PNG, GIF ou WEBP</h3>';
                }
            }
            else{
                // Sem nova imagem, atualizar apenas os outros campos
                $qr = "update produtos set nome=?, preco=?, texto=?, link=?, categoria=?, subcategoria_id=? where id=?";
                $ordem = $ms->prepare($qr);
                $subcategoria_val = !empty($_POST["subcategoria1"]) ? $_POST["subcategoria1"] : null;
                $ordem->bind_param('sisssii', $_POST["nome1"], $_POST["preco1"], $_POST["texto1"], $_POST["link1"], $_POST["categoria1"], $subcategoria_val, $_POST["id"]);
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
                $qr = "INSERT INTO produtos(imagem,nome,preco,texto,link,categoria,subcategoria_id) VALUES(?,?,?,?,?,?,?)";
                $ordem2 = $ms->prepare($qr);
                $nomeCopia = $row["nome"] . " (Cópia)";
                $ordem2->bind_param('ssisssi', $row["imagem"], $nomeCopia, $row["preco"], $row["texto"], $row["link"], $row["categoria"], $row["subcategoria_id"]);
                
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
				// Determinar ordem de exibição
				$ordem_exibicao = 0;
				$subcategoria_insert = !empty($_POST["inserir7"]) ? $_POST["inserir7"] : null;
				
				if(!empty($_POST["inserir8"]) && is_numeric($_POST["inserir8"])){
					// Se o usuário especificou uma posição relativa (1º, 2º, 3º...)
					$posicao_desejada = intval($_POST["inserir8"]);
					
					// Buscar os produtos existentes ordenados para encontrar a ordem_exibicao correta
					if($subcategoria_insert) {
						$qr_lista = "SELECT ordem_exibicao FROM produtos WHERE subcategoria_id = ? ORDER BY ordem_exibicao ASC";
						$stmt_lista = $ms->prepare($qr_lista);
						$stmt_lista->bind_param('i', $subcategoria_insert);
					} else {
						$qr_lista = "SELECT ordem_exibicao FROM produtos WHERE categoria = ? AND (subcategoria_id IS NULL OR subcategoria_id = 0) ORDER BY ordem_exibicao ASC";
						$stmt_lista = $ms->prepare($qr_lista);
						$stmt_lista->bind_param('s', $_POST["inserir5"]);
					}
					$stmt_lista->execute();
					$result_lista = $stmt_lista->get_result();
					
					$produtos_existentes = array();
					while($row_lista = $result_lista->fetch_array()) {
						$produtos_existentes[] = $row_lista['ordem_exibicao'];
					}
					$stmt_lista->close();
					
					// Se a posição desejada é maior que o número de produtos, colocar no final
					if($posicao_desejada > count($produtos_existentes)) {
						if(count($produtos_existentes) > 0) {
							$ordem_exibicao = max($produtos_existentes) + 1;
						} else {
							$ordem_exibicao = 1;
						}
					} else {
						// Inserir na posição desejada (índice = posição - 1)
						$indice = $posicao_desejada - 1;
						if($indice >= 0 && isset($produtos_existentes[$indice])) {
							$ordem_exibicao = $produtos_existentes[$indice];
							
							// Mover todos os produtos com ordem >= à especificada
							if($subcategoria_insert) {
								$qr_ajuste = "UPDATE produtos SET ordem_exibicao = ordem_exibicao + 1 WHERE subcategoria_id = ? AND ordem_exibicao >= ?";
								$stmt_ajuste = $ms->prepare($qr_ajuste);
								$stmt_ajuste->bind_param('ii', $subcategoria_insert, $ordem_exibicao);
							} else {
								$qr_ajuste = "UPDATE produtos SET ordem_exibicao = ordem_exibicao + 1 WHERE categoria = ? AND (subcategoria_id IS NULL OR subcategoria_id = 0) AND ordem_exibicao >= ?";
								$stmt_ajuste = $ms->prepare($qr_ajuste);
								$stmt_ajuste->bind_param('si', $_POST["inserir5"], $ordem_exibicao);
							}
							$stmt_ajuste->execute();
							$stmt_ajuste->close();
						} else {
							// Se não houver produtos, começar em 1
							$ordem_exibicao = 1;
						}
					}
				} else {
					// Se não especificou ordem, colocar no final
					if($subcategoria_insert) {
						$qr_max = "SELECT COALESCE(MAX(ordem_exibicao), 0) + 1 as proxima_ordem FROM produtos WHERE subcategoria_id = ?";
						$stmt_max = $ms->prepare($qr_max);
						$stmt_max->bind_param('i', $subcategoria_insert);
					} else {
						$qr_max = "SELECT COALESCE(MAX(ordem_exibicao), 0) + 1 as proxima_ordem FROM produtos WHERE categoria = ? AND (subcategoria_id IS NULL OR subcategoria_id = 0)";
						$stmt_max = $ms->prepare($qr_max);
						$stmt_max->bind_param('s', $_POST["inserir5"]);
					}
					$stmt_max->execute();
					$result_max = $stmt_max->get_result();
					$row_max = $result_max->fetch_array();
					$ordem_exibicao = $row_max['proxima_ordem'];
					$stmt_max->close();
				}
				
				$qr = "INSERT INTO produtos(imagem,nome,preco,texto,link,categoria,subcategoria_id,ordem_exibicao) VALUES(?,?,?,?,?,?,?,?)";		
				
				$ordem = $ms->prepare($qr);
				$subcategoria_insert = !empty($_POST["inserir7"]) ? $_POST["inserir7"] : null;
				$ordem->bind_param('ssisssii', $destino, $_POST["inserir2"], $_POST["inserir3"], $_POST["inserir6"], $_POST["inserir4"], $_POST["inserir5"], $subcategoria_insert, $ordem_exibicao);
				
	
				// Executar o query (verificar se não dá erro e o número de registos afetados)
				if ($ordem->execute()){
					if($ordem->affected_rows > 0){
						$msg='<h3 class="sucesso">O produto foi inserido na posição '.$ordem_exibicao.'!</h3>';
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

                    <!-- Header -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="m-0 font-weight-bold text-primary mb-2 mb-md-0">Gestão de Produtos</h6>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a class="btn button" href="alterar_categorias.php">Gerir Categorias</a>
                                    <a class="btn button" href="alterar_subcategorias.php">Gerir Subcategorias</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            // Construir filtro baseado em categoria e subcategoria
                            $filtros = array();
                            $tipos = array();
                            $valores = array();
                            $mostrarProdutos = false;
                            
                            // Verificar se algum filtro foi selecionado
                            if(!empty($_POST["pro"]) && $_POST["pro"] != "-1"){
                                $mostrarProdutos = true;
                                
                                if($_POST["pro"] != "20"){
                                    $filtros[] = "categoria = ?";
                                    $tipos[] = 's';
                                    $valores[] = $_POST["pro"];
                                }
                            }
                            
                            if(!empty($_POST["subcat"]) && $_POST["subcat"] != "-1" && $_POST["subcat"] != "20"){
                                $filtros[] = "subcategoria_id = ?";
                                $tipos[] = 'i';
                                $valores[] = $_POST["subcat"];
                            }
                            
                            $results = null;
                            
                            if($mostrarProdutos){
                                $where = "";
                                if(count($filtros) > 0){
                                    $where = "WHERE " . implode(" AND ", $filtros);
                                }
                                
                                $sq = 'SELECT * FROM produtos '.$where.' ORDER BY ordem_exibicao ASC, id ASC';
                                
                                if(count($valores) > 0){
                                    $stmt_filter = $ms->prepare($sq);
                                    $tipos_str = implode('', $tipos);
                                    $stmt_filter->bind_param($tipos_str, ...$valores);
                                    $stmt_filter->execute();
                                    $results = $stmt_filter->get_result();
                                } else {
                                    $results = $ms->query($sq);
                                }
                                
                                if(!$results) {
                                    echo '<div class="alert alert-danger">Erro ao carregar produtos: ' . $ms->error . '</div>';
                                }
                            }
                            ?>
                            
                            <!-- Card para Inserir Novo Produto -->
                            <div class="product-card insert-card">
                                <h5 class="mb-3"><i class="fas fa-plus-circle"></i> Adicionar Novo Produto</h5>
                                <form method="POST" enctype="multipart/form-data">
                                    <!-- Preservar filtros após inserção -->
                                    <input type="hidden" name="pro" value="<?php echo $_POST['pro'] ?? ''; ?>">
                                    <input type="hidden" name="subcat" value="<?php echo $_POST['subcat'] ?? ''; ?>">
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
                                            <select class="form-select" name="inserir5" id="categoria_insert" onchange="loadSubcategorias('insert')" required>
                                                <option value="selecionar">Selecionar</option>
                                                <?php
                                                $sq_cat="select * from categorias ORDER BY nome";
                                                $results_cat = $ms->query($sq_cat);
                                                while($row_cat = $results_cat->fetch_array()) {
                                                    echo '<option value="'.$row_cat["nome"].'" data-id="'.$row_cat["id"].'">'.$row_cat["nome"].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label-custom">Subcategoria (opcional)</label>
                                            <select class="form-select" name="inserir7" id="subcategoria_insert">
                                                <option value="">Nenhuma</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label-custom">Posição (opcional)</label>
                                            <input class="form-control" type="number" name="inserir8" placeholder="Ex: 1, 2, 3..." min="1" title="Deixe vazio para adicionar no final">
                                            <small class="text-muted">Deixe vazio para adicionar no final</small>
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

                            <!-- Filtros de Produtos -->
                            <div class="card" style="background: #f8f9fa; border: 2px solid #6c757d; margin-bottom: 20px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="color: #495057;"><i class="fas fa-filter"></i> Filtrar Produtos Existentes</h5>
                                    <form name="listagem" id="listagem" method="post" action="" class="d-flex gap-2 flex-wrap align-items-end">
                                        <div>
                                            <label class="form-label-custom" style="color: #495057;">Categoria</label>
                                            <select class="form-select" name="pro" id="filtro_categoria" style="width: 210px;" onchange="loadSubcategoriasFilter()">
                                                <option value="-1">Todas</option>
                                                <?php
                                                $sql="select * from categorias ORDER BY nome";
                                                $st=$ms->query($sql);
                                                while ($linha=$st->fetch_array()) {
                                                    $selected = (!empty($_POST["pro"]) && $_POST["pro"] == $linha["nome"]) ? 'selected' : '';
                                                    echo '<option value="'. $linha["nome"] . '" data-id="'.$linha["id"].'" '.$selected.'>' .$linha["nome"]. '</option>';
                                                }
                                                $st->close(); 
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="form-label-custom" style="color: #495057;">Subcategoria</label>
                                            <select class="form-select" name="subcat" id="filtro_subcategoria" style="width: 210px;">
                                                <option value="-1">Todas</option>
                                                <?php
                                                if(!empty($_POST["pro"]) && $_POST["pro"] != "20" && $_POST["pro"] != "-1"){
                                                    $sql_sub="SELECT s.* FROM subcategorias s INNER JOIN categorias c ON s.categoria_id = c.id WHERE c.nome = ? ORDER BY s.nome";
                                                    $st_sub = $ms->prepare($sql_sub);
                                                    $st_sub->bind_param('s', $_POST["pro"]);
                                                    $st_sub->execute();
                                                    $result_sub = $st_sub->get_result();
                                                    while ($linha_sub = $result_sub->fetch_array()) {
                                                        $selected_sub = (!empty($_POST["subcat"]) && $_POST["subcat"] == $linha_sub["id"]) ? 'selected' : '';
                                                        echo '<option value="'. $linha_sub["id"] . '" '.$selected_sub.'>' .$linha_sub["nome"]. '</option>';
                                                    }
                                                    $st_sub->close();
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <button type="submit" class="btn button"><i class="fas fa-search"></i> Filtrar</button>
                                        <?php if(!empty($_POST["pro"]) || !empty($_POST["subcat"])) { ?>
                                            <a href="catalogoonline.php" class="btn btn-secondary"><i class="fas fa-times"></i> Limpar</a>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>

                            <!-- Grid de Produtos Existentes -->
                            <div class="product-grid">
                                <?php
                                if(!$mostrarProdutos){
                                    // Mensagem quando nenhum filtro foi selecionado
                                    ?>
                                    <div class="alert alert-info" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-filter" style="font-size: 48px; color: #6c757d; margin-bottom: 15px;"></i>
                                        <h4>Selecione os filtros acima para visualizar os produtos</h4>
                                        <p class="mb-0">Use os filtros de categoria e subcategoria para encontrar os produtos que deseja editar.</p>
                                    </div>
                                    <?php
                                } elseif($results && $results->num_rows > 0) {
                                    $posicao = 1; // Contador de posição relativa
                                    while($row = $results->fetch_array()) {
                                        $imagemPath = !empty($row["imagem"]) ? $row["imagem"] : "https://via.placeholder.com/150?text=Sem+Imagem";
                                    ?>
                                <div class="product-card">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                        <!-- Preservar filtros após edição -->
                                        <input type="hidden" name="pro" value="<?php echo $_POST['pro'] ?? ''; ?>">
                                        <input type="hidden" name="subcat" value="<?php echo $_POST['subcat'] ?? ''; ?>">
                                        
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
                                                        <select class="form-select" name="categoria1" id="categoria_edit_<?php echo $row["id"]; ?>" onchange="loadSubcategorias('edit_<?php echo $row["id"]; ?>')">
                                                            <?php
                                                            $qs="select * from categorias ORDER BY nome";
                                                            $result_cat = $ms->query($qs);
                                                            while($rowCat = $result_cat->fetch_array()) {
                                                                $selected = ($rowCat["nome"] == $row["categoria"]) ? 'selected' : '';
                                                                echo '<option value="'.$rowCat["nome"].'" data-id="'.$rowCat["id"].'" '.$selected.'>'.$rowCat["nome"].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Subcategoria (opcional)</label>
                                                        <select class="form-select" name="subcategoria1" id="subcategoria_edit_<?php echo $row["id"]; ?>">
                                                            <option value="">Nenhuma</option>
                                                            <?php
                                                            $qs_sub="SELECT s.* FROM subcategorias s INNER JOIN categorias c ON s.categoria_id = c.id WHERE c.nome = ?";
                                                            $stmt_sub = $ms->prepare($qs_sub);
                                                            $stmt_sub->bind_param('s', $row["categoria"]);
                                                            $stmt_sub->execute();
                                                            $result_sub = $stmt_sub->get_result();
                                                            while($rowSub = $result_sub->fetch_array()) {
                                                                $selected_sub = ($rowSub["id"] == $row["subcategoria_id"]) ? 'selected' : '';
                                                                echo '<option value="'.$rowSub["id"].'" '.$selected_sub.'>'.$rowSub["nome"].'</option>';
                                                            }
                                                            $stmt_sub->close();
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
                                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                            <!-- Botões de Ordenação -->
                                                            <div class="d-flex gap-2">
                                                                <form method="POST" style="display: inline;">
                                                                    <input type="hidden" name="produto_id" value="<?php echo $row["id"]; ?>">
                                                                    <input type="hidden" name="categoria_atual" value="<?php echo $row["categoria"]; ?>">
                                                                    <input type="hidden" name="subcategoria_atual" value="<?php echo $row["subcategoria_id"]; ?>">
                                                                    <input type="hidden" name="pro" value="<?php echo $_POST["pro"] ?? ''; ?>">
                                                                    <input type="hidden" name="subcat" value="<?php echo $_POST["subcat"] ?? ''; ?>">
                                                                    <button class="btn btn-sm" type="submit" name="mover_cima" title="Mover para cima" style="background-color: #28a745; color: white; border: none;">
                                                                        <i class="fas fa-arrow-up"></i>
                                                                    </button>
                                                                </form>
                                                                <form method="POST" style="display: inline;">
                                                                    <input type="hidden" name="produto_id" value="<?php echo $row["id"]; ?>">
                                                                    <input type="hidden" name="categoria_atual" value="<?php echo $row["categoria"]; ?>">
                                                                    <input type="hidden" name="subcategoria_atual" value="<?php echo $row["subcategoria_id"]; ?>">
                                                                    <input type="hidden" name="pro" value="<?php echo $_POST["pro"] ?? ''; ?>">
                                                                    <input type="hidden" name="subcat" value="<?php echo $_POST["subcat"] ?? ''; ?>">
                                                                    <button class="btn btn-sm" type="submit" name="mover_baixo" title="Mover para baixo" style="background-color: #ffc107; color: white; border: none;">
                                                                        <i class="fas fa-arrow-down"></i>
                                                                    </button>
                                                                </form>
                                                                <small class="text-muted align-self-center">Posição: <?php echo $posicao; ?>º</small>
                                                            </div>
                                                            
                                                            <!-- Botões de Edição -->
                                                            <div class="d-flex gap-2">
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
                                        </div>
                                    </form>
                                </div>
                                <?php
                                        $posicao++; // Incrementar posição para o próximo produto
                                    }
                                } else {
                                    // Nenhum produto encontrado com os filtros selecionados
                                    ?>
                                    <div class="alert alert-warning" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #856404; margin-bottom: 15px;"></i>
                                        <h4>Nenhum produto encontrado</h4>
                                        <p class="mb-0">Não existem produtos com os filtros selecionados. Tente ajustar os filtros ou adicionar novos produtos.</p>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            // Frees the memory associated with a result
                            if($results) $results->free();
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

    <script>
    function loadSubcategorias(tipo) {
        const categoriaSelect = document.getElementById('categoria_' + tipo);
        const subcategoriaSelect = document.getElementById('subcategoria_' + tipo);
        
        if (!categoriaSelect || !subcategoriaSelect) return;
        
        const selectedOption = categoriaSelect.options[categoriaSelect.selectedIndex];
        const categoriaId = selectedOption.getAttribute('data-id');
        
        // Limpar subcategorias
        subcategoriaSelect.innerHTML = '<option value="">Nenhuma</option>';
        
        if (!categoriaId || categoriaId === '') return;
        
        // Buscar subcategorias via AJAX
        fetch('get_subcategorias.php?categoria_id=' + categoriaId)
            .then(response => response.json())
            .then(data => {
                data.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.nome;
                    subcategoriaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erro ao carregar subcategorias:', error));
    }
    
    function loadSubcategoriasFilter() {
        const categoriaSelect = document.getElementById('filtro_categoria');
        const subcategoriaSelect = document.getElementById('filtro_subcategoria');
        
        if (!categoriaSelect || !subcategoriaSelect) return;
        
        const selectedOption = categoriaSelect.options[categoriaSelect.selectedIndex];
        const categoriaId = selectedOption.getAttribute('data-id');
        const categoriaValue = categoriaSelect.value;
        
        // Limpar subcategorias
        subcategoriaSelect.innerHTML = '<option value="-1">Filtrar por subcategoria</option>';
        subcategoriaSelect.innerHTML += '<option value="20">Todas as subcategorias</option>';
        
        // Se selecionou "Todas as categorias" ou nenhuma, não carregar subcategorias
        if (!categoriaId || categoriaId === '' || categoriaValue === '20' || categoriaValue === '-1') {
            return;
        }
        
        // Buscar subcategorias via AJAX
        fetch('get_subcategorias.php?categoria_id=' + categoriaId)
            .then(response => response.json())
            .then(data => {
                data.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.nome;
                    subcategoriaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erro ao carregar subcategorias:', error));
    }
    </script>

    <?php include ("footer.php"); ?>