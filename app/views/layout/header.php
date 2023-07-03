<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../ressources/images/logoENI.png" />
    <title>Gestion des soutenances</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../public/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../../public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../public/assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../../public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- script pour update -->
</head>

<body class="hold-transition sidebar-mini layout-fixed" style="overflow-x: hidden;">

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../../../index.php" class="brand-link">
                <span class="brand-text font-weight-light">Gestion de Soutenance</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Etudiants
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../pages/ajoutEtudiant.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ajouter</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../pages/afficheEtudiant.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Afficher</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Professeurs
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../pages/ajoutProf.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ajouter</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../pages/afficheProf.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Afficher</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Organismes
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../pages/ajoutOrganisme.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ajouter</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../pages/afficheOrganisme.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Afficher</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Soutenir
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../pages/ajoutSoutenance.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ajouter</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../pages/afficheSoutenance.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Afficher</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->

        </aside>