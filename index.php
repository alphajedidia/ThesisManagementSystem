<?php
require_once("app/functions/isVariableSet.php");
$servername = "localhost";
$username = "root";
$password = "";
$isDevine = isVariableSet($_POST,['database_name']);
//Traitements
if($isDevine){
  $database_name = $_POST['database_name'];
  try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE " . $database_name . " ; USE " . $database_name . " ; CREATE TABLE etudiants ( matricule varchar(20) PRIMARY KEY, nom_etudiant varchar(50) NOT NULL, prenom_etudiant varchar(50) NOT NULL, niveau varchar(5) NOT NULL, parcours varchar(5) NOT NULL, adr_email varchar(50) NOT NULL, actif TINYINT NOT NULL DEFAULT \"1\"  );
    CREATE TABLE professeurs ( id_prof varchar(20) PRIMARY KEY , nom_prof varchar(50) NOT NULL, prenom_prof varchar(50) NOT NULL, civilite varchar(5) NOT NULL, grade varchar(50) NOT NULL, actif_prof TINYINT NOT NULL DEFAULT \"1\" );
    CREATE TABLE organismes ( id_org int PRIMARY KEY AUTO_INCREMENT, design varchar(50) NOT NULL, lieu varchar(50) NOT NULL, actif_org TINYINT NOT NULL DEFAULT \"1\" );CREATE TABLE soutenir(
      matricule VARCHAR(10),
      annee_univ VARCHAR(20),
      id_org INT,
      note FLOAT,
      president varchar(20) NOT NULL,
      examinateur varchar(20) NOT NULL,
      rapporteur_int varchar(20) NOT NULL,
      rapporteur_ext varchar(20) NOT NULL,
      PRIMARY KEY(matricule,annee_univ,id_org),
      FOREIGN KEY(president) REFERENCES professeurs(id_prof),
      FOREIGN KEY(examinateur) REFERENCES professeurs(id_prof), 
      FOREIGN KEY(rapporteur_int) REFERENCES professeurs(id_prof), 
      FOREIGN KEY(rapporteur_ext) REFERENCES professeurs(id_prof),
      FOREIGN KEY(matricule) REFERENCES etudiants(matricule),
      FOREIGN KEY(id_org) REFERENCES organismes(id_org)
  );
  ";
    $conn->exec($sql);
    echo "Database created successfully<br>";
    header('Location: /gestion_de_soutenance/app/views/pages/ajoutEtudiant.php');
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
}
$conn = null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="app/views/ressources/images/logoENI.png" />
  <title>Gestion des soutenances</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="public/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
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
                  <a href="app/views/pages/ajoutEtudiant.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="app/views/pages/afficheEtudiant.php" class="nav-link">
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
                  <a href="app/views/pages/ajoutProf.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="app/views/pages/afficheProf.php" class="nav-link">
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
                  <a href="app/views/pages/ajoutOrganisme.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="app/views/pages/afficheOrganisme.php" class="nav-link">
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
                  <a href="app/views/pages/ajoutSoutenance.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="app/views/pages/afficheSoutenance.php" class="nav-link">
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

    <!-- ao arina  -->

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">GESTION DE SOUTENANCE</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col">
              <h4>Bienvenu sur l'application de GESTION DE SOUTENANCE</h4><br>
              <div class="">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                      </div><!-- /.col -->
                    </div><!-- /.row -->
                  </div><!-- /.container-fluid -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->

    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; mars 2023 <a href="#">Gestion de soutenance</a>.</strong>
      All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="public/assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="public/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="public/assets/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="public/assets/dist/js/demo.js"></script>
</body>

</html>