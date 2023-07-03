<?php
// Connexion base de donnee
require_once("../../connect_database/database.php");

// <!-- Prerequis
// * Recuperer tous les professeurs actifs
require_once("../../models/professeursModel.php");
require_once("../../functions/soutenanceSelectProf.php");
$allActifsProf = Professeur::readAll();


// * recuperer touts les organismes actifs
require_once("../../models/organismesModel.php");
require_once("../../functions/soutenanceSelectOrg.php");
$allActifsOrganisme = Organisme::readAll();

require_once("../../models/soutenirModel.php");
$allMatricule = Soutenir::allMatricule();
// -->


// Verifier si la variable post est definit
require_once("../../functions/isVariableSet.php");
$isDevine = isVariableSet($_POST,['matricule', 'annee_univ', 'id_org', 'note', 'president', 'examinateur','rapporteur_int','rapporteur_ext']);
//Traitements
if($isDevine){
    $soutenance = new Soutenir($_POST['matricule'], $_POST['annee_univ'], $_POST['id_org'], $_POST['note'], $_POST['president'], $_POST['examinateur'],$_POST['rapporteur_int'],$_POST['rapporteur_ext']);
    if($soutenance->create()){
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
              <h3 class="card-title">Ajouter une soutenance</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="ajoutSoutenance.php" method="POST">
              <div class="card-body">
                <div class="form-group">
                <label for="matricule">Matricule</label>
                  <select class="form-select form-control" name="matricule" id="matricule" required>
                    <?php foreach($allMatricule as $row) : ?>
                      <option value="<?php echo htmlspecialchars($row['matricule']); ?>"><?= htmlspecialchars($row['matricule']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="annee_univ">Annee universitaire</label>
                  <select class="form-select form-control" name="annee_univ" id="annee_univ" required>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2024-2025">2024-2025</option>
                    <option value="2025-2026">2025-2026</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="id_org">Organisme</label>
                  <select class="form-select form-control" name="id_org" id="id_org" required>
                    <!-- script php pour recuperer tout les organismes -->
                    <?php
                    soutenanceSelectOrg($allActifsOrganisme);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="note">Note</label>
                  <input type="number" class="form-control" id="note" name="note" step="0.25" min="0" max="20" required placeholder="Enter la note durant la soutenance">
                </div>
                <div class="form-group">
                  <label for="president">President du jury</label>
                  <select class="form-select form-control" name="president" id="president" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectProf($allActifsProf);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="examinateur">Examinateur</label>
                  <select class="form-select form-control" name="examinateur" id="examinateur" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectProf($allActifsProf);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="rapporteur_int">Rapporteur int</label>
                  <select class="form-select form-control" name="rapporteur_int" id="rapporteur_int" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectProf($allActifsProf);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="rapporteur_ext">Rapporteur ext</label>
                  <select class="form-select form-control" name="rapporteur_ext" id="rapporteur_ext" required>
                    <!-- script php pour recuperer tout les profs -->
                    <?php 
                    soutenanceSelectProf($allActifsProf);
                    ?>
                  </select>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-dark">Ajouter</button>
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