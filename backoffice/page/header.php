<?php
// Start the session
session_start();

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
}

if (empty($_SESSION["globaluser"])){ ?>
    <script>window.open("../", "_self")</script>
    <?php
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>

    <title>BackOffice GlmSystem</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Bootstrap 5.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    <!-- font icons -->
    <link rel="stylesheet" href="../../assets/vendors/themify-icons/css/themify-icons.css">

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/17e313b9ac.js" crossorigin="anonymous"></script>


    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/here.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/ollie.css">

    <!-- My Style -->
    <link rel="stylesheet" href="style.css?1.0.33">

</head>

<body id="page-top">

    <?php

        include ("../../bd.php");

        $globaluser = $_SESSION["globaluser"];

        if(isset($_POST['salvar'])){
            if(isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['newpass2'])){
                if($_POST['oldpass']!='' || $_POST['newpass']!='' || $_POST['newpass2']!=''){

                    if($_POST['oldpass']=='' || $_POST['newpass']=='' || $_POST['newpass2']==''){
                        echo 'existem campos por preeencher';
                    }
                    else{
                        $sq="select * from login";
                        $results = $ms->query($sq);
                        while($row = $results->fetch_array()) {
                            if (password_verify($_POST['oldpass'], $row["password"]) && $_POST['newpass'] == $_POST['newpass2'] && $_POST['newpass'] != $_POST['oldpass']){
                                
                                $sq="select * from login";
                                $results = $ms->query($sq);
                                while($row = $results->fetch_array()) {
                                    if($globaluser == $row["user"]){
                                        $qr = "update login set password=? where user='". $row['user'] ."'";	
                                        $p=password_hash($_POST['newpass'], PASSWORD_DEFAULT);
                                        $ordem = $ms->prepare($qr);
                                        $ordem->bind_param('s', $p);
                                        $password=$p;
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
                            else{
                                echo 'Houve um erro, por favor tente novamente';
                            }
                        }
                    }
                }
            }
        }

    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-video"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Backoffice</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->

        <?php
        $qr = "select * from menu where id=1 and nivel<=".$_SESSION["globalnivel"]."";
        $results = $ms->query($qr);
        while($row = $results->fetch_array()){?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $row['link']; ?>">
                    <i class="fas fa-fw fa-house"></i>
                    <span><?php echo $row['nome']; ?></span></a>
            </li>
            <?php
        }
        ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Páginas
        </div>

        <?php
        $qr = "select * from menu where id>=2 and nivel<=".$_SESSION["globalnivel"]."";
        $results = $ms->query($qr);
        while($row = $results->fetch_array()){
            if($row['id'] == 2 || $row['id'] == 6){?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?php echo $row['id']; ?>"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="<?php echo $row['icon']; ?>"></i>
                        <span><?php echo $row['nome']; ?></span>
                    </a>
                    <div id="collapse<?php echo $row['id']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded"><?php
                            if ($row['id'] == 2){?>
                                <h6 class="collapse-header">Home:</h6>
                                <?php
                            }

                            if ($row['id'] == 2){?>
                                <a class="collapse-item" href="home1.php">Editar texto sobre nós</a>
                                <a class="collapse-item" href="home2.php">Editar Estatísticas</a>
                                <a class="collapse-item" href="home3.php">Editar Texto Equipa</a>
                                <a class="collapse-item" href="home4.php">Editar Cargo Equipa</a>
                                <a class="collapse-item" href="servicos.php">Editar Serviços</a>
                                <?php
                            }
                            else{?>
                                <a class="collapse-item" href="registar_utilizadores.php">Registar</a>
                                <a class="collapse-item" href="tbl_utilizadores.php">Tabela de utilizadores</a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </li>
                <?php
            }
            else{?>
                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $row['link'] ?>">
                    <i class="<?php echo $row['icon']; ?>"></i>
                    <span><?php echo $row['nome']; ?></span></a>
                </li>
                <?php
            }
        }
        ?>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Utilities Collapse Menu -->
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-home"></i>
                <span>Catálogo Online</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pastas:</h6>
                    <a class="collapse-item" href="http://diogopreda.pt">Inserir Produtos</a>
                    <a class="collapse-item" href="http://diogopreda.pt/backoffice/">Eliminar Produtos</a>
                </div>
            </div>
        </li> -->

        <!-- Divider -->
        <hr class="sidebar-divider">


        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "$globaluser"; ?></span>
                    <?php
                    $sq="select * from login";
                    $results = $ms->query($sq);
                    while($row = $results->fetch_array()) {
                        if ($globaluser == $row["user"]){
                            if ($row["imagem"] == ""){?>
                                <img class="img-profile rounded-circle"
                                src="../../assets/imgs/notfound.jpg">
                                <?php
                            }
                            else{?>
                                <img class="img-profile rounded-circle"
                                src="<?php echo $row['imagem']; ?>">
                                <?php
                            }
                        }
                    }
                    ?>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="alterar.php" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Password/Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->