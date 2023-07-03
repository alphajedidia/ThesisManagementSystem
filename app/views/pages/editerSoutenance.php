<?php
// Connexion base de donnee
require_once("../../connect_database/database.php");

// <!-- Prerequis
// * Recuperer tous les professeurs actifs
require_once("../../models/professeursModel.php");
require_once("../../functions/soutenanceSelectedProf.php");
$allActifsProf = Professeur::readAll();

// * Recuperation de la soutenance a modifier
require_once("../../models/soutenirModel.php");
$soutenance = null;
if(isset($_GET['id'])){
    $matricule = $_GET['id'];
    $soutenanceTab = Soutenir::getSoutenanceByMatricule($matricule);
    $soutenance = $soutenanceTab[0];
}

// * recuperer touts les organismes actifs
require_once("../../models/organismesModel.php");
require_once("../../functions/soutenanceSelectedOrg.php");
$allActifsOrganisme = Organisme::readAll();

// -->

require_once("../../models/soutenirModel.php");

// Verifier si la variable post est definit
require_once("../../functions/isVariableSet.php");
$isDevine = isVariableSet($_POST,['matricule', 'annee_univ', 'id_org', 'note', 'president', 'examinateur','rapporteur_int','rapporteur_ext']);
//Traitements
if($isDevine){
    if(Soutenir::update($_POST['matricule'],$_POST)){
        // header('Location: index.php');
        header('Location: /gestion_de_soutenance/app/views/pages/afficheSoutenance.php');
    }else{
        echo "<div class='alert alert-danger'>Echec</div>";
    }
}

require_once("../layout/header.php");
?>

<div class="content-wrapper">
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

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <!-- general form elements -->
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Modifier les informations d'une soutenance</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="editerSoutenance.php" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="matricule">Matricule</label>
                  <input type="text" class="form-control" id="matricule" name="matricule" <?= "value='".$soutenance["matricule"]."'"?> required>
                </div>
                <div class="form-group">
                  <label for="annee_univ">Annee universitaire</label>
                  <select class="form-select form-control" name="annee_univ" id="annee_univ" required>
                    <option value="2021-2022" <?= ($soutenance["Annee universitaire"] === '2021-2022')?'selected':''?>>2021-2022</option>
                    <option value="2022-2023" <?= ($soutenance["Annee universitaire"] === '2022-2023')?'selected':''?>>2022-2023</option>
                    <option value="2023-2024" <?= ($soutenance["Annee universitaire"] === '2023-2024')?'selected':''?>>2023-2024</option>
                    <option value="2024-2025" <?= ($soutenance["Annee universitaire"] === '2024-2025')?'selected':''?>>2024-2025</option>
                    <option value="2025-2026" <?= ($soutenance["Annee universitaire"] === '2025-2026')?'selected':''?>>2025-2026</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="id_org">Organisme</label>
                  <select class="form-select form-control" name="id_org" id="id_org" required>
                    <!-- script php pour recuperer tout les organismes -->
                    <?php
                    soutenanceSelectedOrg($allActifsOrganisme,$soutenance['id_org']);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="note">Note</label>
                  <input type="number" class="form-control" id="note" name="note" step="0.25" min="0" max="20" required <?= "value='".$soutenance['Note']."'"?>>
                </div>
                <div class="form-group">
                  <label for="president">President du jury</label>
                  <select class="form-select form-control" name="president" id="president" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectedProf($allActifsProf,$soutenance['id_president']);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="examinateur">Examinateur</label>
                  <select class="form-select form-control" name="examinateur" id="examinateur" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectedProf($allActifsProf,$soutenance['id_examinateur']);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="rapporteur_int">Rapporteur int</label>
                  <select class="form-select form-control" name="rapporteur_int" id="rapporteur_int" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectedProf($allActifsProf,$soutenance['id_rapporteur_int']);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="rapporteur_ext">Rapporteur ext</label>
                  <select class="form-select form-control" name="rapporteur_ext" id="rapporteur_ext" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectedProf($allActifsProf,$soutenance['id_rapporteur_ext']);
                    ?>
                  </select>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-dark">Modifier</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

<?php
require_once("../layout/footer.php");
?>