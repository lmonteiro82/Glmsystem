<?php include ("bd.php"); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Online - GlmSystem</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/ollie.css">
    <style>
        /* Navbar Styles */
        .navbar {
            padding: 15px 0;
            transition: all 0.3s;
        }
        .navbar .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        @media (max-width: 767px) {
            .navbar .container {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
        .navbar-brand {
            font-size: 24px;
        }
        .navbar-nav .nav-link {
            padding: 8px 16px;
            margin: 0 5px;
            border-radius: 6px;
            transition: all 0.3s;
            color: #555;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            background: #f8f9fa;
            color: #9E3223;
        }
        .navbar-nav .nav-link.active {
            background: #9E3223;
            color: white !important;
        }
        body {
            background: #f8f9fa;
        }
    </style>
</head>
<body>

<!-- Navbar Moderna -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <span style="font-weight: 600; color: #333;">GLM<span style="color: #9E3223;">System</span></span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacto.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://ajax.systems/pt/tools/configurator/glmsystem/">Configurador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="catalogo.php">Catálogo Online</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section id="navs" style="margin-top: 100px;">
    <style>
        .search-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 15px;
        }
        .search-box {
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 12px 45px 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .search-box input:focus {
            outline: none;
            border-color: #6c63ff;
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.1);
        }
        .search-box button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 8px;
        }
        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        @media (max-width: 1200px) {
            .category-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 900px) {
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .category-grid {
                grid-template-columns: 1fr;
            }
        }
        .category-grid form {
            margin: 0 !important;
            padding: 0;
            display: contents;
        }
        .category-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.12);
        }
        .category-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }
        .category-card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .category-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #333;
        }
        .category-card p {
            font-size: 14px;
            color: #666;
            margin: 0;
            margin: 0;
            line-height: 1.5;
        }
        .products-header {
            margin: 30px 0 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .products-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .back-button {
            background: #f5f5f5;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .back-button:hover {
            background: #e0e0e0;
        }
        .cards {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s;
            height: 100%;
        }
        
        /* Layout horizontal para mobile */
        @media (max-width: 767px) {
            .cards {
                display: flex;
                flex-direction: row;
                height: auto;
            }
            .cards .card-img-top {
                width: 120px;
                height: 120px;
                object-fit: cover;
                border-radius: 12px 0 0 12px;
                flex-shrink: 0;
            }
            .cards .card-body {
                flex: 1;
                padding: 12px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .cards .card-title {
                font-size: 16px;
                margin-bottom: 8px;
            }
            .cards .card-text {
                font-size: 13px;
                margin-bottom: 10px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .cards .btn-primary {
                padding: 6px 12px;
                font-size: 13px;
            }
        }
        
        .cards:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.12);
        }
    </style>

    <div class="container" id="main">
        <!-- Barra de Pesquisa -->
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Pesquisar produtos..." onkeyup="filterItems()">
                <button type="button">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <?php
        if (isset($_POST["bbb"])) {
            // Mostra produtos da categoria selecionada
            ?>
            <div class="products-header">
                <form method="post" style="margin: 0;">
                    <button type="submit" class="back-button">← Voltar às Categorias</button>
                </form>
                <h2><?php echo htmlspecialchars($_POST["bbb"]); ?></h2>
            </div>

            <div id="div_controladoras" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                <?php
                $sq = "select * from produtos";
                $results = $ms->query($sq);
                while($row = $results->fetch_array()) {
                    if ($row["categoria"] == $_POST["bbb"]) { ?>
                        <div class="col searchable-item" data-name="<?php echo strtolower($row["nome"]); ?>">
                            <div class="card cards">
                                <img src="backoffice/page/<?php echo $row["imagem"] ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row["nome"]); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row["nome"] ?></h5>
                                    <p class="card-text"><?php echo $row["texto"] ?></p>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                        <a href="<?php echo $row["link"] ?>" class="btn btn-primary" target="_blank">Ver Mais</a>
                                        <?php if(!empty($row["preco"])) { ?>
                                            <h4 style="margin: 0; color: #9E3223; font-weight: 600;"><?php echo $row["preco"] ?>€</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        } else {
            // Mostra categorias como cards
            ?>
            <div class="category-grid" id="categoryGrid">
                <?php
                $sq = "select * from categorias";
                $results = $ms->query($sq);
                $temCategorias = false;
                
                if($results && $results->num_rows > 0){
                    while($row = $results->fetch_array()) { 
                        $temCategorias = true;
                        $imagemCategoria = (isset($row["imagem"]) && !empty($row["imagem"])) ? "backoffice/page/" . $row["imagem"] : "https://via.placeholder.com/400x200/e0e0e0/666666?text=" . urlencode($row["nome"]);
                        $descricao = isset($row["descricao"]) ? $row["descricao"] : "Explore os produtos desta categoria.";
                        ?>
                        <form method="post" style="margin: 0;">
                            <button type="submit" name="bbb" value="<?php echo $row["nome"] ?>" class="category-card searchable-item" data-name="<?php echo strtolower($row["nome"]); ?>">
                                <img src="<?php echo $imagemCategoria; ?>" alt="<?php echo htmlspecialchars($row["nome"]); ?>" onerror="this.src='https://via.placeholder.com/400x200/e0e0e0/666666?text=<?php echo urlencode($row["nome"]); ?>'">
                                <div class="category-card-body">
                                    <h3><?php echo $row["nome"] ?></h3>
                                    <p><?php echo $descricao ?></p>
                                </div>
                            </button>
                        </form>
                        <?php
                    }
                }
                
                if(!$temCategorias) {
                    ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                        <h3 style="color: #666; margin-bottom: 15px;">📦 Nenhuma categoria encontrada</h3>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>

    <script>
    function filterItems() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.searchable-item');
        
        items.forEach(item => {
            const itemName = item.getAttribute('data-name');
            if (itemName.includes(searchInput)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
    </script>
</section>

<!-- Footer -->
<section id="contact" class="section pb-0">
    <div class="container">
        <footer class="footer mt-5 border-top">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 text-center text-md-left">
                    <p class="mb-0">Copyright <script>document.write(new Date().getFullYear())</script> &copy; <a target="_blank" href="https://leandromonteiro.pt">Leandro Monteiro</a></p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="social-links">
                        <a href="https://www.facebook.com/glmsystem" class="link pr-1"><i class="ti-facebook"></i></a>
                        <a href="https://www.linkedin.com/in/jorge-monteiro-a2183b45/" class="link pr-1"><i class="ti-linkedin"></i></a>
                    </div>
                </div>
            </div> 
        </footer>
    </div>
</section>

<!-- core  -->
<script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
<script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

<!-- bootstrap 3 affix -->
<script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

<!-- Owl carousel  -->
<script src="assets/vendors/owl-carousel/js/owl.carousel.js"></script>

<!-- Ollie js -->
<script src="assets/js/ollie.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

<!-- My scripts -->
<script src="script.js?1.0.7"></script>

</body>
</html>